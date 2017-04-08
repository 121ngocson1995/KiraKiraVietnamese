@extends('activities.layout.activityLayout')

@section('header-more')
<script src="{{ asset('js/imagesloaded.pkgd.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/smiley-small.css') }}">
<link rel="stylesheet" href="{{ asset('css/screens/p4.css') }}">

<style type="text/css">
	div.div-body {
		background: url({{ asset('img/P4/bg-grass.svg') }}) repeat-x center bottom fixed;
		background-size: 300% auto;
		-webkit-animation: backgroundScroll 700s linear infinite;
		animation: backgroundScroll 700s linear infinite;
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
	<div class="row">
		@foreach ($textRender as $text)
		<div class="wordSpan col-sm-6 col-md-4" style="display: inline-block;">
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

	var wordTime = 0;
	var wordNo = 0;

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

	var elementData = <?php echo json_encode($elementData); ?>;
	var sampleGroup = document.getElementById('sampleGroup');
	for (var i = 0; i < elementData.length; i++) {
		var audioFile = document.createElement("audio");
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
	
</script>

<script src="{{ asset('js/screens/p4.js') }}"></script>

@stop

@section('actDescription-vi')
Tích chuột vào START để bắt đầu nghe. Máy sẽ đọc mỗi câu 2 lần. Nghe và tích chuột vào câu tương ứng.
@stop

@section('actDescription-en')
Click START to begin. The computer will read each sentence twice. Listen and click on appropriate sentence.
@stop