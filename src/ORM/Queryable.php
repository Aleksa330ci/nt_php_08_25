<?php
declare(strict_types=1);

namespace ORM;

use PDO;

trait Queryable
{
    protected string $table = '';
    protected string $primaryKey = 'id';

    protected array  $columns = ['*'];
    protected array  $wheres  = [];   
    protected array  $joins   = [];   
    protected array  $orders  = [];   
    protected array  $groups  = [];   
    protected ?int   $limit   = null;
    protected ?int   $offset  = null;

    protected array $attributes = [];


    public function select(string ...$columns): static
    {
        $this->resetSelect();
        if ($columns) $this->columns = $columns;
        return $this;
    }

    public function where(string $column, string $operator, mixed $value): static
    {
        return $this->addWhere('AND', $column, $operator, $value);
    }

    public function andWhere(string $column, string $operator, mixed $value): static
    {
        return $this->where($column, $operator, $value);
    }

    public function orWhere(string $column, string $operator, mixed $value): static
    {
        return $this->addWhere('OR', $column, $operator, $value);
    }

    public function whereNotIn(string $column, array $values): static
    {
        if (empty($values)) return $this;
        $placeholders = implode(',', array_fill(0, count($values), '?'));
        $this->wheres[] = ['boolean' => 'AND', 'sql' => "$column NOT IN ($placeholders)", 'bind' => $values];
        return $this;
    }

    public function join(string $table, string $first, string $operator, string $second, string $type = 'INNER'): static
    {
        $type = strtoupper($type);
        $this->joins[] = ['sql' => "$type JOIN $table ON $first $operator $second"];
        return $this;
    }

    public function orderBy(string $column, string $direction = 'ASC'): static
    {
        $direction = strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC';
        $this->orders[] = "$column $direction";
        return $this;
    }

    public function groupBy(string ...$columns): static
    {
        array_push($this->groups, ...$columns);
        return $this;
    }

    public function limit(int $limit): static { $this->limit = max(0, $limit); return $this; }
    public function offset(int $offset): static { $this->offset = max(0, $offset); return $this; }


    public function get(): array
    {
        [$sql, $bind] = $this->compileSelect();
        $stmt = $this->pdo()->prepare($sql);
        $stmt->execute($bind);
        $this->resetSelect();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function first(): ?array
    {
        $this->limit(1);
        $rows = $this->get();
        return $rows[0] ?? null;
    }

    public function find(int|string $id): ?array
    {
        return $this->select()->where($this->primaryKey, '=', $id)->first();
    }

    public function findBy(string $column, mixed $value): ?array
    {
        return $this->select()->where($column, '=', $value)->first();
    }


    public function create(array $data): int
    {
        $cols = array_keys($data);
        $place = implode(',', array_fill(0, count($cols), '?'));
        $sql = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $this->table, implode(',', $cols), $place
        );
        $stmt = $this->pdo()->prepare($sql);
        $stmt->execute(array_values($data));
        return (int)$this->pdo()->lastInsertId();
    }

    public function delete(?int $id = null): int
    {
        if ($id !== null) {
            $this->wheres = [['boolean'=>'AND','sql'=> $this->primaryKey.' = ?','bind'=>[$id]]];
        }
        [$whereSql, $bind] = $this->compileWhere();
        $sql = "DELETE FROM {$this->table} $whereSql";
        $stmt = $this->pdo()->prepare($sql);
        $stmt->execute($bind);
        $this->resetSelect();
        return $stmt->rowCount();
    }
    public function destroy(int $id): int { return $this->delete($id); }

    public function fill(array $data): static { $this->attributes = $data + $this->attributes; return $this; }

    public function update(?array $data = null, ?int $id = null): int
    {
        $payload = $data ?? $this->attributes;
        if ($payload === []) return 0;

        if ($id !== null) {
            $this->wheres = [['boolean'=>'AND','sql'=> $this->primaryKey.' = ?','bind'=>[$id]]];
        }

        $sets = [];
        $bind = [];
        foreach ($payload as $col => $val) {
            $sets[] = "$col = ?";
            $bind[] = $val;
        }
        [$whereSql, $whereBind] = $this->compileWhere();
        $bind = array_merge($bind, $whereBind);

        $sql = "UPDATE {$this->table} SET ".implode(',', $sets)." $whereSql";
        $stmt = $this->pdo()->prepare($sql);
        $stmt->execute($bind);
        $this->resetSelect();
        return $stmt->rowCount();
    }


    protected function addWhere(string $boolean, string $column, string $operator, mixed $value): static
    {
        $this->wheres[] = [
            'boolean' => strtoupper($boolean),
            'sql'     => "$column $operator ?",
            'bind'    => [$value],
        ];
        return $this;
    }

    protected function compileSelect(): array
    {
        $sql = 'SELECT '.implode(',', $this->columns).' FROM '.$this->table;

        if ($this->joins) {
            $sql .= ' '.implode(' ', array_column($this->joins, 'sql'));
        }

        [$whereSql, $bind] = $this->compileWhere();
        $sql .= $whereSql;

        if ($this->groups) $sql .= ' GROUP BY '.implode(',', $this->groups);
        if ($this->orders) $sql .= ' ORDER BY '.implode(',', $this->orders);
        if ($this->limit !== null) $sql .= ' LIMIT '.$this->limit;
        if ($this->offset !== null) $sql .= ' OFFSET '.$this->offset;

        return [$sql, $bind];
    }

    protected function compileWhere(): array
    {
        if (!$this->wheres) return ['', []];

        $parts = [];
        $bind  = [];
        foreach ($this->wheres as $i => $w) {
            $prefix = $i === 0 ? 'WHERE' : $w['boolean'];
            $parts[] = "$prefix {$w['sql']}";
            array_push($bind, ...$w['bind']);
        }
        return [' '.implode(' ', $parts), $bind];
    }

    protected function resetSelect(): void
    {
        $this->columns = ['*'];
        $this->wheres  = [];
        $this->joins   = [];
        $this->orders  = [];
        $this->groups  = [];
        $this->limit   = null;
        $this->offset  = null;
    }

    protected function pdo(): PDO
    {
        return \Core\DB::connect();
    }

    public static function query(): static
    {
        /** @var static $m */
        $m = new static();
        $m->resetSelect();
        return $m;
    }
}
