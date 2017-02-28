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
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    {{-- css --}}
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
    .tooltip {
        position: fixed;
        right: 50px;
        bottom: 50px;
        opacity: 1;
    }
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
    .dropdown-submenu {
        position: relative;
    }

    .tooltip .tooltiptext {
        visibility: hidden;
        width: 1000%;
        max-width: 500px;
        background-color: #555;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 10px 10px;
        position: absolute;
        z-index: 1;
        bottom: 125%;
        right: 50px;
        opacity: 0;
        font-size: 17px;
        transition: opacity 1s;
    }

    .tooltip:hover .tooltiptext {
        visibility: visible;
        opacity: 1;
    }
</style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top" style="position: fixed; width: 100%;">
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



    </div>

    <div id="wrapper">
        <div class="overlay"></div>
    
        <!-- Sidebar -->
        <nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
            <ul class="nav sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#">
                       Navigation
                    </a>
                </li>
                <li>
                    <a href="/">Home</a>
                </li>
                <li>
                    <a href="#">About</a>
                </li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Lessons<span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                    <li class="dropdown-header">Choose your lesson</li>
                    <li class="dropdown-submenu">
                        <a class="test" tabindex="-1" href="#">Lesson 1<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li class="dropdown-header">Choose your activity</li>
                            <li><a href="#">Situation</a></li>
                            <li><a href="/P1">P1</a></li>
                            <li><a href="/P2">P2</a></li>
                            <li><a href="/P3">P3</a></li>
                            <li><a href="/P4">P4</a></li>
                            <li><a href="/P5">P5</a></li>
                            <li><a href="/P6">P6</a></li>
                            <li><a href="/P7">P7</a></li>
                            <li><a href="/P8">P8</a></li>
                            <li><a href="/P9">P9</a></li>
                            <li><a href="/P10">P10</a></li>
                            <li><a href="/P11">P11</a></li>
                            <li><a href="/P12">P12</a></li>
                            <li><a href="/P13">P13</a></li>
                            <li><a href="/P14">P14</a></li>
                            <li><a href="/P15">P15</a></li>
                        </ul>
                    </li>
                  </ul>
                </li>
                <li>
                    <a href="#">Services</a>
                </li>
            </ul>
        </nav>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <button type="button" class="hamburger is-closed" data-toggle="offcanvas">
                <span class="hamb-top"></span>
                <span class="hamb-middle"></span>
                <span class="hamb-bottom"></span>
            </button>
            <div class="container">
                @yield('content')
                <div class="tooltip">
                    <a href="">
                        <img src="{{ asset('img/icons/activity-help.ico') }}" style="width: 50px; height: 50px">
                    </a>
                    <span class="tooltiptext">
                        @yield('description')
                    </span>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <script>
        $(document).ready(function () {
            var trigger = $('.hamburger'),
            overlay = $('.overlay'),
            isClosed = false;

            trigger.click(function () {
                hamburger_cross();      
            });

            function hamburger_cross() {

                if (isClosed == true) {          
                    overlay.hide();
                    trigger.removeClass('is-open');
                    trigger.addClass('is-closed');
                    isClosed = false;
                } else {   
                    overlay.show();
                    trigger.removeClass('is-closed');
                    trigger.addClass('is-open');
                    isClosed = true;
                }
            }

            $('.dropdown-submenu a.test').on("click", function(e){
                $(this).next('ul').toggle();
                e.stopPropagation();
                e.preventDefault();
              });

            $('[data-toggle="offcanvas"]').click(function () {
                $('#wrapper').toggleClass('toggled');
            });  
        });
    </script>
</body>
</html>
