@extends('activities.layout.activityLayout')

@section('header-more')

<script src="{{ asset('js/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ asset('js/jquery.countdown360.js') }}"></script>

<style>
	#page-content-wrapper {
		padding-top: 3%;
	}
	body {
		background: #75D1F5;
	}
	#btnStart, #btnRestart {
		display: flex;
		align-items: center;
		text-align: center;
		z-index: 1;
	}
	#countdown {
		align-items: center;
		text-align: center;
		z-index: 1;
	}
	#countdown > canvas {
		z-index: 1;
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
		top: 50%;
		left: 50%;
		transform: translate(-50%,-50%);
		z-index: 1;
	}
	#startBtn, #restartBtn {
	    width: 400px;
	    max-width: 40%;
		margin: auto;
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
	#pStart, #pRestart, #imgStart, #imgRestart {
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
		opacity: 0;
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

@stop

@section('actContent')

<div id="background"{{--  style="text-align: center --}}">
	<img id="cloudBottom" style="position: fixed; left: -6%; bottom: -4%; width: 103%" src="{{ asset('img/testAnimate/cloudBottom.svg') }}" alt="" style="bottom: 0">
	<img id="cloudTop" style="position: fixed; left: -3%; bottom: -4%; width: 106%" src="{{ asset('img/testAnimate/cloudTop.svg') }}" alt="" style="bottom: 0">
</div>

<div style="text-align: center; height: 70px; margin-bottom: 2%; display: none;">
	<div id="container" style="display: inline-block;"></div>
</div>

<div id="wordGroup" class="" style="text-align: center; padding-bottom: 20px;">
	@foreach ($textRender as $text)
		<div class="wordSpan" style="display: inline-block;">
			<div class="flexContainer" style="display: flex">
				<p id="{{ $text['id'] }}" class="tbn word" style="position: absolute; color: #30A782; opacity: 1; font-size: 1.5em;">{{ $text['word'] }}</p>
				<div class="btnBg">
					<img class="wordCloud" style="width: 100%; max-width: 150px;" src="{{ asset('img/testAnimate/wordCloud.svg') }}" alt="start button">
				</div>
			</div>
		</div>
	@endforeach
</div>

<div id="controlBtn" style="text-align: center;">
	<div id="btnStart">
		<p id="pStart" style="display: none;"><i class="fa fa-play fa-4x"></i></p>
		<div id="startBtn" class="btnBg">
			<img id="imgStart" style="width: 40%; max-width: 150px;" src="{{ asset('img/testAnimate/flower1.svg') }}" alt="start button">
		</div>
	</div>
	<div id="btnRestart" style="display: none;">
		<p id="pRestart"><i class="fa fa-refresh fa-4x"></i></p>
		<div id="restartBtn" class="btnBg">
			<img id="imgRestart" style="width: 40%; max-width: 150px;" src="{{ asset('img/testAnimate/flower2.svg') }}" alt="restart button">
		</div>
	</div>
	<div id="countdown"></div>
	{{-- <span id="timer" style="font-size: 70px"></span>
	<span id="addedTime" style="font-size: 40px; color: grey"></span> --}}
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
	}

	function wrongChoice(button) {
		$(button).removeClass("notChosen");
		$(button).addClass("p2wrongWord");
	}

	function start() {
		if(tlFinalScore) {
			tlFinalScore.seek(0).pause();
		}

		$('.wordSpan').bind('click', function() {
			chooseWord(this);
		});

		chosenOrder = 0;

		$("#wordGroup").find(".wordSpan").prop("disabled", false);
		$("#wordGroup").find(".wordSpan").removeClass("p2wrongWord").removeClass("p2correctWord").addClass("notChosen");

		initScore();
		playSample(0);
		// startProgress();
		buildCountdown(totalTimeCount);

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
			$('.wordSpan').unbind('click');
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

		var tl = new TimelineMax();
		tl.to('#imgRestart', 30, {rotation:-720, repeat:-1, ease: Power2.easeInOut, yoyo:true});
		var scoreText = $('#scoreText');
		tlFinalScore = new TimelineMax();
		tlFinalScore.to(scoreText, 2, {text:"Final score: "})
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
			checkTickLoad(this.duration);
		} else {
			audioFile.addEventListener('loadedmetadata', function() {
				checkTickLoad(this.duration);
			});
		}
	}

	var totalTimeCount;

	function checkTickLoad(duration) {
		wordNo++;
		wordTime += duration;

		if (wordNo == elementData.length) {
			var tick = document.getElementById('tick');
			if (!isNaN(tick.duration)) {
				totalTimeCount = wordTime + wordNo * tick.duration;
				buildProgressBar(totalTimeCount);
			} else {
				tick.addEventListener('loadedmetadata', function() {
					totalTimeCount = wordTime + wordNo * tick.duration;
					buildProgressBar(totalTimeCount);
				});
			}
		}
	}

	function buildProgressBar(totalTime) {
		docBar = new ProgressBar.Line("#container", {
			strokeWidth: 4,
			duration: totalTime * 1000,
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
	
	function buildCountdown(totalTime) {
		countdown = $("#countdown").countdown360({
			radius      : 80,
			seconds     : Math.round(totalTime),
			fontColor   : '#FFFFFF',
			autostart   : true,
			onComplete  : function (){
				// showResult();
			}
		});
	}

	function showPractice(){
		initDroppable();
		$("#content").attr("style", "transition: 1s;");
		$("#btn-Start").remove();
		countdown.start();
	}
</script>

@stop()