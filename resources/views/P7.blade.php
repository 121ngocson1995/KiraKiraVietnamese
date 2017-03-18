@extends('layout')

@section('title')
<h1 style="font-size: 400%" align="center">- Bài 7: Nghe và nhắc lại bài hội thoại</h1>

<hr>


<script language="JavaScript">
	var dialogNow = 0;
	var contentArr = <?php echo json_encode($contentArr); ?>;
	var audioArr = <?php echo json_encode($audioArr); ?>;
	function next(){
		
		while (document.getElementById("content_id").firstChild) {
			document.getElementById("content_id").removeChild(document.getElementById("content_id").firstChild);
		}
		if(dialogNow < contentArr.length-1){
			dialogNow = parseInt(dialogNow) + 1;
		}else{
			window.alert("Bạn đã hoàn thành bài tập rồi");
		}
		for (var i = 0; i < contentArr[dialogNow].length; i++) {
			editContent(contentArr[dialogNow][i]);
		}
		editAudio(audioArr[dialogNow]);
		// document.getElementById("audio").load();
	}

	function chooseD(element){
		
		dialogNow = element.getAttribute('id');
		while (document.getElementById("content_id").firstChild) {
			document.getElementById("content_id").removeChild(document.getElementById("content_id").firstChild);
		}

		for (var i = 0; i < contentArr[dialogNow].length; i++) {
			editContent(contentArr[dialogNow][i]);
		}
		editAudio(audioArr[dialogNow]);
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

				$('#playRecord').show();
			}
		}, 3000);
		$('#playRec-btn').show();
	}

	function createMedia(lineNo) {
		recorder && recorder.exportWAV(function(blob) {
			var url = URL.createObjectURL(blob);
			var auRecord = document.getElementById("record"+lineNo);
			auRecord.src = url;
			localStorage.setItem("record"+lineNo, url);
		});
	}

	function play(lineNo){
		muteSound();
		if (lineNo == audioArr[dialogNow].length) {
			return;
		}
		$('#audio' + lineNo).unbind();
		$('#audio' + lineNo).bind('ended', function() {
				play(lineNo+1);
			});
		document.getElementById('audio' + lineNo).play();
	}

	function playRecord(lineNo){
		muteSound();
		if (lineNo == audioArr[dialogNow].length) {
			return;
		}
		if ($('#record' + lineNo).length && document.getElementById("record" + lineNo).hasAttribute('src')) {
			$('#record' + lineNo).unbind();
			$('#record' + lineNo).bind('ended', function() {
				playRecord(lineNo+1);
			});
			document.getElementById('record' + lineNo).play();
			console.log('record' + lineNo);
		}else{
			$('#audio' + lineNo).unbind();
			$('#audio' + lineNo).bind('ended', function() {
				playRecord(lineNo+1);
			});
			document.getElementById('audio' + lineNo).play();
			console.log('audio' + lineNo);
		}
	}

	function muteSound(){
		$('audio').each(function() {
			this.pause();
			this.currentTime = 0;
			$(this).unbind();
		})

		// var sounds = document.getElementsByTagName('audio');
		// for(i=0; i<sounds.length; i++) {
		// 	sounds[i].pause();
		// }
	}
</script>
<script src="{{ asset('js/recorder.js') }}"></script>

@stop

@section('content1')
<div class="btn-group">
	@for ($i = 0; $i < count($dialogCnt); $i++)
	<button id="{{$i}}" type="button" class="btn btn-primary" onclick="JavaScript: chooseD(this)">D{{$i+1}}</button>
	@endfor
</div>
<div class="row">
	<div id="content_id" class="col-sm-9 col-md-6 col-lg-8">
		@for ($i = 0; $i < count($contentArr[1]) ; $i++)

		@if (strcmp(substr($contentArr[1][$i], -1), "*") == 0)
		<div class="row">
			<div>{{ substr_replace($contentArr[1][$i] ,"",-1)}}
				<input type="image" class="startRecord controlBtn" style="width: 50px; height: auto;" id="{{$i}}" src="{{ asset('img/icons/rec_startRecording.svg') }}" onclick="startRecording(this); /*startProgress('progressRecord')*/" alt="Submit" width="130" height="130">
				<input type="image" class="controlBtn" style="width: 50px; height: auto;" id="{{$i}}" src="{{ asset('img/icons/rec_playback2.svg') }}" onclick="$('#record{{$i}}')[0].pause(); $('#record{{$i}}')[0].currentTime = 0; $('#record{{$i}}')[0].play(); /*startProgress('progressPlayback')*/" alt="Submit" width="130" height="130" data-toggle="tooltip" data-placement="bottom" title="Click the middle button to record your voice!">
				<audio id="record{{$i}}"></audio>
			</div>
		</div>
		@else
		<div>{{ $contentArr[1][$i]}}</div>
		@endif 
		@endfor
		<br>
	</div>
	<button type="button" class="btn btn-primary" onclick="JavaScript: next()">Next</button>
	<div class="col-sm-3 col-md-6 col-lg-4" id="audio" >
		@for ($i = 0; $i < count($audioArr[1]) ; $i++)
		<audio id="audio{{$i}}">
			<source src="{{ URL::asset($audioArr[1][$i]) }}" type="audio/mpeg">
				Your browser does not support the audio element.
			</audio>
			@endfor
		</div>
		<button id="play-btn" type="button" onclick="play(0);">Play sample audio</button>
		<button id="playRec-btn" type="button" onclick="playRecord(0);" style="display: none;">Play with recorded</button>
	</div>
	<div class="row">
		<div id="right" class="img_right col-sm-6 col-md-6 col-lg-6" ></div>
		<div id="wrong" class="img_wrong col-sm-6 col-md-6 col-lg-6" ></div>
	</div>
	@stop