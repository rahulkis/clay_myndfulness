@extends ('layouts.app')

@section ('title','Questions Group | Create')

@section ('content')
<div class="content-wrapper" >
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-repeat"></i>
            </span> Questions
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a href="{{route("dashboard")}}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" >
                    <a href="{{ route('questions-group.index') }}">Question Groups</a>
                 </li>
                 <li class="breadcrumb-item" aria-current="page">
                    Questions
                 </li>
            </ul>
        </nav>
    </div>
    <div class="row justify-content-center">
        <div  class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                <h4 class="card-title">QUESTIONS</h4>
                    <vue-group-questions-create-component :question_categories="{{json_encode($question_categories)}}" :questions="{{json_encode($questions)}}" :group_main="{{json_encode($group)}}"></vue-group-questions-create-component>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('js')
<script src="{{asset('js/app.js')}}"></script>
<script>

</script>
@endpush
