<div>
    @if($show_filter)
    <x-table-filter :placeholder="'Users'" />
    @endif
    @if ($records->isNotEmpty())
        <table class="table table-hover" wire:loading.class='loading'>
            <thead>
                <tr>
                    <th>#</th>
                    @if(!$single_user)
                    <th>Name</th>
                    <th>Email</th>
                    @endif
                    <th>Submitted at</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $key => $record)
                    <tr>
                        <td>{{ $records->firstItem() + $key }}</td>
                        @if(!$single_user)
                        <td>{{ $record->user->name ?? "NA" }}</td>
                        <td>{{ $record->user->email ?? "NA" }}</td>
                        @endif
                        <td>{{ $record->created_at->format(config("modules.full_date_format")) ?? "NA" }}</td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <a href="{{route("daily-journal.show", $record)}}" target="_blank" class="btn btn-outline-secondary" title="View Details">
                                    <i class="mdi mdi-eye "></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if($records->hasMorePages())
        <div class="text-center">
            <a class="text-center text-primary text-decoration-underline text-sm" href="javascript:void();" wire:click="viewMore">View More</p>
        </div>
        @endif
    @else
        <x-not-found :title="'No user responses found.'" size="400"></x-not-found>
    @endif
</div>
