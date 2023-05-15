@extends('layouts.auth')

@section('content')
<div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-4 col-lg-5">
                <div class="card">
                    <!-- Logo -->
                    <div class="card-header pt-4 pb-4 text-center bg-dark">
                        <a href="#">
                            <span><img src="{{asset('assets/images/logo_dark.png')}}" alt="" height="40"></span>
                        </a>
                    </div>

                    <div class="card-body p-4">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif

                        <div class="text-center w-75 m-auto">
                            <h4 class="text-dark-50 text-center mt-0 fw-bold">{{ __('Reset Password') }}</h4>
                            <p class="text-primary mb-4">
                                <small>
                                    Ingrese su email y le enviaremos instrucciones para restablecer su contraseña.
                                </small>
                            </p>
                        </div>

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="mb-3">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Ingrese su correo electrónico">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-0 text-center">
                                <button class="btn btn-primary" type="submit">  {{ __('Send Password Reset Link') }}</button>
                            </div>
                        </form>
                    </div> <!-- end card-body-->
                </div>
                <!-- end card -->

                <div class="row mt-3">
                    <div class="col-12 text-center">
                        <p class="text-muted">Volver al <a href="{{route('login')}}" class="text-muted ms-1"><b>{{ __('Sign in') }}</b></a></p>
                    </div> <!-- end col -->
                </div>
                <!-- end row -->

            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end page -->

<footer class="footer footer-alt">
    2023 © apuestatotal.com
</footer>
@endsection
