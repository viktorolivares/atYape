@extends('layouts.auth')

@section('content')

<div class="account-pages pt-2 pt-sm-5 pb-2 pb-sm-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-4 col-lg-5">
                <div class="card">

                    <!-- Logo -->
                    <div class="card-header pt-3 pb-3 text-center bg-dark">
                        <a href="#">
                            <span>
                                <img src="{{ asset('assets/images/logo_dark.png')}}" alt="" height="40">
                            </span>
                        </a>
                    </div>

                    <div class="card-body p-3">
                        <div class="text-center w-75 m-auto">
                            <h4 class="text-dark-50 text-center pb-3 fw-bold">{{ __('Sign in') }}</h4>

                        </div>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('E-Mail Address') }}</label>
                                <input class="form-control @error('email') is-invalid @enderror" name="email"  type="email" id="email" value="{{ old('email') }}" required autocomplete="email" autofocus >
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-primary float-end">
                                        <small>{{ __('Forgot Your Password?') }}</small>
                                    </a>
                                @endif

                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror"  required autocomplete="current-password" >
                                    <div class="input-group-text" data-password="false">
                                        <span class="password-eye"></span>
                                    </div>
                                </div>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                            </div>

                            <div class="mb-3 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember"> {{ __('Remember Me') }}</label>
                                </div>
                            </div>

                            <div class="mb-3 mb-0 text-center">
                                <button class="btn btn-primary px-4" type="submit">{{ __('Login') }}</button>
                            </div>

                        </form>
                    </div> <!-- End card-body -->
                </div>
                <!-- End card -->
            </div>
            <!-- End col -->
        </div>
        <!-- End row -->
    </div>
    <!-- End container -->
</div>

@endsection
