@extends('activities.layout.activityLayout')

@section('actContent')
<hr>
<style type="text/css">
	#record-content{
		width: 230px;
		height: 60px;
		position: fixed;
		z-index: 999;
		right: 130px;
		bottom: 40%;
	}
</style>
<script type="text/javascript">
	function playWord(audioPath) {
		var auRecord = document.getElementById("sample");

		auRecord.src = audioPath;
		auRecord.play();
	} 
</script>
<div id="content_id" class="col-sm-9 col-md-6 col-lg-8">
	<audio id="sample"></audio>
	@for ($i = 0; $i < count($contentArr) ; $i++)
	<div class="row">
		<div class="col-sm-6 col-md-6 col-lg-6" align="right">
			@for ($j = 0; $j < count($contentArr[$i]) ; $j++)
			<p align="center" >{{ $contentArr[$i][$j]}}</p>
			@endfor
		</div>
		<div class="col-sm-6 col-md-6 col-lg-6" align="left">
			<input type="image" class="controlBtn" src="{{ asset('img/icons/sample_play.svg') }}" width="10%" height="10%" onclick="playWord('{{ URL::asset($audioArr[$i]) }}')">
		</div>
	</div>
	<hr>
	@endfor
</div>
<div id="record-content">
	<input type="image" class="startRecord controlBtn" style="width: 100px; height: 100px;" id="btn-rec" src="{{ asset('img/icons/rec_startRecording.svg') }}" onclick="startRecording(this); /*startProgress('progressRecord')*/" alt="Submit" width="130" height="130">
	<input type="image" class="controlBtn" style="width: 100px; height: 100px;" id="btn-playRec" src="{{ asset('img/icons/rec_playback2.svg') }}" onclick="$('#auRecord')[0].pause(); $('#auRecord')[0].currentTime = 0; $('#auRecord')[0].play(); /*startProgress('progressPlayback')*/" alt="Submit" width="130" height="130" data-toggle="tooltip" data-placement="bottom" title="Click the middle button to record your voice!">
	<audio id="auRecord"></audio>
</div>
<script src="{{ asset('js/recorder.js') }}"></script>
<script type="text/javascript">
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
	}
	function startUserMedia(stream) {
		var input = audio_context.createMediaStreamSource(stream);

		recorder = new Recorder(input);
	}

	function startRecording(button) {
		muteSound()
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

				createMedia($(button).attr("id"));

				recorder.clear();
			}
		}, 10000);
	}

	
	function createMedia() {
		recorder && recorder.exportWAV(function(blob) {
			var url = URL.createObjectURL(blob);
			var auRecord = document.getElementById("auRecord");

			auRecord.src = url;
			localStorage.setItem("record", url);
		});
	}

	function muteSound(){
		$('audio').each(function() {
			this.pause();
			this.currentTime = 0;
			$(this).unbind();
		})
	}
</script>
@stop