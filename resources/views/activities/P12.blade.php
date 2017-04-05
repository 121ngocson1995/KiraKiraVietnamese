@extends('activities.layout.activityLayout')

@section('header-more')

<style>
	body {
		background: url({{ asset('img/stave2.jpg') }}) no-repeat center bottom fixed;
		background-size: cover;
	}
	.flexContainer {
		display: flex;
		height: 100%;
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

	.wordCloud {
		height: 100%; 
		width: 700px;
	}

	@media screen and (max-width: 768px) {
		.replay {
			width: 35% !important;
			right: 30px !important;
		}
		.play {
			width: 35% !important;
			left: 30px !important;
		}
		.record {
			width: 35% !important;
			left: 30% !important;
		}
		.replay img {
			width: 100% !important;
			max-width: 262px !important;
		}
		.play img {
			width: 100% !important;
			max-width: 240px !important;
		}
		.record img {
			width: 100% !important;
			max-width: 289px !important;
		}

		.wordCloud {
			height: 100%; 
			width: 650px;
		}
	}
	@media screen and (max-height: 400px) {
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
		display: inline-flex;
		margin: 5px;
		text-align: center;
		cursor: pointer;
	}
	.word {
		font-weight: 500;
		font-size: 1.6em;
		color: white;
		cursor: pointer;
	}
	.wrapLine {
		position: absolute;
		padding: 2em;
		width: 100%;
		top: 50%;
		left: 50%;
		transform: translate(-50%,-50%);
		z-index: 1;
	}
	.line {
		width: 100%;
	}
	#alert {
		display: none;
		position: fixed;
		text-align: center;
		padding: 10px;
		font-size: 1.4em;
		background: rgba(140, 140, 140, 0.9);
		color: white;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
	}
	.spkerDiv{
		font-style: italic;
		text-align: right;
	}
	.diaDiv{
		text-align: left;
	}
	.initDisplayBoard {
		display: inline-block;
	}
	
	@media screen and (max-width: 991px) {
		.col-md-7 {
			overflow-y: scroll;
			max-height: calc(100% - 350px);
		}
	}

	@-webkit-keyframes flipOutY {
	  from {
	    -webkit-transform: perspective(400px);
	    transform: perspective(400px);
	  }

	  30% {
	    -webkit-transform: perspective(400px) rotate3d(0, 1, 0, 15deg);
	    transform: perspective(400px) rotate3d(0, 1, 0, 15deg);
	    opacity: 1;
	  }

	  to {
	    -webkit-transform: perspective(400px) rotate3d(0, 1, 0, -90deg);
	    transform: perspective(400px) rotate3d(0, 1, 0, -90deg);
	    opacity: 0;
	  }
	}

	@keyframes flipOutY {
	  from {
	    -webkit-transform: perspective(400px);
	    transform: perspective(400px);
	  }

	  30% {
	    -webkit-transform: perspective(400px) rotate3d(0, 1, 0, 15deg);
	    transform: perspective(400px) rotate3d(0, 1, 0, 15deg);
	    opacity: 1;
	  }

	  to {
	    -webkit-transform: perspective(400px) rotate3d(0, 1, 0, -90deg);
	    transform: perspective(400px) rotate3d(0, 1, 0, -90deg);
	    opacity: 0;
	  }
	}

	p {
		margin: 0 0 11px;
		font-family: 'Patrick Hand', cursive;
		max-width: 500px;
		font-size: 32px;
		color: white;
		margin-left: 21%;
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

<div class="col-md-7" style="margin-top: 10%;">

	<div class="wordLine" style="text-align: center; width: 100%">
		<div class="wordWrap"{{--  style="display: none;" --}}>
			<div class="flexContainer">
				<div class="wrapLine">
					@foreach ($elementData as $key)
					<p>{{ $key->content }}</p>
					@endforeach
				</div>
				<div class="btnBg">
					<img class="wordCloud" src="{{ asset('img/P7/newboard1.svg') }}" alt="start button">
				</div>
			</div>
		</div>
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
		playWord(this);
	});

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
						$('.wordWrap').click();
					}, 600);

				});
			}, 300);
		});
	}, 800);
</script>

<script>
	var audio_context;
	var recorder;
	var tl;

	var busyPlay, busyReplay, busyRecord, 
		enabledPlay, enabledReplay, enabledRecord, 
		disabledPlay, disabledReplay, disabledRecord;
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

	function chooseD(button){
		$('.dialogBtn').removeClass('selected').prop('disabled', false);
		$(button).addClass('selected').prop('disabled', true);

		var dialogNow = button.getAttribute('data-dialogNo');
		
		var elementData = <?php echo json_encode($elementData); ?>;
		editContent(elementData[dialogNow]);
		editAudio(elementData[dialogNow]);
	}

	function editContent(element) {
		$('.wordWrap').removeClass('pulse').addClass('flipOutY').show().one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {

			while (document.getElementsByClassName("wrapLine")[0].firstChild) {
				document.getElementsByClassName("wrapLine")[0].removeChild(document.getElementsByClassName("wrapLine")[0].firstChild);
			}

			var lines = element.dialogue.split('|');
			for (var i = 0; i < lines.length; i++) {
				var line = document.createElement('div');
				line.className = 'line';

				var lineContent = lines[i].split('*');

				var spkerDiv = document.createElement('div');
				spkerDiv.className = 'tbn word writtenFont spkerDiv col-xs-4';
				spkerDiv.innerHTML = lineContent[0];
				line.appendChild(spkerDiv);

				var diaDiv = document.createElement('div');
				diaDiv.className = 'tbn word writtenFont diaDiv col-xs-8';
				diaDiv.innerHTML = lineContent[1];
				line.appendChild(diaDiv);

				document.getElementsByClassName("wrapLine")[0].appendChild(line);
			}

			$('.wordWrap').removeClass('flipOutY').addClass('flipInY').show().one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function play() {

				$('.wordWrap').off('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend');
					setTimeout(function() {
						$('.wordWrap').click();
					}, 600);
			});
		});
	}

	function editAudio(element) {
		document.getElementById('sample').setAttribute('src', '{{ asset('') }}' + element.audio);
		document.getElementById('sample').load();
	}

	function playWord(button) {
		$('.wordWrap').removeClass('flipInY pulse').addClass('pulse');
		var audio = document.getElementById("sample");

		$('#sample')[0].pause();
		$('#sample')[0].currentTime = 0;
		$('#sample')[0].play();

		setTimeout(function() {
			enableControl('replay');
			enableControl('record');
		}, $('#sample')[0].duration*1000);

		disableControl('replay');
		disableControl('record');
	}

	function playRecord() {
		if ( $('#auRecord').attr('src') ) {
			$('#auRecord')[0].pause();
			$('#auRecord')[0].currentTime = 0;
			$('#auRecord')[0].play();

			$('.replay').addClass('red');
			setTimeout(function() {
				$('.replay').removeClass('red');

				enableControl('replay');
				enableControl('record');
				enableControl('wordWrap');
			}, $('#auRecord')[0].duration*1000);

			busyControl('replay');
			disableControl('record');
			disableControl('wordWrap');
		} else {
			$('#alert').fadeIn(600);

			setTimeout(function() {
				$('.record').addClass('animated flash').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
					$('.record').removeClass('animated flash');

					setTimeout(function() {
						$('#alert').fadeOut(600);
					}, 1000);
				});
			}, 500);
		}
	}

	function disableControl(control) {
		if (control != 'wordWrap') {
			controlHolder = document.getElementsByClassName(control)[0];
			while (controlHolder.firstChild) {
				controlHolder.removeChild(controlHolder.firstChild);
			}
		}

		if (control == 'play') {
			controlHolder.appendChild(disabledPlay);
			$('.play').unbind('click');
		} else if (control == 'replay') {
			controlHolder.appendChild(disabledReplay);
			$('.replay').unbind('click');
		} else if (control == 'record') {
			controlHolder.appendChild(disabledRecord);
			$('.record').unbind('click');
		} else if (control == 'wordWrap') {
			$('.wordWrap').unbind('click');
		}
	}

	function enableControl(control) {
		if (control != 'wordWrap') {
			controlHolder = document.getElementsByClassName(control)[0];
			while (controlHolder.firstChild) {
				controlHolder.removeChild(controlHolder.firstChild);
			}
		}

		if (control == 'play') {
			controlHolder.appendChild(enabledPlay);
			$('.play').click(function() {
				playSample(this);
			});
		} else if (control == 'replay') {
			controlHolder.appendChild(enabledReplay);
			$('.replay').click(function() {
				playRecord();
			});
		} else if (control == 'record') {
			controlHolder.appendChild(enabledRecord);
			$('.record').click(function() {
				startRecording(this);
			});
		} else if (control == 'wordWrap') {
			$('.wordWrap').click(function() {
				playWord(this);
			});
		}
	}

	function busyControl(control) {
		controlHolder = document.getElementsByClassName(control)[0];
		while (controlHolder.firstChild) {
			controlHolder.removeChild(controlHolder.firstChild);
		}

		if (control == 'play') {
			controlHolder.appendChild(busyPlay);
			$('.play').unbind('click');
		} else if (control == 'replay') {
			controlHolder.appendChild(busyReplay);
			$('.replay').unbind('click');
		} else if (control == 'record') {
			controlHolder.appendChild(busyRecord);
			$('.record').unbind('click');
		}
	}

	function startUserMedia(stream) {
		var input = audio_context.createMediaStreamSource(stream);

		recorder = new Recorder(input);
	}

	function startRecording(button) {
		recorder && recorder.record();
		$('.record').addClass('red');

		setTimeout(function() {
			recorder && recorder.stop();

			createMedia();

			recorder.clear();

			$('#playRecord').show();
			$('.record').removeClass('red');

			enableControl('replay');
			enableControl('record');
			enableControl('wordWrap');
		}, 30000);

		busyControl('record');
		disableControl('replay');
		disableControl('wordWrap');
	}

	function createMedia() {
		recorder && recorder.exportWAV(function(blob) {
			var url = URL.createObjectURL(blob);
			var auRecord = document.getElementById("auRecord");

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
<script src="{{ asset('js/recorder.js') }}"></script>

@stop

@section('actDescription-vi')
	Sau khi chuẩn bị xong, hãy ghi âm và nghe lại bài giới thiệu của mình.
@stop

@section('actDescription-en')
	Record and playback your introduction after your preparation.
@stop