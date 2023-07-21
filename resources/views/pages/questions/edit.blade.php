@extends ('layouts.app')

@section ('title','Questions | Edit')

@section ('content')
<div class="content-wrapper" >
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-repeat"></i>
            </span> Edit Question
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
                    Edit Question
                 </li>
            </ul>
        </nav>
    </div>
    <div class="row justify-content-center">
        <div  class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                <h4 class="card-title">EDIT QUESTION</h4>
                <vue-questions-edit-component :question_old="{{$question}}" :habbits="{{json_encode($habbits)}}"></vue-questions-edit-component>
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
