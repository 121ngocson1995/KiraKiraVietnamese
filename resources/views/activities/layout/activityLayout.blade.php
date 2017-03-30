@extends('layouts.app')

@section('header')

{{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/normalize.css') }}" /> --}}
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/component.css') }}" /> --}}
<link rel="stylesheet" href="{{ asset('css/animate.css') }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.19.1/TweenMax.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.13.2/plugins/TextPlugin.min.js"></script>

<style>
	/*btn-NextAct*/
	#btn-NextAct {
		position: fixed;
		right: 0;
		top: 45%;
		background-color: bisque;
		width: auto;
		text-align: center;
		padding-top: 5px;
		padding-bottom: 5px;
		padding-left: 15px;
		padding-right: 60px;
		border: 1px solid #d8b9b9;
		border-radius: 20px;
		cursor: pointer;
		color: rgb(69, 130, 236);
		transition-duration: 1s;
		transform: translateX( calc(100% - 50px) );
		opacity: 0.5;
	}
	#btn-NextAct:hover {
		transform: translateX( 45px ) !important;
		box-shadow: 0px 0px 20px rgb(255, 255, 255);
		opacity: 1;
	}

	/*btn-PreAct*/
	#btn-PreAct {
		position: fixed;
		left: 0;
		top: 45%;
		background-color: bisque;
		width: auto;
		text-align: center;
		padding-top: 5px;
		padding-bottom: 5px;
		padding-left: 60px;
		padding-right: 15px;
		border: 1px solid #d8b9b9;
		border-radius: 20px;
		cursor: pointer;
		color: rgb(69, 130, 236);
		transition-duration: 1s;
		transform: translateX( calc(50px - 100%) );
		opacity: 0.5;
	}
	#btn-PreAct:hover {
		transform: translateX( -45px ) !important;
		box-shadow: 0px 0px 20px rgb(255, 255, 255);
		opacity: 1;
	}
	.fa.fa-arrow-right.fa-4x{
		margin-right: 5px;
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

@yield('actContent')

@stop

@section('extension')

<div id="btn-PreAct" style="font-size: 2em">
	<span id="locationPre">{{ strcmp(\Request::get('preAct')->name, 'View all lessons') == 0 || strcmp(\Request::get('preAct')->name, 'Situations') == 0 ? \Request::get('preAct')->name : 'Previous practice' }}</span>
	<i class="fa fa-arrow-left" aria-hidden="true"></i>
</div>

<div id="btn-NextAct" style="font-size: 2em">
	<i class="fa fa-arrow-right" aria-hidden="true"></i>
	<span id="locationNext">{{ strcmp(\Request::get('nextAct')->name, 'View all lessons') == 0 || strcmp(\Request::get('nextAct')->name, 'Language and Culture') == 0 ? \Request::get('nextAct')->name : 'Next practice' }}</span>
</div>

<script type="text/javascript">
	var preAct = <?php echo json_encode(\Request::get('preAct')); ?>;
	var nextAct = <?php echo json_encode(\Request::get('nextAct')); ?>;
	// $('#locationNext').html(nextAct['name']);
	// $('#btn-NextAct').hide();
	$('#btn-PreAct').click(function(){
		window.location.href="/"+preAct['link'];
	});
	$('#btn-NextAct').click(function(){
		window.location.href="/"+nextAct['link'];
	});
</script>

@stop