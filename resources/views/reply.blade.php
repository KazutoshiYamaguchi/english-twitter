<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    
    <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>
    <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
crossorigin="anonymous"></script>
<!-- popper.js -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
crossorigin="anonymous"></script>
<!-- bootstrap.js -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
crossorigin="anonymous"></script>
    

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/css/layout.css">
    
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                {{-- hashtags --}}
                <div class="dropdown my-dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      #Hashtags
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="/">Show All</a>
                        @foreach($tags as $tag)
                        <a class="dropdown-item" href="/?tag={{$tag['id']}}">{{$tag['name']}}</a>
                        @endforeach
                    </div>
                  </div>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="p-4">
            <div class="row">
                <div class="col-sm-12 col-md-3">
                </div>
                    <div class="col-sm-12 col-md-6 overflow-auto">
                            <a href="{{route('home')}}"><i class="fas fa-arrow-left"></i></a>
                            <div class="card mb-1">
                                <div class="card-body">
                                    <p><strong>{{$reply_post[0]['username']}}</strong></p>
                                {{-- 投稿内容 --}}
                                <p class="card-text">
                                   {{$reply_post[0]['content']}} 
                                </p>
                                {{-- ユーザー名　投稿日 --}}
                                <span>  posted at {{$reply_post[0]['updated_at']}} </span>
                                </div>
                             </div>
                             <div class="card">
                                <form class="form-group" action='{{route('storeReplies')}}' method='post'>
                                    @csrf
                                    <input type="hidden" name='post_id' value='{{$reply_post[0]['id']}}'>
                                    <textarea class="form-control mb-3" name='content' placeholder="Tweet your reply" rows=""></textarea>
                                    @error('content')
                                    <div class="alert alert-danger">Oops! Enter your reply.</div>
                                    @enderror
                                    <div class="dropdown-divider"></div>
                                    <div class="d-flex justify-content-end p-2">  
                                    <button type="submit" class="btn btn-primary">Reply</button>
                                    </div>    
                                </form>
                            </div>
                            <div class="my-card-body replies">
                                @foreach($replies as $reply)
                                <div class="card mb-1">
                                    <div class="card-body">
                                        <p><strong>{{$reply['username']}}</strong></p>
                                    {{-- 投稿内容 --}}
                                    <p class="card-text">
                                       {{$reply['reply_content']}} 
                                    </p>
                                    {{-- ユーザー名　投稿日 --}}
                                    <span>replied at {{$reply['updated_at']}} </span>
                                    </div>
                                 </div>
                                 @endforeach
                            </div>
                    </div>
            
             <div class="col-sm-12 col-md-3 ">
                
             </div>
            </div>
            
        </main>
    </div>
</body>
</html>
