<div class="card-body table-responsive">
    <div class="row">
        <div class="col-md-6">
            <h4 class="card-title">HABIT LIST</h4>
        </div>
        <div class="col-md-6">
            <input type="text" wire:model="search" class="form-control" id="name" placeholder="Search">
        </div>
    </div>
    @if ($habbits->count())
        <table class="table table-hover" wire:loading.class='loading'>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($habbits as $key => $habbit)
                    <tr>
                        <td>{{ $habbits->firstItem() + $key }}</td>
                        <td><img src="{{asset('storage/'.$habbit->image)}}" alt="{{$habbit->name}}" width="50"></td>
                        <td>{{ $habbit->name }}</td>
                        <td>{{ $habbit->category->name ?? "NA" }}</td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <button wire:click="$emitTo('habbit.edit-habbit','setHabbit',{{$habbit}})" data-toggle="modal" data-target="#edit-habbit" type="button" class="btn btn-outline-primary btn-sm" title="Edit"><i class="mdi mdi-table-edit"></i></button>
                                <button wire:click="$emitTo('habbit.view-habbit','setHabbit',{{$habbit}})" data-toggle="modal" data-target="#view-habbit" type="button" class="btn btn-outline-secondary btn-sm" title="View Details"><i class="mdi mdi-eye "></i></button>
                                <button type="button" wire:click="$emit('delete',{{$habbit->id}})" class="btn btn-outline-danger btn-sm" title="Delete"><i class="mdi mdi-delete "></i></button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination-primary d-flex justify-content-end mt-2">
            {{ $habbits->links() }}
        </div>
    @else
        <x-not-found :title="'No habits Found'" size="400"></x-not-found>
    @endif
</div>
