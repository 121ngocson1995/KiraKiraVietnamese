@extends('layouts.app')

@section('header')

<link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/KiraNav.css') }}">

@stop

@section('body')

<div id="promo1">
    <div class="jumbotron about">
        <div class="container">
            <div class="row about">
                <div class="col-md-6 about">
                    <h1>About our Lecture</h1></div>
                </div>
            </div>
        </div>
    </div>
    <div class="grey-section">
        <div class="container site-section" id="descript">
            <div class="row">
                <div class="col-md-8">
                    <h1>Vietnamese Learning Course</h1>
                    <p> 
                        @foreach ($courseData as $value)
                        <span>{{ $value->description }}</span>
                        @endforeach
                    </p>
                </div>
                <div class="col-md-4">
                    <div>
                        <table class="table table-striped">
                            @foreach ($courseData as $value)                        
                            <tbody>
                                <tr>
                                    <td class="info">Course Name</td>
                                    <td class="active">{{ $value->name }}</td>
                                </tr>
                                <tr>
                                    <td class="active">Author </td>
                                    <td class="info"> {{ $value->author }} </td>
                                </tr>
                                <tr>
                                    <td class="info">Number of Lesson</td>
                                    <td> {{ $lessonCnt }} </td>
                                </tr>
                                <tr>
                                    <td class="active">Last Update</td>
                                    <td class="info"> {{ isset($value->updated_at) ? date_format($value->updated_at, 'D, d M Y') : date_format($value->created_at, 'D, d M Y') }} </td>
                                </tr>
                            </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="green-section">
        <div class="container">
            <div class="panel-group accordion" role="tablist" aria-multiselectable="true" id="accordion-1">

                @foreach (\Request::get('lessons') as $lesson)
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab">
                        <h4 class="panel-title"><a role="button" data-toggle="collapse" data-parent="#accordion-1" aria-expanded="true" data-target="#accordion-1 .item-{{ $lesson->lessonNo }}">Lesson {{ $lesson->lessonNo }}</a></h4>
                    </div>
                    <div class="panel-collapse collapse item-{{ $lesson->lessonNo }}" role="tabpanel">
                        <div class="panel-body">
                            <span> {{ $lesson->description }} </span>
                            <div class="row">
                                <div class="col-md-12 btn-group" role="group">

                                    @foreach ($lesson->activity as $activity)
                                    @php
                                        // dd($activity);
                                    @endphp
                                    <div style=" margin: 0.5em 2em"><a class="btn btn-info" href="/lesson{{ $lesson->lessonNo }}/{{ $activity->name }}" style = "width: 100%;font-size: 1.2em; font-weight: 600; color: white; text-decoration: none;"  >{{ $activity->content }}</a></div>
                                    @endforeach
                                </div>
                            </div>
                            
                        </div>                   
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>

<footer>
    <div class="row">
        <div class="col-md-4 col-sm-6 footer-navigation">
            <h3><a href="#">KiraKiraVietnamese </a></h3>
            <p class="links"><a href="#">Home</a><strong> · </strong><a href="#">Blog</a><strong> · </strong><a href="#">About</a><strong> · </strong><a href="#">Faq</a><strong> · </strong><a href="#">Contact</a></p>
            <p class="company-name">Company Name © 2017 </p>
        </div>
        <div class="col-md-4 col-sm-6 footer-contacts">
            <div><i class="fa fa-phone footer-contacts-icon"></i>
                <p class="footer-center-info email text-left">+84123456789 </p>
            </div>
            <div><i class="fa fa-envelope footer-contacts-icon"></i>
                <p> <a href="#" target="_blank">support@kirakira.com</a></p>
            </div>
        </div>
        <div class="clearfix visible-sm-block"></div>
        <div class="col-md-4 footer-about">
            <h4>About the company</h4>
            <p> Lorem ipsum dolor sit amet, consectateur adispicing elit. Fusce euismod convallis velit, eu auctor lacus vehicula sit amet.
            </p>
            <div class="social-links social-icons"><a href="#"><i class="fa fa-facebook"></i></a><a href="#"><i class="fa fa-twitter"></i></a><a href="#"><i class="fa fa-linkedin"></i></a><a href="#"><i class="fa fa-github"></i></a></div>
        </div>
    </div>
</footer>

@stop