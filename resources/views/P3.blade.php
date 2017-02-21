@extends('layouts.app')

@section('content')

<div class="col-md-6 col-lg-6" style="text-align: center; vertical-align: middle; float: right; height: 85vh">
	<div>
		<input type="image" class="controlBtn" id="playSample" src="{{ asset('img/icons/sample_replay.svg') }}" onclick="toggleSample(this); /*startProgress('progressSample')*/" alt="Submit" width="130" height="130" data-toggle="tooltip" data-placement="bottom" title="Click a word on the left to hear sample!">
		<input type="image" class="startRecord controlBtn" id="playSample" src="{{ asset('img/icons/rec_startRecording.svg') }}" onclick="toggleRecord(this); /*startProgress('progressRecord')*/" alt="Submit" width="130" height="130">
		<input type="image" class="controlBtn" id="playSample" src="{{ asset('img/icons/rec_playback2.svg') }}" onclick="$('#record')[0].pause(); $('#record')[0].currentTime = 0; $('#record')[0].play(); /*startProgress('progressPlayback')*/" alt="Submit" width="130" height="130" data-toggle="tooltip" data-placement="bottom" title="Click the middle button to record your voice!">
	</div>

	<div>
		<audio id="sample" onpause="imgToReplay()" onplay="imgToPause()"></audio>
		<audio id="record"></audio>
	</div>
</div>
<div class="col-md-6 col-lg-6" style="float: left;">

		@foreach ($dummy as $dummyValue)

			<div class="wordLine" style="text-align: center;">
				<button class="btn playWord" style="font-size: 14px; padding: 2px 10px; width: 500px; white-space: normal;" onclick="playWord('{{ $dummyValue->audio }}')">{{ $dummyValue->sentence }}</button>
			</div>
		@endforeach

</div>

<script>
	var audio_context;
	var recorder;

	function playWord(audioPath) {
		var auRecord = document.getElementById("sample");

		auRecord.src = audioPath;
		auRecord.play();
	}

	function toggleSample(button) {
		if ($('#sample')[0].paused) {
			$('#sample')[0].play();
		} else {
			$('#sample')[0].pause();
		}
	}

	function playSample(button) {
		$('#sample')[0].pause();
		$('#sample')[0].currentTime = 0;
		$('#sample')[0].play();
	}

	function imgToReplay() {
		$('#playSample').attr('src', "{{ asset('img/icons/sample_replay.svg') }}");
	}

	function imgToPause(button) {
		$('#playSample').attr('src', "{{ asset('img/icons/sample_pause.svg') }}");
	}

	function toggleRecord(button) {
		if ($(button).hasClass('startRecord')) {
			startRecording(button);
		} else if ($(button).hasClass('stopRecord')) {
			stopRecording(button);
		}
	}

	function startUserMedia(stream) {
		var input = audio_context.createMediaStreamSource(stream);

		recorder = new Recorder(input);
	}

	function startRecording(button) {
		recorder && recorder.record();
		$(button).removeClass('startRecord');
		$(button).addClass('stopRecord');
		$(button).attr('src', '{{ asset('img/icons/rec_stopRecording.svg') }}');

		setTimeout(function() {
			if ($(button).hasClass('stopRecord')) {
				recorder && recorder.stop();
				$(button).removeClass('stopRecord');
				$(button).addClass('startRecord');
				$(button).attr('src', '{{ asset('img/icons/rec_startRecording.svg') }}');

				createMedia();

				recorder.clear();

				$('#playRecord').show();
			}
		}, 5000);
	}

	function stopRecording(button) {
		recorder && recorder.stop();

		// $('#progressRecord').attr('style', 'width: 0%');
		// $('#progressRecord').closest('.progress').hide();

		$(button).removeClass('stopRecord');
		$(button).addClass('startRecord');
		$(button).attr('src', '{{ asset('img/icons/rec_startRecording.svg') }}');
		createMedia();

		recorder.clear();

		$('#playRecord').show();

		$('.stopRecord').parent().find('.progress').hide();
	}

	function createMedia() {
		recorder && recorder.exportWAV(function(blob) {
			var url = URL.createObjectURL(blob);
			var auRecord = document.getElementById("record");

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
			navigator.mediaDevices.getUserMedia = navigator.mediaDevices.getUserMedia || navigator.webkitGetUserMedia;
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

@stop()