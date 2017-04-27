function next(button) {
	if (button.innerHTML == "Next") {
		switchQuestion(currentQuestion + 1);
	} else {
		showResult();
	}
}

function switchQuestion(questionId) {

	var btnNext = document.getElementsByClassName('btnNext')[0];
	$(btnNext).addClass('inv');

	if (questionId == 0) {
		showPaper();
		$('.btnNext').click(function () {
			next(this);
		});
	} else {
		var tl = new TimelineMax();
		tl.staggerTo('.answerLineItem', 0, {className:"+=animated flipOutX"}, 0.2);
		$('.answerLineItem').last().one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
			showPaper();
		});
	}

	function showPaper() {
		currentQuestion = questionId;

		if (currentQuestion == lastQuestion) {
			btnNext.innerHTML = 'Finish';
			if (questionsDone < lastQuestion + 1) {
				btnNext.disabled = true;
			} else {
				btnNext.disabled = false;
			}
		} else {
			btnNext.innerHTML = 'Next';
			btnNext.disabled = false;
		}

		$('#qText').empty();

		var problemArr = elementData[questionId].dialog.split("|");
		for (var i = 0; i < problemArr.length; i++) {
			var p = document.createElement('p');
			p.innerHTML = problemArr[i];
			document.getElementById("qText").appendChild(p);
		}

		$('#answerGroup').empty();

		var button = [];
		var chosenNo = 0;
		
		for (var i = 0; i <= 2; i++) {
			var toDisable = false;

			var answerLineItem = document.createElement('div');
			answerLineItem.className = 'answerLineItem';

			var answerFlex = document.createElement('div');
			answerFlex.className = 'answerFlex';

			var crossWrap = document.createElement('div');
			crossWrap.className = 'crossWrap';
			var imgCross  = document.createElement('img');
			imgCross.className = 'imgCross';
			imgCross.src = assetPath + 'img/P6/cross.svg';
			crossWrap.appendChild(imgCross);
			answerFlex.appendChild(crossWrap);

			var checkWrap = document.createElement('div');
			checkWrap.className = 'checkWrap';
			var imgCheck  = document.createElement('img');
			imgCheck.className = 'imgCheck';
			imgCheck.src = assetPath + 'img/P6/check.svg';
			checkWrap.appendChild(imgCheck);
			answerFlex.appendChild(checkWrap);

			var checkWrongWrap = document.createElement('div');
			checkWrongWrap.className = 'checkWrongWrap';
			var imgCheckWrong  = document.createElement('img');
			imgCheckWrong.className = 'imgCheckWrong';
			imgCheckWrong.src = assetPath + 'img/P6/checkWrong.svg';
			checkWrongWrap.appendChild(imgCheckWrong);
			answerFlex.appendChild(checkWrongWrap);

			button.push(document.createElement('button'));
			button[i].id = questionId;
			button[i].setAttribute('autocomplete', 'off');
			button[i].name = elementData[questionId].answerOrder[i];
			button[i].className = "btn-answer";

			if (elementData[questionId].answers[elementData[questionId].answerOrder[i]].chosen == true) {
				button[i].className += " chosen";
				chosenNo++;
				toDisable = true;
			}

			if (elementData[questionId].answerOrder[i] == "correctAnswer") {
				button[i].className += " correctAnswer";
			} else {
				button[i].className += " wrongAnswer";
			}

			button[i].innerHTML = elementData[questionId].answers[elementData[questionId].answerOrder[i]].content;

			button[i].onclick = function () {
				checkAnswer(button[i]);
			};

			if (toDisable == true) {
				button[i].disabled = true;
			}

			answerFlex.appendChild(button[i]);

			answerLineItem.appendChild(answerFlex);

			document.getElementById("answerGroup").appendChild(answerLineItem);
		}

		if (chosenNo == 3) {
			$('.btnNext').prop('disabled', false);
		} else {
			$('.btnNext').prop('disabled', true);
		}

		$('#navQ' + questionId).prop('disabled', false);
		
		$('.btn-answer').click(function () {
			checkAnswer(this);
		});

		prepareAnswer();

		$('#answerGroup > div').hover(
		function() {
			$(this).addClass('pop');
		}, 
		function() {
			$(this).removeClass('pop');
		});
	}
}

function checkAnswer(button) {
	var giveMark = true

	if ($(button).hasClass('correctAnswer')) {
		if ($(button).attr('name') == "correctAnswer") {
			elementData[parseInt($(button).attr('id'))].answers.correctAnswer.chosen = true;
		}

		markBtn('.btn-answer', true);
		correctSFX2();

		correctAnswerNo++;
		questionsDone++;

		var navQn = $(button).attr('id');
		$('#navQ'+navQn).removeClass('btn-warning');
		$('#navQ'+navQn).addClass('btn-success');
	} else if ($(button).hasClass('wrongAnswer')) {
		if ($(button).attr('name') == "wrongAnswer1") {
			elementData[parseInt($(button).attr('id'))].answers.wrongAnswer1.chosen = true;
		} else if ($(button).attr('name') == "wrongAnswer2") {
			elementData[parseInt($(button).attr('id'))].answers.wrongAnswer2.chosen = true;
		}

		markBtn(button, false);
		wrongSFX2();

		if ($('.chosen').length == 2) {

			markBtn('.btn-answer', false);
			questionsDone++;

			var navQn = $(button).attr('id');
			$('#navQ'+navQn).removeClass('btn-warning');
			$('#navQ'+navQn).addClass('btn-danger');
		}
	}
}

function markBtn(button, correctChoice) {
	if (button == ".btn-answer") {
		document.getElementsByClassName('btnNext')[0].disabled = false;

		$('.btn-answer').each(function() {
			if (!$(this).hasClass('chosen')) {
				var qName = this.name;
				if (qName == "correctAnswer") {
					elementData[parseInt($(this).attr('id'))].answers.correctAnswer.chosen = true;
					if (correctChoice) {
						if ($(this).hasClass('correctAnswer')) {
							TweenMax.fromTo($(this).parent().find('.checkWrap'), 0.35, {css:{width:0, height:0}}, {css:{width:100, height:'initial'}});
						}
					} else {
						if ($(this).hasClass('correctAnswer')) {
							TweenMax.fromTo($(this).parent().find('.checkWrongWrap'), 0.35, {css:{width:0, height:0}}, {css:{width:100, height:'initial'}});
						}
					}
				} else if (qName == "wrongAnswer1") {
					elementData[parseInt($(this).attr('id'))].answers.wrongAnswer1.chosen = true;
					if (!$("button[name='" + qName + "']").hasClass('marked')) {
						TweenMax.fromTo($(this).parent().find('.crossWrap'), 0.35, {css:{width:0, height:0}}, {css:{width:100, height:'initial'}});

						$(this).addClass('marked');
					}
				} else {
					elementData[parseInt($(this).attr('id'))].answers.wrongAnswer2.chosen = true;
					if (!$("button[name='" + qName + "']").hasClass('marked')) {
						TweenMax.fromTo($(this).parent().find('.crossWrap'), 0.35, {css:{width:0, height:0}}, {css:{width:100, height:'initial'}});

						$(this).addClass('marked');
					}
				}
			}
		});
	} else {
		if ($(button).hasClass('wrongAnswer')) {
			TweenMax.fromTo($(button).parent().find('.crossWrap'), 0.35, {css:{width:0, height:0}}, {css:{width:100, height:'initial'}});
		}

		$(button).addClass('marked');
	}

	$(button).addClass('chosen');
	$(button).prop('disabled', true);
}

function showResult() {
	var btnNext = document.getElementsByClassName('btnNext')[0];

	$('.answerLineItem').css('opacity', 0);
	$(btnNext).css('opacity', 0);
	btnNext.disabled = true;
	var result = document.createElement("div");
	result.className = 'score result';
	result.innerHTML = '' + correctAnswerNo + '/' + (lastQuestion + 1) + ' correct';
	$('#result').empty();
	document.getElementById("result").appendChild(result);
	$('#qText').fadeOut(600, function () {
		$('#result').fadeIn(600);
		// $('.score').addClass('animated zoomIn');
	});
}

function prepareAnswer() {
	var tl = new TimelineMax();
	tl.staggerFromTo('.answerLineItem', 0.4, {x:-50, y:50, opacity:0}, {x:0, y:0, opacity:1, clearProps:"transform"}, 0.2)
		  .set('.answerLineItem',{className:"+=pinch"})
		  .set('.btnNext',{className:"-=inv"});
}