@extends('layouts.app')

@section('header')

<link rel="stylesheet" href="{{ asset('css/animate.css') }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.19.1/TweenMax.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.13.2/plugins/TextPlugin.min.js"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('css/tooltip-classic.css') }}" />
<link href="https://fonts.googleapis.com/css?family=Dancing+Script:700" rel="stylesheet">
<script src="{{ asset('js/jquery-ui1-12.1.js') }}"></script>

<style>
	.writtenFont {
		font-family: 'Patrick Hand', cursive;
		/*font-size: xx-large !important;*/
	}
	#btn-NextAct, #btn-PreAct {
		position: fixed;
		top: 45%;
		background-color: bisque;
		width: auto;
		text-align: center;
		padding-top: 5px;
		padding-bottom: 5px;
		border: 1px solid #d8b9b9;
		border-radius: 20px;
		cursor: pointer;
		color: rgb(69, 130, 236);
		transition-duration: 1s;
		opacity: 0.5;
		z-index: 1000;
	}
	#btn-NextAct:hover {
		transform: translateX( 45px ) !important;
		box-shadow: 0px 0px 20px rgb(255, 255, 255);
		opacity: 1;
	}

	/*btn-NextAct*/
	#btn-NextAct {
		right: 0;
		padding-left: 15px;
		padding-right: 60px;
		transform: translateX( calc(100% - 50px) );
	}
	/*btn-PreAct*/
	#btn-PreAct {
		left: 0;
		padding-left: 60px;
		padding-right: 15px;
		transform: translateX( calc(50px - 100%) );
	}
	#btn-PreAct:hover {
		transform: translateX( -45px ) !important;
		box-shadow: 0px 0px 20px rgb(255, 255, 255);
		opacity: 1;
	}
	.fa.fa-arrow-right, .fa.fa-arrow-right {
		margin-right: 0;
		margin-left: 0;
	}
	.navbar-brand.title {
		display: block;
	}
	body {
		-webkit-user-select: none;
		-khtml-user-select: none;
		-moz-user-select: none;
		-o-user-select: none;
		user-select: none;
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
		pTitle = 'Ngôn ngữ và văn hoá';
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

	function correctSFX() {
		$('#correct_sound')[0].pause();
		$('#correct_sound')[0].currentTime = 0;
		$('#wrong_sound')[0].pause();
		$('#wrong_sound')[0].currentTime = 0;
		$('#correct_sound2')[0].pause();
		$('#correct_sound2')[0].currentTime = 0;
		$('#wrong_sound2')[0].pause();
		$('#wrong_sound2')[0].currentTime = 0;
		$('#correct_sound')[0].play();
	}

	function wrongSFX() {
		$('#correct_sound')[0].pause();
		$('#correct_sound')[0].currentTime = 0;
		$('#wrong_sound')[0].pause();
		$('#wrong_sound')[0].currentTime = 0;
		$('#correct_sound2')[0].pause();
		$('#correct_sound2')[0].currentTime = 0;
		$('#wrong_sound2')[0].pause();
		$('#wrong_sound2')[0].currentTime = 0;
		$('#wrong_sound')[0].play();
	}

	function correctSFX2() {
		$('#correct_sound')[0].pause();
		$('#correct_sound')[0].currentTime = 0;
		$('#wrong_sound')[0].pause();
		$('#wrong_sound')[0].currentTime = 0;
		$('#correct_sound2')[0].pause();
		$('#correct_sound2')[0].currentTime = 0;
		$('#wrong_sound2')[0].pause();
		$('#wrong_sound2')[0].currentTime = 0;
		$('#correct_sound2')[0].play();
	}

	function wrongSFX2() {
		$('#correct_sound')[0].pause();
		$('#correct_sound')[0].currentTime = 0;
		$('#wrong_sound')[0].pause();
		$('#wrong_sound')[0].currentTime = 0;
		$('#correct_sound2')[0].pause();
		$('#correct_sound2')[0].currentTime = 0;
		$('#wrong_sound2')[0].pause();
		$('#wrong_sound2')[0].currentTime = 0;
		$('#wrong_sound2')[0].play();
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

<div>
	<audio id="correct_sound" src="{{ asset('audio/correct_sound.mp3') }}"></audio>
	<audio id="correct_sound2" src="{{ asset('audio/correct_sound2.mp3') }}"></audio>
	<audio id="wrong_sound" src="{{ asset('audio/wrong_sound.mp3') }}"></audio>
	<audio id="wrong_sound2" src="{{ asset('audio/wrong_sound2.mp3') }}"></audio>
</div>

{{-- <div class="tooltip">
    <a href="">
        <img src="{{ asset('img/icons/activity-help.ico') }}" style="width: 50px; height: 50px">
    </a>
    <span class="tooltiptext">
        @yield('description')
    </span>
</div> --}}

<div>
	<span class="tooltip tooltip-effect-2">
		<div class="tooltip-item">
			<img src="{{ asset('img/icons/activity-help.ico') }}" style="width: 50px; height: 50px">
		</div>
		<span class="tooltip-content">
			<img src="{{ asset('img/bulb.svg') }}"/>
			<span class="tooltip-text">
				<span id="tooltip-vi">@yield('actDescription-vi')</span>
				<hr>
				<span id="tooltip-en">@yield('actDescription-en')</span>
			</span>
		</span>
		<div style="clear: both;"></div>
	</span>
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