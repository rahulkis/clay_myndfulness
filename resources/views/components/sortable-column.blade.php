@props([
    "sortField",
    "field",
    "sortAsc"
])
<a wire:click.prevent="sortBy('{{$field}}')" role="button" href="#" class="{{$field  === $sortField ? "active" : ""}}">
    {{ucwords(str_replace("_"," ",  $field))}}
    <x-sort-icon :sortField="$sortField" :field="$field" :sortAsc="$sortAsc"/>
</a>