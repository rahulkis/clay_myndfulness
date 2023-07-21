@extends ('layouts.app')

@section ('title','Dashboard')

@section ('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-comment-question-outline"></i>
            </span> Questions
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a href="{{route("dashboard")}}">Dashboard</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                    Questions
                </li>
            </ul>
        </nav>
    </div>
    <div class="row justify-content-center">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header text-right">
                    <a href="{{route('questions.add')}}" class="btn btn-gradient-success btn-sm mr-2">Add Question <i class="mdi mdi-arrow-right"></i> </a>
                </div>
                @livewire('question.questions-list', key('questions-list-all'))
            </div>
        </div>
    </div>
    <div class="modal fade" id="view-question" tabindex="-1" role="dialog" aria-labelledby="view-question-modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
              <h5 class="modal-title" id="view-question-modal">View question Details</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                @livewire('question.view-question', key('view-question'))
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-gradient-primary btn-md" data-dismiss="modal">Close</button>
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
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, Delete",
                closeOnConfirm: true
            }, function (isConfirm) {
                if (!isConfirm) return;
                Livewire.emitTo('question.questions-list','confirmDelete',id);
            });
        });
        Livewire.on('closeModal', id => {
            $('#edit-habbit').modal('hide');
        });
    });
</script>
@endpush
