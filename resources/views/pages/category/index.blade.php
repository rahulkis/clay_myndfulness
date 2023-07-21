@extends ('layouts.app')

@section ('title','Categories')

@section ('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-format-list-bulleted-type"></i>
            </span> Categories
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a href="{{ route("dashboard") }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                    Categories
                </li>
            </ul>
        </nav>
    </div>
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header text-right">
                    <button type="button" data-target="#addModal" data-toggle="modal"
                        class="btn btn-gradient-primary btn-sm">
                        Add New <i class="mdi mdi-arrow-right"></i>
                    </button>
                </div>
                <div class="card-body table-responsive">
                    <livewire:category.category-list />
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="view-habbit-modal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary text-white">
                    <h5 class="modal-title" id="view-habbit-modal">Add new category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <livewire:category.create-category />
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
                Livewire.emitTo('category.category-list','delete',id);
            });
        }
        window.addEventListener("closeModal", function(){
            $("#addModal").modal("hide");
            $("#editModal").modal("hide");
        });
        window.addEventListener("editModal", function(){
            $("#editModal").modal("show");
        });
    </script>
@endpush 
