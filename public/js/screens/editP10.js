/**
 * Change textbox's width
 * テキストボックスの幅を変更する。
 *
 * @param  {DOM Object}
 *
 * @return {void}
 */
 function changeTextboxWidth(input) {
 	input.size = parseInt(input.value.length) + 1;
 }

/**
 * Add a new sentence
 *　新しいセンテンスを追加する。
 * 
 * @return {void}
 */
 function addSentence() {
 	var div = document.createElement('div');
 	div.className = 'row sentence-holder';
 	div.setAttribute('data-insert-sentence-id', ++toAdd);

 	var divSentenceNo = document.createElement('div');
 	divSentenceNo.className = 'sentenceNo';

 	var label = document.createElement('label');
 	label.innerHTML = (++sentenceNo) + '.';
 	divSentenceNo.appendChild(label);
 	div.appendChild(divSentenceNo);

 	var sentenceParts = document.createElement('div');
 	sentenceParts.className = 'sentenceParts';

 	sentenceParts.appendChild(createWord(sentenceNo));
 	div.appendChild(sentenceParts);

 	var addPart = document.createElement('div');
 	addPart.className = 'addPart';

 	var button = document.createElement('button');
 	button.className = 'addPartBtn';
 	button.setAttribute('type', 'button');

 	var i = document.createElement('i');
 	i.className =  'fa fa-plus-circle fa-2x';
 	button.appendChild(i);

 	$(button).click(function() {
 		addWord(this);
 	});

 	addPart.appendChild(button);
 	div.appendChild(addPart);

 	var deleteSentence = document.createElement('div');
 	deleteSentence.className = 'deleteSentence';

 	button = document.createElement('button');
 	button.className = 'horizontal close';
 	button.setAttribute('type', 'button');

 	i = document.createElement('i');
 	i.className = 'fa fa-trash';
 	button.appendChild(i);

 	$(button).click(function() {
 		var sentence = $(this).closest('.sentence-holder');
 		$(sentence).find('input.wordText').each(function() {
 			if($(this).attr('name').indexOf('update') != -1) {
 				var name = $(this).attr('name');

 				var id = parseInt(name.split('[')[1].replace(']', ''));

 				if (toDelete) {
 					toDelete += ',';
 				}
 				toDelete += id;
 			}
 		});

 		sentence.next().remove();
 		sentence.remove();

 		sentenceNo = $('div.row.sentence-holder').length;
 		for (var i = 0; i < $('div.sentence-holder').length; i++) {
 			$('div.sentence-holder').eq(i).find('label')[0].innerHTML = '' + (i+1) + '.';
 			$('div.sentence-holder').eq(i).find('input[type="hidden"]').attr('value', '' + (i+1));
 		}
 	});

 	deleteSentence.appendChild(button);
 	div.appendChild(deleteSentence);

 	$(div).hover(function() {
 		$(this).find('button.addPartBtn').fadeIn(60);
 		$(this).find('.deleteSentence').fadeIn(60);
 	}, function() {
 		$(this).find('button.addPartBtn').fadeOut(60);
 		$(this).find('.deleteSentence').fadeOut(60);
 	});

 	document.getElementsByClassName('sentences')[0].appendChild(div);
 	var hr = document.createElement('hr')
 	document.getElementsByClassName('sentences')[0].appendChild(hr);

 	$('.sentences').find('input').last().focus();
 }

/**
 * Store id of content to be deleted
 * 削除する内容のイドを保存する。
 * @type {String}
 */	
 var toDelete = '';

/**
 * Delete a sentence
 *　センテンスを削除する。
 *
 * @param  {DOM Object}
 *
 * @return {[type]}
 */
 function deleteSentence(sentence) {
 	$(sentence).find('.word').each(function() {
 		deleteWord($(this));
 	});

 	sentence.next().remove();
 	sentence.remove();

 	sentenceNo = $('div.row.sentence-holder').length;
 	for (var i = 0; i < $('div.sentence-holder').length; i++) {
 		$('div.sentence-holder').eq(i).find('label')[0].innerHTML = '' + (i+1) + '.';
 		$('div.sentence-holder').eq(i).find('input[type="hidden"]').attr('value', '' + (i+1));
 	}
 }

/**
 * Add a new word
 *　新しい単語を追加する。
 *
 * @param {void}
 */
 function addWord(button) {
 	var sentenceParts = $(button).closest('div.sentence-holder').find('.sentenceParts');
 	var existedWords = sentenceParts.find('.word');
 	var wordsCount = existedWords.length;

 	var word = 0;
 	toAdd++;
 	var newSentenceNo = parseInt($(button).closest('.sentence-holder').find('label')[0].innerHTML.replace('.' ,''));

 	sentenceParts[0].appendChild(createWord(newSentenceNo));

 	$(sentenceParts).find('input').last().focus();
 }

/**
 * Delete a word
 *　単語を削除する。
 *
 * @param  {DOM Object}
 *
 * @return {[type]}
 */
 function deleteWord(word) {
 	if(word.find('.wordText').attr('name').indexOf('update') != -1) {
 		var name = word.find('.wordText').attr('name');

 		var id = parseInt(name.split('[')[1].replace(']', ''));

 		if (toDelete) {
 			toDelete += ',';
 		}
 		toDelete += id;
 	}

 	word.remove();
 }

/**
 * Return newly created word object
 * 新しく作成した単語のオブジェクトをリターンする。
 * @param  {integer}
 *
 * @return {DOM Object}
 */
 function createWord(sentenceNo=null) {
 	var word = document.createElement('div');
 	word.className = 'word';

 	var inputSentenceNo = document.createElement('input');
 	inputSentenceNo.setAttribute('type', 'hidden');
 	inputSentenceNo.setAttribute('name', 'insert[' + toAdd + '][sentenceNo]');
 	inputSentenceNo.setAttribute('value', sentenceNo ? sentenceNo.toString() : '1');
 	word.appendChild(inputSentenceNo);

 	var button = document.createElement('button');
 	button.className ='close deleteOption';
 	button.setAttribute('type', 'button');
 	button.setAttribute('aria-label', 'Delete');

 	var span = document.createElement('span');
 	span.setAttribute('aria-hidden', 'true');
 	span.innerHTML = '×';
 	button.appendChild(span);

 	$(button).click(function() {
 		deleteWord($(this).closest('div.word'));
 	});

 	word.appendChild(button);

 	var input = document.createElement('input');
 	input.className = 'form-control wordText vld-spc';
 	input.setAttribute('type', 'text');
 	input.setAttribute('maxlength', '191');
 	input.setAttribute('name', 'insert[' + toAdd + '][word]');
 	input.setAttribute('size', '2');
 	input.setAttribute('required', '');

 	$(button).click(function() {
 		deleteWord($(this).closest('div.word'));
 	});

 	$(input).on('keypress', function() {
 		changeTextboxWidth(this);
 	});

 	word.appendChild(input);

 	$(word).hover(function() {
 		$(this).find('button.deleteOption').fadeIn(60);
 	}, function() {
 		$(this).find('button.deleteOption').fadeOut(60);
 	});

 	return word;
 }

/**
 * Show Add sentence button when hovering on a sentence
 *　センテンスにホバリングをすると「Add　sentence」ボタンを表す。
 *
 */
 $('div.sentence-holder').hover(function() {
 	$(this).find('button.addPartBtn').fadeIn(60);
 	$(this).find('.deleteSentence').fadeIn(60);
 }, function() {
 	$(this).find('button.addPartBtn').fadeOut(60);
 	$(this).find('.deleteSentence').fadeOut(60);
 });

/**
 * Show Delete button when hovering on a word
 *　単語にホバリングすると、「Delete」ボタンを表す。
 */
 $('.word').hover(function() {
 	$(this).find('button.deleteOption').fadeIn(60);
 }, function() {
 	$(this).find('button.deleteOption').fadeOut(60);
 });

/**
 * Delete word upon button click
 * ボタンをクリックすると、単語を削除する。
 * 
 */
 $('button.deleteOption').click(function() {
 	deleteWord($(this).closest('div.word'));
 });

/**
 * Add a new word upon button click
 * ボタンをクリックすると、新しい単語を追加する。
 */
 $('button.addPartBtn').click(function() {
 	addWord(this);
 });

/**
 * Add a new sentence upon button click
 * ボタンをクリックすると、新しいセンテンスを追加する。
 */
 $('button#newSentenceBtn').click(function() {
 	addSentence();
 });

/**
 * Delete a sentence upon button click
 * ボタンをクリックすると、センテンスを削除する。
 */
 $('.deleteSentence button').click(function() {
 	deleteSentence($(this).closest('.sentence-holder'));
 });

 function validate_chgColor() {
 	var fail = false;
 	for (var i = 0; i < $('.vld-spc').length; i++) {
 		if(!validate_spcChar($('.vld-spc')[i]) || !validate_space($('.vld-spc')[i]) ) {
 			$(this).attr('style', 'border-color: red;');
 			fail = true;
 		}else{
 			$(this).attr('style', 'border-color: #dddddd;');
 		}
 	}
 	return fail;
 	
 }

 function showMesg(element, msg) {
 	if ($(element).parent().find('.alert alert-danger').length) {
 		$(element).parent().find('span.help').html(msg);
 	} else {
 		var div_help = document.createElement('div');
 		div_help.className = 'alert alert-danger';
 		div_help.innerHTML = '<span class="help">' +  msg +  '</span>';
 		$(div_help).insertAfter(element);
 	}
 }

 function validate_space(textElement) {
 	var text = textElement.value;
 	if( text.trim() == "") {
 		showMesg(textElement, 'Empty value is not allowed');
 		return false;
 	}else{
 		return true;
 	}
 }

 function validate_spcChar(textElement){
 	var text = textElement.value;
 	var pattern = new RegExp(/[~`@#$%\^&*+=\\[\]\\';/{}|\\":<>]/);
 	if (pattern.test(text)) {
 		showMesg(textElement, 'Special character is invalid');
 		return false;
 	}else{
 		return true;
 	}
 }
 

 
/**
 * Add a list of id of element to delete to the submiting form
 * 提出するフォームを削除するように、様子のイドのリストを追加する。
 */
 $("#p10Form").submit( function(eventObj) {
 	$('.alert').remove();
 	if (validate_chgColor()) {
 		return false;
 	}
 	if (toDelete) {
 		$('<input />').attr('type', 'hidden')
 		.attr('name', 'delete')
 		.attr('value', toDelete)
 		.appendTo('#p10Form');
 		return true;
 	}
 });