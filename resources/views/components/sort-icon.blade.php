@props([
    "sortField",
    "field",
    "sortAsc"
])
@if ($sortField !== $field)
    <i class="mdi mdi-sort"></i>
@elseif ($sortAsc)
    <i class="mdi mdi-sort-ascending"></i>
@else
    <i class="mdi mdi-sort-descending"></i>
@endif