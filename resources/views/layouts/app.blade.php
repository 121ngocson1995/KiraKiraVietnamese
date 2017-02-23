<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/j/bootstrap.min.js"></script>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script
          src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
          integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
          crossorigin="anonymous"></script>
    {{-- css --}}

    <style>
          #sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
          #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 18px; }
          #sortable li span { position: absolute; margin-left: -1.3em; }
      </style>
          <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
          <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
      <script>
          $( function() {
            $( "#sortable" ).sortable();
            $( "#sortable" ).disableSelection();
          } );
      </script>
    <style type="text/css">
    #container {
      margin: 20px;
      width: 50%;
      height: 8px;
    }
    .playWord {
        transition: background 0.2s;
    }
    .playWord:hover {
        background: cyan;
    }
    .playWord:active {
        outline: none;
    }
    .playWord:focus {
        outline: none;
    }
    .img_right {
        width: 300px;
        height: 300px;
        padding: 10px;
        border: 1px solid #aaaaaa;
        background-image: url("{{ URL::asset('P4_img/right.jpeg') }}");
        background-size: 300px 300px;
        position: relative;
        left: 10%;
        opacity: 0;
    }
    .img_wrong {
        width: 300px;
        height: 300px;
        padding: 10px;
        border: 1px solid #aaaaaa;
        background-image: url("{{ URL::asset('P4_img/wrong.jpeg') }}");
        background-size: 300px 300px;
        position: relative;
        left: 50%;
        opacity: 0;
    }
    .wordLine {
        margin: 8px 0px;
    }
    .controlBtn {
        padding: 10px;
    }
    .correctWord, .correctWord:hover {
        background: #33ffad;
    }
    .wrongWord, .wrongWord:hover {
        color: white;
        background: red;
    }

    /* Tooltip */
    .tooltip > .tooltip-inner {
        color: #FFFFFF;
        width: 120px;
        border: 1px solid black;
        padding: 15px;
        font-size: 14px;
    }

    /* Tooltip on bottom */
    .tooltip.bottom > .tooltip-arrow {
        border-bottom: 5px solid;
    }
</style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
