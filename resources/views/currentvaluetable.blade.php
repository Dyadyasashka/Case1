@extends('layouts.base')
<script src="{{ asset('js/currentvalue.js') }}"></script>
<script src="{{ asset('js/chart.min.js') }}"></script>
<script src="{{ asset('js/chartjs-plugin-zoom.min.js') }}"></script>
@section('content')
<div class="pageTitleWidget">
    <div class="pageTitleWidget_text">
        <div class="pageTitleWidget_item.__last">Мгновенные значения счетчика {{ isset($_COOKIE['meter_name']) ? $_COOKIE['meter_name'] : 'не указано' }}</div>
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
<div class="open-table">
    <button class="btn btn-default" onclick="window.location.href='{{ route('currentvalue', ['meter_id' => request()->route('meter_id'), 'dataType' => $dataType]) }}'">Назад</button>
</div>
@if (isset($currentvalue['result']) && count($currentvalue['result']['data']) > 0)
<div class="boxWidget">
    <table class="table-readings">
        <thead>
            <tr>
                <th>Дата</th>
                @foreach ($currentvalue['result']['headers'] as $index => $header)
                    @if ($index == 4)
                        <th>Сумма</th>
                    @elseif ($index > 0)
                        <th>{{ $header['name'] ?? '' }}</th>
                    @endif
                @endforeach
            </tr>
        </thead>
        <tbody>
            @php
                $data = array_reverse($currentvalue['result']['data']); // Обратная сортировка данных
            @endphp
            @foreach ($data as $data)
                <tr>
                    @foreach ($data as $index => $value)
                        @if ($index == 0)
                            <td>{{ date('d.m.Y H:i:s', strtotime($value)) }}</td>
                        @else
                            <td>{{ $value }}</td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@elseif ($currentvalue['error']['code'] == 20104)
<div class="alert alert-info">
    {{ $currentvalue['data']['details'] }}
</div>
@else
    <p>Нет доступных данных</p>
@endif
@endsection