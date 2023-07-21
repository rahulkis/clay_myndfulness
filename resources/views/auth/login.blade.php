@extends('layouts.auth')

@section('title','Admin Login')

@section('content')
<div class="container-fluid page-body-wrapper full-page-wrapper">
    <div class="content-wrapper d-flex align-items-center auth">
      <div class="row flex-grow">
        <div class="col-lg-4 mx-auto">
          <div class="auth-form-light text-left p-5">
            <div class="brand-logo text-center">
              <img src="{{asset('assets/images/logo.png')}}">
            </div>
            <h4 class="text-center">Hello! let's get started</h4>
            <h6 class="font-weight-light text-center">Sign in to continue.</h6>
            <form class="pt-3" action="{{route('login')}}" method="POST">
              @csrf
              <div class="form-group @error('email') has-danger @enderror">
                <input type="email" class="form-control form-control-lg" id="exampleInputEmail1" name="email" placeholder="Email" value="{{old("email")}}" autofocus>
                @error('email')
                    <label id="cname-error" class="error mt-2 text-danger" for="cname">{{$message}}</label>
                @enderror
              </div>
              <div class="form-group  @error('password') has-danger @enderror">
                <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" name="password" placeholder="Password">
                @error('password')
                    <label id="cname-error" class="error mt-2 text-danger" for="cname">{{$message}}</label>
                @enderror
              </div>
              <div class="mt-3">
                <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">SIGN IN</button>
              </div>
              <div class="my-2 d-flex justify-content-between align-items-center">
                <div class="form-check">
                  <label class="form-check-label text-muted">
                    <input type="checkbox" class="form-check-input" name="remember"> Keep me signed in </label>
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- content-wrapper ends -->
</div>
@endsection
