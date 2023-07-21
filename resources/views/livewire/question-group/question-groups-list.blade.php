<div class="card-body table-responsive">
    <div class="row">
        <div class="col-md-6">
            <h4 class="card-title">QUESTION GROUPS</h4>
        </div>
        <div class="col-md-6">
            <input type="text" wire:model="search" class="form-control" placeholder="Search">
        </div>
    </div>
    @if ($groups->count())
        <table class="table table-hover" wire:loading.class='loading'>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Order</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($groups as $key => $group)
                    <tr>
                        <td>{{ $groups->firstItem() + $key }}</td>
                        <td>{{ $group->order }}</td>
                        <td>{{ $group->name }}</td>
                        <td>{{ $group->category }}</td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <button wire:click="$emitTo('question-group.edit-question-group','setGroup',{{$group}})" data-toggle="modal" data-target="#edit-group" type="button" class="btn btn-outline-primary btn-sm" title="Edit"><i class="mdi mdi-table-edit"></i></button>
                                <a href="{{route('group-questions.index',['group_id' => $group->id])}}" class="btn btn-outline-primary btn-sm">Questions <i class="mdi mdi-comment-question-outline"></i></a>
                                <button type="button" wire:click="$emit('delete',{{$group->id}})" class="btn btn-outline-danger btn-sm" title="Delete"><i class="mdi mdi-delete "></i></button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination-primary d-flex justify-content-end mt-2">
            {{ $groups->links() }}
        </div>
    @else
        <x-not-found :title="'No groups Found'" size="400"></x-not-found>
    @endif
</div>
