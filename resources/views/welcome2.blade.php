@extends('layouts.app')

@section('body')

<style>
    .row.wehave {
        display: flex;
        align-items: center;
    }
    .row.wehave h3 {
        font-size: 2.5em;
    }
    .row.wehave p {
        font-size: 1.5em;
    }
    .row.introduction {
        display: flex;
        align-items: center;
    }
    .teacher_img img {
        width: 600px;
        max-width: 100%;
        text-align: center;
    }
    @media screen and (max-width: 991px) {
        .row.wehave {
            display: block;
        }
    }
    @media screen and (max-width: 767px) {
        .row.introduction {
            display: block;
        }
    }
</style>

<div id="promo">
    <div class="jumbotron hero">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-7 get-it">
                    <h1>Start your learning today</h1>
                    <p>Every step needs a stable ground, walking on the road of knowledge is no exception. If you ever wondered from where to begin your journey, we're your answer.</p>
                    <p><a class="btn btn-primary btn-lg margin-sm" role="button" href="#">Start your first lesson<i class="fa fa-graduation-cap"></i></a><a class="btn btn-success btn-lg margin-sm" role="button" href="/login">Login<i class="fa fa-sign-in fa fa-sign-in"></i></a></p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="features">
    <div class="row">
        <div class="col-sm-4 feature"><img src="{{ asset('img/chat.svg') }}">
            <h3>Situations</h3>
            <p class="text-center feature">Get to know Vietnamese with realistic situations</p>
        </div>
        <div class="col-sm-4 feature"><img src="{{ asset('img/airplane.svg') }}">
            <h3>Practices</h3>
            <p class="text-center feature">Skyrocket your language skills with exclusively designed activities</p>
        </div>
        <div class="col-sm-4 feature"><img src="{{ asset('img/profits.svg') }}">
            <h3>Extensions</h3>
            <p class="text-center feature">Boost your knowledge with our specially designed articles about Vietnamese language and culture</p>
        </div>
    </div>
</div>
<div class="container-fluid about">
    <h1 class="text-center">We have...</h1>
    {{-- <div class="row wehave">
        <div class="col-md-5 col-md-push-7 image"><img src="{{ asset('img/1.gif') }}"></div>
        <div class="col-md-7 col-md-pull-5 left">
            <h3>Situations </h3>
            <p>Each lesson provides multiple situations which can create a momentum for you to get the feel of the topic</p>
        </div>
    </div> --}}
    <div class="row wehave">
        <div class="col-md-5 image"><img src="{{ asset('img/1.gif') }}"></div>
        <div class="col-md-7 right">
            <h3>Practices </h3>
            <p>You can hone your skills by taking part in our numerous practices. Your progress and score will be saved for you to measure your development.</p>
        </div>
    </div>
    <div class="row wehave">
        <div class="col-md-5 col-md-push-7 image"><img src="{{ asset('img/2.gif') }}"></div>
        <div class="col-md-7 col-md-pull-5 left">
            <h3>Quick navigation</h3>
            <p>Never stop learning!! It's easy to switch from a lesson to another with our side navigation. Knowledge is just one click away.</p>
        </div>
    </div>
</div>
<div class="container-fluid author">
    <h1 class="text-center">With content created by...</h1>
    <div class="row introduction">
        <div class="col-sm-5 col-sm-push-7 teacher_img">
            <div class="img_container"><img class="img-circle" src="{{ asset('img/avatar_2x.png') }}"></div>
        </div>
        <div class="col-sm-7 col-sm-pull-5 author_info">
            <h2 class="author_info">Ph.D Lan Trung Nguyen</h2>
            <p class="author_info">Ph.D Lan Trung Nguyen, currently holding the position of Vice-principal of the University of Languages and International Studies, is well known for his vast knowledge of international languages as well as his enormous contribution to the work of preserving and developing the national language, Vietnamese.</p>
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
                <p class="footer-center-info email text-left">+84123456789</p>
            </div>
            <div><i class="fa fa-envelope footer-contacts-icon"></i>
                <p> <a href="#" target="_blank">support@kirakira.com</a></p>
            </div>
        </div>
        <div class="clearfix visible-sm-block"></div>
        <div class="col-md-4 footer-about">
            <h4>Connect to us</h4>
            {{-- <p> Lorem ipsum dolor sit amet, consectateur adispicing elit. Fusce euismod convallis velit, eu auctor lacus vehicula sit amet.
            </p> --}}
            <div class="social-links social-icons"><a href="#"><i class="fa fa-facebook"></i></a><a href="#"><i class="fa fa-twitter"></i></a><a href="#"><i class="fa fa-linkedin"></i></a><a href="#"><i class="fa fa-github"></i></a></div>
        </div>
    </div>
</footer>

@stop