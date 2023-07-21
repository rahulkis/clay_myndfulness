@extends ('layouts.app')

@section ('title','Question Groups')

@section ('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-repeat"></i>
            </span> Question Groups
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a href="{{route("dashboard")}}">Dashboard</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                    Question Groups
                </li>
            </ul>
        </nav>
    </div>
    <div class="row justify-content-center">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header text-right">
                    <a href="{{ route('questions-group.add') }}" type="button" class="btn btn-gradient-primary btn-sm">
                        Add Group <i class="mdi mdi-arrow-right"></i>
                    </a>
                </div>
                @livewire('question-group.question-groups-list', key('question-groups-list'))
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit-group" tabindex="-1" role="dialog" aria-labelledby="edit-group-modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="view-group-modal">Edit Group</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            <div class="modal-body">
                @livewire('question-group.edit-question-group', key('edit-question-group'))
            </div>
          </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('delete', id => {
            swal({
                title: "Are you sure?",
                text: "This will permanently delete the group and all the questions of this group.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, Delete",
                closeOnConfirm: true
            }, function (isConfirm) {
                if (!isConfirm) return;
                Livewire.emitTo('question-group.question-groups-list','confirmDelete',id);
            });
        });
        Livewire.on('closeModal', id => {
            $('#edit-group').modal('hide');
        });
    });
</script>
@endpush
