<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
</head>
<body>
<div class="sidebar">
    <!-- Заголовок бренда с ссылкой -->
    <div class="brand-header">
        <a href="{{ url('/networks')}}" class="brand-title">Личный кабинет</a>
    </div>
    <!-- Меню -->
    <ul class="menu">
        <li class="menu-item"><a href="{{ route('networks') }}">Сети</a></li>
        @if (isset($_COOKIE['network_id']))
        <li class="menu-item"><a href="{{ route('objects', ['networkId' => $_COOKIE['network_id'] ?? 'null']) }}">Объекты</a></li>
        <li class="menu-item"><a href="{{ route('metersall', ['networkId' => $_COOKIE['network_id'] ?? 'null']) }}">Счетчики</a></li>
        @endif
        <li class="menu-item"><a href="{{ route('support') }}">Техподдержка</a></li>
    </ul>
</div>
</body>
</html>
