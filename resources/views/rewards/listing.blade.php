<table class='table table-hover'>
    <thead>
        <tr>
            <th>Rank</th>
            <th>Name</th>
            <th>Medal <x-medal-icon /></th>
            <th>Coins <x-coin-icon /></th>
        </tr>
    </thead>
    <tbody>
        @forelse ($records as $key => $record)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$record->name}}</td>
                <td>{{$record->total_medal}} </td>
                <td>{{$record->total_coin}} </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-danger text-center">No Records found.</td>
            </tr>
        @endforelse
    </tbody>
</table>