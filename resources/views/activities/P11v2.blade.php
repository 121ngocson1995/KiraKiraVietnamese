@extends('activities.layout.activityLayout')

@section('header-more')

<link rel="stylesheet" href="{{ asset('css/smiley.css') }}">
<link rel="stylesheet" href="{{ asset('css/font-awesome-animation.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/screens/p11.css') }}">

<style>
	.dragSentence {
		text-align: left;
	}
</style>

@stop

@section('actContent')

<div id="background">
	<div id="sunPositionHolder" style="position: fixed; width: 80%; bottom: -64%; left: 50%; transform: translateX(-40%); z-index: -1">
		<div id="sunMoveHolder" style="opacity: 0;">
			<img id="sun" class="sunRotate" style="width: 100%;" src="{{ asset('img/P11/bg-sun.svg') }}" alt="">
		</div>
	</div>
	<img id="land" style="position: fixed; width: 101%; bottom: 0; z-index: -1" src="{{ asset('img/P11/bg-land.svg') }}" alt="">
</div>

<div class='fullscreenDiv'>
	<div id="element">
		<div class="row dragdrop">
			<div class="col-sm-6 dragGroup" style="z-index: 20;">
				<div id="draggable">
					@foreach ($elementData as $elementValue)
					<div class="dragSentence"><span>{{ $elementValue->sentence }}</span></div>
					@endforeach
				</div>
				<div id="tryAgainBtn2Holder" style="display: none;"><a id="tryAgainBtn2" class="btn tryAgain" role="button" onclick="redo()">Try again<i class="fa fa-repeat faa-spin animated faa-slow" style="vertical-align: middle;"></i></a></div>
			</div>
			<div class="col-sm-6 dropGroup">
				<div id="droppable">
					@for ($i = 0; $i < count($elementData); $i++)
					<div class="dropSentence"></div>
					@endfor
				</div>
			</div>
		</div>
		<div class="row help">
			<div id="btnHelp">
				<div id="helpBtn">
					<div class="btnBg">
						<img id="imgHelp" style="width: 100%; max-width: 220px;" src="{{ asset('img/P11/cloud.svg') }}" alt="show answer">
					</div>
					<div id="angel" style="display: none; z-index: 30">
						<img d="imgAngel" src="{{ asset('img/P11/angel.svg') }}" alt="angel">
					</div>
				</div>
			</div>
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
	<div>
		<div class="btn tryAgain score">
			<span id="scoreText">Score: </span>
			<span id="correct"></span>
			<span id="total"></span>
		</div>
		<a id="tryAgainBtn" class="btn tryAgain" role="button" onclick="redo()" style="display: none;">Try again<i class="fa fa-repeat faa-spin animated faa-slow" style="vertical-align: middle;"></i></a>
		<a id="nextBtn" class="btn tryAgain" role="button" onclick="redo()" style="display: none;">Do it once more<i class="fa fa-forward faa-horizontal animated faa-slow" style="vertical-align: middle;"></i></a>
	</div>
</div>

<br style="clear:both">

<script>
	var elementData = <?php echo json_encode($elementData); ?>;
	var correctAnswerList = <?php echo json_encode($correctAnswerList); ?>;
	var correctNo = 0;
	var totalQuestion = 0;

	var sunTimeline = new TimelineMax();
	sunTimeline.from('#land', 1, {scale:1, y:300,  ease:Elastic.easeOut})
			   .fromTo('#sunMoveHolder', 4, {y:300, opacity: 0}, {y:0, opacity: 1, clearProps:"transform", ease:Power1.easeOut});
	setTimeout(function() {
		TweenMax.staggerFromTo('.dragSentence', 0.5, {x:-150, y:50, opacity:0}, {x:0, y:0, opacity:1, clearProps:"transform"}, 0.2);
		TweenMax.staggerFromTo('.dropSentence', 0.5, {x:150, y:50, opacity:0}, {x:0, y:0, opacity:1, clearProps:"transform"}, 0.2);
		TweenLite.set('#helpBtn', {opacity: 1, className:'+=animated zoomIn', delay: 1.5});
	}, 2000);

	window.onresize = function() {
		$('.dropSentence').each(function() {
			$(this).css('height', $($(this).data('curDrag')).css('height'));
			rePosition($(this), $(this).data('curDrag'));
		});
	}

	window.onload = function() {
		initDroppable();
	}

	$('#helpBtn').click(function() {
		help();
	});

	$('#helpBtn').on( "mouseenter", function() {
		$('#angel').show();
		TweenLite.from('#angel img', 1, {x:150, y:50, opacity: 0});
	})
				 .on( "mouseleave", function() {
		$('#angel').hide();
		TweenLite.set('#angel img', {x:0, y:0, opacity: 1});
	});

	$('#angel').click(function() {
		help();
	});
</script>
<script src="{{ asset('js/screens/p11.js') }}"></script>

@stop

@section('actDescription-vi')
	Sắp xếp lại trình tự bài hội thoại bằng cách tích chuột vào câu và bỏ sang các ô trống phía bên phải.
@stop

@section('actDescription-en')
	To reorder the dialogue, click on the sentence and then move to the appropriate box on the right.
@stop