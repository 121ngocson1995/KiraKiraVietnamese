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

    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://use.fontawesome.com/45e03a14ce.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Pretty-Header-1.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Pretty-Footer.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}"> --}}
    {{-- css --}}
    <style type="text/css">
    #container {
      margin: 20px;
      width: 50%;
      height: 8px;
    }
    a {
        outline: 0;
    }
    input::-moz-focus-inner { 
        border: 0; 
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
    body {
        font-family: "Open Sans",sans-serif;
    }
    #activity_menu {
        border-right: none;
    }
    .header_bar {
        border-radius: 0;
    }
    .header_bar .navbar-brand {
        height: 70px;
    }
    .header_bar main {
        margin-top: 0px;
        font-weight: 600;
        font-size: 1.5em;
    }
    header {
        padding-top: 30px;
    }
    .header_bar .navbar-nav li a.active {
        color: greenyellow;
    }
    /**sidbar menu**/
    .sidenav {
        background-color: rgba(5, 162, 249, 0.9);
        height: 100%;
        left: 0;
        overflow-x: hidden;
        padding-top: 100px;
        position: fixed;
        text-align: left;
        top: 65px;
        transition: all 0.5s ease 0s;
        width: 0;
        z-index: 100;
        color:#fff;
    }
    .sidenac div {}
    .sidenav div a {
        color: #fff;
        display: inline-block;
        padding: 8px 8px 8px 32px;
        text-decoration: none;
        transition: all 0.3s ease 0s;
    }
    .sidenav div a:hover{
        color: #f1f1f1;
    }
    .sidenav .side_menu div a {
        font-size: 24px;
        font-weight: 600;
        padding-left: 8px;
    }

    .sidenav .closebtn {
        font-size: 30px;
        margin-left: 50px;
        position: absolute;
        z-index: 99 !important;
        right: 25px;
        top: 20px;
        color: white;
    }
    .side_menu {
        padding-left: 32px;
        border-right: 1px solid #ffffff;
    }
    .login_side {
        padding-left: 50px;
    }
    @media screen and (max-height: 450px) {
        .sidenav {padding-top: 45px;}
    }
    /**sidbar menu close**/

    .btn-red{
        border-color:greenyellow;
        background:greenyellow;
        color:#fff;
    }
    .btn-none{
        border-color:#fff;
        background:transparent;
        color:#fff;
    }
    .btn.focus, .btn:focus, .btn:hover {
        color: #fff;
        opacity: 0.8;
    }
    .border-radius
    {
        border-radius:0px;
    }
    .login_side .btn {
        font-size: 16px;
        padding-left: 30px;
        padding-right: 30px;
        text-transform: uppercase;
    }
    .text-red{
        color:greenyellow !important;
    }
    h1, h2, h3, h4, h5, h6 {
        color: #4d4d4d;
        font-weight: 600;
        margin-top: 0;
    }
    .social_ico a {
        display: inline-block;
        height: 30px;
        line-height: 30px;
        margin: 0 5px 0 0;
        text-align: center;
        width: 30px;
        background: #c0c4c7 none repeat scroll 0 0;
        color: #fff;
        padding:0px;
    }
    .social_ico {
        float: left;
        margin-top: 15px;
        width: 100%;
    }
    .contact_info {
        float: left;
        margin-top: 20px;
        width: 100%;
    }
    .mar-25
    {
        margin-top:25px;
    }
    .header_bar .navbar-toggle {
        height: auto;
        margin-top: 19px;
        padding: 7px 12px;
        cursor:pointer;
    }
    .social_ico a:hover {
        background: greenyellow none repeat scroll 0 0;
    }
    .sidenav .side_menu a.lesson:hover, .sidenav .side_menu div.active a.lesson, .sidenav .side_menu a.activity:hover, .sidenav .side_menu div.active a.activity {
        border-left: 4px solid greenyellow;
        color: greenyellow;
    }
    .sidenav .side_menu div a.expandLesson {
        position: absolute;
        left: 150px;
    }
    .sidenav .side_menu a.expandLesson:hover {
        color: greenyellow;
        padding-left: 7px;
    }
    .top_section {
        float: left;
        margin-bottom: 25px;
        width: 100%;
    }
    .chu-section {
        float: left;
        padding: 40px 0;
        width: 100%;
    }
    section {
        float: left;
        width: 100%;
    }
    .bg-gray{
        background-color:#262627;
        color:#fff;
    }
    .section-cover {
        float: left;
        padding: 40px;
        width: 100%;
    }
    .bg-gray h1, .bg-gray h4 {
        color: #fff;
    }
    .ico-cover {
        background: rgba(255, 255, 255, 0.6) none repeat scroll 0 0;
        border-radius: 100px;
        clear: both;
        height: 100px;
        line-height: 100px;
        margin: auto auto 20px;
        position: relative;
        text-align: center;
        width: 100px;
    }
    .view-btn ,.view-btn:hover,.view-btn:focus{
        color: #ffffff;
        font-weight: 600;
        text-decoration:none;
    }
    .ico-cover::after {
        border: 4px solid #050505;
        border-radius: 100px;
        content: "";
        height: 90px;
        left: 5px;
        line-height: 90px;
        position: absolute;
        top: 5px;
        width: 90px;
    }
    .login_side h3 {
        color: #ffffff;
    }
    @media screen and (max-width: 767px) {
        .side_menu {
            border-right: none;
        }

    }




    .hamburger {
        position: relative;
        top: 18px;  
        display: inline-block;
        width: 15px;
        height: 28px;
        margin-right: 12px;
        background: transparent;
        border: none;
        float: left;
    }
    .hamburger:hover,
    .hamburger:focus,
    .hamburger:active {
        outline: none;
    }
    .hamburger:before {
        content: '';
        display: block;
        width: 100px;
        font-size: 14px;
        color: #fff;
        line-height: 32px;
        text-align: center;
        opacity: 0;
        -webkit-transform: translate3d(0,0,0);
        -webkit-transition: all .35s ease-in-out;
    }
    .hamburger:hover:before {
        opacity: 1;
        display: block;
        -webkit-transform: translate3d(-100px,0,0);
        -webkit-transition: all .35s ease-in-out;
    }

    .hamburger .hamb-top,
    .hamburger .hamb-middle,
    .hamburger .hamb-bottom,
    .hamburger.is-open .hamb-top,
    .hamburger.is-open .hamb-middle,
    .hamburger.is-open .hamb-bottom {
        position: absolute;
        left: 0;
        height: 2px;
        width: 100%;
    }
    .hamburger .hamb-top,
    .hamburger .hamb-middle,
    .hamburger .hamb-bottom {
        background-color: white;
    }
    .hamburger .hamb-top { 
        top: 5px; 
        -webkit-transition: all .35s ease-in-out;
    }
    .hamburger .hamb-middle {
        top: 50%;
        margin-top: -2px;
    }
    .hamburger .hamb-bottom {
        bottom: 7px;  
        -webkit-transition: all .35s ease-in-out;
    }

    .hamburger:hover .hamb-top {
        top: 2px;
        -webkit-transition: all .35s ease-in-out;
    }
    .hamburger:hover .hamb-bottom {
        bottom: 2px;
        -webkit-transition: all .35s ease-in-out;
    }
</style>
</head>
<body>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">

            <div class="navbar-header">
                <button type="button" class="hamburger" onclick="openNav()">
                    <span class="hamb-top"></span>
                    <span class="hamb-middle"></span>
                    <span class="hamb-bottom"></span>
                </button>
                <a class="navbar-brand navbar-link" href="/">KiraKiraVietnamese </a>
                <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
            </div>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="active navbtn" role="presentation"><a href="/">Home</a></li>
                    <li role="presentation" class="navbtn"><a href="#">About</a></li>
                    <li role="presentation" class="navbtn"><a href="#">Lessons</a></li>
                    <li role="presentation" class="navbtn"><a href="#">Guide</a></li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="#"> <span class="caret"></span><img src="{{ asset('img/avatar_2x.png') }}" class="dropdown-image"></a>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                            <li role="presentation"><a href="#">Settings</a></li>
                            <li role="presentation"><a href="#">Payments</a></li>
                            <li role="presentation" class="active"><a href="#">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
        <div id="lesson_menu" class="col-sm-6 side_menu" style="white-space: nowrap; overflow: hidden;">

            <div><a href="#" class="lesson">Lesson 1</a><a href="#" class="expandLesson"><i class="fa fa-caret-right" aria-hidden="true"></i></a></div>
            <div><a href="#" class="lesson">Lesson 2</a><a href="#" class="expandLesson"><i class="fa fa-caret-right" aria-hidden="true"></i></a></div>
            <div><a href="#" class="lesson">Lesson 3</a><a href="#" class="expandLesson"><i class="fa fa-caret-right" aria-hidden="true"></i></a></div>
            <div><a href="#" class="lesson">Lesson 4</a><a href="#" class="expandLesson"><i class="fa fa-caret-right" aria-hidden="true"></i></a></div>
            <div><a href="#" class="lesson">Lesson 5</a><a href="#" class="expandLesson"><i class="fa fa-caret-right" aria-hidden="true"></i></a></div>
            <div><a href="#" class="lesson">Lesson 6</a><a href="#" class="expandLesson"><i class="fa fa-caret-right" aria-hidden="true"></i></a></div>
            <div><a href="#" class="lesson">Lesson 7</a><a href="#" class="expandLesson"><i class="fa fa-caret-right" aria-hidden="true"></i></a></div>
        </div><!--side_menu-->

        <div id="activity_menu" class="col-sm-6 side_menu" style="white-space: nowrap; overflow: hidden;">
            <div class="activity_holder"></div>
        </div>

    </div>

    <div id="page-content-wrapper" style="width: 100%; margin-top: 65px;">
        @yield('content')
        <div class="tooltip">
            <a>
                <img src="{{ asset('img/icons/activity-help.ico') }}" style="width: 50px; height: 50px">
            </a>
            <span class="tooltiptext">
                @yield('description')
            </span>
        </div>
    </div>

    <script>
        function openNav() {
            document.getElementById("mySidenav").style.width = "100%";
        }

        /* Close/hide the sidenav */
        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
        }

        $('.expandLesson').click(function () {
            $('#lesson_menu').find('.active').removeClass('active');
            var expandBtn = $(this);
            expandBtn.closest('div').addClass('active');

            function createActivity() {
                $('#activity_menu').children().first().empty();
                var pracNo = 0;
                for (var i = 0; i < 4; i++) {
                    var outerDiv = document.createElement('div');
                    var link = document.createElement('a');
                    link.className = "activity";
                    if (i <= 0) {
                        link.innerHTML = "Situation";
                    } else {
                        link.innerHTML = "Practice " + ++pracNo;
                    }
                    link.href = "#";
                    link.innerHTML += " for " + expandBtn.parent().find('.lesson').html();
                    outerDiv.appendChild(link);
                    $('#activity_menu').children().first().append(outerDiv);
                }

                $('#activity_menu').children().first().fadeIn(250);
            }

            if ($('#activity_menu').children().first().html() == "") {
                $('#activity_menu').children().first().hide()
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

    </script>
</body>
</html>
