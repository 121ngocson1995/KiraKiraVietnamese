var tl;
var readWordTimeout;

function readWord(button) {
	var audio = document.getElementById("sample");

	audio.src = assetPath + button.getAttribute('data-audio-source');
	audio.play();

	var duration = 1;
	if(tl) {
		tl.seek(0).pause();
	}
	tl = new TimelineMax({
		onComplete:complete,
		onCompleteParams:['{self}']});
	TweenMax.to(button, duration / 4, {y:-20, ease:Power2.easeOut});
	TweenMax.to(button, duration / 2, {y:0, ease:Bounce.easeOut, delay:duration / 4});
	setTimeout(function() {
		tl.to(button, duration / 4, {y:-20, ease:Power2.easeOut}, 1).to(button, duration / 2, {y:0, ease:Bounce.easeOut});
	}, 1040);

	function complete(tl) {
		tl.restart();
	}

	function doNothing() {}

	document.getElementById("sample").addEventListener('loadedmetadata', function toEnableBtn() {
		if (readWordTimeout) {
			clearTimeout(readWordTimeout);
		}
		readWordTimeout = setTimeout(function() {
			document.getElementById("sample").removeEventListener('loadedmetadata', toEnableBtn);

			enableControl('replay');
			enableControl('record');
		}, $('#sample')[0].duration*1000);
	});

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
				$('#alert').fadeOut(600);
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
			readWord(this);
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
		stopRecording();
	}, 3000);

	busyControl('record');
	disableControl('replay');
	disableControl('wordWrap');
}

function stopRecording() {
	isRecording = false;
	recorder && recorder.stop();

	createMedia();

	recorder.clear();

	$('.record').removeClass('red toPause').addClass('toRecord');

	enableControl('replay');
	enableControl('record');
	enableControl('wordWrap');
}

function createMedia() {
	recorder && recorder.exportWAV(function(blob) {
		var url = URL.createObjectURL(blob);
		var auRecord = document.getElementById("auRecord");

		auRecord.src = url;
		localStorage.setItem("record", url);
	});
}