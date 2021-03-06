@extends('activities.layout.activityLayout')

@section('header-more')

<style>
	body {
		background: url({{ asset('img/testAnimate/bg.svg') }}) no-repeat center bottom fixed;
		background-size: cover;
	}
	.replay {
		position: fixed;
		bottom: -30px;
		right: 80px;
		overflow: hidden;
	}
	.play {
		position: fixed;
		bottom: -30px;
		right: 510px;
		overflow: hidden;
	}
	.record {
		position: fixed;
		bottom: -70px;
		right: 280px;
		overflow: hidden;
	}
	@media screen and (max-width: 768px) {
		.replay {
			width: 35% !important;
			right: 30px !important;
		}
		.play {
			width: 35% !important;
			left: 30px !important;
		}
		.record {
			width: 35% !important;
			left: 30% !important;
		}
		.replay img {
			width: 100% !important;
			max-width: 262px !important;
		}
		.play img {
			width: 100% !important;
			max-width: 240px !important;
		}
		.record img {
			width: 100% !important;
			max-width: 289px !important;
		}
	}
	@media screen and (max-height: 400px) {
		.replay {
			top: 230px !important;
			overflow: visible;
		}
		.play {
			top: 220px !important;
			overflow: visible;
		}
		.record {
			top: 290px !important;
			overflow: visible;
		}
	}
	.replay svg, .play svg, .record svg, .replay img, .play img, .record img {
		cursor: pointer;
	}
	.replay svg:hover, .play svg:hover, .record svg:hover, .replay img:hover, .play img:hover, .record img:hover {
		-webkit-filter: drop-shadow( 0px 0px 10px blue );
        filter: drop-shadow( 0px 0px 10px blue );
	}
	div.red svg, div.red img {
		-webkit-filter: drop-shadow( 0px 0px 10px red ) !important;
		filter: drop-shadow( 0px 0px 10px red ) !important;
	}
	div.blue svg, div.blue img {
		-webkit-filter: drop-shadow( 0px 0px 10px blue );
		filter: drop-shadow( 0px 0px 10px blue );
	}
	.wordWrap {
		/*width: 90px;*/
		height: 40px;
		/*line-height: 40px;*/
		display: inline-block;
		margin: 5px;
		text-align: center;
		{{-- background: url({{ asset('img/testAnimate/board.svg') }}); --}}
		cursor: pointer;
	}
	.word {
		display: inline-block;
		vertical-align: middle;
		line-height: normal;
		font-weight: 600;
		font-family: Cambria;
		font-size: 1.3em;
		color: white;
		cursor: pointer;
	}
	.flexContainer p {
		position: absolute;
		width: 100%;
		top: 50%;
		left: 50%;
		transform: translate(-50%,-50%);
		z-index: 1;
	}
	#alert {
		display: none;
		position: fixed;
		text-align: center;
		padding: 10px;
		font-size: 1.4em;
		background: rgba(140, 140, 140, 0.9);
		color: white;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
	}

</style>

@stop

@section('actContent')

<div class="play">
	<img class="fillable" src="{{ asset('img/testAnimate/play.png') }}" id="playSample">
</div>
<div class="replay">
	<img class="fillable" src="{{ asset('img/testAnimate/replay.png') }}" id="playSample">
</div>
<div class="record">
	<img class="fillable" src="{{ asset('img/testAnimate/record.png') }}" id="record">
</div>

<div>
	<audio id="sample"></audio>
	<audio id="auRecord"></audio>
</div>

<div class="col-md-6" style="margin-top: 30px">
	@php
		$currentlineNumber = $firstLineNumber;
	@endphp

	<div class="wordLine" style="text-align: center; width: 100%">

		@foreach ($elementData as $elementValue)
			@if ($elementValue->lineNumber > $currentlineNumber)
				@php
					$currentlineNumber = $elementValue->lineNumber;
				@endphp

				</div><div class="wordLine" style="text-align: center; width: 100%">
			@endif

			<div class="wordWrap" id="{{ $elementValue->audio }}" style="display: inline-block; height: 60px;">
				<div class="flexContainer" style="display: flex; height: 100%;">
					<p class="tbn word" style="position: absolute;">{{ $elementValue->word }}</p>
					<div class="btnBg" style="height: 100%;">
						<img class="wordCloud" style="height: 100%; " src="{{ asset('img/testAnimate/newboard' . count(explode(' ', $elementValue->word)) . '.svg') }}" alt="start button">
					</div>
				</div>
			</div>
		@endforeach

	</div>

</div>

<div id="alert">
	To record your voice, first click on the record sign at the middle.
</div>

<script>
	$('.play').click(function() {
		playSample(this);
	});

	$('.replay').click(function() {
		playRecord();
	});

	$('.record').click(function() {
		startRecording(this);
	});

	$('.wordWrap').click(function() {
		playWord(this);
	});
</script>

<script>
	// TweenMax.from('.replay', 2, {opacity:0, scale:0, y:-500, ease:Elastic.easeOut}, 2);
	TweenMax.from('.play', 1, {scale:0.5, y:300, delay:1, ease:Elastic.easeOut});
	TweenMax.from('.replay', 1, {scale:0.5, y:300, delay:1.3, ease:Elastic.easeOut});
	TweenMax.from('.record', 1, {scale:0.5, y:300, delay:1.6, ease:Elastic.easeOut});
	TweenMax.staggerFrom('.wordWrap', 0.5, {opacity:0, y:100, rotation:120, scale:2, delay:0.5}, 0.2);
</script>

<script>
	var audio_context;
	var recorder;
	var tl;

	var busyPlay, busyReplay, busyRecord, 
		enabledPlay, enabledReplay, enabledRecord, 
		disabledPlay, disabledReplay, disabledRecord;
	function preloadImage() {
		busyPlay = new Image();
		busyPlay.src = '{{ asset('img/testAnimate/play-blu.png') }}';
		busyReplay = new Image();
		busyReplay.src = '{{ asset('img/testAnimate/replay-blu.png') }}';
		busyRecord = new Image();
		busyRecord.src = '{{ asset('img/testAnimate/record-blu.png') }}';
		enabledPlay = new Image();
		enabledPlay.src = '{{ asset('img/testAnimate/play.png') }}';
		enabledReplay = new Image();
		enabledReplay.src = '{{ asset('img/testAnimate/replay.png') }}';
		enabledRecord = new Image();
		enabledRecord.src = '{{ asset('img/testAnimate/record.png') }}';
		disabledPlay = new Image();
		disabledPlay.src = '{{ asset('img/testAnimate/play-red.png') }}';
		disabledReplay = new Image();
		disabledReplay.src = '{{ asset('img/testAnimate/replay-red.png') }}';
		disabledRecord = new Image();
		disabledRecord.src = '{{ asset('img/testAnimate/record-red.png') }}';
	}

	function playWord(button) {
		var audio = document.getElementById("sample");

		audio.src = button.id;
		audio.play();

		var duration = 1;
		if(tl) {
			tl.seek(0).pause();
		}
		tl = new TimelineMax({
			onComplete:complete,
			onCompleteParams:['{self}']});
		TweenMax.to(button, duration / 4, {y:-20, ease:Power2.easeOut});
		TweenMax.to(button, duration / 2, {y:0, ease:Bounce.easeOut, delay:duration / 4});
		setTimeout(function() {
			tl.to(button, duration / 4, {y:-20, ease:Power2.easeOut}, 1).to(button, duration / 2, {y:0, ease:Bounce.easeOut});
		}, 1040);

		function complete(tl) {
			tl.restart();
		}

		function doNothing() {}

		document.getElementById("sample").addEventListener('loadedmetadata', function toEnableBtn() {
			setTimeout(function() {
				document.getElementById("sample").removeEventListener('loadedmetadata', toEnableBtn);

				enableControl('play');
				enableControl('replay');
				enableControl('record');
			}, $('#sample')[0].duration*1000);
		});

		disableControl('play');
		disableControl('replay');
		disableControl('record');
	}

	function playSample(button) {
		var firstWord = !$('#sample').attr('src');

		if ( firstWord ) {
			var audio = document.getElementById("sample");
			audio.src = document.getElementsByClassName('wordWrap')[0].id;

			var duration = 1;
			var button = document.getElementsByClassName('wordWrap')[0];
			if(tl) {
				tl.seek(0).pause();
			}
			tl = new TimelineMax({
				onComplete:complete,
				onCompleteParams:['{self}']});
			TweenMax.to(button, duration / 4, {y:-20, ease:Power2.easeOut});
			TweenMax.to(button, duration / 2, {y:0, ease:Bounce.easeOut, delay:duration / 4});
			setTimeout(function() {
				tl.to(button, duration / 4, {y:-20, ease:Power2.easeOut}, 1).to(button, duration / 2, {y:0, ease:Bounce.easeOut});
			}, 1040);

			function complete(tl) {
				tl.restart();
			}

			function doNothing() {}
		}

		$('#sample')[0].pause();
		$('#sample')[0].currentTime = 0;
		$('#sample')[0].play();

		$('.play').addClass('red');

		if (firstWord) {
			document.getElementById("sample").addEventListener('loadedmetadata', function toEnableBtn() {
				setTimeout(function() {
					document.getElementById("sample").removeEventListener('loadedmetadata', toEnableBtn);
					$('.play').removeClass('red');

					enableControl('play');
					enableControl('replay');
					enableControl('record');
				}, $('#sample')[0].duration*1000);
			});
		} else {
			setTimeout(function() {
				$('.play').removeClass('red');

				enableControl('play');
				enableControl('replay');
				enableControl('record');
			}, $('#sample')[0].duration*1000);
		}

		busyControl('play');
		disableControl('replay');
		disableControl('record');
	}

	function playRecord() {
		if ( $('#auRecord').attr('src') ) {
			$('#auRecord')[0].pause();
			$('#auRecord')[0].currentTime = 0;
			$('#auRecord')[0].play();

			$('.replay').addClass('red');
			setTimeout(function() {
				$('.replay').removeClass('red');

				enableControl('play');
				enableControl('replay');
				enableControl('record');
			}, $('#auRecord')[0].duration*1000);

			busyControl('replay');
			disableControl('play');
			disableControl('record');
		} else {
			$('#alert').fadeIn(600);

			setTimeout(function() {
				$('.record').addClass('animated flash').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
					$('.record').removeClass('animated flash');
					$('#alert').fadeOut(600);
				});
			}, 500);
		}
	}

	function disableControl(control) {
		controlHolder = document.getElementsByClassName(control)[0];
		while (controlHolder.firstChild) {
			controlHolder.removeChild(controlHolder.firstChild);
		}

		if (control == 'play') {
			controlHolder.appendChild(disabledPlay);
			$('.play').unbind('click');
		} else if (control == 'replay') {
			controlHolder.appendChild(disabledReplay);
			$('.replay').unbind('click');
		} else if (control == 'record') {
			controlHolder.appendChild(disabledRecord);
			$('.record').unbind('click');
		}
	}

	function enableControl(control) {
		controlHolder = document.getElementsByClassName(control)[0];
		while (controlHolder.firstChild) {
			controlHolder.removeChild(controlHolder.firstChild);
		}

		if (control == 'play') {
			controlHolder.appendChild(enabledPlay);
			$('.play').click(function() {
				playSample(this);
			});
		} else if (control == 'replay') {
			controlHolder.appendChild(enabledReplay);
			$('.replay').click(function() {
				playRecord();
			});
		} else if (control == 'record') {
			controlHolder.appendChild(enabledRecord);
			$('.record').click(function() {
				startRecording(this);
			});
		}
	}

	function busyControl(control) {
		controlHolder = document.getElementsByClassName(control)[0];
		while (controlHolder.firstChild) {
			controlHolder.removeChild(controlHolder.firstChild);
		}

		if (control == 'play') {
			controlHolder.appendChild(busyPlay);
			$('.play').unbind('click');
		} else if (control == 'replay') {
			controlHolder.appendChild(busyReplay);
			$('.replay').unbind('click');
		} else if (control == 'record') {
			controlHolder.appendChild(busyRecord);
			$('.record').unbind('click');
		}
	}

	function startUserMedia(stream) {
		var input = audio_context.createMediaStreamSource(stream);

		recorder = new Recorder(input);
	}

	function startRecording(button) {
		recorder && recorder.record();
		$('.record').addClass('red');

		setTimeout(function() {
			recorder && recorder.stop();

			createMedia();

			recorder.clear();

			$('#playRecord').show();
			$('.record').removeClass('red');

			enableControl('play');
			enableControl('replay');
			enableControl('record');
		}, 3000);

		busyControl('record');
		disableControl('play');
		disableControl('replay');
	}

	function createMedia() {
		recorder && recorder.exportWAV(function(blob) {
			var url = URL.createObjectURL(blob);
			var auRecord = document.getElementById("auRecord");

			auRecord.src = url;
			localStorage.setItem("record", url);
		});
	}

	function startProgress(id) {
		var elem = document.getElementById(id);
		$(elem).closest('.progress').show();

		var interval = 0;
		if (id == 'progressSample') {
			interval = $('#sample')[0].duration *10;
		} else if (id == 'progressRecord') {
			interval = 50;
		} else if (id == 'progressPlayback') {
			interval = $('#record')[0].duration *10;
		}
		var width = 1;
		var duration = setInterval(frame, interval);
		function frame() {
			if (width >= 100) {
				clearInterval(duration);
				setTimeout(function() {
					$(elem).attr('style', 'width: 0%');
					$(elem).closest('.progress').hide();
				}, 1000);
			} else {
				width++; 
				elem.style.width = width + '%'; 
			}
		}
	}

	window.onload = function init() {
		try {
			// webkit shim
			window.AudioContext = window.AudioContext || window.webkitAudioContext;
			navigator.getUserMedia = ( navigator.getUserMedia ||
                       navigator.webkitGetUserMedia ||
                       navigator.mozGetUserMedia ||
                       navigator.msGetUserMedia);
			window.URL = window.URL || window.webkitURL;

			audio_context = new AudioContext;
			// console.log('Audio context set up.');
			// console.log('navigator.getUserMedia ' + (navigator.getUserMedia ? 'available.' : 'not present!'));
		} catch (e) {
			alert('No web audio support in this browser!');
		}

		navigator.getUserMedia({audio: true}, startUserMedia, function(e) {
			window.alert('No live audio input: ' + e);
		});

		$(document).ready(function(){
			preloadImage();
		});
	};
</script>
<script src="{{ asset('js/recorder.js') }}"></script>

@stop

@section('description')
	In this activity, you can click on the button on the left to hear the sample recording, use controls on the right to replay sample, practive your pronunciation by recording and listening to your own voice.
@stop