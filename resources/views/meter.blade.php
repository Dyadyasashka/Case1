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
            Список счетчиков объекта {{ isset($_COOKIE['object_name']) ? $_COOKIE['object_name'] : 'без названия' }}
        </div>
    </div>
</div>
    <ul class="object-list">
        @foreach ($meters['result'] as $meter)
            <li class="list_item">
            <div class="object-block">
                <a class="meter-link" href="{{ route('readings', ['meter_id' => $meter['values'][0]['id']]) }}" data-meter-name="{{ $meter['values'][0]['num'] }} {{ $meter['values'][0]['mark'] }}">{{ $meter['values'][0]['num'] }} {{ $meter['values'][0]['mark'] }}</a><br>
                @if (isset($meter['values'][0]))
                    Объект: {{ $meter['values'][0]['object'] ?? 'Нет данных'}}<br>
                    Адрес: {{ $meter['values'][0]['address'] ?? 'Нет данных'}}<br>
                    Потери при коротком замыкании: {{ $meter['values'][0]['lossShortCircuit'] ?? 'Нет данных'}}<br>
                    Потери в простое: {{ $meter['values'][0]['lossIdle'] ?? 'Нет данных'}}<br>
                    <div class="hidden-info" style="display: none;">
                        Электрический: {{ $meter['values'][0]['electric'] ? 'Да' : 'Нет' }}<br>
                        KTT: {{ $meter['values'][0]['ktt'] ?? 'Нет данных'}}<br>
                        KTN: {{ $meter['values'][0]['ktn'] ?? 'Нет данных'}}<br>
                        Дата следующей проверки: {{ $meter['values'][0]['dateCheckNext'] ?? 'Нет данных'}}<br>
                        Номер: {{ $meter['values'][0]['num'] ?? 'Нет данных'}}<br>
                        Марка: {{ $meter['values'][0]['mark'] ?? 'Нет данных'}}<br>
                        Тип: {{ $meter['values'][0]['type'] ?? 'Нет данных'}}<br>
                        Единица измерения: {{ $meter['values'][0]['unit'] ?? 'Нет данных'}}<br>
                    </div>
                    <a href="javascript:void(0)" class="toggle-button">Подробнее</a><br>
                    <a href="{{ route('readings', ['meter_id' => $meter['values'][0]['id']]) }}" data-meter-name="{{ $meter['values'][0]['num'] }} {{ $meter['values'][0]['mark'] }}" class="meter-link"><i class="fa fa-fw fa-tachometer"></i> Показания</a><br>
                    <a href="{{ route('powerprofile', ['meter_id' => $meter['values'][0]['id']]) }}" data-meter-name="{{ $meter['values'][0]['num'] }} {{ $meter['values'][0]['mark'] }}" class="meter-link"><i class="fa fa-fw fa-bar-chart"></i> Профиль мощности</a><br>
                    <a href="{{ route('currentvalue', ['meter_id' => $meter['values'][0]['id']]) }}" data-meter-name="{{ $meter['values'][0]['num'] }} {{ $meter['values'][0]['mark'] }}" class="meter-link"><i class="fa fa-fw fa-line-chart"></i> Мгновенные значения</a><br>
                @else
                    <strong>Счетчики не найдены</strong><br>
                @endif
            </div>
            </li>
        @endforeach
    </ul>
@endsection

