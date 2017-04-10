@extends('layouts.app')

@section('body')

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap -->

  <!-- Bootstrap Form Helpers -->
  <link href="css/bootstrap-formhelpers.min.css" rel="stylesheet" media="screen">

  <style type="text/css">
    .nav-side-menu {
      overflow: auto;
      font-family: verdana;
      font-size: 12px;
      font-weight: 200;
      background-color: #2e353d;
      position: fixed;
/*      top: 0px;*/
      width: 300px;
      height: 100%;
      color: #e1ffff;
    }
    .nav-side-menu .brand {
      background-color: #23282e;
      line-height: 50px;
      display: block;
      text-align: center;
      font-size: 14px;
    }
    .nav-side-menu .toggle-btn {
      display: none;
    }
    .glyphicon {  margin-bottom: 10px;margin-right: 10px;}

    small {
      display: block;
      line-height: 1.428571429;
      color: #999;
    }
    .nav-side-menu ul,
    .nav-side-menu li {
      list-style: none;
      padding: 0px;
      margin: 0px;
      line-height: 35px;
      cursor: pointer;
  /*    
    .collapsed{
       .arrow:before{
                 font-family: FontAwesome;
                 content: "\f053";
                 display: inline-block;
                 padding-left:10px;
                 padding-right: 10px;
                 vertical-align: middle;
                 float:right;
            }
     }
     */
   }
   .nav-side-menu ul :not(collapsed) .arrow:before,
   .nav-side-menu li :not(collapsed) .arrow:before {
    font-family: FontAwesome;
    content: "\f078";
    display: inline-block;
    padding-left: 10px;
    padding-right: 10px;
    vertical-align: middle;
    float: right;
  }
  .nav-side-menu ul .active,
  .nav-side-menu li .active {
    border-left: 3px solid #d19b3d;
    background-color: #4f5b69;
  }
  .nav-side-menu ul .sub-menu li.active,
  .nav-side-menu li .sub-menu li.active {
    color: #d19b3d;
  }
  .nav-side-menu ul .sub-menu li.active a,
  .nav-side-menu li .sub-menu li.active a {
    color: #d19b3d;
  }
  .nav-side-menu ul .sub-menu li,
  .nav-side-menu li .sub-menu li {
    background-color: #181c20;
    border: none;
    line-height: 28px;
    border-bottom: 1px solid #23282e;
    margin-left: 0px;
  }
  .nav-side-menu ul .sub-menu li:hover,
  .nav-side-menu li .sub-menu li:hover {
    background-color: #020203;
  }
  .nav-side-menu ul .sub-menu li:before,
  .nav-side-menu li .sub-menu li:before {
    font-family: FontAwesome;
    content: "\f105";
    display: inline-block;
    padding-left: 10px;
    padding-right: 10px;
    vertical-align: middle;
  }
  .nav-side-menu li {
    padding-left: 0px;
    border-left: 3px solid #2e353d;
    border-bottom: 1px solid #23282e;
  }
  .nav-side-menu li a {
    text-decoration: none;
    color: #e1ffff;
  }
  .nav-side-menu li a i {
    padding-left: 10px;
    width: 20px;
    padding-right: 20px;
  }
  .nav-side-menu li:hover {
    border-left: 3px solid #d19b3d;
    background-color: #4f5b69;
    -webkit-transition: all 1s ease;
    -moz-transition: all 1s ease;
    -o-transition: all 1s ease;
    -ms-transition: all 1s ease;
    transition: all 1s ease;
  }
  @media (max-width: 767px) {
    .nav-side-menu {
      position: relative;
      width: 100%;
      margin-bottom: 10px;
    }
    .nav-side-menu .toggle-btn {
      display: block;
      cursor: pointer;
      position: absolute;
      right: 10px;
      top: 10px;
      z-index: 10 !important;
      padding: 3px;
      background-color: #ffffff;
      color: #000;
      width: 40px;
      text-align: center;
    }
    .brand {
      text-align: left !important;
      font-size: 22px;
      padding-left: 20px;
      line-height: 50px !important;
    }
  }
  @media (min-width: 767px) {
    .nav-side-menu .menu-list .menu-content {
      display: block;
    }
  }
  body {
    margin: 0px;
    padding: 0px;
  }


</style>
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<div style="">
  <div class="nav-side-menu">
    <div class="brand">User Profile</div>
    <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>

    <div class="menu-list">

      <ul id="menu-content" class="menu-content collapse out">
        <li id='li-info'>
          <a href="#">
            <i class="fa fa-user fa-lg"></i> Info
          </a>
        </li>

        <li id='li-add' data-target="#products" class="collapsed ">
        <a href="/AddLesson"><i class="fa fa-plus fa-lg"></i> Add lesson </a>
        </li>
        <li id='li-edit' data-target="#service" class="collapsed">
        <a href="#"><i class="fa fa-pencil fa-lg"></i> Edit lesson </a>
        </li>  
      </ul>
    </div>
  </div>

@yield('content')
  <div class="container">
    <form action="EditUser" method="get">
      <div class="col-sm-6 col-md-4">
        <img src="{{ asset('')."img/avatar/".$userData[0]['avatar']}}" alt="" class="img-rounded img-responsive" />
      </div>
      <div class="col-sm-6 col-md-8">
        <span>
          {{$userData[0]['first_name']." ".$userData[0]['last_name']}}</span>
          <br>
          <span>
            Username: {{$userData[0]['username']}}</span>
            <p>
              <i class="glyphicon glyphicon-envelope"></i>Email: <input type="text" name="txtEmail" value="{{$userData[0]['email']}}" id="txtEmail">
              <br />
              <i class="glyphicon glyphicon-gift"></i>DOB: <input type="date" name="txtDOB" value="{{$userData[0]['date_of_birth']}}" id="txtDOB">
              <br>
              <i class="fa fa-venus-mars" aria-hidden="true"></i>Gender: <select id="txtGender" name="txtGender">
              <option value="1" @if ($userData[0]['gender'] == '1')
              selected 
              @endif>Male</option>
              <option value="0" @if ($userData[0]['gender'] == '0')
              selected 
              @endif>Female</option>
            </select>
          </p>
          <!-- Split button -->
          Country: <select class="input-medium bfh-countries" id="txtCountry"  name="txtCountry" data-country="{{$userData[0]['country']}}"></select>
          <br>
          Language: <select class="input-medium bfh-languages" id="txtLanguage" name="txtLanguage" data-language="{{$userData[0]['language']}}"></select>
          <br>
          <button type="submit">Edit</button>
        </div>
      </form>
    </div>
  </div>
</div>
</div>

<!-- Bootstrap Form Helpers -->
<script src="js/bootstrap-formhelpers.min.js"></script>
<script src="js/bootstrap-formhelpers-countries.js"></script>
</div>
@stop
