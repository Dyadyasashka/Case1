@extends('layouts.base')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://kit.fontawesome.com/d46e17f8a3.js" crossorigin="anonymous"></script>
<script src="{{ asset('js/meter-toggle.js') }}"></script>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/meter-id.js') }}"></script>
@section('content')
<div class="pageTitleWidget">
    <div class="pageTitleWidget_text">
        <div class="pageTitleWidget_item.__last">
            Список счетчиков сети {{ isset($_COOKIE['network_name']) ? $_COOKIE['network_name'] : 'без названия' }}
        </div>
    </div>
</div>
    <ul class="object-list">
        @foreach ($meters as $meter)
            <li class="list_item">
            <div class="object-block">
                <a class="meter-link" href="{{ route('readings', ['meter_id' => $meter['id']]) }}" data-meter-name="{{ $meter['mark'] }}">{{ $meter['num'] }} {{ $meter['mark'] }}</a><br>
                @if (isset($meter))
                    Объект: {{ $meter['object'] ?? 'Нет данных'}}<br>
                    Адрес: {{ $meter['address'] ?? 'Нет данных'}}<br>
                    Потери при коротком замыкании: {{ $meter['lossShortCircuit'] ?? 'Нет данных'}}<br>
                    Потери в простое: {{ $meter['lossIdle'] ?? 'Нет данных'}}<br>
                    <div class="hidden-info" style="display: none;">
                        Электрический: {{ $meter['electric'] ? 'Да' : 'Нет' }}<br>
                        KTT: {{ $meter['ktt'] ?? 'Нет данных'}}<br>
                        KTN: {{ $meter['ktn'] ?? 'Нет данных'}}<br>
                        Дата следующей проверки: {{ $meter['dateCheckNext'] ?? 'Нет данных'}}<br>
                        Номер: {{ $meter['num'] ?? 'Нет данных'}}<br>
                        Марка: {{ $meter['mark'] ?? 'Нет данных'}}<br>
                        Тип: {{ $meter['type'] ?? 'Нет данных'}}<br>
                        Единица измерения: {{ $meter['unit'] ?? 'Нет данных'}}<br>
                    </div>
                    <a href="javascript:void(0)" class="toggle-button">Подробнее</a><br>
                    <a href="{{ route('readings', ['meter_id' => $meter['id']]) }}" data-meter-name="{{ $meter['mark'] }}" class="meter-link"><i class="fa fa-fw fa-tachometer"></i> Показания</a><br>
                    <a href="{{ route('powerprofile', ['meter_id' => $meter['id']]) }}" data-meter-name="{{ $meter['mark'] }}" class="meter-link"><i class="fa fa-fw fa-bar-chart"></i> Профиль мощности</a><br>
                    <a href="{{ route('currentvalue', ['meter_id' => $meter['id']]) }}" data-meter-name="{{ $meter['mark'] }}" class="meter-link"><i class="fa fa-fw fa-line-chart"></i> Мгновенные значения</a><br>
                @else
                    <strong>Счетчики не найдены</strong><br>
                @endif
            </div>
            </li>
        @endforeach
    </ul>
@endsection