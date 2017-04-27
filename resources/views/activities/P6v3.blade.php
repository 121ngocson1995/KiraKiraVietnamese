@extends('activities.layout.activityLayout')

@section('header-more')

<style>
	body {
		background: url({{ asset('img/P6/bg.svg') }}) no-repeat center center fixed;
		background-size: cover;
	}
	.btn-answer {
		background: url({{ asset('img/P6/paper.svg') }});
		background-size: cover;
		box-shadow: -7px 7px 5px rgba(102, 102, 153, 0.3);
		transition: all 0.4s;
	}
</style>
<link rel="stylesheet" href="{{ asset('css/screens/p6.css') }}">

@stop

@section('actContent')

<div id="questions">
	<div id='problems' align="center">
		<div id="qText">
			@php
			$problems = explode("|", $elementData[0]->dialog);
			@endphp
			@foreach ($problems as $problem)
			<p>{{ $problem }}</p>
			@endforeach
		</div>
		<div id="result" style="text-align: center;"></div>
		<div>
			<img id="imgBoard" style="width: 80%; max-width: 900px;" src="{{ asset('img/P6/board.svg') }}" alt="start button">
		</div>
	</div>
	
	<div id="answerGroup" style="text-align: center;">
		<div class="answerLineItem">
			<div class="answerFlex">
				<div class="crossWrap">
					<img class="imgCross" src="{{ asset('img/P6/cross.svg') }}" alt="answer paper">
				</div>
				<div class="checkWrap">
					<img class="imgCheck" src="{{ asset('img/P6/check.svg') }}" alt="answer paper">
				</div>
				<div class="checkWrongWrap">
					<img class="imgCheckWrong" src="{{ asset('img/P6/checkWrong.svg') }}" alt="answer paper">
				</div>
				<button autocomplete="off" id="0" name="{{ $elementData[0]->answerOrder[0] }}" class="btn-answer {{ strcmp($elementData[0]->answerOrder[0], 'correctAnswer') == 0 ? " correctAnswer" : "wrongAnswer" }} {{ $elementData[0]->answers[$elementData[0]->answerOrder[0]]["chosen"] == true ? " chosen" : "" }}">
					{{ $elementData[0]->answers[$elementData[0]->answerOrder[0]]["content"] }}
				</button>
			</div>
		</div>
		<div class="answerLineItem">
			<div class="answerFlex">
				<div class="crossWrap">
					<img class="imgCross" src="{{ asset('img/P6/cross.svg') }}" alt="answer paper">
				</div>
				<div class="checkWrap">
					<img class="imgCheck" src="{{ asset('img/P6/check.svg') }}" alt="answer paper">
				</div>
				<div class="checkWrongWrap">
					<img class="imgCheckWrong" src="{{ asset('img/P6/checkWrong.svg') }}" alt="answer paper">
				</div>
				<button autocomplete="off" id="0" name="{{ $elementData[0]->answerOrder[1] }}" class="btn-answer {{ strcmp($elementData[0]->answerOrder[1], 'correctAnswer') == 0 ? " correctAnswer" : "wrongAnswer" }} {{ $elementData[0]->answers[$elementData[0]->answerOrder[1]]["chosen"] == true ? " chosen" : "" }}">
					{{ $elementData[0]->answers[$elementData[0]->answerOrder[1]]["content"] }}
				</button>
			</div>
		</div>
		<div class="answerLineItem">
			<div class="answerFlex">
				<div class="crossWrap">
					<img class="imgCross" src="{{ asset('img/P6/cross.svg') }}" alt="answer paper">
				</div>
				<div class="checkWrap">
					<img class="imgCheck" src="{{ asset('img/P6/check.svg') }}" alt="answer paper">
				</div>
				<div class="checkWrongWrap">
					<img class="imgCheckWrong" src="{{ asset('img/P6/checkWrong.svg') }}" alt="answer paper">
				</div>
				<button autocomplete="off" id="0" name="{{ $elementData[0]->answerOrder[2] }}" class="btn-answer {{ strcmp($elementData[0]->answerOrder[2], 'correctAnswer') == 0 ? " correctAnswer" : "wrongAnswer" }} {{ $elementData[0]->answers[$elementData[0]->answerOrder[2]]["chosen"] == true ? " chosen" : "" }}">
					{{ $elementData[0]->answers[$elementData[0]->answerOrder[2]]["content"] }}
				</button>
			</div>
		</div>
	</div>

	<div style="text-align: center">
		<button autocomplete="off" class="btn btn-warning btnNext inv" disabled>Next</button>
	</div>
</div>

<script>
	$('.btnNext').click(function () {
		next(this);
	});

	$('.btn-answer').click(function () {
		checkAnswer(this);
	});

	$('#answerGroup > div').hover(
		function() {
			$(this).addClass('pop');
		}, 
		function() {
			$(this).removeClass('pop');
		});

	var originalData = <?php echo json_encode($elementData); ?>;
	var elementData = <?php echo json_encode($elementData); ?>;
	var cnt = <?php echo json_encode($cnt); ?>;
	var currentQuestion = 0;
	var lastQuestion = cnt - 1;
	var questionsDone = 0;
	var correctAnswerNo = 0;
	var assetPath = '{{ mb_substr(\Storage::url('/'),0,-1) }}';

	$(document).ready(function() {
		var tl = new TimelineMax();
		$('#problems').addClass('animated bounceInDown').css('opacity', 1).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
			tl.staggerFromTo('.answerLineItem', 0.4, {x:-50, y:50, opacity:0}, {x:0, y:0, opacity:1, clearProps:"transform"}, 0.2)
			  .set('.answerLineItem',{className:"+=pinch"})
			  .set('.btnNext',{className:"-=inv"});
		});
	})
</script>
<script src="{{ asset('js/screens/p6.js') }}"></script>

@stop

@section('actDescription-vi')
	Lựa chọn một trong 3 đáp án, rê chuột vào đó và tích chuột.
@stop

@section('actDescription-en')
	To choose 1 option from the total of 3, click on each option.
@stop