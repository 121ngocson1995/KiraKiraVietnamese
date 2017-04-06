@extends('activities.layout.activityLayout')

@section('header-more')
<script src="{{ asset('js/imagesloaded.pkgd.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/smiley-small.css') }}">

<style type="text/css">
	#page-content-wrapper {
		padding-top: 2%;
	}
	body {
		background-color: #ccffff;
	}
	div.div-body {
		position: fixed;
		width: 100%;
		height: 100%;
		background: url({{ asset('img/P4/bg-grass.svg') }}) repeat-x center bottom fixed;
		background-size: 300% auto;
		-webkit-animation: backgroundScroll 700s linear infinite;
		animation: backgroundScroll 700s linear infinite;
	}

	@-webkit-keyframes backgroundScroll {
		from {background-position: 0 100%;}
		to {background-position: 200% 100%;}
	}
	@keyframes backgroundScroll {
		from {background-position: 0 100%;}
		to {background-position: 200% 100%;}
	}
	#btnStart, #btnRestart {
		display: flex;
		align-items: center;
		text-align: center;
		z-index: 1;
		width: 106px;
	}
	#btnStart p, #btnRestart p {
		position: absolute;
		color: #33ccff;
		left: 50%;
		transform: translateX(-50%);
		z-index: 1;
	}
	.flexContainer p {
		position: absolute;
		width: 100%;
		color: #33ccff;
		top: 65%;
		left: 50%;
		transform: translate(-50%,-50%);
		z-index: 1;
	}
	#startBtn, #restartBtn {
		width: 100%;
		margin: auto;
	}
	#progressbarContainer {
		margin: 20px;
		width: calc(100% - 200px);
		height: 8px;
	}
	#resultContainer {
		font-weight: 300;
		padding-right: 2em;
	}
	#scoreText {
		font-size: 2em;
	}
	#correct {
		color: blue;
		font-size: 4em;
		font-weight: 500;
	}
	#total {
		color: red;
		font-size: 2em;
		font-weight: 500;
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
	#pStart, #pRestart, #imgStart, #imgRestart {
		cursor: pointer;
	}
	#controlBtn {
		margin-top: 20px;
	}
	#wordGroup {
		/*max-height: calc(100% - 250px);
		overflow-y: scroll;*/
		padding: 0 1.5em;
	}
	.wordSpan {
		opacity: 0;
		cursor: pointer;
		padding: 10px 20px;
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

@stop

@section('actContent')

<div class="div-body"></div>

<div class="row" style="text-align: center; margin-bottom: 20px;">
	<div id="resultContainer" class="col-md-3" style="text-align: right; padding-right: 2em; display: inline-block;">
		<div id="resultInner" style="display: inline-block; right: 0;">
			<div id="resultHolder">
				<span id="correct"></span>
				<span id="total"></span>
			</div>
		</div>
	</div>
	<div id="smileyContainer" class="col-md-3 col-md-push-6 happy" style="text-align: left; padding-left: 2em; display: inline-block;">
		<div id="smiley" class="smiley" style="display: none;">
			<div class="eyes">
				<div class="eye"></div>
				<div class="eye"></div>
			</div>
			<div class="mouth"></div>
		</div>
	</div>
	<div class="col-md-6 col-md-pull-3">
		<div id="controlContainer" style="display: inline-block; position: relative;">
			<div id="btnStart">
				<p id="pStart" style="display: none;"><i class="fa fa-play fa-3x"></i></p>
				<div id="startBtn" class="btnBg">
					<img id="imgStart" style="width: 100%" src="{{ asset('img/testAnimate/flower1.svg') }}" alt="start button">
				</div>
			</div>
			<div id="btnRestart" style="display: none;">
				<p id="pRestart"><i class="fa fa-refresh fa-3x"></i></p>
				<div id="restartBtn" class="btnBg">
					<img id="imgRestart" style="width: 100%" src="{{ asset('img/testAnimate/flower2.svg') }}" alt="restart button">
				</div>
			</div>
		</div>
		<div id="progressbarContainer" style="display: inline-block;"></div>
	</div>
	<div class="col-md-3">
		
	</div>
</div>

<div id="wordGroup" class="" style="text-align: center;">
	@php
		$sentencesInRow = 0;
	@endphp

	<div class="row">
		@foreach ($textRender as $text)
		@if ($sentencesInRow++ == 3)
			</div>
			<div class="row">
			@php
				$sentencesInRow = 1;
			@endphp
		@endif
		<div class="wordSpan col-sm-4" style="display: inline-block;">
			<div class="flexContainer">
				<p id="{{ $text['id'] }}" class="tbn word writtenFont" style="position: absolute; color: #30A782; opacity: 1; font-size: 1.5em;">{{ $text['sentence'] }}</p>
				<div class="btnBg">
					<img class="wordCloud" src="{{ asset('img/P4/cloud1.svg') }}" alt="start button">
				</div>
			</div>
		</div>
		@endforeach
	</div>
</div>

<div id="controlBtn" style="text-align: center;">
	<div id="sampleGroup"></div>
	<audio id="tick" src="{{ asset('audio/tick-sentence.mp3') }}"></audio>
</div>

<div>
	<audio id="correct_sound" src="{{ asset('audio/correct_sound.mp3') }}"></audio>
	<audio id="wrong_sound" src="{{ asset('audio/wrong_sound.wav') }}"></audio>
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
		$('#pStart').show();
		var tl = new TimelineMax();
		tl.to('#imgStart', 30, {rotation:360, repeat:-1, ease: Power0.easeNone});
	});

	var countCloud = 0;
	var textRender = <?php echo json_encode($textRender); ?>;

	TweenMax.staggerFrom('.wordSpan', 0.5, {scale:0, delay:0.5}, 0.2);
	TweenMax.staggerTo('.wordSpan', 0.5, {opacity:1,delay:0.5}, 0.2);

	$('#pStart').click(function() {
		start();
	});

	$('#imgStart').click(function() {
		start();
	});

	$('#pRestart').click(function() {
		start();
	});

	$('#imgRestart').click(function() {
		start();
	});
</script>

<script>
	var docBar;
	var playingSample = -1;
	var tlFinalScore;

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
		happyFace();
		correctSFX();
	}

	function wrongChoice(button) {
		$(button).removeClass("notChosen");
		$(button).addClass("p2wrongWord");
		sadFace();
		wrongSFX();
	}

	function happyFace() {
		var smiley = document.getElementById('smiley');
		smiley.classList.remove("happy");
		smiley.classList.remove("normal");
		smiley.offsetWidth;
		smiley.classList.add("happy");
	}

	function sadFace() {
		var smiley = document.getElementById('smiley');
		smiley.classList.remove("happy");
		smiley.classList.remove("normal");
		smiley.offsetWidth;
		smiley.classList.add("normal");
	}

	function start() {
		if (playTimeout) {
			clearTimeout(playTimeout);
		}

		console.log(playTimeout);

		$('audio').each(function() {
			this.pause();
			this.currentTime = 0;
		})

		if(tlFinalScore) {
			tlFinalScore.seek(0).pause();
		}

		if (!$('#resultHolder').is(':visible')) {
			$('#resultHolder').fadeIn(500);
		}

		if (!$('#smiley').is(':visible')) {
			$('#smiley').fadeIn(500);
		}

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

		$("#btnStart").fadeOut(500, function() {
			var tl = new TimelineMax();
			tl.to('#imgRestart', 30, {rotation:-720, repeat:-1, ease: Power1.easeInOut, yoyo:true});
			$("#btnRestart").fadeIn(500);
		});
	}

	function initScore() {
		$('#resultContainer').show();
		// document.getElementById('scoreText').innerHTML = 'Score: ';
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

	var playTimeout;

	function playSample(index) {
		if(index == $("#sampleGroup audio").length) {
			$('.wordSpan').unbind('click');
			showResult();
			return;
		}
		$(".p2wrongWord").removeClass("p2wrongWord").addClass("notChosen");
		$('#sampleGroup').children().eq(index)[0].play();
		playingSample = $('#sampleGroup').children().eq(index)[0].id;
		changeScore('total', '/' + parseInt(index + 1));
		playTimeout = setTimeout(function() {
			$('#tick')[0].play();
			playTimeout = setTimeout(function() {
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

		var tl = new TimelineMax();
		tl.to('#resultInner', 0.25, {scale:1.4, ease:Power2.easeOut})
		.to('#resultInner', 0.25, {scale:1, ease:Power2.easeOut});
	}

	var wordTime = 0;
	var wordNo = 0;

	var elementData = <?php echo json_encode($elementData); ?>;
	var sampleGroup = document.getElementById('sampleGroup');
	for (var i = 0; i < elementData.length; i++) {
		var audioFile = document.createElement("audio");
		// audioFile.src = elementData[i].audio;
		audioFile.id = 'audio' + elementData[i].id;
		audioFile.innerHTML  = "<source src='{{ asset('') }}" + elementData[i].audio + "' type='audio/mp3'>";
		sampleGroup.appendChild(audioFile);


		if (!isNaN(audioFile.duration)) {
			checkTickLoad(this.duration);
		} else {
			audioFile.addEventListener('loadedmetadata', function() {
				checkTickLoad(this.duration);
			});
		}
	}

	function checkTickLoad(duration) {
		wordNo++;
		wordTime += duration;

		if (wordNo == elementData.length) {
			var tick = document.getElementById('tick');
			if (!isNaN(tick.duration)) {
				buildProgressBar(wordTime + wordNo * tick.duration);
			} else {
				tick.addEventListener('loadedmetadata', function() {
					buildProgressBar(wordTime + wordNo * this.duration);
				});
			}
		}
	}

	function buildProgressBar(totalTime) {
		docBar = new ProgressBar.Line("#progressbarContainer", {
			strokeWidth: 1,
			duration: totalTime * 1000,
			color: '#FFEA82',
			trailColor: '#eee',
			trailWidth: 1,
			svgStyle: {width: '100%', height: '200%'},
			from: {color: '#ED6A5A'},
			to: {color: '#1affa3'},
			step: (state, bar) => {
				bar.path.setAttribute('stroke', state.color);
			}
		});
		docBar.set(1);
	}
	
</script>

@stop

@section('actDescription-vi')
Tích chuột vào START để bắt đầu nghe. Máy sẽ đọc mỗi câu 2 lần. Nghe và tích chuột vào câu tương ứng.
@stop

@section('actDescription-en')
Click START to begin. The computer will read each sentence twice. Listen and click on appropriate sentence.
@stop