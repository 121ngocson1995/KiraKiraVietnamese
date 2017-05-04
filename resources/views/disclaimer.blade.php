@extends('layouts.app')

@section('header')

<link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/KiraNav.css') }}">

<style>
    .btn-group {
        display: initial;
    }
    .panel-heading {
        padding: 12px 15px;
    }
    .panel-heading a {
        font-size: 1.1em !important;
    }
    .unavailable {
        background-color: #d5eef6;
        border-color: #d5eef6;
        font-style: italic;
        pointer-events:none;
    }
    #promo1 {
        background: url({{ asset('img/banner-default.jpg') }});
    }
</style>

@stop

@section('body')

<div id="promo1">
    <div class="jumbotron about">
        <div class="container">
            <div class="row about">
                <div class="col-md-6 about">
                    <h1>Disclaimer</h1></div>
                </div>
            </div>
        </div>
    </div>
    <div class="grey-section">
        <div class="container site-section" id="descript">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <h1>We do not own every visual content on this website.</h1>
                    <p> 
                        We make use of various vector images designed by Freepik (www.freepik.com) for displaying visual content on activity pages.
                    </p>
                    <div>
                        <p><a href='http://www.freepik.com/free-vector/white-clouds-pack_760099.htm'>White clouds pack</a></p>
                        <p><a href='http://www.freepik.com/free-vector/green-trees_794232.htm'>Green trees</a></p>
                        <p><a href='http://www.freepik.com/free-vector/winter-background-with-wooden-sign_984427.htm'>Winter background with wooden sign</a></p>
                        <p><a href='http://www.freepik.com/free-vector/cute-angel_790563.htm'>Cute angel</a></p>
                        <p><a href='http://www.freepik.com/free-vector/education-background-design_1096054.htm'>Education background design</a></p>
                        <p><a href='http://www.freepik.com/free-vector/sunrise-in-the-fields_712076.htm'>Sunrise in the fields</a></p>
                        <p><a href='http://www.freepik.com/free-vector/happy-kids-at-school_798930.htm'>Happy kids at school</a></p>
                        <p><a href='http://www.freepik.com/free-vector/wooden-signs-with-branches-and-leaves_917044.htm'>Wooden signs with branches and leaves</a></p>
                        <p><a href='http://www.freepik.com/free-vector/background-of-beautiful-sunny-landscape-with-sea-and-hills_1049985.htm'>Background of beautiful sunny landscape with sea and hills</a></p>
                        <p><a href='http://www.freepik.com/free-vector/background-of-children-learning-in-class-with-teacher_1073796.htm'>Background of children learning in class with teacher</a></p>
                        <p><a href='http://www.freepik.com/free-vector/sunburst-retro-background-of-balloons_1066412.htm'>Sunburst retro background of balloons</a></p>
                        <p><a href='http://www.freepik.com/free-vector/beautiful-greeting-card-with-bird-and-flowers-for-spring_1061260.htm'>Beautiful greeting card with bird and flowers for spring</a></p>
                        <p><a href='http://all-free-download.com/free-vector/download/cute-cartoon-trees-vector-background-graphics_540826.html'>Cute cartoon trees vector background</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('vendor.footer')

    @stop