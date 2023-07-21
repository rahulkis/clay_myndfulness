@extends ('layouts.app')

@section ('title','Contact Us Submissions')

@section ('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-contact-mail-outline"></i>
            </span> Contact Us Submissions
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a href="{{route("dashboard")}}">Dashboard</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                    Contact Us Submissions
                </li>
            </ul>
        </nav>
    </div>
    <div class="row justify-content-center">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                @livewire('contact-us.contact-us-submissions', key('contact-us-submissions'))
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
    });
</script>
@endpush
