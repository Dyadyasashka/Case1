@extends('layouts.base')

@section('content')
<div class="pageTitleWidget">
    <div class="pageTitleWidget_text">
        <div class="pageTitleWidget_item.__last">Потребление энергии</div>
    </div>
</div>
    <div class="boxWidget">
        @if (count($consumption['result']) > 0)
            <table class="table-readings">
                <thead>
                    <tr>
                        <th>Месяц</th>                        
                        <th>ID объекта</th>
                        <th>Объект</th>
                        <th>Адрес объекта</th>
                        <th>Потребление</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($consumption['result'] as $data)
                        <tr>
                            <td>{{ $data['month'] }}</td>
                            <td>{{ $data['object']['id'] }}</td>
                            <td>{{ $data['object']['name'] }}</td>
                            <td>{{ $data['object']['address'] ?? 'Нет данных' }}</td>
                            <td>
                                @if (!empty($data['values']))
                                    @foreach ($data['values'] as $value)
                                        {{ $value }}<br>
                                    @endforeach
                                @else
                                    Нет данных
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Нет доступных данных</p>
        @endif
    </div>
@endsection
