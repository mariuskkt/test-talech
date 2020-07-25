<table class="{!! $attr['class']  !!}">
    <thead>
    @foreach ($header as $head)
        <th>{{$head}}</th>
    @endforeach
    </thead>
    <tbody>
    @foreach ($rows as $row)
        <tr>
            @foreach ($row as $value)
                <td> {{$value}}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
