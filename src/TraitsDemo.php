<?php
declare(strict_types=1);

namespace App;

use App\Traits\TraitOne;
use App\Traits\TraitTwo;
use App\Traits\TraitThree;

final class TraitsDemo
{
    use TraitOne, TraitTwo, TraitThree {
        TraitOne::test as private test1;
        TraitTwo::test as private test2;
        TraitThree::test as private test3;

 
        TraitOne::test insteadof TraitTwo, TraitThree;
    }

    public function test(): int
    {
        return $this->test1();
    }

    public function sum(): int
    {
        return $this->test1() + $this->test2() + $this->test3();
    }
}
