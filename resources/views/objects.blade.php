@extends('layouts.base')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://kit.fontawesome.com/d46e17f8a3.js" crossorigin="anonymous"></script>
<script src="{{ asset('js/meter-toggle.js') }}"></script>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/object-id.js') }}"></script>
@section('content')
<div class="pageTitleWidget">
    <div class="pageTitleWidget_text">
        <div class="pageTitleWidget_item.__last">Список объектов</div>
    </div>
</div>
<div class="boxWidget">
    <ul class="object-list">
        @foreach ($objects as $object)
            <li class="list_item">
                <div class="object-block">
                <a class="object-link" href="{{ route('meters', ['networkId' => $networkId, 'object_id'=> $object['id']]) }}" data-object-name = "{{ $object['name'] }}">{{ $object['name'] }}</a><br>
                    Лицевой счет: {{ $object['account'] }}<br>
                    Контрагент: {{ $object['contractor'] ?? 'N/A' }}<br>
                    Расположение: {{ $object['addressSiteValue'] ?? 'N/A' }}<br>
                    Город: {{ $object['city'] ?? 'N/A' }}<br>
                    <div class="hidden-info" style="display: none;">
                        Улица: {{ $object['street'] ?? 'N/A' }}<br>
                        Дом: {{ $object['house'] ?? 'N/A' }}<br>
                        Корпус: {{ $object['building'] ?? 'N/A' }}<br>
                        Расположение: {{ $object['flat'] ?? 'N/A' }}<br>
                        Офис: {{ $object['office'] ?? 'N/A' }}<br>
                        Доп. адрес: {{ $object['additionAddr'] ?? 'N/A' }}<br>
                    </div>
                    <a href="javascript:void(0)" class="toggle-button">Подробнее</a><br>
                    <a href="{{ route('consumption', ['object_id' => $object['id']]) }}" class="meter-link"><i class="fa fa-fw fa-calculator"></i> Потребление</a><br>
                </div>
            </li>
        @endforeach
    </ul>
</div>
@endsection

