<div class="bikes-container">
    @foreach($cards as $card)
        <div class="bike">
            <div class="bike-img-container">
                <img class="bike-img" src="{{$card['photo']}}">
            </div>
            <h2>{{$card['title']}}</h2>
            <p>{{$card['description']}}</p>
            <h3>{{$card['city']}}</h3>
            {{$card['more']}}
        </div>
    @endforeach
</div>
