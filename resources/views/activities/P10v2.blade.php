@extends('activities.layout.activityLayout')

@section('header-more')

<link rel="stylesheet" href="{{ asset('css/smiley.css') }}">
<link rel="stylesheet" href="{{ asset('css/screens/p10.css') }}">
<link rel="stylesheet" href="{{ asset('css/font-awesome-animation.min.css') }}">
{{-- <link rel="stylesheet" href="{{ asset('css/component.css') }}"> --}}

@stop

@section('actContent')

<script>
	var elementData = <?php echo json_encode($elementData); ?>;
	var curQuestion = 0;
</script>

<div id="background">
	<img id="sun" style="position: fixed; width: 80%; top: 0; left: 50%; transform: translateX(-50%); opacity: 0; z-index: -1" src="{{ asset('img/P10/bg-sun.svg') }}" alt="">
	<img id="cloud" style="position: fixed; width: 130%; left: -15%; bottom: 5%; z-index: -1" src="{{ asset('img/P10/bg-cloud.svg') }}" alt="">
	<img id="land" style="position: fixed; width: 100%; bottom: -50%; z-index: -1" src="{{ asset('img/P10/bg-land.svg') }}" alt="">
</div>

<div class='fullscreenDiv'>
	<div id="questionHolder" class="col-xs-12">
		<div id="draggable" style="z-index: 20">
			@foreach ($elementData[0] as $elementValue)
			<div id="{{ $elementValue->correctOrder }}" class="dragWord"><span>{{ $elementValue->word }}</span></div>
			@endforeach
		</div>
		<div id="droppable">
			@for ($i = 0; $i < count($elementData[0]); $i++)
			<div class="dropWord"></div>
			@endfor
		</div>
	</div>
</div>
<div id="resultContainer">

	<input id="happy" type="radio" name="smiley" value="Happy">
	<input id="normal" type="radio" name="smiley" value="Normal">
	<div class="smiley">
		<div class="eyes">
			<div class="eye"></div>
			<div class="eye"></div>
		</div>
		<div class="mouth"></div>
	</div>
	<div id="result" style="text-align: center; text-align-last: center;"></div>
	<div class="{{-- hi-icon-wrap hi-icon-effect-4 hi-icon-effect-4a --}}">
		<div class="btn tryAgain score">
			<span id="scoreText">Score: </span>
			<span id="correct"></span>
			<span id="total"></span>
		</div>
		<a id="tryAgainBtn" class="{{-- hi-icon --}}btn tryAgain" role="button" onclick="changeSentence(curQuestion, false)" style="display: none;">Try again<i class="fa fa-repeat faa-spin animated faa-slow" style="vertical-align: middle;"></i></a>
		<a id="nextBtn" class="{{-- hi-icon --}}btn tryAgain resultSpace" role="button" onclick="changeSentence(curQuestion+1, true)" style="display: none;"><span>Next</span><i class="fa fa-forward faa-horizontal animated faa-slow" style="vertical-align: middle;"></i></a>
	</div>
</div>

<script>
	var correctNo = 0;
	var totalQuestion = 0;
	var currentNo = 0;
	var totalNo = parseInt(<?php echo count($elementData); ?>);

	TweenMax.from('#land', 1, {scale:1, y:300,  ease:Elastic.easeOut});
	TweenMax.from('#cloud', 1, {scale:1, y:300, delay:1, ease:Elastic.easeOut});
	TweenMax.from('#sun', 1, {scale:1, y:300, delay:2, ease:Bounce.easeOut})
	TweenMax.set('#sun', {opacity:1, delay:2});
	setTimeout(function() {
		var tl = new TimelineMax();
		$('#draggable').addClass('animated bounceInDown').css('opacity', 1).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
			TweenMax.staggerFromTo('.dropWord', 0.4, {x:-50, y:50, opacity:0}, {x:0, y:0, opacity:1, clearProps:"transform"}, 0.2);
			TweenMax.set('.dropWord',{className:"+=pinch"});
		});

		var tl = new TimelineMax();
		tl.to('#sun', 300, {rotation:360, repeat:-1, ease:Power0.easeNone});

		$('#cloud').addClass('animated shake infinite');
	}, 2000);
</script>

<script src="{{ asset('js/screens/p10.js') }}"></script>

@stop

@section('actDescription-vi')
	Sắp xếp lại trật tự từ trong câu bằng cách kéo các từ thả vào trong các ô trống
@stop

@section('actDescription-en')
	To reorder the words, hold the words and then move to the appropriate space below.
@stop