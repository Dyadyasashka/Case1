@extends('layouts.base')
<script src="{{ asset('js/currentvalue.js') }}"></script>
<script src="{{ asset('js/chart.min.js') }}"></script>
<script src="{{ asset('js/chartjs-plugin-zoom.min.js') }}"></script>
@section('content')
<div class="pageTitleWidget">
    <div class="pageTitleWidget_text">
        <div class="pageTitleWidget_item.__last">Мгновенные значения счетчика {{ isset($_COOKIE['meter_name']) ? $_COOKIE['meter_name'] : 'без названия' }}</div>
    </div>
</div>
<div class="paneWidget">
    <li class="paneWidget_pane">
        <a class="paneWidget_link" href="{{ route('readings', ['meter_id' => request()->route('meter_id')]) }}">Показания</a>
    </li>
    <li class="paneWidget_pane">
        <a class="paneWidget_link" href="{{ route('powerprofile', ['meter_id' => request()->route('meter_id')]) }}">Профиль Мощности</a>
    </li>
    <li class="paneWidget_pane">
        <a class="paneWidget_link" href="{{ route('currentvalue', ['meter_id' => request()->route('meter_id')]) }}">Мгновенные Значение</a>
    </li>
</div>
<div id="currentValueData" data-data="{{ json_encode($dataPoints) }}" data-meter_id="{{ $meter_id }}"></div>

<div class="data-box-button">
    <div class="open-table" style="flex: 1;">
        <button class="btn btn-default" onclick="window.location.href='{{ route('currentvaluetable', ['meter_id' => request()->route('meter_id'), 'dataType' => $dataType]) }}'">Таблица</button>
    </div>
    <form method="get" action="{{ route('currentvalue', ['meter_id' => $meter_id]) }}">
        @csrf
        <input type="hidden" name="dataType" value="{{ $dataType }}">
        <div class="btn-group pull-right" style="flex: 0;">
            <button class="btn btn-default {{ request('type') == 'day' ? 'btn-success' : '' }}" type="submit" name="type" value="day">сегодня</button>
            <button class="btn btn-default {{ request('type') == 'month' ? 'btn-success' : '' }}" type="submit" name="type" value="month">месяц</button>
        </div>
    </form>
</div>
<div id="chartContainer">
<canvas id="currentValueChart" class = "boxWidget" style="max-height: 450px;"></canvas>
<button id="toggleLegendButton">Показать легенду</button>
</div>
<div id="chartButtons" class="chartButton currentValues_switcherWrapper">
    <a class="voltage" title="Фазное напряжение"><button id="button_voltage">Uф</button></a>
    <a class="current" title="Сила тока"><button id="button_current">I</button></a>
    <a class="activePower" title="Активная мощность"><button id="button_activePower">P</button></a>
    <a class="reactivePower" title="Реактивная мощность"><button id="button_reactivePower">Q</button></a>
    <a class="fullPower" title="Полная мощность"><button id="button_fullPower">S</button></a>
    <a class="powerFactor" title="Коэффициент мощности"><button id="button_powerFactor">cosφ</button></a>
    <a class="angle" title="Угол между фазными напряжениями"><button id="button_angle">∠</button></a>
    <a class="frequency" title="Частота сети"><button id="button_frequency">F</button></a>
</div>
@endsection