<?php
declare(strict_types=1);

namespace App\ISP;

use App\ISP\Contracts\Eater;
use App\ISP\Contracts\Flyer;

final class Swallow implements Eater, Flyer
{
    public function eat(): void
    {
        
    }

    public function fly(): void
    {
        
    }
}
