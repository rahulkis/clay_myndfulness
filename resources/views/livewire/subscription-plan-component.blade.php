<div>
    <x-table-filter :placeholder="'Plans'" />
    @if ($plans->count())
        <table class="table table-hover" wire:loading.class='loading'>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Type</th>
                    <th class="text-right">Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($plans as $key => $plan)
                    <tr>
                        <td>{{ $plans->firstItem() + $key }}</td>
                        <td>{{ $plan->name }}</td>
                        <td>{{ $plan->description }}</td>
                        <td>{{ $plan->getTypeString() }}</td>
                        <td class="text-right">{{ config("modules.currency") }}
                            {{ $plan->price }}</td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                {{-- <button type="button" class="btn btn-outline-primary" title="Edit"><i
                                    class="mdi mdi-table-edit"></i></button> --}}
                                <button wire:click="$emitTo('subscription-plans.view-plan','setPlan',{{ $plan->id }})"
                                    data-toggle="modal" data-target="#view-plan" type="button"
                                    class="btn btn-outline-secondary" title="View Details"><i
                                        class="mdi mdi-eye "></i></button>

                                <button type="button" class="btn btn-outline-danger" title="Remove"
                                    onClick="return removeItem({{ $plan->id }})"><i
                                        class="mdi mdi-delete "></i></button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <x-pagination-footer :collection="$plans" class="pagination-primary d-flex justify-content-end mt-2"/>
    @else
        <x-not-found :title="'No Plans Found'" size="400"></x-not-found>
    @endif
</div>
