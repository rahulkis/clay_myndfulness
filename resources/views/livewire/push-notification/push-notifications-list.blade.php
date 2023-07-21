<div>
    {{-- <x-table-filter :placeholder="'Plans'" /> --}}
    @if ($notifications->count())
        <table class="table table-hover" wire:loading.class='loading'>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Message</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($notifications as $key => $notification)
                    <tr>
                        <td>{{ $notifications->firstItem() + $key }}</td>
                        <td>{{ $notification->title }}</td>
                        <td>{{ $notification->message }}</td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-outline-danger" title="Remove"
                                    onClick="return removeItem({{ $notification->id }})"><i
                                        class="mdi mdi-delete "></i></button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <x-pagination-footer :collection="$notifications" class="pagination-primary d-flex justify-content-end mt-2"/>
    @else
        <x-not-found :title="'No Record Found'" size="400"></x-not-found>
    @endif
</div>
