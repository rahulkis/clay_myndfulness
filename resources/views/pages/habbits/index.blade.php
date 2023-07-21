@extends ('layouts.app')

@section ('title','Dashboard')

@section ('content')
<div class="content-wrapper" x-data="{mode : 'view'}" x-on:show-table.window="mode = 'view'">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-repeat"></i>
            </span> Habits
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a href="{{route("dashboard")}}">Dashboard</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                    Habits
                </li>
            </ul>
        </nav>
    </div>
    <div class="row justify-content-center">
        <div x-show="mode == 'view'" class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header text-right">
                    <button type="button" @click="mode = 'create'" class="btn btn-gradient-primary btn-sm">
                        Add Habit <i class="mdi mdi-arrow-right"></i>
                    </button>
                </div>
                @livewire('habbit.habbits-list', key('habbits-list'))
            </div>
        </div>
        <div x-show="mode == 'create'"  class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header text-right">
                    <button type="button" @click="mode = 'view'" class="btn btn-gradient-success btn-sm">
                        View List <i class="mdi mdi-format-list-bulleted-type"></i>
                    </button>
                </div>
                <div class="card-body">
                <h4 class="card-title">ADD HABIT</h4>
                @livewire('habbit.create-new-habbit', key('create-new-habbit'))
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="view-habbit" tabindex="-1" role="dialog" aria-labelledby="view-habbit-modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
              <h5 class="modal-title" id="view-habbit-modal">View Habit Details</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                @livewire('habbit.view-habbit', key('view-habbit'))
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-gradient-primary btn-md" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
    </div>
    <div class="modal fade" id="edit-habbit" tabindex="-1" role="dialog" aria-labelledby="edit-habbit-modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="view-habbit-modal">Edit Habit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            <div class="modal-body">
                @livewire('habbit.edit-habbit', key('edit-habbit'))
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
                Livewire.emitTo('habbit.habbits-list','confirmDelete',id);
            });
        });
        Livewire.on('closeModal', id => {
            $('#edit-habbit').modal('hide');
        });
        Livewire.on('showTable', mode => {
            let event = new CustomEvent("show-table");
            window.dispatchEvent(event);
        });
    });
</script>
@endpush
