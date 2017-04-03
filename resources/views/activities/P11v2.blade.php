@extends('activities.layout.activityLayout')

@section('header-more')
<link rel="stylesheet" href="{{ asset('css/hover.css') }}">
<link rel="stylesheet" href="{{ asset('css/smiley.css') }}">
<link rel="stylesheet" href="{{ asset('css/font-awesome-animation.min.css') }}">
<style>
	body {
		margin: 0;
		background: -moz-linear-gradient(top, rgb(152,168,192) 0%, rgb(206,192,140) 25%, rgb(206,193,36) 74%, rgb(214,203,145) 100%);
		background: -webkit-linear-gradient(top, rgb(152,168,192) 0%,rgb(206,192,140) 25%,rgb(206,193,36) 74%,rgb(214,203,145) 100%);
		background: linear-gradient(to bottom, rgb(152,168,192) 0%,rgb(206,192,140) 25%,rgb(206,193,36) 74%,rgb(214,203,145) 100%);
		background-repeat: no-repeat;
	    background-attachment: fixed;
	}
	.fullscreenDiv {
		width: 100%;
		height: auto;
		bottom: 0px;
		top: 65px;
		left: 0;
		position: absolute;
		text-align: center;
	}
	.dragSentence {
		/*display: inline-block;*/
		border-radius: 4px;
		border: 1px solid transparent;
		color: firebrick;
		min-height:45px;
		width: 80%;
		max-width: 400px;
		white-space: normal;
		padding: 2px 10px;
		margin: 10px 10px;
		text-align: center;
		background: #e6e6e6;
		font-size: 1.5em;
		transition: background 0.6s;
		opacity: 0;
	}
	.dragSentence:hover {
		cursor: move;
	}
	.dragSentence:active {
		background: gold;
	}
	.dragSentence span {
		vertical-align: middle;
	}
	.dropSentence {
		/*display: inline-block;*/
		width: 80%;
		max-width: 400px;
		height: 45px;
		font-size: 30px;
		text-align: center;
		border-radius: 4px;
		background: rgba(0, 153, 255, .8);
		margin: 10px 10px;
		opacity: 0;
	}
	.dropSentence span {
		position: relative;
		float: left;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		/*padding: 0 20px;*/
	}
	#btnHelp {
		display: flex;
		align-items: center;
		text-align: center;
		z-index: 1;
	}
	#helpBtn {
		opacity: 0;
		margin: auto;
	}
	#angel {
		position: absolute;
		left: 50%;
		height: 120px;
		    transform: translate(30%, -140%);
	}
	#angel img {
		height: 100%;
	}
	#helpBtn, #angel {
		cursor: pointer;
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
		/*position: fixed;
		top:50%;
		left: 50%;
		transform: translate(-50%, -50%);*/
		text-align: center;
		display: none;
		padding-top: 10%;
	}
	.tryAgain {
		padding-top: 0.3em;
		padding-bottom: 0.3em;
		padding-left: 0.8em;
		padding-right: 0.8em;
		margin: 0.2em;
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
	.sunRotate {
		-webkit-animation-name: sunRotate;
		animation-name: sunRotate;
		-webkit-animation-duration: 300s;
		animation-duration: 300s;
		-webkit-animation-iteration-count: infinite;
		animation-iteration-count: infinite;
		-webkit-animation-timing-function: linear; /* Safari 4.0 - 8.0 */
		animation-timing-function: linear;
	}
	@-webkit-keyframes sunRotate {
		100% {
			-webkit-transform: rotate(360deg);
			transform: rotate(360deg);
		}
	}
	@keyframes sunRotate {
		100% {
			-webkit-transform: rotate(360deg);
			transform: rotate(360deg);
		}
	}
	.row.dragdrop {
		position: relative;
	}
	@media screen and (min-width: 768px) and (min-height: 666px) {
		.row.dragdrop {
			top: calc(100% - 600px);
		}
	}
	@media screen and (min-width: 768px) and (min-height: 700px) {
		.row.dragdrop {
			top: 85px;
		}
	}
	#tryAgainBtn2Holder {
		position: absolute;
		top: 50%;
		right: 10%;
	}
	#tryAgainBtn2 {
		transform: translateY(-50%);
	}
	.dragGroup {
		text-align: right;
		text-align: -webkit-right;
	}
	.dropGroup {
		text-align: left;
		text-align: -webkit-left;
	}
	@media screen and (max-width: 767px) {
		.dragSentence, .dropSentence {
			width: 90%;
		}
		.dragGroup, .dropGroup {
			text-align: center;
			text-align: -webkit-center;
		}
	}
</style>

@stop

@section('actContent')

<script>
	var elementData = <?php echo json_encode($elementData); ?>;
</script>

<div id="background">
	<div id="sunPositionHolder" style="position: fixed; width: 80%; bottom: -64%; left: 50%; transform: translateX(-40%); z-index: -1">
		<div id="sunMoveHolder" style="opacity: 0;">
			<img id="sun" class="sunRotate" style="width: 100%;" src="{{ asset('img/P11/bg-sun.svg') }}" alt="">
		</div>
	</div>
	{{-- <img id="cloud" style="position: fixed; width: 130%; left: -15%; bottom: 5%; z-index: -1" src="{{ asset('img/P11/bg-cloud.svg') }}" alt=""> --}}
	<img id="land" style="position: fixed; width: 101%; bottom: 0; z-index: -1" src="{{ asset('img/P11/bg-land.svg') }}" alt="">
</div>

<div class='fullscreenDiv'>
	<div id="element">
		<div class="row dragdrop">
			<div class="col-sm-6 dragGroup" style="z-index: 20;">
				<div id="draggable">
					@foreach ($elementData as $elementValue)
					<div id="{{ $elementValue->correctOrder }}" class="dragSentence"><span>{{ $elementValue->sentence }}</span></div>
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

	function help() {
		$('#helpBtn').fadeOut(500);

		var revert = false;

		/* revert all dragSentence objects to their original positions */
		$('.dropSentence').each(function() {
			if ($(this).data('curDrag')) {
				var lastDrag = $(this).data('curDrag');

				lastDrag.css('transition', '1s');
				lastDrag.css('top', 0);
				lastDrag.css('left', 0);
				lastDrag.removeData('curDrop');
				$(this).removeData('curDrag');

				setTimeout(function() {
					lastDrag.css('transition', '');
				}, 1000);

				revert = true;
			}
		});

		/* Move all dragSentence objects to their correct positions */

		var correctAnswer = <?php echo json_encode($correctAnswer); ?>;
		var timeout = revert ? 1500 : 0;

		setTimeout(function() {
			reposition(0, 700);
		}, timeout);

		function reposition(i, timeout) {
			loopDrag:
			for (var j = 0; j < $('.dragSentence').length; j++) {
				if($($('.dragSentence')[j]).find('span').html() == correctAnswer[i] && !$($('.dragSentence')[j]).hasClass('ordered')) {
					
					var dragSentence = $('.dragSentence')[j];

					$(dragSentence).position({
						my: "center",
						at: "center",
						of: $('.dropSentence')[i],
						using: function(pos) {
							$(this).animate(pos, timeout, "swing");
						}
					});
					$($('.dropSentence')[i]).css('height', $(dragSentence).css('height'));

					$(dragSentence).addClass('ordered');
					break loopDrag;
				}
			}

			if (i < correctAnswer.length) {
				setTimeout(function() {
					reposition(++i, 500);
				}, timeout);
			} else {
				setTimeout(function() {
					$('#tryAgainBtn2Holder').show();
					$('#tryAgainBtn2Holder').addClass('animated rotateIn').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
						$(this).removeClass('animated rotateIn');
					});
				}, 500);
				return;
			}
		}

		totalQuestion++;
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
		
			$('#helpBtn').fadeOut(500);

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
			$('.fullscreenDiv').css('top', 'initial');
			$('.fullscreenDiv').css('bottom', 'initial');

			$('#resultContainer').fadeIn(500);
			$('#nextBtn').fadeIn(500);
			document.getElementById('happy').checked = true;
		});
	}

	function showWrong() {
		$('#draggable').fadeOut(500);
		$('#droppable').fadeOut(500, function () {
			$('.fullscreenDiv').css('top', 'initial');
			$('.fullscreenDiv').css('bottom', 'initial');

			$('#resultContainer').fadeIn(500);
			$('#tryAgainBtn').fadeIn(500);
			document.getElementById('normal').checked = true;
		});
	}

	function showScore(isCorrect) {
		$('#correct').html(isCorrect ? ++correctNo : correctNo);
		$('#total').html('/' + ++totalQuestion + (totalQuestion == 1 ? ' try' : ' tries'));
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
			console.log($('#tryAgainBtn2Holder:visible'));
			if ($('#tryAgainBtn2Holder').is(':visible')) {
				$('#tryAgainBtn2Holder').addClass('animated rotateOut').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
					$(this).removeClass('animated rotateOut').hide();
					showQuestion();
				});
			} else {
				showQuestion();
			}
		});

		if ($('#tryAgainBtn').css('display') != 'none') {
			$('#tryAgainBtn').fadeOut(500);
		}

		if ($('#nextBtn').css('display') != 'none') {
			$('#nextBtn').fadeOut(500);
		}

		initDroppable();

		function showQuestion() {
			$('.fullscreenDiv').css('top', '65px');
			$('.fullscreenDiv').css('bottom', 0);

			$('#draggable').show();
			$('#droppable').show();
			TweenMax.staggerFromTo('.dragSentence', 0.5, {x:-150, y:50, opacity:0}, {x:0, y:0, opacity:1, clearProps:"transform"}, 0.2);
			TweenMax.staggerFromTo('.dropSentence', 0.5, {x:150, y:50, opacity:0}, {x:0, y:0, opacity:1, clearProps:"transform"}, 0.2);
			TweenLite.set('#helpBtn', {display: '', opacity: 1, className:'+=animated zoomIn', delay: 1.5});
			document.getElementById('normal').checked = true;
		}
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

@section('actDescription-vi')
	Sắp xếp lại trình tự bài hội thoại bằng cách tích chuột vào câu và bỏ sang các ô trống phía bên phải.
@stop

@section('actDescription-en')
	To reorder the dialogue, click on the sentence and then move to the appropriate box on the right.
@stop