@extends('activities.layout.activityLayout')

@section('header-more')

<style>
	body {
		background: url({{ asset('img/P7/bg.svg') }}) no-repeat center bottom fixed;
		background-size: cover;
	}
</style>
<link rel="stylesheet" href="{{ asset('css/screens/p7.css') }}">

@stop

@section('actContent')

<div>
	<audio id="sample"{{ count($elementData) > 0 && isset($elementData[0]->audio) ? 'src="' . \Storage::url($elementData[0]->audio) . '"' : '' }}></audio>
	<audio id="auRecord"></audio>
</div>

<div class="col-md-7" style="margin-top: 30px">
	<div id="chooseDHolder" style="text-align: center; display: none;">

		@for ($i = 0; $i < count($dialogCnt); $i++)
			<button data-dialogNo="{{ $i }}" class="dialogBtn" onclick="chooseDialog(this)">
				<span> 
					<span>D{{$i+1}}</span>
					<span>D{{$i+1}}</span>
					<span>D{{$i+1}}</span>
				</span>
			</button>
		@endfor
	</div>
	<div class="wordLine" style="text-align: center; width: 100%">
		<div class="wordWrap" style="display: none;">
			<div class="flexContainer">
				<div class="wrapLine">
					@foreach (explode( "|", $elementData[0]->dialogue) as $line)
					<div class="line">
						@php
						$lineContent = explode('*', $line);
						@endphp
						<div class="tbn word writtenFont spkerDiv col-xs-4">{{ $lineContent[0]}}</div>
						<div class="tbn word writtenFont diaDiv col-xs-8">{{ $lineContent[1]}}</div>
					</div>
					@endforeach
				</div>
				<div class="btnBg">
					<img class="wordCloud" style="height: 100%; " src="{{ asset('img/P7/newboard1.svg') }}" alt="start button">
				</div>
			</div>
		</div>
	</div>
</div>

<div class="replay">
	<img class="fillable" src="{{ asset('img/testAnimate/replay.png') }}" id="playSample">
</div>
<div class="record toRecord">
	<img class="fillable" src="{{ asset('img/testAnimate/record.png') }}" id="record">
</div>

<div id="alert"></div>

<script>
	TweenMax.from('.replay', 1, {scale:0.5, y:300, delay:1, ease:Elastic.easeOut});
	TweenMax.from('.record', 1, {scale:0.5, y:300, delay:1.3, ease:Elastic.easeOut});
	setTimeout(function() {
		$('#chooseDHolder').addClass('animated fadeInDownBig').show().one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {

			$('.dialogBtn').first().addClass('selected').prop('disabled', true);
			setTimeout(function() {
				$('.wordWrap').addClass('animated flipInY').show().one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function play() {

					$('.wordWrap').css('display', 'inline-block');
					$('.wordWrap').off('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend');
					setTimeout(function() {
						$('.wordWrap').click(function() {
							togglePlaySample(this);
						});
					}, 600);

				});
			}, 300);
		});
	}, 800);
</script>

<script>
	var elementData = <?php echo json_encode($elementData); ?>;
	var assetPath = '{{ mb_substr(\Storage::url('/'),0,-1) }}';
	var busyPlay, busyReplay, busyRecord, 
		enabledPlay, enabledReplay, enabledRecord, 
		disabledPlay, disabledReplay, disabledRecord;

	 /**
	 * set image source
	 *　イメージソースをセットする。
	 *
	 * @return {void}
	 */
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

	/**
	 * create component for record through micro
	 * マイクロから記録にコンポーネントを作成する。
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
			var elementData = <?php echo json_encode($elementData); ?>;
			document.getElementById('sample').setAttribute('src', '{{ asset('') }}' + elementData[0].audio);
			document.getElementById('sample').load();

			preloadImage();
		});
	};
</script>
<script src="{{ asset('js/screens/p7.js') }}"></script>
<script src="{{ asset('js/recorder.js') }}"></script>

@stop

@section('actDescription-vi')
	Rê chuột vào D1, D2, D3, D4, D5, D6 và tích chuột để nghe và luyện tập nói theo bài hội thoại.
	<br>
	Tự ghi âm và nghe lại bằng cách bấm vào nút ghi âm và nút nghe lại.
@stop

@section('actDescription-en')
	Click D1, D2, D3, D4, D5, D6 to listen to the dialogue and practice.
	<br>
	Record your own voice by clicking the microphone button, listen by clicking the arrow button.
@stop