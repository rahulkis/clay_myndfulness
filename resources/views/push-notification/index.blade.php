@extends ('layouts.app')

@section ('title','Push Notifications')

@section ('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-calendar-clock"></i>
            </span> Push Notifications
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a href="{{ route("dashboard") }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                    Push Notifications
                </li>
            </ul>
        </nav>
    </div>
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header text-right">
                    <button class="btn btn-gradient-success btn-sm" data-toggle="modal" data-target="#sendNotification"><i class="mdi mdi-plus "></i>Add New</button>
                </div>
                <div class="card-body table-responsive">
                    @livewire('push-notification.push-notifications-list')
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="sendNotification" tabindex="-1" role="dialog" aria-labelledby="sendNotification"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary text-white">
                    <h5 class="modal-title" id="sendNotification">Send App Push Notification</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @livewire('push-notification.new-push-notification')
            </div>
        </div>
    </div>
</div>
@endsection
@push ("js")
    <script>
        window.addEventListener("closeModal", function(){
            $("#sendNotification").modal("hide");
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
                Livewire.emitTo('push-notification.push-notifications-list','delete',id);
            });
        }
    </script>
@endpush
