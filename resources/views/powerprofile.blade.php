@extends('layouts.base')
<script src="{{ asset('js/powerprofile.js') }}"></script>
<script src="{{ asset('js/chart.min.js') }}"></script>
<script src="{{ asset('js/chartjs-plugin-zoom.min.js') }}"></script>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/datepicker.js') }}"></script>
@section('content')
<div class="pageTitleWidget">
    <div class="pageTitleWidget_text">
        <div class="pageTitleWidget_item.__last">Профиль мощности счетчика {{ isset($_COOKIE['meter_name']) ? $_COOKIE['meter_name'] : 'не указано' }}</div>
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
<div id="powerProfileData" data-data="{{ json_encode($dataPoints) }}"></div>
<form action="{{ route('powerprofile', ['meter_id' => request()->route('meter_id')]) }}" method="get">
    @csrf
    <div class="data-box">
        <div class="data-box-month">
            <input type="month" id="monthPicker" name="month" class="form-control">
            <input type="hidden" id="selectedDate" name="selectedDate">
        </div>
        <select id="groupSelect" class="form-control" name="group">
            <option value="1800">30 мин</option>
            <option value="3600">60 мин</option>
        </select>
        <button type="submit" class="btn btn-success">Обновить</button>
    </div>
</form>
<div id="chartContainer">
    <canvas id="powerProfileChart" class = "boxWidget" style="max-height: 400px;"></canvas>
    <button id="toggleLegendButton">Показать легенду</button>
</div>
@if ($dataPoints->count() > 0)
    <div class="boxWidget">
        <table class="table-readings">
            <thead>
                <tr>
                <th id="date">Дата и время</th>
                <th id="active_power">Активная мощность</th>
                <th id="reverse_active_power">Обратная активная мощность</th>
                <th id="reactive_power">Реактивная мощность</th>
                <th id="reverse_reactive_power">Обратная реактивная мощность</th>
                </tr>
            </thead>
            <tbody>
                @php
                $dataPoints = $powerProfile['result']['data'];
                $dataPoints = array_reverse($dataPoints); // Обратная сортировка
                $page = request('page', 1);
                $itemsPerPage = 10;
                $dataPoints = array_slice($dataPoints, ($page - 1) * $itemsPerPage, $itemsPerPage);
                @endphp
                @foreach ($dataPoints as $dataPoint)
                    <tr>
                        <td>{{ date('d.m.Y H:i:s', strtotime($dataPoint[0])) }}</td>
                        <td>{{ $dataPoint[1] }}</td>
                        <td>{{ $dataPoint[3] }}</td>
                        <td>{{ $dataPoint[2] }}</td>
                        <td>{{ $dataPoint[4] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <p>Данные профиля мощности не доступны.</p>
@endif
@endsection
