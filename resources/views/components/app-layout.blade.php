@props(['modal_id', 'modal_title', 'sidenav_product' ])

<div id="applayot">
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/mainpagestyle.css">
    <link rel="stylesheet" href="/css/modalstyle.css">
    <title>Enterprise Resource Planning</title>
</head>
<body>

<div class="sidenav">
    <div class="sidenav-header">
        <div class="logobox">
            <img src="logo.png" alt="Logo">
        </div>
        <div class="sidenav-companyname">Enterprise<br> Resource<br> Planning<br></div>
    </div>
    <div class="sidenav-product">{{ $sidenav_product }}</div>
</div>

<div class="topbar">

    <div class="topbar-product">
        <a href="{{ route('main') }}" class="{{ request()->routeIs('main') ? 'active' : '' }}">Продукты</a>

        @if(Auth::check() && Auth::user()->role === 'admin')
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Админ-панель</a>
        @endif
    </div>
    
    <div class="topbar-username">
    <a href="#" class="art-link"> {{ Auth::user()->name }} </a>
    <div class="admin-dropdown">
        <a href="/profile">Профиль</a>
        @if(Auth::check() && Auth::user()->role === 'admin')
            <a href="{{ route('dashboard') }}">Админ-панель</a>
        @endif
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Выход
        </a>
    </div>
</div>
</div>
</div>

{{$slot}}

@include('modals.add_prod_modal')
@include('modals.show_prod_card')

<script src="{{ asset('js/scripts.js') }}"></script>

</body>
</html>