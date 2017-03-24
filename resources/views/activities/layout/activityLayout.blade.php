@extends('layouts.app')

@section('header')

<link rel="stylesheet" type="text/css" href="{{ asset('css/normalize.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('css/component.css') }}" />
<link rel="stylesheet" href="{{ asset('css/animate.css') }}">
<link rel="stylesheet" href="{{ asset('css/preload/Icomoon/style.css') }}">
<link rel="stylesheet" href="{{ asset('css/preload/main.css') }}">
<script src="{{ asset('js/modernizr.custom.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/main.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.19.1/TweenMax.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.13.2/plugins/TextPlugin.min.js"></script>
{{-- <script src="{{ asset('js/waypoints.min.js') }}"></script> --}}

<style>
#loading{
	background-color: #374140;
	height: 100%;
	width: 100%;
	position: fixed;
	z-index: 1;
	margin-top: 0px;
	top: 0px;
}
#loading-center{
	width: 100%;
	height: 100%;
	position: relative;
}
#loading-center-absolute {
	position: absolute;
	left: 50%;
	top: 50%;
	height: 150px;
	width: 150px;
	margin-top: -75px;
	margin-left: -75px;
}
.object{
	width: 20px;
	height: 20px;
	background-color: #FFF;
	float: left;
	margin-right: 20px;
	margin-top: 65px;
	-moz-border-radius: 50% 50% 50% 50%;
	-webkit-border-radius: 50% 50% 50% 50%;
	border-radius: 50% 50% 50% 50%;
}

#object_one {	
	-webkit-animation: object_one 1.5s infinite;
	animation: object_one 1.5s infinite;
}
#object_two {
	-webkit-animation: object_two 1.5s infinite;
	animation: object_two 1.5s infinite;
	-webkit-animation-delay: 0.25s; 
	animation-delay: 0.25s;
}
#object_three {
	-webkit-animation: object_three 1.5s infinite;
	animation: object_three 1.5s infinite;
	-webkit-animation-delay: 0.5s;
	animation-delay: 0.5s;
	
}

@-webkit-keyframes object_one {
	75% { -webkit-transform: scale(0); }
}

@keyframes object_one {
	75% { 
		transform: scale(0);
		-webkit-transform: scale(0);
	}
}

@-webkit-keyframes object_two {
	75% { -webkit-transform: scale(0); }
}

@keyframes object_two {
	75% { 
		transform: scale(0);
		-webkit-transform:  scale(0);
	}
}

@-webkit-keyframes object_three {
	75% { -webkit-transform: scale(0); }
}

@keyframes object_three {
	75% { 
		transform: scale(0);
		-webkit-transform: scale(0);
	}
}

.navbar-brand.title {
	display: block;
}
</style>

@yield('header-more')

@stop

@section('body')

<script>
	$('.navbar-brand.original').hide();
	
	var pTitle;
	if ( '{{\Request::get('activity') }}'.toUpperCase() == 'P1')
		pTitle = 'Nghe phát âm từ và nhắc lại';
	else if ( '{{\Request::get('activity') }}'.toUpperCase() == 'P2')
		pTitle = 'Nghe và tìm từ đúng';
	else if ( '{{\Request::get('activity') }}'.toUpperCase() == 'P3')
		pTitle = 'Nghe phát âm câu và nhắc lại';
	else if ( '{{\Request::get('activity') }}'.toUpperCase() == 'P4')
		pTitle = 'Nghe và tìm câu đúng';
	else if ( '{{\Request::get('activity') }}'.toUpperCase() == 'P5')
		pTitle = 'Nghe phát âm đoạn thoại và nhắc lại';
	else if ( '{{\Request::get('activity') }}'.toUpperCase() == 'P6')
		pTitle = 'Đọc và chọn đáp án đúng';
	else if ( '{{\Request::get('activity') }}'.toUpperCase() == 'P7')
		pTitle = 'Nghe và luyện tập nói theo bài hội thoại';
	else if ( '{{\Request::get('activity') }}'.toUpperCase() == 'P8')
		pTitle = 'Đọc và điền vào chỗ trống';
	else if ( '{{\Request::get('activity') }}'.toUpperCase() == 'P9')
		pTitle = 'Đọc và hoàn thành bài hội thoại';
	else if ( '{{\Request::get('activity') }}'.toUpperCase() == 'P10')
		pTitle = 'Đọc và sắp xếp lại trật tự từ trong câu';
	else if ( '{{\Request::get('activity') }}'.toUpperCase() == 'P11')
		pTitle = 'Đọc và sắp xếp lại trình tự bài hội thoại';
	else if ( '{{\Request::get('activity') }}'.toUpperCase() == 'P12')
		pTitle = 'Tương tác nhóm';
	else if ( '{{\Request::get('activity') }}'.toUpperCase() == 'P13')
		pTitle = 'Bài khóa';
	else if ( '{{\Request::get('activity') }}'.toUpperCase() == 'P14')
		pTitle = 'Ghi nhớ các mẫu câu sau';
	else if ( '{{\Request::get('activity') }}'.toUpperCase() == 'SITUATIONS')
		pTitle = 'Tình huống';
	else if ( '{{\Request::get('activity') }}'.toUpperCase() == 'EXTENSIONS')
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

{{-- <div id="loading">
	<div id="loading-center">
		<div id="loading-center-absolute">
			<div class="object" id="object_one"></div>
			<div class="object" id="object_two"></div>
			<div class="object" id="object_three"></div>
		</div>
	</div>
</div> --}}


@yield('actContent')

{{-- <script type="text/javascript">
	$(document).ready(function() {
		$("#loading").fadeOut(500);
	})
</script> --}}

@stop

@section('extension')

<div id="btn-NextAct">
	<i class="fa fa-arrow-right fa-4x" aria-hidden="true"></i>
	<span id="locationNext"></span>
</div>

<script type="text/javascript">
	var nextAct = <?php echo json_encode(\Request::get('nextAct')); ?>;
	$('#locationNext').html(nextAct['name']);
	$('#btn-NextAct').hide();
	$('#btn-NextAct').click(function(){
		window.location.href="/"+nextAct['link']; 
	});
</script>

@stop