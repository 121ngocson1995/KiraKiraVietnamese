if (elementData[0].audio) {
	$('#wrapper').css('top', '233px');
}

var index = 0;

$('#pStart').click(function() {
	toggleSample(this);
});

$('#imgStart').click(function() {
	toggleSample(this);
});

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
		console.log($('#audio'+index)[0]);
		if($('#audio'+index)[0]) {
			stopAudio();
		}
		$('a.panelt').removeClass('selected');
		$(this).addClass('selected');
		current = $(this);
		$('#wrapper').scrollTo($(this).attr('href'), 800);
		
		index = parseInt($(this).attr('id'));
		if(!elementData[index].audio)
		{
			if ($('#btnStart').is(':visible')) {
				$('#btnStart').hide();
				$('#wrapper').css('top', '125px');
			}
		}
		else {
			if (!$('#btnStart').is(':visible')) {
				$('#btnStart').show();
				$('#wrapper').css('top', '233px');
			}
		}
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
});
function resizePanelt() {
	width = $(window).width();
	height = $(window).height();
	mask_width = width * $('.part').length;
	$('#debug').html(width + ' ' + height + ' ' + mask_width);
	$('#wrapper, .part').css({
		width: width,
		height: height
	});
	$('#mask').css({
		width: mask_width,
		height: height
	});
	$('#wrapper').scrollTo($('a.selected').attr('href'), 0);
}