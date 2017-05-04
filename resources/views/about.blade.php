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
</style>

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

    <div class="green-section row">
        <div class="container col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1">
            <div class="panel-group accordion" role="tablist" aria-multiselectable="true" id="accordion-1">

                @foreach (\Request::get('lessons') as $lesson)
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab">
                        <h4 class="panel-title"><a role="button" data-toggle="collapse" data-parent="#accordion-1" aria-expanded="true" data-target="#accordion-1 .item-{{ $lesson->lessonNo }}">Lesson {{ $lesson->lessonNo }}: {{ $lesson->name }}</a></h4>
                    </div>
                    <div class="panel-collapse collapse item-{{ $lesson->lessonNo }}" role="tabpanel">
                        <div class="panel-body">
                            <span> {{ $lesson->description }} </span>
                            <div class="row">
                                <div class="btn-group" role="group">
                                    @foreach ($lesson->activity as $activity)
                                    <div style=" margin: 0.5em 2em"><a class="btn btn-info{{ $activity->exist ? '' : ' unavailable' }}" href="/lesson{{ $lesson->lessonNo }}/{{ $activity->name }}" style = "width: 100%;font-size: 1.2em; font-weight: 600; color: white; text-decoration: none;">{{ $activity->content }}</a>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            
                        </div>                   
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    @include('vendor.footer')

    @stop