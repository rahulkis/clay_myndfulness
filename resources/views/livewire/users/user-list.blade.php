<div>
    <x-table-filter :placeholder="'Users'" />
    @if ($users->isNotEmpty())
        <table class="table table-hover" wire:loading.class='loading'>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Registered at</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $key => $user)
                    <tr>
                        <td>{{ $users->firstItem() + $key }}</td>
                        <td>{{ $user->name ?? "NA" }}</td>
                        <td>{{ $user->email ?? "NA" }}</td>
                        <td>{{ $user->created_at->format(config("modules.full_date_format")) ?? "NA" }}</td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                {{-- <button type="button" class="btn btn-outline-primary" title="Edit"><i
                                class="mdi mdi-table-edit"></i></button> --}}
                                <a href="{{route("user.profile", $user)}}" target="_blank" class="btn btn-outline-secondary" title="View Details">
                                    <i class="mdi mdi-eye "></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <x-pagination-footer :collection="$users" class="pagination-primary d-flex justify-content-end mt-2" />
    @else
        <x-not-found :title="'No users found.'" size="400"></x-not-found>
    @endif
</div>
