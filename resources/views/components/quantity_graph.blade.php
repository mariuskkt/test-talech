<h1>{{$title}}</h1>
@if(isset($quantity_chart))
    {!! $quantity_chart->container() !!}
    {!! $quantity_chart->script() !!}
@endif
