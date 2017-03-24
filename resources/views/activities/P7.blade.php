@extends('activities.layout.activityLayout')

@section('actContent')

<style type="text/css">
	.dialogDiv{
		display: inline-block;
		width: 100px;
		text-align: right;
	}

	#btn-NextAct, #btn-PreAct {
		position: fixed;
		right: 0;
		bottom: 50%;
		background-color: bisque;
		width: auto;
		text-align: center;
		padding-top: 5px;
		padding-bottom: 5px;
		padding-left: 20px;
		padding-right: 20px;
		border: 1px solid #d8b9b9;
		border-radius: 20px;
		color: rgb(69, 130, 236);
		transition-duration: 1s;
		transform: translateX( calc(100% - 90px) );
	}
	#btn-NextAct:hover, #btn-PreAct:hover {
		transform: translateX( 0 ) !important;
	}
	.fa.fa-arrow-right.fa-4x{
		margin-right: 5px;
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
	function next(){

		while (document.getElementById("content_id").firstChild) {
			document.getElementById("content_id").removeChild(document.getElementById("content_id").firstChild);
		}
		while (document.getElementById("audio_id").firstChild) {
			document.getElementById("audio_id").removeChild(document.getElementById("audio_id").firstChild);
		}
		if(dialogNow < contentArr.length-1){
			dialogNow = parseInt(dialogNow) + 1;
		}else{
			$('#btn-NextAct').show();
		}
		for (var i = 0; i < contentArr[dialogNow].length; i++) {
			editContent(i);
			editAudio(i);
		}
		
	}

	function chooseD(element){
		
		dialogNow = element.getAttribute('id');
		while (document.getElementById("content_id").firstChild) {
			document.getElementById("content_id").removeChild(document.getElementById("content_id").firstChild);
		}
		while (document.getElementById("audio_id").firstChild) {
			document.getElementById("audio_id").removeChild(document.getElementById("audio_id").firstChild);
		}
		for (var i = 0; i < contentArr[dialogNow].length; i++) {
			editContent(i);
			editAudio(i);
		}
	}
	function editContent(index) {
		var node = document.createElement("div");
		var node_spker = document.createElement("div");
		var node_content = document.createElement("div");
		var text_spker = contentArr[dialogNow][index][0];
		var text = contentArr[dialogNow][index][1];
		var textnode_spker;
		var textnode_content;
		textnode_spker = document.createTextNode(text_spker);
		node_spker.appendChild(textnode_spker);
		node_spker.setAttribute('class', 'dialogDiv');
		node_spker.setAttribute('style', 'display: inline-block;');
		if (text.substr(-1,1) == "*") {
			textnode_content = document.createTextNode(text.replace("*",""));
			node_content.appendChild(textnode_content);

			var nodeRecord = document.createElement("input");
			var nodePlayRecord = document.createElement("input");
			var nodeAudio = document.createElement("audio");

			nodeRecord.setAttribute('id', index);
			nodeRecord.setAttribute('type', 'image');
			nodeRecord.setAttribute('class', 'startRecord controlBtn');
			nodeRecord.setAttribute('style', 'width: 50px; height: auto;');
			nodeRecord.setAttribute('src', '{{ asset('img/icons/rec_startRecording.svg') }}');
			nodeRecord.setAttribute('onclick', 'startRecording(this);');
			nodeRecord.setAttribute('alt', 'Submit');
			nodeRecord.setAttribute('width', '130');
			nodeRecord.setAttribute('height', '130');
			node_content.appendChild(nodeRecord);

			nodePlayRecord.setAttribute('id', index);
			nodePlayRecord.setAttribute('type', 'image');
			nodePlayRecord.setAttribute('class', 'controlBtn');
			nodePlayRecord.setAttribute('style', 'width: 50px; height: auto;');
			nodePlayRecord.setAttribute('src', '{{ asset('img/icons/rec_playback2.svg') }}');
			nodePlayRecord.setAttribute('onclick', "$('#record"+index+"')[0].pause(); $('#record"+index+"')[0].currentTime = 0; $('#record"+index+"')[0].play();");
			nodePlayRecord.setAttribute('alt', 'Submit');
			nodePlayRecord.setAttribute('width', '130');
			nodePlayRecord.setAttribute('height', '130');
			nodePlayRecord.setAttribute('data-toggle', 'tooltip');
			nodePlayRecord.setAttribute('data-placement', 'bottom');
			nodePlayRecord.setAttribute('title', 'Click the middle button to record your voice!');
			node_content.appendChild(nodePlayRecord);

			nodeAudio.setAttribute('id',"record"+index);
			node_content.appendChild(nodeAudio);

		}else{
			textnode_content = document.createTextNode(text);
			node_content.appendChild(textnode_content);
		}
		
		node_content.setAttribute('style', 'display: inline-block;');
		node.appendChild(node_spker);
		node.appendChild(node_content);
		document.getElementById("content_id").appendChild(node);
	}

	function editAudio(index) {
		var node = document.createElement("audio");
		node.setAttribute('id', 'audio'+index);
		var path = audioArr[dialogNow][index];
		node.setAttribute('src', '{{ URL::asset('') }}' + path);
		document.getElementById('audio_id').appendChild(node);
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
		}else{
			$('#audio' + lineNo).unbind();
			$('#audio' + lineNo).bind('ended', function() {
				playRecord(lineNo+1);
			});
			document.getElementById('audio' + lineNo).play();
		}
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

<div id="btn-NextAct">
	<i class="fa fa-arrow-right fa-4x" aria-hidden="true"></i>
	<span id="locationNext"></span>
</div>
<div class="btn-group">
	@for ($i = 0; $i < count($dialogCnt); $i++)
	<button id="{{$i}}" type="button" class="btn btn-primary" onclick="JavaScript: chooseD(this)">D{{$i+1}}</button>
	@endfor
</div>
<div class="row">
	<div id="content_id" class="col-sm-9 col-md-6 col-lg-8">
		@for ($i = 0; $i < count($contentArr[0]) ; $i++)
		<div>
			<div class="dialogDiv" style="display: inline-block;">{{ $contentArr[0][$i][0]}}</div>
			@if (strcmp(substr($contentArr[0][$i][1], -1), "*") == 0)
			<div style="display: inline-block;">{{ substr_replace($contentArr[0][$i][1] ,"",-1)}}
				<input type="image" class="startRecord controlBtn" style="width: 50px; height: auto;" id="{{$i}}" src="{{ asset('img/icons/rec_startRecording.svg') }}" onclick="startRecording(this); /*startProgress('progressRecord')*/" alt="Submit" width="130" height="130">
				<input type="image" class="controlBtn" style="width: 50px; height: auto;" id="{{$i}}" src="{{ asset('img/icons/rec_playback2.svg') }}" onclick="$('#record{{$i}}')[0].pause(); $('#record{{$i}}')[0].currentTime = 0; $('#record{{$i}}')[0].play(); /*startProgress('progressPlayback')*/" alt="Submit" width="130" height="130" data-toggle="tooltip" data-placement="bottom" title="Click the middle button to record your voice!">
				<audio id="record{{$i}}"></audio>
			</div>
			@else
			<div style="display: inline-block;">{{ $contentArr[0][$i][1]}}</div>
			@endif 
		</div>
		@endfor
		<br>
	</div>
	<button type="button" class="btn btn-primary" onclick="JavaScript: next()">Next</button>
	<div class="col-sm-3 col-md-6 col-lg-4" id="audio_id" >
		@for ($i = 0; $i < count($audioArr[0]) ; $i++)
		<audio id="audio{{$i}}">
			<source src="{{ URL::asset($audioArr[0][$i]) }}" type="audio/mpeg">
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

	<script type="text/javascript">
		var nextAct = <?php echo json_encode(\Request::get('nextAct')); ?>;
		$('#locationNext').html(nextAct['name']);
		$('#btn-NextAct').hide();
		$('#btn-NextAct').click(function(){
			window.location.href="http://localhost:8000/lesson1/"+nextAct['name']; 
		});
	</script>

	@stop