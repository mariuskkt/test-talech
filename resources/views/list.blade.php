@extends('layouts.app')

@section('content')
    <ul>
        @foreach ($list as $list_item)
            <li>{{ $list_item}}</li>
        @endforeach
    </ul>
@endsection
