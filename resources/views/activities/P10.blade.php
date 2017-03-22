@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/smiley.css') }}">
<style>
	.fullscreenDiv {
		width: 100%;
		height: auto;
		bottom: 0px;
		top: 65px;
		left: 0;
		position: absolute;
		text-align: center;
	}
	#questionHolder {
		top: 40%;
		left: 50%;
		/* bring your own prefixes */
		transform: translate(-50%, -50%);
	}
	#draggable {
		position: relative;
		/*top: 32%;
		left: 50%;*/
		/*transform: translate(-50%, -50%);*/
	}
	#droppable {
		position: relative;
		/*top: 55%;
		left: 50%;*/
		/*transform: translate(-50%, -50%);*/
	}
	#resultContainer {
		position: fixed;
		top:50%;
		left: 50%;
		transform: translate(-50%, -50%);
		text-align: center;
		display: none;
	}
	html>body #sortable span {
		padding: 6px 15px;
	}
	.ui-state-highlight {
		padding: 6px 15px;
	}
	.dragWord {
		display: inline-block;
		border-radius: 4px;
		border: 1px solid transparent;
		height: 60px;
		/*padding: 6px 15px;*/
		margin: 5px;
		background: #e6e6e6;
		font-size: 30px;
		transition: background 0.6s;
	}
	.dragWord:hover {
		cursor: move;
	}
	.dragWord:active {
		background: gold;
	}
	.dragWord span {
		position: relative;
		float: left;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		padding: 0 20px;
	}
	.dropWord {
		display: inline-block;
		width: 60px;
		height: 60px;
		font-size: 30px;
		text-align: center;
		border-radius: 4px;
		background: rgba(0, 153, 255, .2);
		margin: 5px;
	}
	.dropWord span {
		position: relative;
		float: left;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		/*padding: 0 20px;*/
	}
	@media screen and (max-height: 736px) {
	}
	@media screen and (max-width: 791px) {
		.dragWord {
			height: 40px;
			font-size: 20px;
		}
		.dropWord {
			width: 40px;
			height: 40px;
			font-size: 20px;
		}
	}
	.result {
		background-color: transparent;
		padding: 10px;
		border: none;
		border-bottom: solid 2px #cccccc;
		text-align: center;
		font-size: 60px;
		transition: color 0.4s, border-bottom 0.4s;
		cursor: default;
	}
	.result:hover {
		outline: none;
		color: cornflowerblue;
		border-bottom: solid 2px #6495ed;
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
	.resultSpace {
	    position: relative;
	    top: 50px;
	}
</style>

<link rel="stylesheet" href="{{ asset('css/font-awesome-animation.min.css') }}">
{{-- <link rel="stylesheet" href="{{ asset('css/component.css') }}"> --}}
<script>
	var elementData = <?php echo json_encode($elementData); ?>;
	var curQuestion = 0;
</script>

<div class='fullscreenDiv'>

	<div id="questionHolder" class="col-xs-12">
		<div id="draggable">
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
			<a id="nextBtn" class="{{-- hi-icon --}}btn tryAgain resultSpace" role="button" onclick="changeSentence(curQuestion+1, true)" style="display: none;">Next<i class="fa fa-forward faa-horizontal animated faa-slow" style="vertical-align: middle;"></i></a>
		</div>
	</div>
</div>

<script>
	var correctNo = 0;
	var totalQuestion = 0;

	window.onresize = function() {
		$('.dropWord').each(function() {
			rePosition($(this), $(this).data('curDrag'));
		});
	}

	window.onload = function() {
		initDroppable();
	}

	function initDroppable() {
		$(".dragWord").draggable({
			create: function(){
				$(this).data('position',$(this).position());
			},
			cursor:'move',
			drag: function(){
				$(this).css('background', 'gold');
			},
			// cursorAt: { left: Math.floor(this.width / 2), top: Math.floor(this.height / 2) },
			// start:function(){$(this).stop(true,true)},
			revert: 'invalid',
			start:function(){
				$(this).stop(true,true);
			},
			stack: ".dragWord"
		});

		$('.dropWord').droppable({
			over: function(event, ui) {
				var dropTarget = $(this);
				dropInitialWidth = dropTarget.css('width');
				if (parseFloat(ui.draggable.css('width')) > parseFloat(dropInitialWidth)) {
					dropTarget.css('width', ui.draggable.css('width'));
				}

				/* change position of draggable element along with drop target */
				$('.dropWord').each(function() {
					if ($(this).data('curDrag') != ui.draggable) {
						rePosition($(this), $(this).data('curDrag'));
					}
				})
			},
			out: function(event, ui) {
				var dropTarget = $(this);
				dropTarget.css('width', dropInitialWidth);

				/* change position of draggable element along with drop target */
				$('.dropWord').each(function() {
					if ($(this).data('curDrag') != ui.draggable) {
						rePosition($(this), $(this).data('curDrag'));
					}
				})
			},
			drop: function(event, ui) {
				/* exhange draggable element if drop target already have one */
				if($(this).data('curDrag')) {
					var lastDrag = $(this).data('curDrag');
					
					if (ui.draggable.data('curDrop')) {
						var lastDrop = ui.draggable.data('curDrop');
						lastDrop.css('width', lastDrag.css('width'));
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

				/* place draggable element at the middle of drop target */
				var dropTarget = $(this);
				dropTarget.css('width', ui.draggable.css('width'));

				ui.draggable.position({
					my: "center",
					at: "center",
					of: dropTarget,
					using: function(pos) {
						$(this).animate(pos, 200, "linear");
						setTimeout(function() {
							ui.draggable.css('background', 'initial');
						}, 200);
					}
				});

				dropTarget.data('curDrag', ui.draggable);
				ui.draggable.data('curDrop', dropTarget);
				checkAnswer();

				$('.dropWord').each(function() {
					rePosition($(this), $(this).data('curDrag'));
				})
			}
		});
	}

	document.getElementById('normal').checked = true;

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
		var order = [];
		sentence = [];

		$('.dropWord').each(function() {
			if ($(this).data('curDrag')) {
				order.push($(this).data('curDrag').attr('id'));
				sentence.push($(this).data('curDrag').html().replace('<span>', '').replace('</span>', ''));
			}
		});

		if (order.length == $('.dragWord').length) {
			var allCorrect = true;
			for (var i = 1; i < order.length; i++) {
				if (parseInt(order[i]) != parseInt(order[i-1]) + 1) {
					allCorrect = false;
				}
			}

			if (allCorrect == true) {
				showScore(true);
				showCorrect(sentence);
			} else {
				showScore(false);
				showWrong();
			}
		}
	}

	function showCorrect(correctSentence) {
		var result = document.createElement("span");
		result.className = 'result';
		result.innerHTML = mergeWord(correctSentence);
		var resultDiv = document.getElementById("result");
		emptyDiv(resultDiv);
		resultDiv.appendChild(result);
		$('#draggable').fadeOut(500);
		$('#droppable').fadeOut(500, function () {
			$('#resultContainer').fadeIn(500);
			$('#nextBtn').fadeIn(500);
			document.getElementById('happy').checked = true;
		});
		$('.score').addClass('resultSpace');
	}

	function showWrong() {
		var resultDiv = document.getElementById("result");
		emptyDiv(resultDiv);
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

	function mergeWord(correctSentence) {
		var result = '';
		var lastIndex = correctSentence.length - 1;

		for (var i = 0; i <= lastIndex; i++) {
			result += correctSentence[i];

			if (i < lastIndex) {
				result += ' ';
			} else {
				result += '.';
			}
		}

		result = toSentenceCase(result);

		return result;
	}

	function toSentenceCase(sentence) {
		var fixedSentence = "";
		var n=sentence.split(".");

		for(i=0;i<n.length;i++) {
			var spaceput = "";
			var spaceCount = n[i].replace(/^(\s*).*$/,"$1").length;

			n[i]=n[i].replace(/^\s+/,"");

			var newstring = n[i].charAt(n[i]).toUpperCase() + n[i].slice(1);

			for(j = 0; j < spaceCount; j++)
				spaceput = spaceput +" ";

			fixedSentence = fixedSentence+spaceput+newstring + '.';
		}

		fixedSentence=fixedSentence.substring(0, fixedSentence.length - 1);

		return fixedSentence;
	}

	function changeSentence(index, isNext) {
		var droppable = document.getElementById('droppable');
		emptyDiv(droppable);
		var draggable = document.getElementById('draggable');
		emptyDiv(draggable);

		shuffleWords(index);
		for (var i = 0; i < elementData[index].length; i++) {
			var newDrop = document.createElement('div');
			newDrop.className = 'dropWord';
			document.getElementById('droppable').appendChild(newDrop);

			var newDrag = document.createElement('div');
			newDrag.className = 'dragWord';
			newDrag.id = elementData[index][i].correctOrder;
			newDrag.innerHTML = '<span>' + elementData[index][i].word + '</span>';
			document.getElementById('draggable').appendChild(newDrag);
		}

		$('#resultContainer').fadeOut(500, function() {
			$('#draggable').fadeIn(500);
			$('#droppable').fadeIn(500);
			document.getElementById('normal').checked = true;
			
			if (isNext) {
				correctNo = 0;
				totalQuestion = 0;
				$('.score').removeClass('resultSpace');
			}
		});

		if ($('#tryAgainBtn').css('display') != 'none') {
			$('#tryAgainBtn').fadeOut(500);
		}

		if ($('#nextBtn').css('display') != 'none') {
			$('#nextBtn').fadeOut(500);
		}

		curQuestion = index;
		initDroppable();
	}

	function shuffleWords(elementDataIndex) {
		var doAgain = true;
		while(doAgain) {
			doAgain = true;

			Shuffle(elementData[elementDataIndex]);

			for (var i = 0; i < elementData[elementDataIndex].length - 1; i++) {
				if (parseInt(elementData[elementDataIndex][i].correctOrder) != parseInt(elementData[elementDataIndex][i+1].correctOrder) - 1) {
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