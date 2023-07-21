@extends ('layouts.app')

@section ('title','Daily Journal Responses')

@section ('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-forum"></i>
            </span> Daily Journal Responses
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a href="{{ route("dashboard") }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                    Daily Journal Responses
                </li>
            </ul>
        </nav>
    </div>
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body table-responsive">
                    <livewire:users.daily-journal-responses-list />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection