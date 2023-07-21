@props(['collection'])
<div class="row">
    <div class="col text-left text-muted pt-4">
        @if($collection->total())
            Showing {{ $collection->firstItem() }} to {{ $collection->lastItem() }} out of {{ $collection->total() }} results
        @endif
    </div>

    <div {{ $attributes->merge(['class' => 'col']) }}>
        {{ $collection->links() }}
    </div>
</div>