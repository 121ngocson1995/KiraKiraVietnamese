@extends('layout')

@section('title')
<h1 style="font-size: 400%" align="center">- Bài 7: Nghe và nhắc lại bài hội thoại</h1>

<hr>


<script language="JavaScript">
	var contentNow = 0;
	var contentArr = <?php echo json_encode($contentArr); ?>;
	var audioArr = <?php echo json_encode($audioArr); ?>;
	function next(){
		
		while (document.getElementById("content_id").firstChild) {
			document.getElementById("content_id").removeChild(document.getElementById("content_id").firstChild);
		}
		if(contentNow < contentArr.length-1){
			contentNow = parseInt(contentNow) + 1;
		}else{
			window.alert("Bạn đã hoàn thành bài tập rồi");
		}
		for (var i = 0; i < contentArr[contentNow].length; i++) {
			editContent(contentArr[contentNow][i]);
		}
		editAudio(audioArr[contentNow]);
		// document.getElementById("audio").load();
	}

	function chooseD(element){
		
		contentNow = element.getAttribute('id');
		while (document.getElementById("content_id").firstChild) {
			document.getElementById("content_id").removeChild(document.getElementById("content_id").firstChild);
		}

		for (var i = 0; i < contentArr[contentNow].length; i++) {
			editContent(contentArr[contentNow][i]);
		}
		editAudio(audioArr[contentNow]);
		document.getElementById("audio").load();
	}

	function editContent(text) {
		var node = document.createElement("div");
		var textnode = document.createTextNode(text);
		node.appendChild(textnode);
		document.getElementById("content_id").appendChild(node);
	}

	function editAudio(pathList) {
		document.getElementById("audio").setAttribute('src', '{{ URL::asset('') }}' + path);
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
	function play(index){
		if (index == audioArr[contentNow].length) {
			return;
		}

		document.getElementById('audio' + index).play();
		document.getElementById('audio' + index).addEventListener('ended', function() {
			play(index+1);
		});
	}
</script>
<script src="{{ asset('js/recorder.js') }}"></script>

@stop

@section('content1')
<div class="btn-group">
	@for ($i = 0; $i < count($dialogCnt); $i++)
	<button id="{{$i}}" type="button" class="btn btn-primary" onclick="JavaScript: chooseD(this)">D{{$i}}</button>
	@endfor
</div>
<div class="row">
	<div id="content_id" class="col-sm-9 col-md-6 col-lg-8">
		@for ($i = 0; $i < count($contentArr[0]) ; $i++)
		
		@if (strcmp(substr($contentArr[0][$i], -1), "*") == 0)
		<div class="row">
			<div>{{ substr_replace($contentArr[0][$i] ,"",-1)}}
				<input type="image" class="startRecord controlBtn" style="width: 50px; height: auto;" id="playSample" src="{{ asset('img/icons/rec_startRecording.svg') }}" onclick="toggleRecord(this); /*startProgress('progressRecord')*/" alt="Submit" width="130" height="130">
				<input type="image" class="controlBtn" style="width: 50px; height: auto;" id="playSample" src="{{ asset('img/icons/rec_playback2.svg') }}" onclick="$('#record')[0].pause(); $('#record')[0].currentTime = 0; $('#record')[0].play(); /*startProgress('progressPlayback')*/" alt="Submit" width="130" height="130" data-toggle="tooltip" data-placement="bottom" title="Click the middle button to record your voice!">

			</div>
		</div>
		@else
		<div>{{ $contentArr[0][$i]}}</div>
		@endif 
		@endfor
		<br>
	</div>
	<div>
		<audio id="sample" onpause="imgToReplay()" onplay="imgToPause()"></audio>
		<audio id="record"></audio>
	</div>
	<button type="button" class="btn btn-primary" onclick="JavaScript: next()">Next</button>
	<div class="col-sm-3 col-md-6 col-lg-4" id="audio" >
	@for ($i = 0; $i < count($audioArr[0]) ; $i++)
		<audio id="audio{{$i}}">
		<source id="audio_id" src="{{ URL::asset($audioArr[0][$i]) }}" type="audio/mpeg">
			Your browser does not support the audio element.
		</audio>
	@endfor
	</div>
	<button type="button" onclick="play(0);">play</button>
</div>
<div class="row">
	<div id="right" class="img_right col-sm-6 col-md-6 col-lg-6" ></div>
	<div id="wrong" class="img_wrong col-sm-6 col-md-6 col-lg-6" ></div>
</div>
@stop