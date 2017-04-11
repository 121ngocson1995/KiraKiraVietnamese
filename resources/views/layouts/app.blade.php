<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'KiraKiraVietnamese') }}</title>

    <!-- Styles -->
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>

    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    {{-- <script src="https://use.fontawesome.com/45e03a14ce.js"></script> --}}
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Patrick+Hand" rel="stylesheet">
    <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui1-12.1.js') }}"></script>
    <script src="{{ asset('js/jquery.ui.touch-punch.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Pretty-Header-1.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Pretty-Footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/scrollbar.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}"> --}}
    {{-- css --}}

@yield('header')
    
</head>
<body>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">

            <div class="navbar-header">
                <button type="button" class="hamburger" onclick="toggleNav()">
                    <span class="hamb-top"></span>
                    <span class="hamb-middle"></span>
                    <span class="hamb-bottom"></span>
                </button>
                <a class="navbar-brand original navbar-link" href="/" style="font-family: Arial;">KiraKiraVietnamese </a>
                <a class="navbar-brand title navbar-link" href="/" style="font-family: Arial;"></a>
                <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
            </div>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav navbar-right">
                    <li role="presentation" class="{{ strcmp(\Request::path(), '/') == 0 ? 'active' : '' }} navbtn"><a href="/">Home</a></li>
                    <li role="presentation" class="{{ strcmp(\Request::path(), 'lessons') == 0 ? 'active' : '' }} navbtn"><a href="/lessons">Lessons</a></li>
                    {{-- <li role="presentation" class="{{ strcmp(\Request::path(), '/') == 0 ? 'active' }} navbtn"><a href="#">Guide</a></li> --}}
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li role="presentation" class="{{ strcmp(\Request::path(), 'login') == 0 ? 'active' : '' }} navbtn"><a href="{{ url('/login') }}">Login</a></li>
                        <li role="presentation" class="{{ strcmp(\Request::path(), 'register') == 0 ? 'active' : '' }} navbtn"><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="#"><span class="caret"></span><img src="{{ asset('img/avatar_2x.png') }}" class="dropdown-image"></a>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li role="presentation"><a href="/userManage">Settings</a></li>
                                {{-- <li role="presentation"><a href="#">Payments</a></li> --}}
                                <li role="presentation" class="active"><a href="{{ url('/logout') }}" 
                                    onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">Logout</a></li>
                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <script>
        var lessons = <?php echo json_encode(\Request::get('lessons')); ?>
    </script>
    
    <div id="mySidenav" class="sidenav" style="overflow: hidden;">
        <a href="javascript:void(0)" class="backbtn" onclick="back()"><</a>
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
        <div id="lesson_menu" class="col-sm-6 side_menu" style="white-space: nowrap; height: 100%; overflow-y: scroll;">

            @foreach (\Request::get('lessons') as $lesson)
                <div>
                    <a href="#" id="lesson{{ $lesson->lessonNo }}" class="lesson expandLesson">Lesson {{ $lesson->lessonNo }}: {{ $lesson->name }}</a>
                </div>
            @endforeach

        </div><!--side_menu-->

        <div id="activity_menu" class="col-sm-6 side_menu" style="white-space: nowrap; height: 100%; overflow-y: scroll;">
            <div class="activity_holder"></div>
        </div>

    </div>

    <div id="page-content-wrapper" style="width: 100%; margin-top: 65px;">
        @yield('body')
    </div>

    @yield('extension')

    <script>
        window.onresize = function() {
            $('.activity_holder div').css('width', '100%');
        }

        var lessonNo = <?php echo json_encode(\Request::get('lessonNo')); ?>;
        var activity = <?php echo json_encode(\Request::get('activity')); ?>;

        function toggleNav() {
            if (document.getElementById("mySidenav").style.width != '100%') {
                openNav();
            } else {
                closeNav();
            }
        }

        function openNav() {
            document.getElementById("mySidenav").style.width = "100%";
            document.body.classList.toggle('noscroll');
            setTimeout(function() {
                if (document.getElementById("mySidenav").style.width == "100%") {
                    $('.closebtn').addClass('open');
                }
            }, 500);
        }

        /* Close/hide the sidenav */
        function closeNav() {
            $('.closebtn').removeClass('open');
            document.getElementById("mySidenav").style.width = "0";
            document.body.classList.toggle('noscroll');
        }

        function back() {
            if ($('#activity_menu').hasClass('onFocus')) {
                $('#activity_menu').removeClass('onFocus').addClass('offFocus');
                $('#lesson_menu').removeClass('offFocus').addClass('onFocus');
            }
        }

        $('.lesson').click(function () {
            $('#lesson_menu').find('.active').removeClass('active');
            var expandBtn = $(this);
            expandBtn.closest('div').addClass('active');
        })

        $('.expandLesson').click(function () {
            $('#lesson_menu').find('.active').removeClass('active');
            var expandBtn = $(this);
            expandBtn.closest('div').addClass('active');

            function createActivity() {
                $('#activity_menu').children().first().empty();
                var pracNo = 0;
                var lesson = lessons[parseInt(expandBtn.parent().find('.lesson').attr('id').substring('lesson'.length)) - 1];
                for (var i = 0; i < lesson.activity.length; i++) {
                    var outerDiv = document.createElement('div');
                    var link = document.createElement('a');
                    link.id = lesson.activity[i].name;
                    link.className = "activity";
                    link.href = "/lesson" + lesson.lessonNo + "/" + lesson.activity[i].name;
                    link.innerHTML = lesson.activity[i].content;
                    // link.innerHTML = lessons[];
                    outerDiv.appendChild(link);
                    $('#activity_menu').children().first().append(outerDiv);
                }

                if (expandBtn.parent().find('.lesson').attr('id') == lessonNo) {
                    $('#'+activity).closest('div').addClass('active');
                    $('#'+activity).bind('click', function(e){
                        e.preventDefault();
                        closeNav();
                    })
                }

                $('#lesson_menu').removeClass('onFocus').addClass('offFocus');
                $('#activity_menu').removeClass('offFocus').addClass('onFocus');

                $('#activity_menu').children().first().fadeIn(250);
            }

            if ($('#activity_menu').children().first().html() == "") {
                $('#activity_menu').children().first().hide();
                createActivity();
            } else {
                $('#activity_menu').children().first().fadeOut(250, createActivity);
            }
        });

        $(document).keyup(function(e) {
            if(e.which == 27) {
                closeNav();
            }
        });

        $( document ).ready(function() {
            if (!lessonNo && !activity) {
                return;
            }

            $('#'+lessonNo).next('a').click();
            $('#'+activity).closest('div').addClass('active');
            $('#'+activity).bind('click', function(e){
                e.preventDefault();
                closeNav();
            })
        });

    </script>
</body>
</html>
