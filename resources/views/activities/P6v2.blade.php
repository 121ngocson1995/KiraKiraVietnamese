@extends('activities.layout.activityLayout')

@section('header-more')

<style>
	body {
		background: url({{ asset('img/P6/bg.svg') }}) no-repeat center center fixed;
		background-size: cover;
	}
	#questions {
		/*position: fixed;
		top: 42%;
		left: 50%;
		transform: translate(-50%, -50%);*/
		text-align: center;
		padding-top: 5%;
	}
	/*#result {
		position: fixed;
		top: 42%;
		left: 50%;
		transform: translate(-50%, -50%);
		display: none;
	}*/
	#problems {
		display: flex;
		align-items: center;
		text-align: center;
		z-index: 1;
		opacity: 0;
	}
	#problems #qText, #problems #result {
		position: absolute;
		color: white;
		font-family: 'Patrick Hand', cursive;
		font-size: 2.5em;
		left: 50%;
		transform: translate(-50%,-5%);
		z-index: 1;
	}
	#problems #result {
		font-size: 3.5em;
	}
	#qText + div, #result + div {
		position: relative;
		left: 50%;
		transform: translateX(-50%);
	}
	.pinch {
		transition: all 0.3s;
	}
	.answerLineItem {
		display: inline-block;
		opacity: 0;
	}
	.answerFlex {
		display: flex;
		align-items: center;
		text-align: center;
	}
	.btn-answer {
		border-radius: 4px;
		border: 1px solid transparent;
		padding: 15px 30px;
		margin: 10px;
		font-size: 30px;
		font-family: 'Patrick Hand', cursive;
		background: url({{ asset('img/P6/paper.svg') }});
		background-size: cover;
		box-shadow: -7px 7px 5px rgba(102, 102, 153, 0.3);
		transition: background-color 0.4s, transform 0.4s;
	}
	.imgCross, .imgCheck, .imgCheckWrong {
		/*position: absolute;*/
		color: #33ccff;
		/*margin-left: 3%;*/
		/*left: 50%;*/
		transform: translateX(15%);
		max-width: 100px;
		z-index: 1;
		transition: all 0.4s;
	}
	.imgCheck, .imgCheckWrong {
		transform: scale(0.65, 0.65);
	}
	.crossWrap, .checkWrap, .checkWrongWrap {
		position: absolute;
		overflow: hidden;
		width: 0;
		height: 0;
	}
	.pop {
		transform: translate3d(10px,-5px,100px);
	}
	.btnNext {
		font-size: 20px;
		width: 150px;
		border-radius: 50px;
		font-weight: 800;
		transition: all 0.4s, opacity 0.4s;
	}
	.btnNext.inv {
		opacity: 0 !important;
	}
	.chosen.correctAnswer, .chosen.correctAnswer:hover {
		background-color: #008000 !important;
		border-color: #008000 !important;
	}
	.chosen.wrongAnswer, .chosen.wrongAnswer:hover {
		background-color: red !important;
		border-color: red !important;
	}
	/*.result {
		-moz-animation-delay: 4s;
		-webkit-animation-delay: 4s;
	}*/
	/*.result {
		padding: 10px;
		border: none;
		outline: none;
		color: cornflowerblue;
		background-color: transparent;
		border-bottom: solid 2px #6495ed;
		border-bottom: solid 2px #cccccc;
		text-align: center;
		font-size: 60px;
		transition: color 0.4s, background-color 0.4s, border-bottom 0.4s;
		cursor: default;
	}*/
</style>

@stop

@section('actContent')

<script type="text/javascript">
	var originalData = <?php echo json_encode($elementData); ?>;
	var elementData = <?php echo json_encode($elementData); ?>;
	var cnt = <?php echo json_encode($cnt); ?>;
	var currentQuestion = 0;
	var lastQuestion = cnt - 1;
	var questionsDone = 0;
	var correctAnswerNo = 0;

	function next(button) {
		if (button.innerHTML == "Next") {
			switchQuestion(currentQuestion + 1);
		} else {
			showResult();
		}
	}

	function switchQuestion(questionId) {

		var btnNext = document.getElementsByClassName('btnNext')[0];
		$(btnNext).addClass('inv');

		if (questionId == 0) {
			showPaper();
			$('.btnNext').click(function () {
				console.log(this);
				next(this);
			});
		} else {
			var tl = new TimelineMax();
			tl.staggerTo('.answerLineItem', 0, {className:"+=animated hinge"}, 0.2);
			$('.answerLineItem').last().one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
				showPaper();
			});
		}

		function showPaper() {
			currentQuestion = questionId;

			if (currentQuestion == lastQuestion) {
				btnNext.innerHTML = 'Finish';
				if (questionsDone < lastQuestion + 1) {
					btnNext.disabled = true;
				} else {
					btnNext.disabled = false;
				}
			} else {
				btnNext.innerHTML = 'Next';
				btnNext.disabled = false;
			}

			$('#qText').empty();

			var problemArr = elementData[questionId].dialog.split("|");
			for (var i = 0; i < problemArr.length; i++) {
				var p = document.createElement('p');
				p.innerHTML = problemArr[i];
				document.getElementById("qText").appendChild(p);
			}

			$('#answerGroup').empty();

			var button = [];
			var chosenNo = 0;
			
			for (var i = 0; i <= 2; i++) {
				var toDisable = false;

				var answerLineItem = document.createElement('div');
				answerLineItem.className = 'answerLineItem';

				var answerFlex = document.createElement('div');
				answerFlex.className = 'answerFlex';

				var crossWrap = document.createElement('div');
				crossWrap.className = 'crossWrap';
				var imgCross  = document.createElement('img');
				imgCross.className = 'imgCross';
				imgCross.src = '{{ asset('img/P6/cross.svg') }}';
				crossWrap.appendChild(imgCross);
				answerFlex.appendChild(crossWrap);

				var checkWrap = document.createElement('div');
				checkWrap.className = 'checkWrap';
				var imgCheck  = document.createElement('img');
				imgCheck.className = 'imgCheck';
				imgCheck.src = '{{ asset('img/P6/check.svg') }}';
				checkWrap.appendChild(imgCheck);
				answerFlex.appendChild(checkWrap);

				var checkWrongWrap = document.createElement('div');
				checkWrongWrap.className = 'checkWrongWrap';
				var imgCheckWrong  = document.createElement('img');
				imgCheckWrong.className = 'imgCheckWrong';
				imgCheckWrong.src = '{{ asset('img/P6/checkWrong.svg') }}';
				checkWrongWrap.appendChild(imgCheckWrong);
				answerFlex.appendChild(checkWrongWrap);

				button.push(document.createElement('button'));
				button[i].id = questionId;
				button[i].setAttribute('autocomplete', 'off');
				button[i].name = elementData[questionId].answerOrder[i];
				button[i].className = "btn-answer";

				if (elementData[questionId].answers[elementData[questionId].answerOrder[i]].chosen == true) {
					button[i].className += " chosen";
					chosenNo++;
					toDisable = true;
				}

				if (elementData[questionId].answerOrder[i] == "correctAnswer") {
					button[i].className += " correctAnswer";
				} else {
					button[i].className += " wrongAnswer";
				}

				button[i].innerHTML = elementData[questionId].answers[elementData[questionId].answerOrder[i]].content;

				button[i].onclick = function () {
					checkAnswer(button[i]);
				};

				if (toDisable == true) {
					button[i].disabled = true;
				}

				answerFlex.appendChild(button[i]);

				answerLineItem.appendChild(answerFlex);

				document.getElementById("answerGroup").appendChild(answerLineItem);
			}

			if (chosenNo == 3) {
				$('.btnNext').prop('disabled', false);
			} else {
				$('.btnNext').prop('disabled', true);
			}

			$('#navQ' + questionId).prop('disabled', false);
			
			$('.btn-answer').click(function () {
				checkAnswer(this);
			});

			prepareAnswer();

			$('#answerGroup > div').hover(
			function() {
				$(this).addClass('pop');
			}, 
			function() {
				$(this).removeClass('pop');
			});
		}
	}

	function checkAnswer(button) {
		var giveMark = true

		if ($(button).hasClass('correctAnswer')) {
			if ($(button).attr('name') == "correctAnswer") {
				elementData[parseInt($(button).attr('id'))].answers.correctAnswer.chosen = true;
			}

			markBtn('.btn-answer', true);

			correctAnswerNo++;
			questionsDone++;

			var navQn = $(button).attr('id');
			$('#navQ'+navQn).removeClass('btn-warning');
			$('#navQ'+navQn).addClass('btn-success');
		} else if ($(button).hasClass('wrongAnswer')) {
			if ($(button).attr('name') == "wrongAnswer1") {
				elementData[parseInt($(button).attr('id'))].answers.wrongAnswer1.chosen = true;
			} else if ($(button).attr('name') == "wrongAnswer2") {
				elementData[parseInt($(button).attr('id'))].answers.wrongAnswer2.chosen = true;
			}

			markBtn(button, false);

			if ($('.chosen').length == 2) {

				markBtn('.btn-answer', false);
				questionsDone++;

				var navQn = $(button).attr('id');
				$('#navQ'+navQn).removeClass('btn-warning');
				$('#navQ'+navQn).addClass('btn-danger');
			}
		}
	}

	function markBtn(button, correctChoice) {
		if (button == ".btn-answer" /*&& currentQuestion == lastQuestion && questionsDone == lastQuestion + 1*/) {
			document.getElementsByClassName('btnNext')[0].disabled = false;

			$('.btn-answer').each(function() {
				if (!$(this).hasClass('chosen')) {
					var qName = this.name;
					if (qName == "correctAnswer") {
						elementData[parseInt($(this).attr('id'))].answers.correctAnswer.chosen = true;
						if (correctChoice) {
							if ($(this).hasClass('correctAnswer')) {
								TweenMax.fromTo($(this).parent().find('.checkWrap'), 0.35, {css:{width:0, height:0}}, {css:{width:100, height:'initial'}});
							}
						} else {
							if ($(this).hasClass('correctAnswer')) {
								TweenMax.fromTo($(this).parent().find('.checkWrongWrap'), 0.35, {css:{width:0, height:0}}, {css:{width:100, height:'initial'}});
							}
						}
					} else if (qName == "wrongAnswer1") {
						elementData[parseInt($(this).attr('id'))].answers.wrongAnswer1.chosen = true;
						if (!$("button[name='" + qName + "']").hasClass('marked')) {
							TweenMax.fromTo($(this).parent().find('.crossWrap'), 0.35, {css:{width:0, height:0}}, {css:{width:100, height:'initial'}});

							$(this).addClass('marked');
						}
					} else {
						elementData[parseInt($(this).attr('id'))].answers.wrongAnswer2.chosen = true;
						if (!$("button[name='" + qName + "']").hasClass('marked')) {
							TweenMax.fromTo($(this).parent().find('.crossWrap'), 0.35, {css:{width:0, height:0}}, {css:{width:100, height:'initial'}});

							$(this).addClass('marked');
						}
					}
				}
			});
		} else {
			if ($(button).hasClass('wrongAnswer')) {
				TweenMax.fromTo($(button).parent().find('.crossWrap'), 0.35, {css:{width:0, height:0}}, {css:{width:100, height:'initial'}});
			}

			$(button).addClass('marked');
		}

		$(button).addClass('chosen');
		$(button).prop('disabled', true);
	}

	function showResult() {
		var btnNext = document.getElementsByClassName('btnNext')[0];
		// btnNext.innerHTML = 'Redo';
		// btnNext.disabled = false;
		// $('.answerLineItem').css('opacity', 0);
		// $(btnNext).click(function() {
		// 	$('#qText').fadeIn(600);
		// 	$('#result').fadeOut(600);
		// 	elementData = originalData;
		// 	currentQuestion = 0;
		// 	questionsDone = 0;
		// 	correctAnswerNo = 0;
		// 	switchQuestion(0);
		// });

		$('.answerLineItem').css('opacity', 0);
		$(btnNext).css('opacity', 0);
		btnNext.disabled = true;
		var result = document.createElement("div");
		result.className = 'score result';
		result.innerHTML = '' + correctAnswerNo + '/' + (lastQuestion + 1) + ' correct';
		$('#result').empty();
		document.getElementById("result").appendChild(result);
		$('#qText').fadeOut(600, function () {
			$('#result').fadeIn(600);
			// $('.score').addClass('animated zoomIn');
		});
	}
</script>

<div id="questions">
	<div id="order_id" style="text-align: center; margin: 10px">
		{{-- <div class="btn-group">
			@php
				$firstBtn = true;
			@endphp
			@for ($i = 0; $i < count($elementData); $i++)
				<button autocomplete="off" type="button" id="navQ{{ $i }}" class="btn btn-warning" style="font-size: 18px; width: 60px;" onclick="switchQuestion({{ $i }})"
				@if ($firstBtn != true)
					disabled=""
				@else
					@php
						$firstBtn = false;
					@endphp
				@endif
				>{{ "Q".($i+1) }}</button>
			@endfor
		</div> --}}
	</div>
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
				{{-- <div>
					<img class="imgPaper" style="width: 100%;" src="{{ asset('img/P6/paper.svg') }}" alt="answer paper">
				</div> --}}
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

	$(document).ready(function() {
		var tl = new TimelineMax();
		$('#problems').addClass('animated bounceInDown').css('opacity', 1).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
			tl.staggerFromTo('.answerLineItem', 0.4, {x:-50, y:50, opacity:0}, {x:0, y:0, opacity:1, clearProps:"transform"}, 0.2)
			  .set('.answerLineItem',{className:"+=pinch"})
			  .set('.btnNext',{className:"-=inv"});
		});
	})

	function prepareAnswer() {
		var tl = new TimelineMax();
		tl.staggerFromTo('.answerLineItem', 0.4, {x:-50, y:50, opacity:0}, {x:0, y:0, opacity:1, clearProps:"transform"}, 0.2)
			  .set('.answerLineItem',{className:"+=pinch"})
			  .set('.btnNext',{className:"-=inv"});
	}
</script>
@stop