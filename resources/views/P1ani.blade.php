@extends('layouts.app')

@section('content')

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.19.1/TweenMax.min.js"></script>
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
	@media screen and (max-height: 600px) {
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
		width: 90px;
		height: 40px;
		line-height: 40px;
		display: inline-block;
		margin: 5px;
		text-align: center;
		background: url({{ asset('img/testAnimate/board.svg') }});
		cursor: pointer;
	}
	span.word {
		display: inline-block;
		vertical-align: middle;
		line-height: normal;
		font-weight: 600;
		font-family: Cambria;
		font-size: 1.2em;
		color: white;
		cursor: pointer;
	}

</style>


<div class="play"">
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
		// dd($elementData);
	@endphp

	<div class="wordLine" style="text-align: center; width: 100%">

		@foreach ($elementData as $dummyValue)
			@if ($dummyValue->lineNumber > $currentlineNumber)
				@php
					$currentlineNumber = $dummyValue->lineNumber;
				@endphp

				</div><div class="wordLine" style="text-align: center; width: 100%">
			@endif

			<div class="wordWrap"><span id="{{ $dummyValue->audio }}" class="word">{{ $dummyValue->word }}</span></div>
		@endforeach

	</div>

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

	function playWord(button) {
		var audio = document.getElementById("sample");

		audio.src = button.children[0].id;
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
	}

	function playSample(button) {
		$('#sample')[0].pause();
		$('#sample')[0].currentTime = 0;
		$('#sample')[0].play();

		$('.play').addClass('red');
		$(".play").unbind('click');
		setTimeout(function() {
			$('.play').removeClass('red');
			$(".play").bind('click', function(){ playSample(this); });
		}, $('#sample')[0].duration*1000);
	}

	function playRecord() {
		$('#auRecord')[0].pause();
		$('#auRecord')[0].currentTime = 0;
		$('#auRecord')[0].play();

		$('.replay').addClass('red');
		$(".replay").unbind('click');
		setTimeout(function() {
			$('.replay').removeClass('red');
			$(".replay").bind('click', function(){ playRecord(); });
		}, $('#auRecord')[0].duration*1000);
	}

	function startUserMedia(stream) {
		var input = audio_context.createMediaStreamSource(stream);

		recorder = new Recorder(input);
	}

	function startRecording(button) {
		recorder && recorder.record();
		$('.record').addClass('red');
		$(".record").unbind('click');

		setTimeout(function() {
			recorder && recorder.stop();

			createMedia();

			recorder.clear();

			$('#playRecord').show();
			$('.record').removeClass('red');
			$(".record").bind('click', function(){ startRecording(this); });
		}, 3000);
	}

	function createMedia() {
		recorder && recorder.exportWAV(function(blob) {
			var url = URL.createObjectURL(blob);
			var auRecord = document.getElementById("auRecord");

			auRecord.src = url;
			localStorage.setItem("record", url);
			console.log(url);
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
			console.log('Audio context set up.');
			console.log('navigator.getUserMedia ' + (navigator.getUserMedia ? 'available.' : 'not present!'));
		} catch (e) {
			alert('No web audio support in this browser!');
		}


		navigator.getUserMedia({audio: true}, startUserMedia, function(e) {
			window.alert('No live audio input: ' + e);
		});

		$(document).ready(function(){
		    $('[data-toggle="tooltip"]').tooltip("show");   
		});
	};
</script>
<script src="{{ asset('js/recorder.js') }}"></script>

@stop

@section('description')
	In this activity, you can click on the button on the left to hear the sample recording, use controls on the right to replay sample, practive your pronunciation by recording and listening to your own voice.
@stop