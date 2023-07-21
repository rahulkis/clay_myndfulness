@extends ('layouts.app')

@section ('title','Daily Journal responses')

@section ('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-forum"></i>
            </span> Daily Journal responses
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route("dashboard") }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                    <a href="{{ route("users.self-assessment-responses") }}">Daily Journal
                        response</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $response->id ." - ".$response->created_at->format(config("modules.full_date_format")) }}
                </li>
            </ul>
        </nav>
    </div>
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <x-user-response-head :response='$response' />
                    <x-user-response :responses='$response->transactions' />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
@push ("js")
@endpush 
