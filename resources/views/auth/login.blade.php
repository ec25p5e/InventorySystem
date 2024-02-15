@extends('layouts.auth')

@section('login')
    <div class="login-header box-shadow">
        <div
            class="container-fluid d-flex justify-content-between align-items-center"
        >
            <div class="brand-logo">
                <a href="login.html">
                    <img src="{{ asset('assets/images/images.jpg') }}" alt="" />
                </a>
            </div>
            <div class="login-menu">
                <ul>
                    <li><a href="register.html">Register</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div
        class="login-wrap d-flex align-items-center flex-wrap justify-content-center"
    >
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-7">
                    <img src="" alt="" />
                </div>
                <div class="col-md-6 col-lg-5">
                    <div class="login-box bg-white box-shadow border-radius-10">
                        <div class="login-title">
                            <h2 class="text-center text-primary">Accedi al gestionale</h2>
                        </div>
                        <form action="{{ route('login') }}" method="post" class="form-login">
                            @csrf
                            <div class="form-group has-feedback @error('email') has-error @enderror">
                                <input type="email" name="email" class="form-control" placeholder="Email" required value="{{ old('email') }}" autofocus>
                                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                @error('email')
                                <span class="help-block">{{ $message }}</span>
                                @else
                                    <span class="help-block with-errors"></span>
                                    @enderror
                            </div>
                            <div class="form-group has-feedback @error('password') has-error @enderror">
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                @error('password')
                                <span class="help-block">{{ $message }}</span>
                                @else
                                    <span class="help-block with-errors"></span>
                                    @enderror
                            </div>
                            <div class="row">
                                <div class="col-xs-8">
                                    <div class="checkbox icheck">
                                        <label>
                                            <input type="checkbox"> Ricordami
                                        </label>
                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-xs-4">
                                    <button type="submit" class="btn btn-success btn-block btn-flat">Log In</button>
                                </div>
                                <!-- /.col -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
