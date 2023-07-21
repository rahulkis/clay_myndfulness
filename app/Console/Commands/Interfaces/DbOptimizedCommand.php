<?php
namespace App\Console\Commands\Interfaces;

use Illuminate\Database\Eloquent\Builder;

interface DbOptimizedCommand
{
    /***
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder;
}
