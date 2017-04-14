function switchLanguage(board){
	var languageFrom, languageTo;
	if ($(board).hasClass('vietnamese')) {
		languageFrom = 'vietnamese';
		languageTo = 'english';
	} else {
		languageFrom = 'english';
		languageTo = 'vietnamese';
	}
	flipBoard(languageFrom, languageTo);
}

function flipBoard(languageFrom, languageTo) {
	$('.wordWrap2').unbind('click');
	$('.wordWrap2').unbind('mouseenter');
	$('.wordWrap2').unbind('mouseleave');

	$('.wordWrap2.' + languageFrom).removeClass('pulse infinite').addClass('flipOutY').show().one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {

		$('.wordWrap2.' + languageFrom).removeClass('flipOutY infinite animated').hide();

		$('.wordWrap2.' + languageTo).removeClass('flipOutY infinite').addClass('flipInY animated').show().one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function play() {

			$('.wordWrap2' + languageTo).off('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend');

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
	});
}

function editAudio(element) {
	document.getElementById('sample').setAttribute('src', assetPath + element.audio);
	document.getElementById('sample').load();
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
			switchLanguage(this);
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
			stopRecording(this);
		});
	}
}

function startRecording(button) {
	recorder && recorder.record();
	$('.record').removeClass('toRecord').addClass('red toPause');

	setTimeout(function() {
		if($('.record').hasClass('toPause')) {
			stopRecording(button);
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

function stopRecording(button) {
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