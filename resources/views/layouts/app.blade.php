<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    @include('layouts.sections.head')

    <body class="{{ Auth::check() ? 'small' : 'authentication-bg' }}">
        @if(Auth::check())
        <div class="wrapper" id="app">
            <app route="{{ route('basepath') }}" :user="{{ Auth::user()->load('file') }}"></app>
        </div>
        @else
        <div class="wrapper" id="app">
            <auth route="{{ route('basepath') }}"></auth>
        </div>
        @endif

        @include('layouts.sections.script')

    </body>

    @include('layouts.sections.head')

</html>
