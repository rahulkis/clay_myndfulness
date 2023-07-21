<table class="table table-bordered">
    <thead>
        <tr>
            <th>SL</th>
            <th>Question</th>
            <th>Response</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($responses as $key => $response)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $response->question }}</td>
                <td>
                    <ol>
                        @foreach ($response->options as $item)
                            <li>{{ $item }}</li>
                        @endforeach 
                    </ol>
                </td>
            </tr>
        @empty 
            <tr>
                <td class="text-danger text-center" colspan="3">No responses found.</td>
            </tr>
        @endforelse 
    </tbody>
</table>
