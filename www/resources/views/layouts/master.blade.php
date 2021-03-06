<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name') }}</title>

  <link rel="stylesheet" href="{{ mix('/css/app.css') }}">

  <!-- mapbox -->
  <link href="https://api.tiles.mapbox.com/mapbox-gl-js/v0.53.0/mapbox-gl.css" rel="stylesheet" />
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper" id="app">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
        </li>
        </ul>

        <!-- search form -->
        @include('layouts.search-form')

    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <router-link to="/dashboard" class="brand-link">
        <img src="{{ asset('/images/logo256.png') }}" alt="" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.company') }}</span>
        </router-link>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <router-link to="/profile">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ auth()->user()->photo }}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    {{ Auth::user()->name }}
                    <span class="d-block text-muted">
                        {{ Ucfirst(Auth::user()->type) }}
                    </span>
                </div>
            </div>
            </router-link>

        <!-- Sidebar Menu -->
        @include('layouts.sidebar-menu')
        <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    {{-- Content Wrapper. Contains page content --}}
    <div class="content-wrapper">
        {{-- Main content --}}

        <!-- Content Header (Page header) -->
        <div class="content-header">
        <div class="container-fluid">
            {{-- <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Starter Page</li>
                </ol>
            </div><!-- /.col -->
            </div><!-- /.row --> --}}
        </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <router-view user_type="{{ Auth::user()->type }}"></router-view>
        <vue-progress-bar></vue-progress-bar>
        {{-- /.content --}}
    </div>
    {{-- /.content-wrapper --}}

    {{-- Main Footer --}}
    <footer class="main-footer">
        {{-- To the right --}}
        <div class="float-right d-none d-sm-block">
            <small>
                <strong>Powered by <a href="https://www.webartigiani.it/">WebArtigiani</a></strong>
            </small>
        </div>
        {{-- Default to the left --}}
        <small>
            <b>versione Sito</b> {{config('app.version')}} | <b>versione APP</b> {{config('app.app_version')}}
        </small>
    </footer>
    </div>
{{-- ./wrapper --}}

@auth
<script>
    window.user = @json(auth()->user())
</script>
@endauth
<script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>
