@extends('layouts.base')

@section('content')
<div class="pageTitleWidget">
    <div class="pageTitleWidget_text">
        <div class="pageTitleWidget_item.__last">Показания счетчика {{ isset($_COOKIE['meter_name']) ? $_COOKIE['meter_name'] : 'не указано' }}</div>
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
<div class="boxWidget">
    @if (!empty($readings['result']))
        <table class="table-readings">
            <thead>
                <tr>
                    <th>Дата</th>
                    <th>Т1, А+</th>
                    <th>Т2, А+</th>  
                    <th>Сумма, А+</th>
                    <th>Обратная активная энергия</th>
                    <th>Прямая реактивная энергия</th>
                    <th>Обратная реактивная энергия</th>
                    <th>Ошибка</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($readings['result'] as $reading)
                    <tr>
                        <td>{{ date('d.m.Y H:i:s', strtotime($reading['date'])) }}</td>
                        <td>{{ $reading['zones'][0]['value'] ?? 'нет данных' }}</td>
                        <td>{{ $reading['zones'][1]['value'] ?? 'нет данных' }}</td>
                        <td>{{ $reading['value'] ?? 'нет данных' }}</td>
                        <td>{{ $reading['reverseValue'] ?? 'нет данных' }}</td>
                        <td>{{ $reading['reactiveValue'] ?? 'нет данных' }}</td>
                        <td>{{ $reading['reactiveReverseValue'] ?? 'нет данных' }}</td>
                        <td>
                            @if (!empty($reading['error']))
                                Код ошибки: {{ $reading['error']['code'] }}<br>
                                Сообщение об ошибке: {{ $reading['error']['message'] }}
                            @else
                                нет ошибок
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Показания счетчика не найдены.</p>
    @endif
</div>
@endsection
