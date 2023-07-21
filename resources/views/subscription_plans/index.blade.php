@extends ('layouts.app')

@section ('title','Subscription Plans')

@section ('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-calendar-clock"></i>
            </span> Subscription Plans
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a href="{{ route("dashboard") }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                    Subscription plans
                </li>
            </ul>
        </nav>
    </div>
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header text-right">
                    <button class="btn btn-gradient-success btn-sm" data-toggle="modal" data-target="#addPlanModal"><i class="mdi mdi-plus "></i>Add New</button>
                </div>
                <div class="card-body table-responsive">
                    <livewire:subscription-plan-component />
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addPlanModal" tabindex="-1" role="dialog" aria-labelledby="addPlanModal"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary text-white">
                    <h5 class="modal-title" id="addPlanModal">Add New Subscription Plan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <livewire:subscription-plans.create-subscription-plan>
            </div>
        </div>
    </div>
    <div class="modal fade" id="view-plan" tabindex="-1" role="dialog" aria-labelledby="view-habbit-modal" aria-hidden="true">
        <livewire:subscription-plans.view-plan />
    </div>
</div>
@endsection 
@push ("js")
    <script>
        window.addEventListener("closeModal", function(){
            $("#addPlanModal").modal("hide");
        })
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
                Livewire.emitTo('subscription-plan-component','delete',id);
            });
        }
    </script>
@endpush 
