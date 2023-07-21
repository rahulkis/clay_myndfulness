@extends ('layouts.app')

@section ('title','Change Password')

@section ('content')
<!-- End Page-content -->
<div class="content-wrapper ">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-lock"></i>
            </span> Change Password
        </h3>
    </div>

    <x-alert />
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-rep-plugin">
                        <div class="row">
                            <div class="col-sm-6 ">
                                {!! Form::open(["route" => "change-password.post"]) !!}
                                <div class="form-group @error ('old_password') has-danger @enderror">
                                    {!! Form::label("old_password", "Old Password", ["class" => "label-control"])
                                    !!}
                                    {!! Form::password("old_password", ["class" => "form-control", "placeholder" =>
                                    "Old password"]) !!}
                                    @error ('old_password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group @error ('new_password') has-danger @enderror">
                                    {!! Form::label("new_password", "New Password", ["class" => "label-control"])
                                    !!}
                                    {!! Form::password("new_password", ["class" => "form-control", "placeholder" =>
                                    "New password", "minlength" => 6]) !!}
                                    @error ('new_password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group  @error ('new_password_confirmation') has-danger @enderror">
                                    {!! Form::label("new_password_confirmation", "Confirm Password", ["class" =>
                                    "label-control"]) !!}
                                    {!! Form::password("new_password_confirmation", ["class" => "form-control",
                                    "placeholder" => "Confirm password", "minlength" => 6]) !!}
                                    @error ('new_password_confirmation')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group text-right">
                                    {!! Form::submit("Submit", ["class" => "btn btn-block btn-gradient-primary"]) !!}
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
</div>
@endsection
