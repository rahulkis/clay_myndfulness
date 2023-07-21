@extends ('layouts.app')

@section ('title','Users')

@section ('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-account-group"></i>
            </span> Users
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a href="{{ route("dashboard") }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                    Users
                </li>
            </ul>
        </nav>
    </div>
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body table-responsive">
                    <livewire:users.user-list />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
@push ("js")
    <script>
        removeItem = function(id){
            swal({
                title: "Are you sure?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, Delete",
                closeOnConfirm: true
            }, function (isConfirm) {
                if (!isConfirm) return;
                alert("please add delete function here.");
                // Livewire.emitTo('subscription-plan-component','delete',id);
            });
        }
    </script>
@endpush 
