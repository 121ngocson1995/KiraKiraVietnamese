@extends('activities.layout.activityLayout')

@section('actContent')

<style type="text/css">
	.spkerDiv{
		display: inline-block;
		width: 100px;
		text-align: right;
	}
	.movOut{
		transform: none;
	}
</style>
<hr>


<script language="JavaScript">
	var dialogNow = 0;
	var contentArr = <?php echo json_encode($contentArr); ?>;
	var audioArr = <?php echo json_encode($audioArr); ?>;

	function chooseD(element){
		
		dialogNow = element.getAttribute('id');
		while (document.getElementById("content_id").firstChild) {
			document.getElementById("content_id").removeChild(document.getElementById("content_id").firstChild);
		}
		editContent();
		editAudio();
	}

	function editContent() {
		
		var line;
		for (var i = 0; i < contentArr[dialogNow].length; i++) {
			var node_spker = document.createElement("div");
			var node_dia = document.createElement("div");
			line = contentArr[dialogNow][i].split("*");
			var text_spker = line[0];
			var text = line[1];
			var textnode_spker;
			var textnode_dia;
			textnode_spker = document.createTextNode(text_spker);
			node_spker.appendChild(textnode_spker);
			node_spker.setAttribute('class', 'spkerDiv');
			node_spker.setAttribute('style', 'display: inline-block;');
			textnode_dia = document.createTextNode(text);
			node_dia.appendChild(textnode_dia);

			node_dia.setAttribute('class', 'diaDiv');
			node_dia.setAttribute('style', 'display: inline-block;');
			document.getElementById("content_id").appendChild(node_spker);
			document.getElementById("content_id").appendChild(node_dia);
			document.getElementById("content_id").appendChild(document.createElement("br"));
			
			
		}
		
	}

	function editAudio(index) {
		var path = audioArr[dialogNow];
		document.getElementById('sample').setAttribute('src', '{{ URL::asset('') }}' + path);
		document.getElementById('sample').load();
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
		muteSound();
		$('#playRecord').show();
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
		}, 60000);
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

	function playRecord() {
		$('#record')[0].pause();
		$('#record')[0].currentTime = 0;
		$('#record')[0].play();
		$('#sample')[0].pause();
		if ($('#recordSample').hasClass('stopRecord')) {
			stopRecording($('#recordSample'));
		}
		

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
		$('#playRecord').hide();
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

	function play(){
		if ($('#recordSample').hasClass('stopRecord')) {
			stopRecording($('#recordSample'));
		}
		muteSound();
		document.getElementById('sample').play();
	}


	function muteSound(){
		$('audio').each(function() {
			this.pause();
			this.currentTime = 0;
			$(this).unbind();
		})
	}
</script>
<script src="{{ asset('js/recorder.js') }}"></script>

<div class="btn-group">
	@for ($i = 0; $i < count($dialogCnt); $i++)
	<button id="{{$i}}" type="button" class="btn btn-primary" onclick="JavaScript: chooseD(this)">D{{$i+1}}</button>
	@endfor
</div>
<div id="content_id" >
	@for ($i = 0; $i < count($contentArr[0]) ; $i++)
	@php
	$line = explode('*', $contentArr[0][$i]);
	@endphp
	<div class="spkerDiv" style="display: inline-block;">{{ $line[0]}}</div>	
	<div class="diaDiv" style="display: inline-block;">{{ $line[1]}}</div>
	<br>
	@endfor
</div>

<div>
	<audio src="{{ URL::asset($audioArr[0]) }}" id="sample" "></audio>
	<audio id="record"></audio>
</div>
<div>
	<input type="image" class="controlBtn" id="playSample" src="{{ asset('img/icons/sample_replay.svg') }}" onclick="play(); /*startProgress('progressSample')*/" alt="Submit" width="25%" height="25%" data-toggle="tooltip" data-placement="bottom" title="Click a word on the left to hear sample!">
	<input type="image" class="startRecord controlBtn" id="recordSample" src="{{ asset('img/icons/rec_startRecording.svg') }}" onclick="toggleRecord(this); /*startProgress('progressRecord')*/" alt="Submit" width="25%" height="25%">
	<input type="image" class="controlBtn" id="playRecord" src="{{ asset('img/icons/rec_playback2.svg') }}" onclick="playRecord()" alt="Submit" width="25%" height="25%" data-toggle="tooltip" data-placement="bottom" title="Click the middle button to record your voice!">
</div>
@stop

@section('actDescription-vi')
	Rê chuột vào D1, D2, D3, D4, D5, D6 và tích chuột để nghe và luyện tập nói theo bài hội thoại.
@stop

@section('actDescription-en')
	Click D1, D2, D3, D4, D5, D6 to listen the dialogue and practice.
@stop