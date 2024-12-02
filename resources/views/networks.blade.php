@extends('layouts.base')
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/network-id.js') }}"></script>
@section('content')
<div class="pageTitleWidget">
    <div class="pageTitleWidget_text">
        <div class="pageTitleWidget_item.__last">Список сетей</div>
    </div>
</div>
@foreach ($networks as $network)
    <li class="list_item">
        <div class="networks-list">  
            <a class="network-link" href="{{ route('objects', ['networkId' => $network['id']]) }}" data-network-id="{{ $network['id'] }}" data-network-name="{{ $network['name'] }}">{{ $network['name'] }}</a><br>
            Владелец: {{ $network['owner'] }}<br>
            Компания: {{ $network['company']['name'] }} (ИНН: {{ $network['company']['inn'] }})<br>
            Адрес: {{ $network['address'] ?: 'N/A' }}<br>
            Режим показа объектов: {{ $network['objectView'] ? 'Включен' : 'Выключен' }}<br>
            Возможности: {{ implode(', ', $network['features']) }}
        </div>
    </li>
@endforeach
@endsection
