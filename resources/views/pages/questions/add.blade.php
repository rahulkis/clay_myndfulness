@extends ('layouts.app')

@section ('title','Questions | Create')

@section ('content')
<div class="content-wrapper" >
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-repeat"></i>
            </span> Add Question
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a href="{{route("dashboard")}}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" >
                    <a href="{{route("questions.index")}}">Questions</a>
                 </li>
                 <li class="breadcrumb-item" aria-current="page">
                    Add Question
                 </li>
            </ul>
        </nav>
    </div>
    <div class="row justify-content-center">
        <div  class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                <h4 class="card-title">ADD QUESTION</h4>
                <vue-questions-create-component :habbits="{{json_encode($habbits)}}"></vue-questions-create-component>
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
