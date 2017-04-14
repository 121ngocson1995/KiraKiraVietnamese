@extends('activities.layout.activityLayout')

@section('header-more')

<link rel="stylesheet" href="{{ asset('css/screens/p12.css') }}">
<style>
	body {
		background: url({{ asset('img/stave2.jpg') }}) no-repeat center bottom fixed;
		background-size: cover;
	}
</style>

@stop

@section('actContent')

<div>
	<audio id="sample"></audio>
	<audio id="auRecord"></audio>
</div>

<div class="col-md-7" style="margin-top: 2%;">
	<div class="wordLine" style="text-align: center; width: 100%">
		@foreach ($elementData as $key)
			<div class="wordWrap2 vietnamese" style="display: none;">
				<div class="flexContainer">
					<div class="wrapLine">
						<p class="content writtenFont">{{ $key->content }}</p>
						<p class="content_translate writtenFont"><i class="fa fa-commenting" aria-hidden="true"></i> 
						Click to read this guide in English</p>
					</div>
					<div>
						<img class="wordCloud" src="{{ asset('img/P7/newboard1.svg') }}">
					</div>
				</div>
			</div>
			<div class="wordWrap2 english" style="display: none;">
				<div class="flexContainer">
					<div class="wrapLine">
						<p class="content writtenFont">{{ $key->content_translate }}</p>
						<p class="content_translate writtenFont"><i class="fa fa-commenting" aria-hidden="true"></i> 
						Bấm vào đây để xem hướng dẫn bằng tiếng Việt</p>
					</div>
					<div>
						<img class="wordCloud" src="{{ asset('img/P7/newboard1.svg') }}">
					</div>
				</div>
			</div>
		@endforeach
	</div>
</div>

<div class="replay">
	<img class="fillable" src="{{ asset('img/testAnimate/replay.png') }}" id="playSample">
</div>

<div class="record">
	<img class="fillable" src="{{ asset('img/testAnimate/record.png') }}" id="record">
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

	$('.wordWrap2').click(function() {
		switchLanguage(this);
	});

	TweenMax.from('.replay', 1, {scale:0.5, y:300, delay:1, ease:Elastic.easeOut});
	TweenMax.from('.record', 1, {scale:0.5, y:300, delay:1.3, ease:Elastic.easeOut});

	setTimeout(function() {
		$('.wordWrap2.vietnamese').addClass('animated flipInY').show().one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function play() {
			$('.wordWrap2.vietnamese').css('display', 'inline-block');
			$('.wordWrap2.vietnamese').off('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend');

			$('.wordWrap2').click(function() {
				switchLanguage(this);
			});

			$('.wordWrap2')
			.mouseenter(function() {
				$(this).removeClass('flipInY pulse').addClass('pulse infinite');
			})
			.mouseleave(function() {
				$(this).removeClass('infinite');
			});
		});
	}, 1500);

</script>

<script>
	var audio_context;
	var recorder;
	var tl;
	var assetPath = '{{ asset('') }}';

	var busyPlay, busyReplay, busyRecord, 
		enabledPlay, enabledReplay, enabledRecord, 
		disabledPlay, disabledReplay, disabledRecord;
	function preloadImage() {
		busyReplay = new Image();
		busyReplay.src = '{{ asset('img/testAnimate/replay-blu.png') }}';
		busyRecord = new Image();
		busyRecord.src = '{{ asset('img/P7/pause.png') }}';
		enabledReplay = new Image();
		enabledReplay.src = '{{ asset('img/testAnimate/replay.png') }}';
		enabledRecord = new Image();
		enabledRecord.src = '{{ asset('img/testAnimate/record.png') }}';
		disabledReplay = new Image();
		disabledReplay.src = '{{ asset('img/testAnimate/replay-red.png') }}';
		disabledRecord = new Image();
		disabledRecord.src = '{{ asset('img/testAnimate/record-red.png') }}';
	}

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
			var elementData = <?php echo json_encode($elementData); ?>;
			document.getElementById('sample').setAttribute('src', '{{ asset('') }}' + elementData[0].audio);
			document.getElementById('sample').load();

			preloadImage();
		});
	};
</script>

<script src="{{ asset('js/screens/p12.js') }}"></script>
<script src="{{ asset('js/recorder.js') }}"></script>

@stop

@section('actDescription-vi')
	Sau khi chuẩn bị xong, hãy ghi âm và nghe lại bài giới thiệu của mình.
@stop

@section('actDescription-en')
	Record and playback your introduction after your preparation.
@stop