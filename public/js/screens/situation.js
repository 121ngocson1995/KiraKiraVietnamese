if (elementData[0].audio) {
	$('#wrapper').css('top', '198px');
}

var index = 0;

$('#pStart').click(function() {
	toggleSample(this);
});

$('#imgStart').click(function() {
	toggleSample(this);
});

function setIndex(node) {
	stopAudio();
	$('.btn').removeClass('selected');
	node.setAttribute('class', 'btn btn-default selected');
	index = node.getAttribute('data-index');
	$('#situation-group a button').prop('disabled', false);
	node.disabled = true;
	if(!elementData[index].audio)
	{
		if ($('#controlBtn').hasClass('in')) {
			$('#pStart').unbind('click');
			$('#imgStart').unbind('click');
			$('#collapsePlay').click();
		}
	}
	else {
		if (!$('#controlBtn').hasClass('in')) {
			$('#pStart').click(function() {
				toggleSample(this);
			});

			$('#imgStart').click(function() {
				toggleSample(this);
			});

			$('#collapsePlay').click();
		}
	}
}

function setIndexNote(node) {
	stopAudio();
	$('.btn').removeClass('selected');
	node.setAttribute('class', 'btn btn-success selected');
	$('#situation-group a button').prop('disabled', false);
	node.disabled = true;

	if ($('#controlBtn').hasClass('in')) {
		$('#pStart').unbind('click');
		$('#imgStart').unbind('click');
		$('#collapsePlay').click();
	}
}

function toggleSample(button) {
	if ($("#audio"+index)[0].paused) {
		playAudio();
	} else {
		pauseAudio();
	}
}

var audioTimeout;

function playAudio() {
	$('#pStart i').removeClass('fa-play').addClass('fa-pause fa-normal');
	$("#audio"+index)[0].play();

	if (audioTimeout) {
		clearTimeout(audioTimeout);
	}

	audioTimeout = setTimeout(function() {
		$('#pStart i').removeClass('fa-pause fa-normal').addClass('fa-play');
	}, (document.getElementById("audio"+index).duration - document.getElementById("audio"+index).currentTime) * 1000);
}

function pauseAudio() {
	$('#pStart i').removeClass('fa-pause fa-normal').addClass('fa-play');
	$("#audio"+index)[0].pause();
}

function stopAudio() {
	pauseAudio();
	$("#audio"+index)[0].currentTime = 0;
}

$(document).ready(function() {
	$('a.panelt').click(function() {
		$('a.panelt').removeClass('selected');
		$(this).addClass('selected');
		current = $(this);
		$('#wrapper').scrollTo($(this).attr('href'), 800);
		return false;
	});
	width = $(window).width();
	mask_width = width * $('.part').length;
	$('#wrapper, .part').css({
		width: width,
	});
	$('#mask').css({
		width: mask_width,
	});
	$(window).resize(function() {
		resizePanelt();
	});
	$('#situation-group a').prop('disabled', false);
	$('#situation-group a button').first().addClass('selected').prop('disabled', true);
});

function resizePanelt() {
	width = $(window).width();
	height = $(window).height();
	mask_width = width * $('.part').length;
	$('#debug').html(width + ' ' + height + ' ' + mask_width);
	$('#wrapper, .part').css({
		width: width,
	});
	$('#mask').css({
		width: mask_width,
	});
	$('#wrapper').scrollTo($('a.selected').attr('href'), 0);
}