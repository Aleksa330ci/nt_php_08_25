<?php
declare(strict_types=1);

namespace Console\Contracts;

interface Command
{    
    public function handle(array $args): int;

     
    public function description(): string;


    public function signature(): string;
}
