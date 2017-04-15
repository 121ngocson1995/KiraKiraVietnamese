@extends('layouts.app')

@section('body')

<link rel="stylesheet" href="{{ asset('css/register-login.css') }}">
<style>
    body {
       height: calc(100% - 65px);
       background-repeat: no-repeat;
       background:url({{ asset('img/register-bg.svg') }}) no-repeat center center fixed;
       font-family: 'Oxygen', sans-serif;
       background-size: cover;
   }
</style>

<div class="container">
    <div class="row main">
        <div class="main-login main-center">
            {{-- <h4 style="color: white">Apply to become a teacher at KiraKiraVietnamese</h4> --}}
            <form class="" role="form" method="post" action="{{ route('login') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="cols-sm-2 control-label">Your Email</label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
                            <input type="text" class="form-control" name="email" id="email" value="{{ old('email') }}" maxlength="191" placeholder="Enter your Email" required autofocus>
                        </div>
                    </div>

                    @if ($errors->has('email'))
                    <div class="help-block">
                        <span>{{ $errors->first('email') }}</span>
                    </div>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="cols-sm-2 control-label">Password</label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                            <input type="password" class="form-control" name="password" id="password" maxlength="24" placeholder="Enter your Password" required>
                        </div>
                    </div>

                    @if ($errors->has('password'))
                    <div class="help-block">
                        <span>{{ $errors->first('password') }}</span>
                    </div>
                    @endif
                </div>

                <div class="form-group ">
                    <button type="submit" target="_blank" id="submitBtn" class="btn btn-success btn-lg btn-block login-button">Login</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
