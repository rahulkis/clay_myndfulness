<?php

namespace App\Traits;

/**
 * responsible for sorting table livewire table
 * default sorting is date created_at field
 */
trait WithSortable
{
    public $sortField = "created_at";
    public $sortAsc = false;

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = ! $this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }
}
