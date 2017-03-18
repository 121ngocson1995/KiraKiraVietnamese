@extends('layouts.app')

@section('content')

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.19.1/TweenMax.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.13.2/plugins/TextPlugin.min.js"></script>
<script src="{{ asset('js/imagesloaded.pkgd.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/animate.css') }}">

<style>
	html, #page-content-wrapper {
		height: 100%;
	}
	body {
		height: calc(100% - 65px);
		background: #75D1F5;
	}
	#result {
		font-weight: 300;
	}
	#scoreText {
		font-size: 2em;
	}
	#correct {
		color: blue;
		font-size: 5em;
	}
	#total {
		color: red;
		font-size: 2em;
	}
	#cloudTop {
		-webkit-animation-duration: 40s;
		-webkit-animation-delay: 1s;
		-webkit-animation-iteration-count: infinite;
		-moz-animation-duration: 40s;
		-moz-animation-delay: 1s;
		-moz-animation-iteration-count: infinite;
	}
	#cloudBottom {
		-webkit-animation-duration: 60s;
		-webkit-animation-delay: 10s;
		-webkit-animation-iteration-count: infinite;
		-moz-animation-duration: 60s;
		-moz-animation-delay: 10s;
		-moz-animation-iteration-count: infinite;
	}
	#pStart, #pRestart, .btnBg {
		cursor: pointer;
	}
	#controlBtn {
		margin-top: 20px;
	}
	#wordGroup {
		max-height: calc(100% - 370px);
		overflow-y: scroll;
		padding-top: 20px;
	}
	.wordSpan {
		cursor: pointer;
	}
	.wordSpan:hover {
		-webkit-filter: drop-shadow( 0px 0px 10px DodgerBlue);
		filter: drop-shadow( 0px 0px 10px DodgerBlue);
	}
	.p2wrongWord {
		-webkit-filter: drop-shadow( 0px 0px 10px red);
		filter: drop-shadow( 0px 0px 10px red);
	}
	.p2correctWord {
		-webkit-filter: drop-shadow( 0px 0px 10px green);
		filter: drop-shadow( 0px 0px 10px green);
	}
	.fa {
		margin-left: 0;
	}
	.fa-play {
		margin-left: 0.15em;
	}
</style>

<div id="background"{{--  style="text-align: center --}}">
	<img id="cloudBottom" style="position: fixed; left: -6%; bottom: -4%; width: 103%" src="{{ asset('img/testAnimate/cloudBottom.svg') }}" alt="" style="bottom: 0">
	<img id="cloudTop" style="position: fixed; left: -3%; bottom: -4%; width: 106%" src="{{ asset('img/testAnimate/cloudTop.svg') }}" alt="" style="bottom: 0">
</div>

<div style="text-align: center; height: 70px">
	<div id="container" style="display: inline-block;"></div>
</div>

<div id="wordGroup" class="" style="text-align: center; padding-bottom: 20px;">
	@foreach ($textRender as $text)
		{{-- <span style="padding: 0px 2px;">
			<button autocomplete="off" id="{{ $text['id'] }}" class="btn playWord notChosen" style="font-size: 18px; padding: 2px 10px" onclick="chooseWord(this)" disabled="">{{ $text['word'] }}</button>
		</span> --}}

		<div class="wordSpan" style="display: inline-block;">
			<p id="{{ $text['id'] }}" class="tbn word" style="position: absolute; color: #30A782; opacity: 0; font-size: 1.5em;">{{ $text['word'] }}</p>
			<div class="btnBg">
				<img class="wordCloud" style="width: 100%; height: 80%; max-width: 150px;" src="{{ asset('img/testAnimate/wordCloud.svg') }}" alt="start button">
			</div>
		</div>
	@endforeach
</div>

<div id="controlBtn" style="text-align: center;">
	<div id="btnStart">
		<p id="pStart" style="position: absolute; color: #33ccff; display: none; z-index: 1"><i class="fa fa-play fa-4x"></i></p>
		<div id="startBtn" class="btnBg">
			<img id="imgStart" style="width: 40%; max-width: 150px;" src="{{ asset('img/testAnimate/flower1.svg') }}" alt="start button">
		</div>
	</div>
	<div id="btnRestart" style="display: none;">
		<p id="pRestart" style="position: absolute; color: #33ccff; z-index: 1"><i class="fa fa-refresh fa-4x"></i></p>
		<div id="restartBtn" class="btnBg">
			<img id="imgRestart" style="width: 40%; max-width: 150px;" src="{{ asset('img/testAnimate/flower2.svg') }}" alt="restart button">
		</div>
	</div>
	<span id="timer" style="font-size: 70px"></span>
	<span id="addedTime" style="font-size: 40px; color: grey"></span>
	<div id="sampleGroup"></div>
	<audio id="tick" src="{{ asset('audio/tick.wav') }}"></audio>
</div>

<div id="result" style="text-align: center; display: none;">
	<span id="scoreText">Score: </span>
	<span id="correct"></span>
	<span id="total"></span>
</div>

<script src="{{ asset('js/progressbar.js') }}"></script>

<script>
	TweenMax.from('#cloudBottom', 1, {scale:1, y:300, delay:1, ease:Elastic.easeOut});
	TweenMax.from('#cloudTop', 1, {scale:1, y:300,  ease:Elastic.easeOut});
	setTimeout(function() {
		$('#cloudTop').addClass('animated shake infinite');
		$('#cloudBottom').addClass('animated shake infinite');
	}, 2000);

	imagesLoaded( document.getElementById('imgStart'), function() {
		$('#pStart').position({
			my: "center",
			at: "center",
			of: $('#startBtn')
		});
		$('#pStart').show();
		var tl = new TimelineMax();
		tl.to('#imgStart', 30, {rotation:360, repeat:-1, ease: Power0.easeNone});
	});

	var countCloud = 0;
	var textRender = <?php echo json_encode($textRender); ?>;

	$('.wordCloud').each(function() {
		var word = $(this).get();
		imagesLoaded( word, function() {
			// console.log('loaded');
			// var img = $(this);
			var p = $(word).parent().parent().find('p')[0];
			$(p).position({
				my: "center",
				at: "center",
				of: $(word)
			});
			// $(p).show();
			$(p).css('opacity', 1);
		});
	});
	TweenMax.staggerFrom('.wordSpan', 0.5, {opacity:0, scale:0, delay:0.5}, 0.2);

	window.onresize = function() {
		$('#pStart').position({
			my: "center",
			at: "center",
			of: $('#startBtn')
		});
		$('#pRestart').position({
			my: "center",
			at: "center",
			of: $('#restartBtn')
		});
	}

	$('#pStart').click(function() {
		start();
	});

	$('#restartBtn').click(function() {
		start();
	});

	$('#pRestart').click(function() {
		start();
	});

	$('#restartBtn').click(function() {
		start();
	});
</script>

<script>
	var docBar;
	var playingSample = -1;

	function chooseWord(button) {
		if ('audio' + $(button).find('p').attr("id") == playingSample) {
			correctChoice(button);
		} else {
			wrongChoice(button);
		}
	}

	function correctChoice(button) {
		$(button).removeClass("notChosen");
		$(button).addClass("p2correctWord");
		$(button).prop("disabled", true);
		$(".p2wrongWord").removeClass("p2wrongWord").addClass("notChosen");
		changeScore('correct', '' + (parseInt(document.getElementById('correct').innerHTML)  + 1));
		$(button).unbind('click');
	}

	function wrongChoice(button) {
		$(button).removeClass("notChosen");
		$(button).addClass("p2wrongWord");
	}

	function start() {
		$('.wordSpan').unbind('click');
		$('.wordSpan').bind('click', function() {
			chooseWord(this);
		});

		chosenOrder = 0;

		$("#wordGroup").find(".wordSpan").prop("disabled", false);
		$("#wordGroup").find(".wordSpan").removeClass("p2wrongWord").removeClass("p2correctWord").addClass("notChosen");

		initScore();
		playSample(0);
		startProgress();

		$("#btnStart").prop("disabled", true);
		$("#btnRestart").prop("disabled", true);
		$("#btnStart").hide();
		$("#btnRestart").hide();
		// startCountdown();
	}

	function initScore() {
		$('#result').show();
		document.getElementById('scoreText').innerHTML = 'Score: ';
		document.getElementById('correct').innerHTML = '0';
		document.getElementById('total').innerHTML = '/0';

		if (docBar) {
			docBar.set(1);
		}
	}

	function changeScore(text, to) {
		var text = $('#'+text);
		var box = text.parent();
		var tl = new TimelineMax();
		tl.to(box, 0.25, {scale:1.4, ease:Power2.easeOut})
		  .set(text, {text:to})
		  .to(box, 0.25, {scale:1, ease:Power2.easeOut});
	}

	function playSample(index) {
		if(index == $("#sampleGroup audio").length) {
			showResult();
			return;
		}
		$(".p2wrongWord").removeClass("p2wrongWord").addClass("notChosen");
		$('#sampleGroup').children().eq(index)[0].play();
		playingSample = $('#sampleGroup').children().eq(index)[0].id;
		changeScore('total', '/' + parseInt(index + 1));
		setTimeout(function() {
			$('#tick')[0].play();
			setTimeout(function() {
				playSample(++index);
			}, $('#tick')[0].duration * 1000);
		}, $('#sampleGroup').children().eq(index)[0].duration * 1000);
	}

	function startProgress() {
		if (docBar) {
			docBar.animate(0);
		}
	}

	function showResult() {
		$(".notChosen").removeClass("notChosen").addClass("p2wrongWord");
		$("#wordGroup").find("button").prop("disabled", true);
		$("#btnRestart").prop("disabled", false);
		$("#btnRestart").show();

		$('#pRestart').position({
			my: "center",
			at: "center",
			of: $('#restartBtn')
		});
		var tl = new TimelineMax();
		tl.to('#imgRestart', 30, {rotation:-360, repeat:-1, ease: Power0.easeNone});
		var scoreText = $('#scoreText');
		var tl = new TimelineMax();
		tl.to(scoreText, 2, {text:"Final score: "})
		  .to(scoreText.parent(), 2, {scale:1.6, ease:Power2.easeOut})
		  .to(scoreText.parent(), 0.4, {scale:1.4, ease:Power2.easeOut});
	}

	var wordTime = 0;
	var wordNo = 0;

	var elementData = <?php echo json_encode($elementData); ?>;
	var sampleGroup = document.getElementById('sampleGroup');
	for (var i = 0; i < elementData.length; i++) {
		var audioFile = document.createElement("audio");
		// audioFile.src = elementData[i].audio;
		audioFile.id = 'audio' + elementData[i].id;
		audioFile.innerHTML  = "<source src='" + elementData[i].audio + "' type='audio/mp3'>";
		sampleGroup.appendChild(audioFile);


		if (!isNaN(audioFile.duration)) {
			buildProgressBar(this.duration);
		} else {
			audioFile.addEventListener('loadedmetadata', function() {
				buildProgressBar(this.duration);
			});
		}
	}

	function checkTickLoad(argument) {
		wordNo++;
		wordTime += duration;

		if (wordNo == elementData.length) {
			var tick = document.getElementById('tick');
			if (!isNaN(tick.duration)) {
				buildProgressBar(wordTime + wordNo * tick.duration);
			} else {
				tick.addEventListener('loadedmetadata', function() {
					buildProgressBar(wordTime + wordNo * this.duration);
				}
			}
		}
	}

	function buildProgressBar(duration) {
		console.log('wordTime=' + wordTime + ' wordNo=' + wordNo + ' totalTime=' + totalTime);
		docBar = new ProgressBar.Line("#container", {
			strokeWidth: 4,
			duration: duration * 1000,
			color: '#FFEA82',
			trailColor: '#eee',
			trailWidth: 1,
			svgStyle: {width: '100%', height: '100%'},
			from: {color: '#ED6A5A'},
			to: {color: '#1affa3'},
			step: (state, bar) => {
				bar.path.setAttribute('stroke', state.color);
			}
		});
		docBar.set(1);
	}
	
</script>

@stop()