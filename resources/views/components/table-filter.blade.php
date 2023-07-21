{{-- perPage, and search need to impliment --}}
@props(['placeholder'])
<div class="row mb-4">
    <div class="col form-inline">
        Per Page: &nbsp;
        <select wire:model="perPage" class="form-control form-control-sm">
            <option>10</option>
            <option>25</option>
            <option>50</option>
            <option>100</option>
            <option>500</option>
        </select>
    </div>

    <div class="col">
        <div class="input-group">
            <input wire:model.debounce.1000ms="search" class="form-control form-control-sm" type="text" placeholder="Search {{$placeholder}}...">
        </div>
    </div>
</div>