function help() {
	$('#helpBtn').fadeOut(500);
	$('.dragSentence').draggable('destroy');

	var answerFiltered = filterAnswer();

	/* revert all dragSentence objects to their original positions */
	var timeout = revertChosenSentences() ? 1500 : 0;

	/* Move all dragSentence objects to their correct positions */
	setTimeout(function() {
		reposition(0, 700, answerFiltered.bestAnswer, answerFiltered.blankIdList);
	}, timeout);

	totalQuestion++;
}

function filterAnswer() {
	var numberOfCorrect = 0;
	var answerListId = 0;

	var answer = [];

	$('.dropSentence').each(function() {
		if ($(this).data('curDrag')) {
			answer.push($(this).data('curDrag').html().replace('<span>', '').replace('</span>', ''));
		} else {
			answer.push('');
		}
	});

	var blanks = [];
	for (var i = 0; i < elementData.length; i++) {
		blanks.push(i);
	}

	for (var i = 0; i < correctAnswerList.length; i++) {

		var correct = 0;
		var currentBlanks = [];
		for (var j = 0; j < answer.length; j++) {
			if (answer[j] == correctAnswerList[i][j]) {
				correct++;
			} else {
				currentBlanks.push(j);
			}
		}

		if (correct > numberOfCorrect) {
			numberOfCorrect = correct;
			blanks = currentBlanks;
			answerListId = i;
		}

	}

	markCorrect(answer, answerListId);

	var result = {bestAnswer: answerListId, blankIdList: blanks};

	return result;
}

function markCorrect(answer, answerListId) {
	for (var j = 0; j < answer.length; j++) {

		if (answer[j] == correctAnswerList[answerListId][j]) {
			$('.dropSentence').eq(j).addClass('ordered');
			$('.dropSentence').eq(j).data('curDrag').addClass('ordered');
		}

	}
}

function revertChosenSentences() {
	var revert = false;

	$('.dropSentence:not(.ordered)').each(function() {
		if ($(this).data('curDrag')) {
			var lastDrag = $(this).data('curDrag');

			lastDrag.css('transition', '1s');
			lastDrag.css('top', 0);
			lastDrag.css('left', 0);
			lastDrag.removeData('curDrop');
			$(this).removeData('curDrag');

			setTimeout(function() {
				lastDrag.css('transition', '');
			}, 1000);

			revert = true;
		}
	});

	return revert;
}

function reposition(i, timeout, bestAnswer, blankIdList) {
	loopDrag:
	for (var j = 0; j < $('.dragSentence:not(.ordered)').length; j++) {
		if($($('.dragSentence:not(.ordered)')[j]).find('span').html() == correctAnswerList[bestAnswer][blankIdList[i]]) {

			var dragSentence = $('.dragSentence:not(.ordered)')[j];

			$(dragSentence).position({
				my: "center",
				at: "center",
				of: $('.dropSentence')[blankIdList[i]],
				using: function(pos) {
					$(this).animate(pos, timeout, "swing");
				}
			});
			$($('.dropSentence')[i]).css('height', $(dragSentence).css('height'));

			$(dragSentence).addClass('ordered');
			break loopDrag;
		}
	}

	if (i < blankIdList.length) {
		setTimeout(function() {
			reposition(++i, 500, bestAnswer, blankIdList);
		}, timeout);
	} else {
		setTimeout(function() {
			$('#tryAgainBtn2Holder').show();
			$('#tryAgainBtn2Holder').addClass('animated rotateIn').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
				$(this).removeClass('animated rotateIn');
			});
		}, 500);
		return;
	}
}

function initDroppable() {
	$(".dragSentence").draggable({
		create: function(){
			$(this).data('position',$(this).position());
		},
		cursor:'move',
		// cursorAt: { top: this.clientHeight / 2, left: this.clientWidth / 2 },
		drag: function(){
			$(this).css('background', 'gold');
		},
		stop: function(){
			$(this).css('background', '#e6e6e6');
		},
		// cursorAt: { left: Math.floor(this.width / 2), top: Math.floor(this.height / 2) },
		// start:function(){$(this).stop(true,true)},
		revert: 'invalid',
		start:function(){
			$(this).stop(true,true);
		},
		stack: ".dragSentence"
	});

	$('.dropSentence').droppable({
		over: function(event, ui) {
			$(this).addClass('dropPulse');
			var dropTarget = $(this);
			dropInitialHeight = dropTarget.css('height');
			if (parseFloat(ui.draggable.css('height')) > parseFloat(dropInitialHeight)) {
				dropTarget.css('height', ui.draggable.css('height'));
			}

			/* change position of draggable element along with drop target */
			$('.dropSentence').each(function() {
				if ($(this).data('curDrag') != ui.draggable) {
					rePosition($(this), $(this).data('curDrag'));
				}
			})
		},
		out: function(event, ui) {
			$(this).removeClass('dropPulse');
			var dropTarget = $(this);
			dropTarget.css('height', dropInitialHeight);

			/* change position of draggable element along with drop target */
			$('.dropSentence').each(function() {
				if ($(this).data('curDrag') != ui.draggable) {
					rePosition($(this), $(this).data('curDrag'));
				}
			})
		},
		drop: function(event, ui) {
			$(this).removeClass('dropPulse');
			/* exhange draggable element if drop target already have one */
			if($(this).data('curDrag')) {
				var lastDrag = $(this).data('curDrag');
				
				if (ui.draggable.data('curDrop')) {
					var lastDrop = ui.draggable.data('curDrop');
					lastDrop.css('height', lastDrag.css('height'));
					lastDrag.position({
						my: "center",
						at: "center",
						of: lastDrop,
						using: function(pos) {
							$(this).animate(pos, 0, "linear");
						}
					});
					lastDrop.data('curDrag', lastDrag);
					lastDrag.data('curDrop', lastDrop);
				} else {
					lastDrag.css('top', 0);
					lastDrag.css('left', 0);
					lastDrag.css('background', '#e6e6e6');
					ui.draggable.css('background', 'initial');
					lastDrag.removeData('curDrop');
				}
			} else {
				$(ui.draggable.data('curDrop')).removeData('curDrag');
			}

			/* position draggable elemtn at the middle of drop target */
			var dropTarget = $(this);
			dropTarget.css('height', ui.draggable.css('height'));

			ui.draggable.position({
				my: "center",
				at: "center",
				of: dropTarget,
				using: function(pos) {
					$(this).animate(pos, 200, "linear");
					setTimeout(function() {
						ui.draggable.css('background', '#e6e6e6');
					}, 200);
				}
			});

			dropTarget.data('curDrag', ui.draggable);
			ui.draggable.data('curDrop', dropTarget);
			checkAnswer();

			$('.dropSentence').each(function() {
				rePosition($(this), $(this).data('curDrag'));
			})
		}
	});
}

function rePosition(drop, drag) {
	/* change position of draggable element along with drop target */
	if (drop.data('curDrag')) {
		drag.position({
			my: "center",
			at: "center",
			of: drop,
			using: function(pos) {
				$(this).animate(pos, 0, "linear");
			}
		});
	}
}

function checkAnswer() {
	var answer = [];

	$('.dropSentence').each(function() {
		if ($(this).data('curDrag')) {
			answer.push($(this).data('curDrag').html().replace('<span>', '').replace('</span>', ''));
		}
	});

	if (answer.length == correctAnswerList[0].length) {
		$('#helpBtn').fadeOut(500);

		if (answerIsCorrect(answer, correctAnswerList) == true) {
			showScore(true);
			showCorrect();
		} else {
			showScore(false);
			showWrong();
		}
	}
}

function answerIsCorrect(answer, correctAnswerList) {
	var allCorrect = true;

	for (var i = 0; i < correctAnswerList.length; i++) {
		allCorrect = true;

		for (var j = 0; j < answer.length; j++) {
			if (answer[j] != correctAnswerList[i][j]) {
				allCorrect = false;
				break;
			}
		}

		if (allCorrect) {
			break;
		}
	}

	return allCorrect;
}

function showCorrect() {
	$('#draggable').fadeOut(500);
	$('#droppable').fadeOut(500, function () {
		$('.fullscreenDiv').css('top', 'initial');
		$('.fullscreenDiv').css('bottom', 'initial');

		$('#resultContainer').fadeIn(500);
		$('#nextBtn').fadeIn(500);
		document.getElementById('happy').checked = true;
	});
}

function showWrong() {
	$('#draggable').fadeOut(500);
	$('#droppable').fadeOut(500, function () {
		$('.fullscreenDiv').css('top', 'initial');
		$('.fullscreenDiv').css('bottom', 'initial');

		$('#resultContainer').fadeIn(500);
		$('#tryAgainBtn').fadeIn(500);
		document.getElementById('normal').checked = true;
	});
}

function showScore(isCorrect) {
	$('#correct').html(isCorrect ? ++correctNo : correctNo);
	$('#total').html('/' + ++totalQuestion + (totalQuestion == 1 ? ' try' : ' tries'));
}

function redo() {
	var droppable = document.getElementById('droppable');
	emptyDiv(droppable);
	var draggable = document.getElementById('draggable');
	emptyDiv(draggable);

	shuffleSentence();
	for (var i = 0; i < elementData.length; i++) {
		var newDrop = document.createElement('div');
		newDrop.className = 'dropSentence';
		document.getElementById('droppable').appendChild(newDrop);

		var newDrag = document.createElement('div');
		newDrag.className = 'dragSentence';
		newDrag.innerHTML = '<span>' + elementData[i].sentence + '</span>';
		document.getElementById('draggable').appendChild(newDrag);
	}

	$('#resultContainer').fadeOut(500, function() {
		if ($('#tryAgainBtn2Holder').is(':visible')) {
			$('#tryAgainBtn2Holder').addClass('animated rotateOut').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
				$(this).removeClass('animated rotateOut').hide();
				showQuestion();
			});
		} else {
			showQuestion();
		}
	});

	if ($('#tryAgainBtn').css('display') != 'none') {
		$('#tryAgainBtn').fadeOut(500);
	}

	if ($('#nextBtn').css('display') != 'none') {
		$('#nextBtn').fadeOut(500);
	}

	initDroppable();

	function showQuestion() {
		$('.fullscreenDiv').css('top', '65px');
		$('.fullscreenDiv').css('bottom', 0);

		$('#draggable').show();
		$('#droppable').show();
		TweenMax.staggerFromTo('.dragSentence', 0.5, {x:-150, y:50, opacity:0}, {x:0, y:0, opacity:1, clearProps:"transform"}, 0.2);
		TweenMax.staggerFromTo('.dropSentence', 0.5, {x:150, y:50, opacity:0}, {x:0, y:0, opacity:1, clearProps:"transform"}, 0.2);
		TweenLite.set('#helpBtn', {display: '', opacity: 1, className:'+=animated zoomIn', delay: 1.5});
		document.getElementById('normal').checked = true;
	}
}

function shuffleSentence() {
	var doAgain = true;
	while(doAgain) {
		doAgain = true;

		Shuffle(elementData);

		for (var i = 0; i < elementData.length - 1; i++) {
			if (parseInt(elementData[i].correctOrder) != parseInt(elementData[i+1].correctOrder) - 1) {
				doAgain = false;
				break;
			}
		}
	}
}

function Shuffle(o) {
	for(var j, x, i = o.length; i; j = parseInt(Math.random() * i), x = o[--i], o[i] = o[j], o[j] = x);
	return o;
};

function emptyDiv(div) {
	while(div.firstChild){
		div.removeChild(div.firstChild);
	}
}