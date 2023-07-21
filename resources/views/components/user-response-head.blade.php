<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <p>Name: <a href="{{route("user.profile", $response->user_id)}}"><strong>{{ $response->user->name }}</strong></a></p>
                <p>Email: <a href="{{route("user.profile", $response->user_id)}}"><strong>{{ $response->user->email }}</strong></a></p>
                <p>Date: <strong>{{$response->created_at->format(config("modules.full_date_format"))}}</strong></p>
            </div>
        </div>
    </div>
</div>