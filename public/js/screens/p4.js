var docBar;
var playingSample = -1;
var tlFinalScore;

function chooseWord(button) {
	if ('audio' + $(button).find('p').attr("id") == playingSample) {
		correctChoice(button);
	} else {
		wrongChoice(button);
	}
}

function correctChoice(button) {
	$(button).removeClass("notChosen");
	$(button).addClass("p2correctWord");
	$(button).prop("disabled", true);
	$(".p2wrongWord").removeClass("p2wrongWord").addClass("notChosen");
	changeScore('correct', '' + (parseInt(document.getElementById('correct').innerHTML)  + 1));
	$(button).unbind('click');
	happyFace();
	correctSFX();
}

function wrongChoice(button) {
	$(button).removeClass("notChosen");
	$(button).addClass("p2wrongWord");
	sadFace();
	wrongSFX();
}

function happyFace() {
	var smiley = document.getElementById('smiley');
	smiley.classList.remove("happy");
	smiley.classList.remove("normal");
	smiley.offsetWidth;
	smiley.classList.add("happy");
}

function sadFace() {
	var smiley = document.getElementById('smiley');
	smiley.classList.remove("happy");
	smiley.classList.remove("normal");
	smiley.offsetWidth;
	smiley.classList.add("normal");
}

function start() {
	if (playTimeout) {
		clearTimeout(playTimeout);
	}

	$('.wordSpan').bind('click', function() {
		chooseWord(this);
	});

	chosenOrder = 0;

	$("#wordGroup").find(".wordSpan").prop("disabled", false);
	$("#wordGroup").find(".wordSpan").removeClass("p2wrongWord").removeClass("p2correctWord").addClass("notChosen");

	resetAudio();
	showScore();
	initScore();
	showSmiley();
	playSample(0);
	startProgressbar();

	$("#btnStart").prop("disabled", true);
	$("#btnRestart").prop("disabled", true);

	$("#btnStart").fadeOut(500, function() {
		var tl = new TimelineMax();
		tl.to('#imgRestart', 30, {rotation:-720, repeat:-1, ease: Power1.easeInOut, yoyo:true});
		$("#btnRestart").fadeIn(500);
	});
}

function resetAudio() {
	$('audio').each(function() {
		this.pause();
		this.currentTime = 0;
	})
}

function showScore() {
	if(tlFinalScore) {
		tlFinalScore.seek(0).pause();
	}

	if (!$('#resultHolder').is(':visible')) {
		$('#resultHolder').fadeIn(500);
	}
}

function showSmiley() {
	if (!$('#smiley').is(':visible')) {
		$('#smiley').fadeIn(500);
	}

	if (hideSmiley) {
		clearTimeout(hideSmiley);
	}
}

function initScore() {
	$('#resultContainer').show();
	// document.getElementById('scoreText').innerHTML = 'Score: ';
	document.getElementById('correct').innerHTML = '0';
	document.getElementById('total').innerHTML = '/0';

	if (docBar) {
		docBar.set(1);
	}
}

function changeScore(text, to) {
	var text = $('#'+text);
	var box = text.parent();
	var tl = new TimelineMax();
	tl.to(box, 0.25, {scale:1.4, ease:Power2.easeOut})
	.set(text, {text:to})
	.to(box, 0.25, {scale:1, ease:Power2.easeOut});
}

var playTimeout;

function playSample(index) {
	if(index == $("#sampleGroup audio").length) {
		$('.wordSpan').unbind('click');
		showResult();
		return;
	}
	$(".p2wrongWord").removeClass("p2wrongWord").addClass("notChosen");
	$('#sampleGroup').children().eq(index)[0].play();
	playingSample = $('#sampleGroup').children().eq(index)[0].id;
	changeScore('total', '/' + parseInt(index + 1));
	playTimeout = setTimeout(function() {
		$('#tick')[0].play();
		playTimeout = setTimeout(function() {
			playSample(++index);
		}, $('#tick')[0].duration * 1000);
	}, $('#sampleGroup').children().eq(index)[0].duration * 1000);
}

function startProgressbar() {
	if (docBar) {
		docBar.animate(0);
	}
}

var hideSmiley;

function showResult() {
	$(".notChosen").removeClass("notChosen").addClass("p2wrongWord");
	$("#wordGroup").find("button").prop("disabled", true);
	$("#btnRestart").prop("disabled", false);
	$("#btnRestart").show();

	if ($('#smiley').is(':visible')) {
		hideSmiley = setTimeout(function() {
			$('#smiley').fadeOut(500);	
		}, 1000);
	}

	var tl = new TimelineMax();
	tl.to('#resultInner', 0.25, {scale:1.4, ease:Power2.easeOut})
	.to('#resultInner', 0.25, {scale:1, ease:Power2.easeOut});
}