<div>
    <x-table-filter :placeholder="'Categories'" />
    @if ($records->isNotEmpty())
        <table class="table table-hover" wire:loading.class='loading'>
            <thead>
                <tr>
                    <th>#</th>
                    <th>
                        <x-sortable-column :sortField="$sortField" :field="'name'" :sortAsc="$sortAsc"/>
                    </th>
                    <th>
                        <x-sortable-column :sortField="$sortField" :field="'created_at'" :sortAsc="$sortAsc"/>
                    </th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $key => $record)
                    <tr>
                        <td>{{ $records->firstItem() + $key }}</td>
                        <td>{{ $record->name ?? "NA" }}</td>
                        <td>{{ $record->created_at->format(config("modules.full_date_format")) ?? "NA" }}</td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-outline-danger" title="Remove"
                                    onClick="return removeItem({{ $record->id }})"><i
                                        class="mdi mdi-delete "></i></button>
                                <button type="button" class="btn btn-outline-primary" title="Update"
                                    wire:click="edit({{$record->id}})"><i
                                        class="mdi mdi-open-in-new  "></i></button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <x-pagination-footer :collection="$records" class="pagination-primary d-flex justify-content-end mt-2" />
    @else
        <x-not-found :title="'No categories found.'" size="400"></x-not-found>
    @endif
    <div wire:ignore class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="view-habbit-modal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary text-white">
                    <h5 class="modal-title" id="view-habbit-modal">Update Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">name</label>
                        <input type="text" wire:model.defer="name" class="form-control @error('name') has-danger @enderror" id="name" placeholder="Name">
                        @error('name')
                            <label id="name-error" class="error mt-2 text-danger" for="name">{{$message}}</label>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-gradient-secondary btn-md" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-gradient-primary btn-md" wire:click="update">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>
