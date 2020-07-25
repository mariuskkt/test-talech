<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
{{--        <a class="navbar-brand" href="{{ url('/') }}">--}}
{{--            {{ config('app.name', 'Share a bike') }}--}}
{{--        </a>--}}
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                @foreach($nav['left'] as $link)
                    <li class="nav-item">
                        <a class="nav-link" href="{{$link['url']}}">{{ __($link['name']) }}</a>
                    </li>
                @endforeach
            </ul>
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    @foreach($nav['right'] as $link)
                        <li class="nav-item">
                            <a class="nav-link" href="{{$link['url']}}">{{ __($link['name']) }}</a>
                        </li>
                    @endforeach
                    @foreach($nav['register'] ?? [] as $link)
                        <li class="nav-item">
                            <a class="nav-link" href="{{$link['url']}}">{{ __($link['name']) }}</a>
                        </li>
                    @endforeach
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            @foreach($nav['right']['dropdown'] as $link)
                                @if($link['url'] == route('logout'))
                                    <a class="dropdown-item" href="{{$link['url']}}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __($link['name']) }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        @csrf
                                    </form>
                                @else
                                    <a class="dropdown-item" href="{{$link['url']}}">{{ __($link['name']) }}</a>
                                @endif
                            @endforeach
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
