@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/hover.css') }}">
<link rel="stylesheet" href="{{ asset('css/smiley.css') }}">
<link rel="stylesheet" href="{{ asset('css/font-awesome-animation.min.css') }}">
<style>
	.dragSentence {
		/*display: inline-block;*/
		border-radius: 4px;
		border: 1px solid transparent;
		min-height: 40px;
		width: 75%;
		white-space: normal;
		padding: 0 10px;
		margin: 5px;
		text-align: center;
		background: #e6e6e6;
		font-size: 1.5em;
		transition: background 0.6s;
	}
	.dragSentence:hover {
		cursor: move;
	}
	.dragSentence:active {
		background: gold;
	}
	.dragSentence span {
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		padding: 0 20px;
	}
	.dropSentence {
		/*display: inline-block;*/
		width: 75%;
		height: 40px;
		font-size: 30px;
		text-align: center;
		border-radius: 4px;
		background: rgba(0, 153, 255, .2);
		margin: 5px;
	}
	.dropSentence span {
		position: relative;
		float: left;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		/*padding: 0 20px;*/
	}
	.dropPulse {
		-webkit-animation-name: hvr-pulse-grow;
		animation-name: hvr-pulse-grow;
		-webkit-animation-duration: 0.5s;
		animation-duration: 0.5s;
		-webkit-animation-timing-function: linear;
		animation-timing-function: linear;
		-webkit-animation-iteration-count: infinite;
		animation-iteration-count: infinite;
		-webkit-animation-direction: alternate;
		animation-direction: alternate;
	}
	@-webkit-keyframes hvr-pulse-grow {
		to {
			-webkit-transform: scale(1.1);
			transform: scale(1.1);
		}
	}
	@keyframes hvr-pulse-grow {
		to {
			-webkit-transform: scale(1.1);
			transform: scale(1.1);
		}
	}
	#resultContainer {
		position: fixed;
		top:50%;
		left: 50%;
		transform: translate(-50%, -50%);
		text-align: center;
		display: none;
	}
	.tryAgain {
		padding-top: 0.3em;
		padding-bottom: 0.3em;
		padding-left: 0.8em;
		padding-right: 0.8em;
		border: 0.2em solid #f2f2f2;
		border-radius: 10px;
		background: #f2f2f2;
		font-size: 2.5em;
		color: black;
		transition: all .5s;
	}
	.tryAgain:hover {
		border: 0.2em solid #bfbfbf;
		background: #bfbfbf;
		color: white;
	}
	.score {
		background: initial;
	}
	.score:hover {
		background: initial;
		color: black;
	}
</style>

<script>
	var elementData = <?php echo json_encode($elementData); ?>;
</script>

<div class="col-sm-6" style="text-align: right; text-align: -webkit-right">
	<div id="draggable">
		@foreach ($elementData as $elementValue)
			<div id="{{ $elementValue->correctOrder }}" class="dragSentence"><span>{{ $elementValue->sentence }}</span></div>
		@endforeach
	</div>
</div>
<div class="col-sm-6">
	<div id="droppable">
		@for ($i = 0; $i < count($elementData); $i++)
			<div class="dropSentence"></div>
		@endfor
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
	<div class="{{-- hi-icon-wrap hi-icon-effect-4 hi-icon-effect-4a --}}">
		<div class="btn tryAgain score">
			<span id="scoreText">Score: </span>
			<span id="correct"></span>
			<span id="total"></span>
		</div>
		<a id="tryAgainBtn" class="{{-- hi-icon --}}btn tryAgain" role="button" onclick="redo()" style="display: none;">Try again<i class="fa fa-repeat faa-spin animated faa-slow" style="vertical-align: middle;"></i></a>
		<a id="nextBtn" class="{{-- hi-icon --}}btn tryAgain" role="button" onclick="redo()" style="display: none;">Do it once more<i class="fa fa-forward faa-horizontal animated faa-slow" style="vertical-align: middle;"></i></a>
	</div>
</div>

<br style="clear:both">

<script>
	var correctNo = 0;
	var totalQuestion = 0;

	window.onresize = function() {
		$('.dropSentence').each(function() {
			$(this).css('height', $($(this).data('curDrag')).css('height'));
			rePosition($(this), $(this).data('curDrag'));
		});
	}

	window.onload = function() {
		initDroppable();
	}

	function initDroppable() {
		$(".dragSentence").draggable({
			create: function(){
				$(this).data('position',$(this).position());
			},
			cursor:'move',
			// cursorAt: { top: this.clientHeight / 2, left: this.clientWidth / 2 },
			drag: function(){
				$(this).css('background', 'gold');
			},
			stop: function(){
				$(this).css('background', '#e6e6e6');
			},
			// cursorAt: { left: Math.floor(this.width / 2), top: Math.floor(this.height / 2) },
			// start:function(){$(this).stop(true,true)},
			revert: 'invalid',
			start:function(){
				$(this).stop(true,true);
			},
			stack: ".dragSentence"
		});

		$('.dropSentence').droppable({
			over: function(event, ui) {
				$(this).addClass('dropPulse');
				var dropTarget = $(this);
				dropInitialHeight = dropTarget.css('height');
				if (parseFloat(ui.draggable.css('height')) > parseFloat(dropInitialHeight)) {
					dropTarget.css('height', ui.draggable.css('height'));
				}

				/* change position of draggable element along with drop target */
				$('.dropSentence').each(function() {
					if ($(this).data('curDrag') != ui.draggable) {
						rePosition($(this), $(this).data('curDrag'));
					}
				})
			},
			out: function(event, ui) {
				$(this).removeClass('dropPulse');
				var dropTarget = $(this);
				dropTarget.css('height', dropInitialHeight);

				/* change position of draggable element along with drop target */
				$('.dropSentence').each(function() {
					if ($(this).data('curDrag') != ui.draggable) {
						rePosition($(this), $(this).data('curDrag'));
					}
				})
			},
			drop: function(event, ui) {
				$(this).removeClass('dropPulse');
				/* exhange draggable element if drop target already have one */
				if($(this).data('curDrag')) {
					var lastDrag = $(this).data('curDrag');
					
					if (ui.draggable.data('curDrop')) {
						var lastDrop = ui.draggable.data('curDrop');
						lastDrop.css('height', lastDrag.css('height'));
						lastDrag.position({
							my: "center",
							at: "center",
							of: lastDrop,
							using: function(pos) {
								$(this).animate(pos, 0, "linear");
							}
						});
						lastDrop.data('curDrag', lastDrag);
						lastDrag.data('curDrop', lastDrop);
					} else {
						lastDrag.css('top', 0);
						lastDrag.css('left', 0);
						lastDrag.css('background', '#e6e6e6');
						ui.draggable.css('background', 'initial');
						lastDrag.removeData('curDrop');
					}
				} else {
					$(ui.draggable.data('curDrop')).removeData('curDrag');
				}

				/* position draggable elemtn at the middle of drop target */
				var dropTarget = $(this);
				dropTarget.css('height', ui.draggable.css('height'));

				ui.draggable.position({
					my: "center",
					at: "center",
					of: dropTarget,
					using: function(pos) {
						$(this).animate(pos, 200, "linear");
						setTimeout(function() {
							ui.draggable.css('background', '#e6e6e6');
						}, 200);
					}
				});

				dropTarget.data('curDrag', ui.draggable);
				ui.draggable.data('curDrop', dropTarget);
				checkAnswer();

				$('.dropSentence').each(function() {
					rePosition($(this), $(this).data('curDrag'));
				})
			}
		});
	}

	function rePosition(drop, drag) {
		/* change position of draggable element along with drop target */
		if (drop.data('curDrag')) {
			drag.position({
				my: "center",
				at: "center",
				of: drop,
				using: function(pos) {
					$(this).animate(pos, 0, "linear");
				}
			});
		}
	}

	function checkAnswer() {
		var correctAnswer = <?php echo json_encode($correctAnswer); ?>;
		var answer = [];

		$('.dropSentence').each(function() {
			if ($(this).data('curDrag')) {
				answer.push($(this).data('curDrag').html().replace('<span>', '').replace('</span>', ''));
			}
		});

		if (answer.length == correctAnswer.length) {
			var allCorrect = true;
			for (var i = 1; i < answer.length; i++) {
				if (answer[i] != correctAnswer[i]) {
					allCorrect = false;
				}
			}

			if (allCorrect == true) {
				showScore(true);
				showCorrect();
			} else {
				showScore(false);
				showWrong();
			}
		}
	}

	function showCorrect() {
		$('#draggable').fadeOut(500);
		$('#droppable').fadeOut(500, function () {
			$('#resultContainer').fadeIn(500);
			$('#nextBtn').fadeIn(500);
			document.getElementById('happy').checked = true;
		});
	}

	function showWrong() {
		$('#draggable').fadeOut(500);
		$('#droppable').fadeOut(500, function () {
			$('#resultContainer').fadeIn(500);
			$('#tryAgainBtn').fadeIn(500);
			document.getElementById('normal').checked = true;
		});
	}

	function showScore(isCorrect) {
		$('#correct').html(isCorrect ? ++correctNo : correctNo);
		$('#total').html('/' + ++totalQuestion + ' tries');
	}

	function redo() {
		var droppable = document.getElementById('droppable');
		emptyDiv(droppable);
		var draggable = document.getElementById('draggable');
		emptyDiv(draggable);

		shuffleSentence();
		for (var i = 0; i < elementData.length; i++) {
			var newDrop = document.createElement('div');
			newDrop.className = 'dropSentence';
			document.getElementById('droppable').appendChild(newDrop);

			var newDrag = document.createElement('div');
			newDrag.className = 'dragSentence';
			newDrag.id = elementData[i].correctOrder;
			newDrag.innerHTML = '<span>' + elementData[i].sentence + '</span>';
			document.getElementById('draggable').appendChild(newDrag);
		}

		$('#resultContainer').fadeOut(500, function() {
			$('#draggable').fadeIn(500);
			$('#droppable').fadeIn(500);
			document.getElementById('normal').checked = true;
		});

		if ($('#tryAgainBtn').css('display') != 'none') {
			$('#tryAgainBtn').fadeOut(500);
		}

		if ($('#nextBtn').css('display') != 'none') {
			$('#nextBtn').fadeOut(500);
		}

		initDroppable();
	}

	function shuffleSentence() {
		var doAgain = true;
		while(doAgain) {
			doAgain = true;

			Shuffle(elementData);

			for (var i = 0; i < elementData.length - 1; i++) {
				if (parseInt(elementData[i].correctOrder) != parseInt(elementData[i+1].correctOrder) - 1) {
					doAgain = false;
					break;
				}
			}
		}
	}

	function Shuffle(o) {
		for(var j, x, i = o.length; i; j = parseInt(Math.random() * i), x = o[--i], o[i] = o[j], o[j] = x);
		return o;
	};

	function emptyDiv(div) {
		while(div.firstChild){
			div.removeChild(div.firstChild);
		}
	}
</script>

@stop

@section('description')
	In this activity, drag and drop sentences from the left box to the right one so that they makes a dialog.
@stop