@extends('layouts.app')

@section('body')

<link rel="stylesheet" type="text/css" href="{{ asset('css/normalize.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('css/component.css') }}" />
<script src="{{ asset('js/modernizr.custom.js') }}"></script>
{{-- <script src="{{ asset('js/waypoints.min.js') }}"></script> --}}
<link rel="stylesheet" href="{{ asset('css/animate.css') }}">

<script>
	$('.navbar-brand.original').hide();
	
	var pTitle;
	if ( '{{\Request::get('activity') }}' == 'P1')
		pTitle = 'Nghe phát âm từ và nhắc lại';
	else if ( '{{\Request::get('activity') }}' == 'P2')
		pTitle = 'Nghe và tìm từ đúng';
	else if ( '{{\Request::get('activity') }}' == 'P3')
		pTitle = 'Nghe phát âm câu và nhắc lại';
	else if ( '{{\Request::get('activity') }}' == 'P4')
		pTitle = 'Nghe và tìm câu đúng';
	else if ( '{{\Request::get('activity') }}' == 'P5')
		pTitle = 'Nghe phát âm đoạn thoại và nhắc lại';
	else if ( '{{\Request::get('activity') }}' == 'P6')
		pTitle = 'Đọc và chọn đáp án đúng';
	else if ( '{{\Request::get('activity') }}' == 'P7')
		pTitle = 'Nghe và luyện tập nói theo bài hội thoại';
	else if ( '{{\Request::get('activity') }}' == 'P8')
		pTitle = 'Đọc và điền vào chỗ trống';
	else if ( '{{\Request::get('activity') }}' == 'P9')
		pTitle = 'Đọc và hoàn thành bài hội thoại';
	else if ( '{{\Request::get('activity') }}' == 'P10')
		pTitle = 'Đọc và sắp xếp lại trật tự từ trong câu';
	else if ( '{{\Request::get('activity') }}' == 'P11')
		pTitle = 'Đọc và sắp xếp lại trình tự bài hội thoại';
	else if ( '{{\Request::get('activity') }}' == 'P12')
		pTitle = 'Tương tác nhóm';
	else if ( '{{\Request::get('activity') }}' == 'P13')
		pTitle = 'Bài khóa';
	else if ( '{{\Request::get('activity') }}' == 'P14')
		pTitle = 'Ghi nhớ các mẫu câu sau';
	else if ( '{{\Request::get('activity') }}' == 'situation')
		pTitle = 'Tình huống';
	else if ( '{{\Request::get('activity') }}' == 'extension')
		pTitle = 'Mở rộng';
	$('.navbar-brand.title').html(pTitle);

	setTimeout(function() {
		changeToOriginal('KiraKiraVietnamese', pTitle);
	}, 15000);

	function changeToOriginal(original, pTitle) {
		$('.navbar-brand.title').removeClass('animated fadeInDown').addClass('animated fadeOutUp').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {

			if (!$('.navbar-brand.original').is(":visible"))
				$('.navbar-brand.original').show();

			$('.navbar-brand.title').hide();

			$('.navbar-brand.original').removeClass('animated fadeOutUp').addClass('animated fadeInDown').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {

				setTimeout(function() {
					changeToPTitle(original, pTitle);
				}, 5000);
			});
		});
	}

	function changeToPTitle(original, pTitle) {
		$('.navbar-brand.original').removeClass('animated fadeInDown').addClass('animated fadeOutUp').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {

			if (!$('.navbar-brand.title').is(":visible"))
				$('.navbar-brand.title').show();

			$('.navbar-brand.original').hide();

			$('.navbar-brand.title').removeClass('animated fadeOutUp').addClass('animated fadeInDown').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {

				setTimeout(function() {
					changeToOriginal(original, pTitle);
				}, 15000);
			});
		});
	}

</script>

<div id="page-content-wrapper" style="width: 100%; margin-top: 65px;">
    @yield('content')
    <div class="tooltip" style="display: none;">
        <a>
            <img src="{{ asset('img/icons/activity-help.ico') }}" style="width: 50px; height: 50px">
        </a>
        <span class="tooltiptext">
            @yield('description')
        </span>
    </div>
</div>

@stop