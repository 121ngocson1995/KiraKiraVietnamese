@extends('activities.layout.activityLayout')

@section('header-more')

<link rel="stylesheet" href="{{ asset('css/screens/p1.css') }}">
<style>
	body {
		background: url({{ asset('img/P1/bg.svg') }}) no-repeat center bottom fixed;
		background-size: cover;
	}
</style>

@stop

@section('actContent')

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

<div class="col-md-7" style="margin-top: 30px">
	<div class="wordLine" style="text-align: center; width: 100%">

		@foreach ($elementData as $elementValue)

			<div class="wordWrap" data-audio-source="{{ $elementValue->audio }}" style="display: inline-block; height: 60px;">
				<div class="flexContainer" style="display: flex; height: 100%;">
					<p class="tbn word writtenFont">{{ $elementValue->word }}</p>
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
	$('.replay').click(function() {
		playRecord();
	});

	$('.record').click(function() {
		startRecording(this);
	});

	$('.wordWrap').click(function() {
		readWord(this);
	});

	TweenMax.from('.replay', 1, {scale:0.5, y:300, delay:1, ease:Elastic.easeOut});
	TweenMax.from('.record', 1, {scale:0.5, y:300, delay:1.3, ease:Elastic.easeOut});
	TweenMax.staggerFrom('.wordWrap', 0.5, {opacity:0, y:100, rotation:120, scale:2, delay:0.5}, 0.2);
</script>

<script>
	var audio_context;
	var recorder;
	var assetPath = '{{ mb_substr(\Storage::url('/'),0,-1) }}';
	// bản chất: tạo đường dẫn " \Storage::url('') + đường dẫn trong db "
	// tham khảo line 7 trong p1.js
	// \Storage::url('') lấy giá trị của url trong filesystems.php
	// đối với local:  đường dẫn là : localhost:8000/storage/public/...
	// đối với server: đường dẫn là : https://s3-ap-southeast-1.amazonaws.com/kirakiravn/public/...

	var busyPlay, busyReplay, busyRecord, 
	enabledPlay, enabledReplay, enabledRecord, 
	disabledPlay, disabledReplay, disabledRecord;

	/**
	 * set image source
	 * @return {void}
	 */
	function preloadImage() {
		busyReplay = new Image();
		busyReplay.src = '{{ asset('img/testAnimate/replay-blu.png') }}';
		busyRecord = new Image();
		busyRecord.src = '{{ asset('img/testAnimate/record-blu.png') }}';
		enabledReplay = new Image();
		enabledReplay.src = '{{ asset('img/testAnimate/replay.png') }}';
		enabledRecord = new Image();
		enabledRecord.src = '{{ asset('img/testAnimate/record.png') }}';
		disabledReplay = new Image();
		disabledReplay.src = '{{ asset('img/testAnimate/replay-red.png') }}';
		disabledRecord = new Image();
		disabledRecord.src = '{{ asset('img/testAnimate/record-red.png') }}';
	}

	/**
	 * create component for record through micro
	 * @param  {stream} stream 
	 * @return {void} 
	 */
	function startUserMedia(stream) {
		var input = audio_context.createMediaStreamSource(stream);

		recorder = new Recorder(input);
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
<script src="{{ asset('js/screens/p1.js') }}"></script>
<script src="{{ asset('js/recorder.js') }}"></script>

@stop

@section('actDescription-vi')
	Rê chuột vào các từ và tích chuột để nghe từ.
	<br>
	Tự ghi âm và nghe lại bằng cách bấm vào nút ghi âm và nút nghe lại.
@stop

@section('actDescription-en')
	Click the word to listen.
	<br>
	Record your own voice by clicking the microphone button, listen by clicking the arrow button.
@stop