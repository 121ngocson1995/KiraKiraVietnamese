var audio_context;
var recorder;
var tl;

function chooseDialog(button){
	$('.dialogBtn').removeClass('selected').prop('disabled', false);
	$(button).addClass('selected').prop('disabled', true);

	stopReplay();
	if (isRecording) {
		clearTimeout(recordTimeout);
		stopRecording(false);
	}

	if (playRecordTimeout) {
		clearTimeout(playRecordTimeout);
	}

	var dialogNow = button.getAttribute('data-dialogNo');

	editContent(elementData[dialogNow]);
	editAudio(elementData[dialogNow]);
}

function togglePlaySample() {
	if (wordIsPlaying()) {
		stopReadWord();
	} else {
		readWord();
	}
}

function wordIsPlaying() {
	return !$('#sample')[0].paused;
}

function stopReplay() {
	if ($('#auRecord')[0].currentTime != 0) {
		$('#auRecord')[0].pause();
		$('#auRecord')[0].currentTime = 0;

		$('.replay').removeClass('red');
	}

	disableControl('replay');
	disableControl('record');
	disableControl('wordWrap');
}

function editContent(element) {
	$('.wordWrap').unbind('click');

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
				if (!$._data( document.getElementsByClassName('wordWrap')[0], "events" )) {
					$('.wordWrap').click(function() {
						togglePlaySample(this);
					});
				}
				$('.wordWrap').click();
			}, 600);
		});
	});
}

function editAudio(element) {
	document.getElementById('sample').setAttribute('src', assetPath + element.audio);
	document.getElementById('sample').load();
}

var recordTimeout;
var playRecordTimeout;
var readWordTimeout;

function readWord() {
	pulseDialogHolder();

	$('#sample')[0].pause();
	$('#sample')[0].currentTime = 0;
	$('#sample')[0].play();

	if (readWordTimeout) {
		clearTimeout(readWordTimeout);
	}
	readWordTimeout = setTimeout(function() {
		enableControl('replay');
		enableControl('record');
	}, $('#sample')[0].duration*1000);

	disableControl('replay');
	disableControl('record');
}

function stopReadWord() {
	$('#sample')[0].pause();
	$('#sample')[0].currentTime = 0;

	if (readWordTimeout) {
		clearTimeout(readWordTimeout);
	}
	enableControl('replay');
	enableControl('record');
}

function pulseDialogHolder() {
	button = document.getElementsByClassName('wordWrap')[0];
	button.classList.remove("flipInY");
	button.classList.remove("pulse");
	button.offsetWidth;
	button.classList.add("pulse");
}

function playRecord() {
	if ( $('#auRecord').attr('src') ) {
		$('#auRecord')[0].pause();
		$('#auRecord')[0].currentTime = 0;
		$('#auRecord')[0].play();

		$('.replay').addClass('red');
		playRecordTimeout = setTimeout(function() {
			$('.replay').removeClass('red');

			enableControl('replay');
			enableControl('record');
			enableControl('wordWrap');
		}, $('#auRecord')[0].duration*1000);

		busyControl('replay');
		disableControl('record');
		disableControl('wordWrap');
	} else {
		document.getElementById('alert').innerHTML = 'To record your voice, first click on the record sign at the middle.';
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

	if (control == 'replay') {
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

	if (control == 'replay') {
		controlHolder.appendChild(enabledReplay);
		$('.replay').click(function() {
			playRecord();
		});
	} else if (control == 'record') {
		controlHolder.appendChild(enabledRecord);
		$('.record').unbind('click');
		$('.record').removeClass('toPause').addClass('toRecord').click(function() {
			startRecording(this);
		});
	} else if (control == 'wordWrap') {
		$('.wordWrap').click(function() {
			togglePlaySample(this);
		});
	}
}

function busyControl(control) {
	controlHolder = document.getElementsByClassName(control)[0];
	while (controlHolder.firstChild) {
		controlHolder.removeChild(controlHolder.firstChild);
	}

	if (control == 'replay') {
		controlHolder.appendChild(busyReplay);
		$('.replay').unbind('click');
	} else if (control == 'record') {
		controlHolder.appendChild(busyRecord);
		$('.record').unbind('click');
		$('.record').click(function() {
			stopRecording(true);
		});
	}
}

var isRecording = false;

function startRecording(button) {
	isRecording = true;
	recorder && recorder.record();
	$('.record').removeClass('toRecord').addClass('red toPause');

	setTimeout(function() {
		if($('.record').hasClass('toPause')) {
			recordTimeout = stopRecording(true);
		}
	}, 60000);

	busyControl('record');
	disableControl('replay');
	disableControl('wordWrap');

	document.getElementById('alert').innerHTML = "Once you're done, click the record button again to stop recording";
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

function stopRecording(enableButtons) {
	isRecording = false;
	recorder && recorder.stop();

	createMedia();

	recorder.clear();

	$('.record').removeClass('red toPause').addClass('toRecord');

	if (enableButtons) {
		enableControl('replay');
		enableControl('record');
		enableControl('wordWrap');
	}
}

function createMedia() {
	recorder && recorder.exportWAV(function(blob) {
		var url = URL.createObjectURL(blob);
		var auRecord = document.getElementById("auRecord");

		auRecord.src = url;
		localStorage.setItem("record", url);
	});
}