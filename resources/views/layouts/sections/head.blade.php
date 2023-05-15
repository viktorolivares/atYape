<head>

    <meta charset="utf-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'atYape!') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Transactions AT / Yape" name="description">
    <meta content="apuestatotal" name="author">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}">

    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <!-- App css -->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="light-style">
    <link href="{{ asset('assets/css/app-dark.min.css') }}" rel="stylesheet" type="text/css" id="dark-style">

    <!-- Custom -->
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css" id="dark-style">

    <!-- Scripts -->
    @vite(['resources/js/app.js'])

</head>
