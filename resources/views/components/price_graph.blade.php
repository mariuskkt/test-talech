<h1>{{$title}}</h1>
@if(isset($price_chart))
    {!! $price_chart->container() !!}
    {!! $price_chart->script() !!}
@endif
