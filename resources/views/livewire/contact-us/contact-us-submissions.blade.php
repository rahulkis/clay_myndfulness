<div class="card-body table-responsive">
    <x-table-filter :placeholder="'Submissions'" />
    @if ($submissions->count())
        <table class="table table-hover" wire:loading.class='loading'>
            <thead>
                <tr>
                    <th>#</th>
                    <th>
                        <x-sortable-column :sortField="$sortField" :field="'name'" :sortAsc="$sortAsc"/>
                    </th>
                    <th>
                        <x-sortable-column :sortField="$sortField" :field="'email'" :sortAsc="$sortAsc"/>
                    </th>
                    <th>Text</th>
                    <th>
                        <x-sortable-column :sortField="$sortField" :field="'created_at'" :sortAsc="$sortAsc"/>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($submissions as $key => $submission)
                    <tr>
                        <td>{{ $submissions->firstItem() + $key }}</td>
                        <td>{{ $submission->name }}</td>
                        <td>{{ $submission->email }}</td>
                        <td>{{ $submission->text ?? 'N/A'}}</td>
                        <td>{{ $submission->created_at->format(Config::get('modules.full_date_format')) }}</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination-primary d-flex justify-content-end mt-2">
            {{ $submissions->links() }}
        </div>
    @else
        <x-not-found :title="'No submissions Found'" size="400"></x-not-found>
    @endif
</div>
