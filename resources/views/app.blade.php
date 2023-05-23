<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    @include('layouts.head')

    <body class="{{ Auth::check() ? 'small' : 'authentication-bg' }}">

    <div class="wrapper" id="app">
        @if(Auth::check())
            <app route="{{ route('basepath') }}" :user="{{ Auth::user()->load('file') }}"></app>

        @else
            <auth route="{{ route('basepath') }}"></auth>
        @endif
    </div>

        @include('layouts.script')

    </body>

</html>
