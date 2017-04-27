window.onresize = function() {
	$('.dropWord').each(function() {
		rePosition($(this), $(this).data('curDrag'));
	});
}

window.onload = function() {
	initDroppable();
}

function initDroppable() {
	$(".dragWord").draggable({
		create: function(){
			$(this).data('position',$(this).position());
		},
		cursor:'move',
		// cursorAt: { left: Math.floor(this.width / 2), top: Math.floor(this.height / 2) },
		// start:function(){$(this).stop(true,true)},
		revert: function(is_valid_drop) {
			if(!is_valid_drop){
				$(this).removeClass('gold');
				return true;
			}
		},
		start:function(){
			$(this).stop(true,true);
			$(this).addClass('gold');
		},
		stack: ".dragWord"
	});

	$('.dropWord').droppable({
		over: function(event, ui) {
			var dropTarget = $(this);
			dropInitialWidth = dropTarget.css('width');
			if (parseFloat(ui.draggable.css('width')) > parseFloat(dropInitialWidth)) {
				dropTarget.css('width', ui.draggable.css('width'));
			}

			/* change position of draggable element along with drop target */
			//  ドロップタゲットと一緒にドラッグの可能な位置変更する。
			$('.dropWord').each(function() {
				if ($(this).data('curDrag') != ui.draggable) {
					rePosition($(this), $(this).data('curDrag'));
				}
			})
		},
		out: function(event, ui) {
			var dropTarget = $(this);
			dropTarget.css('width', dropInitialWidth);

			/* change position of draggable element along with drop target */
			// ドロップタゲットと一緒にドラッグの可能な要素位置変更する。
			$('.dropWord').each(function() {
				if ($(this).data('curDrag') != ui.draggable) {
					rePosition($(this), $(this).data('curDrag'));
				}
			})
		},
		drop: function(event, ui) {
			/* exhange draggable element if drop target already have one */
			// ドロップタゲットが１つあったら、ドラッグの可能な要素を交換する。
			if($(this).data('curDrag')) {
				var lastDrag = $(this).data('curDrag');
				
				if (ui.draggable.data('curDrop')) {
					var lastDrop = ui.draggable.data('curDrop');
					lastDrop.css('width', lastDrag.css('width'));
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
					lastDrag.removeClass('gold initial');
					ui.draggable.removeClass('gold').addClass('initial');
					lastDrag.removeData('curDrop');
					$(lastDrag).css('color', 'initial');
				}
			} else {
				$(ui.draggable.data('curDrop')).removeData('curDrag');
			}

			/* place draggable element at the middle of drop target */
			// ドロップタゲットの中間でドラッグの可能な要素を位置する。
			var dropTarget = $(this);
			dropTarget.css('width', ui.draggable.css('width'));

			ui.draggable.position({
				my: "center",
				at: "center",
				of: dropTarget,
				using: function(pos) {
					$(this).animate(pos, 200, "linear");
					setTimeout(function() {
						ui.draggable.removeClass('gold').addClass('initial');
					}, 200);
				}
			});

			dropTarget.data('curDrag', ui.draggable);
			ui.draggable.data('curDrop', dropTarget);
			checkAnswer();

			$('.dropWord').each(function() {
				rePosition($(this), $(this).data('curDrag'));
			})

			$(ui.draggable).css('color', 'white');
		}
	});
}

document.getElementById('normal').checked = true;

function rePosition(drop, drag) {
	/* change position of draggable element along with drop target */
	// ドロップタゲットと一緒にドラッグの可能な要素位置変更する。
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
	var order = [];
	sentence = [];

	$('.dropWord').each(function() {
		if ($(this).data('curDrag')) {
			order.push($(this).data('curDrag').attr('id'));
			sentence.push($(this).data('curDrag').html().replace('<span>', '').replace('</span>', ''));
		}
	});

	if (order.length == $('.dragWord').length) {
		var allCorrect = true;
		for (var i = 1; i < order.length; i++) {
			if (parseInt(order[i]) != parseInt(order[i-1]) + 1) {
				allCorrect = false;
			}
		}

		if (allCorrect == true) {
			showScore(true);
			showCorrect(sentence);
		} else {
			showScore(false);
			showWrong();
		}
	}
}

function showCorrect(correctSentence) {
	var result = document.createElement("span");
	result.className = 'result';
	result.innerHTML = mergeWord(correctSentence);
	var resultDiv = document.getElementById("result");
	emptyDiv(resultDiv);
	resultDiv.appendChild(result);
	$('#draggable').fadeOut(500);
	$('#droppable').fadeOut(500, function () {
		$('.fullscreenDiv').css('top', 'initial');
		$('.fullscreenDiv').css('bottom', 'initial');

		$('#resultContainer').fadeIn(500);
		$('#nextBtn').fadeIn(500);
		document.getElementById('happy').checked = true;
	});
	$('.score').addClass('resultSpace');

	if (currentNo == totalNo - 1) {
		$('#nextBtn > span').html('Redo');
	} else {
		$('#nextBtn > span').html('Next');
	}
}

function showWrong() {
	var resultDiv = document.getElementById("result");
	emptyDiv(resultDiv);
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

function mergeWord(correctSentence) {
	var result = '';
	var lastIndex = correctSentence.length - 1;

	for (var i = 0; i <= lastIndex; i++) {
		result += correctSentence[i];

		if (i < lastIndex) {
			result += ' ';
		} else {
			result += '.';
		}
	}

	result = toSentenceCase(result);

	return result;
}

function toSentenceCase(sentence) {
	var fixedSentence = "";
	var n=sentence.split(".");

	for(i=0;i<n.length;i++) {
		var spaceput = "";
		var spaceCount = n[i].replace(/^(\s*).*$/,"$1").length;

		n[i]=n[i].replace(/^\s+/,"");

		var newstring = n[i].charAt(n[i]).toUpperCase() + n[i].slice(1);

		for(j = 0; j < spaceCount; j++)
			spaceput = spaceput +" ";

		fixedSentence = fixedSentence+spaceput+newstring + '.';
	}

	fixedSentence=fixedSentence.substring(0, fixedSentence.length - 1);

	return fixedSentence;
}

function changeSentence(index, isNext) {
	var droppable = document.getElementById('droppable');
	emptyDiv(droppable);
	var draggable = document.getElementById('draggable');
	emptyDiv(draggable);

	if (index == totalNo) {
		index = 0;
		currentNo = 0;
	}

	shuffleWords(index);
	for (var i = 0; i < elementData[index].length; i++) {
		var newDrop = document.createElement('div');
		newDrop.className = 'dropWord';
		document.getElementById('droppable').appendChild(newDrop);

		var newDrag = document.createElement('div');
		newDrag.className = 'dragWord';
		newDrag.id = elementData[index][i].correctOrder;
		newDrag.innerHTML = '<span>' + elementData[index][i].word + '</span>';
		document.getElementById('draggable').appendChild(newDrag);
	}

	$('#resultContainer').fadeOut(500, function() {
		$('.fullscreenDiv').css('top', '65px');
		$('.fullscreenDiv').css('bottom', 0);

		$('#draggable').fadeIn(500);
		$('#droppable').fadeIn(500);
		document.getElementById('normal').checked = true;

		$('#draggable').css('opacity', 1).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
			TweenMax.staggerFromTo('.dropWord', 0.4, {x:-50, y:50, opacity:0}, {x:0, y:0, opacity:1, clearProps:"transform"}, 0.2);
			TweenMax.set('.dropWord',{className:"+=pinch"});
		});
		
		if (isNext) {
			correctNo = 0;
			totalQuestion = 0;
			currentNo++;
			$('.score').removeClass('resultSpace');
		}
	});

	if ($('#tryAgainBtn').css('display') != 'none') {
		$('#tryAgainBtn').fadeOut(500);
	}

	if ($('#nextBtn').css('display') != 'none') {
		$('#nextBtn').fadeOut(500);
	}

	curQuestion = index;
	initDroppable();
}

function shuffleWords(elementDataIndex) {
	var doAgain = true;
	while(doAgain) {
		doAgain = true;

		Shuffle(elementData[elementDataIndex]);

		for (var i = 0; i < elementData[elementDataIndex].length - 1; i++) {
			if (parseInt(elementData[elementDataIndex][i].correctOrder) != parseInt(elementData[elementDataIndex][i+1].correctOrder) - 1) {
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