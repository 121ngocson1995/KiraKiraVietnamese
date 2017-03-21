@extends('activities.layout.activityLayout')

@section('actContent')

<style>
	#questions {
		position: fixed;
		top: 42%;
		left: 50%;
		transform: translate(-50%, -50%);
	}
	#result {
		position: fixed;
		top: 42%;
		left: 50%;
		transform: translate(-50%, -50%);
		display: none;
	}
	.btn-answer {
		border-radius: 4px;
		border: 1px solid transparent;
		padding: 6px 15px;
		margin: 10px;
		font-size: 30px;
		transition: background-color 0.4s;
	}
	.btnNext {
		font-size: 20px;
		width: 150px;
		border-radius: 50px;
		font-weight: 800;
		transition: background-color 0.4s;
	}
	.chosen.correctAnswer, .chosen.correctAnswer:hover {
		background-color: #008000;
		border-color: #008000;
	}
	.chosen.wrongAnswer, .chosen.wrongAnswer:hover {
		background-color: red;
		border-color: red;
	}
	.result {
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
	}
</style>

<script type="text/javascript">
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
		currentQuestion = questionId;

		var btnNext = document.getElementsByClassName('btnNext')[0];
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

		$('#problems').empty();

		var problemArr = elementData[questionId].dialog.split("|");
		for (var i = 0; i < problemArr.length; i++) {
			var p = document.createElement('p');
			p.innerHTML = problemArr[i];
			document.getElementById("problems").appendChild(p);
		}

		$('#answerGroup').empty();

		var button = [];
		var chosenNo = 0;
		
		for (var i = 0; i <= 2; i++) {
			var toDisable = false;
			button.push(document.createElement('button'));
			button[i].id = questionId;
			button[i].name = elementData[questionId].answerOrder[i];
			button[i].className = "btn btn-primary btn-answer";

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

			document.getElementById("answerGroup").appendChild(button[i]);
		}

		if (chosenNo == 3) {
			$('.btnNext').prop('disabled', false);
		} else {
			$('.btnNext').prop('disabled', true);
		}

		$('#navQ' + questionId).prop('disabled', false);
		
		$('.btn-answer').click(function () {
			checkAnswer(this);
		})
	}

	function checkAnswer(button) {
		var giveMark = true

		if ($(button).hasClass('correctAnswer')) {
			if ($(button).attr('name') == "correctAnswer") {
				elementData[parseInt($(button).attr('id'))].answers.correctAnswer.chosen = true;
			}

			markBtn('.btn-answer');

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

			markBtn(button);

			if ($('.chosen').length == 2) {

				markBtn('.btn-answer');
				questionsDone++;

				var navQn = $(button).attr('id');
				$('#navQ'+navQn).removeClass('btn-warning');
				$('#navQ'+navQn).addClass('btn-danger');
			}
		}
	}

	function markBtn(button) {
		if (button == ".btn-answer" /*&& currentQuestion == lastQuestion && questionsDone == lastQuestion + 1*/) {
			document.getElementsByClassName('btnNext')[0].disabled = false;

			$('.btn-answer').each(function() {
				if (!$(this).hasClass('chosen')) {
					var qName = this.name;
					if (qName == "correctAnswer") {
						console.log(elementData[parseInt($(this).attr('id'))].answers.correctAnswer.chosen);
						elementData[parseInt($(this).attr('id'))].answers.correctAnswer.chosen = true;
					} else if (qName == "wrongAnswer1") {
						console.log(elementData[parseInt($(this).attr('id'))].answers.wrongAnswer1.chosen);
						elementData[parseInt($(this).attr('id'))].answers.wrongAnswer1.chosen = true;
					} else {
						console.log(elementData[parseInt($(this).attr('id'))].answers.wrongAnswer2.chosen);
						elementData[parseInt($(this).attr('id'))].answers.wrongAnswer2.chosen = true;
					}
				}
			});
		}

		$(button).addClass('chosen');
		$(button).prop('disabled', true);
	}

	function showResult() {
		var result = document.createElement("span");
		result.className = 'result';
		result.innerHTML = 'You are ' + (correctAnswerNo / (lastQuestion + 1) * 100).toFixed(2) + '% correct <br> (' + correctAnswerNo + '/' + (lastQuestion + 1) + ')';
		document.getElementById("result").appendChild(result);
		$('#questions').fadeOut(600, function () {
			$('#result').fadeIn(600);
		});
	}
</script>

<div id="questions">
	<div id="order_id" style="text-align: center; margin: 10px">
		<div class="btn-group">
			@php
				$firstBtn = true;
			@endphp
			@for ($i = 0; $i < count($elementData); $i++)
				<button type="button" id="navQ{{ $i }}" class="btn btn-warning" style="font-size: 18px; width: 60px;" onclick="switchQuestion({{ $i }})"
				@if ($firstBtn != true)
					disabled=""
				@else
					@php
						$firstBtn = false;
					@endphp
				@endif
				>{{ "Q".($i+1) }}</button>
			@endfor
		</div>
	</div>
	<div id='problems' align="center" style="border-radius: 10px; background-color:#e6e6e6; color:white ;padding:10px; font-size: 30px; color: black">
		@php
			$problems = explode("|", $elementData[0]->dialog);
		@endphp
		@foreach ($problems as $problem)
			<p>{{ $problem }}</p>
		@endforeach
	</div>
	
	<div id="answerGroup" style="text-align: center;">
		<button id="0" name="{{ $elementData[0]->answerOrder[0] }}" class="btn btn-primary btn-answer {{ strcmp($elementData[0]->answerOrder[0], 'correctAnswer') == 0 ? " correctAnswer" : "wrongAnswer" }} {{ $elementData[0]->answers[$elementData[0]->answerOrder[0]]["chosen"] == true ? " chosen" : "" }}">
				{{ $elementData[0]->answers[$elementData[0]->answerOrder[0]]["content"] }}
		</button>
		<button id="0" name="{{ $elementData[0]->answerOrder[1] }}" class="btn btn-primary btn-answer {{ strcmp($elementData[0]->answerOrder[1], 'correctAnswer') == 0 ? " correctAnswer" : "wrongAnswer" }} {{ $elementData[0]->answers[$elementData[0]->answerOrder[1]]["chosen"] == true ? " chosen" : "" }}">
				{{ $elementData[0]->answers[$elementData[0]->answerOrder[1]]["content"] }}
		</button>
		<button id="0" name="{{ $elementData[0]->answerOrder[2] }}" class="btn btn-primary btn-answer {{ strcmp($elementData[0]->answerOrder[2], 'correctAnswer') == 0 ? " correctAnswer" : "wrongAnswer" }} {{ $elementData[0]->answers[$elementData[0]->answerOrder[2]]["chosen"] == true ? " chosen" : "" }}">
				{{ $elementData[0]->answers[$elementData[0]->answerOrder[2]]["content"] }}
		</button>
	</div>

	<div style="text-align: center">
		<button class="btn btn-warning btnNext" onclick="next(this)" disabled>Next</button>
	</div>
</div>

<div>
	<div id="result" style="text-align: center;"></div>
</div>

<script>
	$('.btn-answer').click(function () {
		checkAnswer(this);
	})
</script>
@stop