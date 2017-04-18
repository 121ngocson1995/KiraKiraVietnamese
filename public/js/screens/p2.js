var docBar;
var playingSample = -1;
var tlFinalScore;

initAudio();

function check(word) {
	if (isCorrect(word)) {
		displayCorrect(word);
	} else {
		displayWrong(word);
	}
}

function isCorrect(word) {
	return 'audio' + $(word).find('p').attr("id") == playingSample;
}

function displayCorrect(button) {
	$(button).removeClass("notChosen");
	$(button).addClass("p2correctWord");
	$(button).prop("disabled", true);
	$(".p2wrongWord").removeClass("p2wrongWord").addClass("notChosen");
	changeScore('correct', '' + (parseInt(document.getElementById('correct').innerHTML)  + 1));
	$(button).unbind('click');
	happyFace();
	correctSFX();
}

function displayWrong(button) {
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
		check(this);
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

	$("#btnStart").fadeOut(500, function() {
		var tl = new TimelineMax();
		tl.to('#imgRestart', 30, {rotation:-720, repeat:-1, ease: Power1.easeInOut, yoyo:true});
		$("#btnRestart").fadeIn(500);
	});
}

function restart() {
	if (playTimeout) {
		clearTimeout(playTimeout);
	}

	$('#pRestart').unbind('click');
	$('#imgRestart').unbind('click');

	document.getElementById('correct').innerHTML = '0';
	document.getElementById('total').innerHTML = '/0'
	resetAudio();
	showScore();
	initScore();
	showSmiley();
	happyFace();
	hideWords();
}

function resetAudio() {
	$('audio').each(function() {
		this.pause();
		this.currentTime = 0;
	});
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
	document.getElementById('correct').innerHTML = '0';
	document.getElementById('total').innerHTML = '/0';

	if (docBar) {
		docBar.set(1);
	}
}

function hideWords() {
	var tl = new TimelineMax({
		onComplete: init
	});
	tl.staggerFromTo('.wordSpan', 0.5, {opactiry:1, scale:1}, {opacity:0, scale:0}, 0.2);
}

function init() {
	shuffle(elementData);
	shuffle(textRender);

	initWords();
	showWords();
	initAudio();
}

function showWords() {
	var tl = new TimelineMax({
		onComplete: function() {
			$('#pRestart').click(function() {
				restart();
			});

			$('#imgRestart').click(function() {
				restart();
			});

			$('.wordSpan').bind('click', function() {
				check(this);
			});

			playSample(0);
			startProgressbar();
		}
	});
	tl.staggerFromTo('.wordSpan', 0.5, {opacity:0, scale:0}, {opacity:1, scale:1}, 0.2);
}

function shuffle(o) {
	for(var j, x, i = o.length; i; j = parseInt(Math.random() * i), x = o[--i], o[i] = o[j], o[j] = x);
	return o;
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

var wordTime = 0;
var wordNo = 0;

function initWords() {
	var wordGroup = document.getElementById('wordGroup');

	while (wordGroup.firstChild) {
		wordGroup.removeChild(wordGroup.firstChild);
	}

	for (var i = 0; i < textRender.length; i++) {
		var wordSpan = document.createElement('div');
		wordSpan.className = 'wordSpan';

		var flexContainer = document.createElement('div');
		flexContainer.className = 'flexContainer';

		var word = document.createElement('p');
		word.id = textRender[i].id;
		word.className = 'tbn word writtenFont';
		word.innerHTML = textRender[i].word;
		flexContainer.appendChild(word);

		var btnBg = document.createElement('div');
		btnBg.className = 'btnBg';

		var wordCloud = document.createElement('img');
		wordCloud.className = 'wordCloud';
		wordCloud.src = assetPath + 'img/testAnimate/wordCloud.svg';
		btnBg.appendChild(wordCloud);

		flexContainer.appendChild(btnBg);
		wordSpan.appendChild(flexContainer);
		wordGroup.appendChild(wordSpan);
	}
}

function initAudio() {
	var sampleGroup = document.getElementById('sampleGroup');

	while (sampleGroup.firstChild) {
		sampleGroup.removeChild(sampleGroup.firstChild);
	}

	for (var i = 0; i < elementData.length; i++) {
		var audioFile = document.createElement("audio");
		audioFile.id = 'audio' + elementData[i].id;
		audioFile.innerHTML  = "<source src='" + assetPath + elementData[i].audio + "' type='audio/mp3'>";
		sampleGroup.appendChild(audioFile);

		if (!isNaN(audioFile.duration)) {
			checkTickLoad(this.duration);
		} else {
			audioFile.addEventListener('loadedmetadata', function() {
				checkTickLoad(this.duration);
			});
		}
	}
}

function checkTickLoad(duration) {
	wordNo++;
	wordTime += duration;

	if (wordNo == elementData.length) {
		var tick = document.getElementById('tick');
		if (!isNaN(tick.duration)) {
			buildProgressBar(wordTime + wordNo * tick.duration);
		} else {
			tick.addEventListener('loadedmetadata', function() {
				buildProgressBar(wordTime + wordNo * this.duration);
			});
		}
	}
}

function buildProgressBar(totalTime) {
	docBar = new ProgressBar.Line("#progressbarContainer", {
		strokeWidth: 1,
		duration: totalTime * 1000,
		color: '#FFEA82',
		trailColor: '#eee',
		trailWidth: 1,
		svgStyle: {width: '100%', height: '200%'},
		from: {color: '#ED6A5A'},
		to: {color: '#1affa3'},
		step: (state, bar) => {
			bar.path.setAttribute('stroke', state.color);
		}
	});
	docBar.set(1);
}