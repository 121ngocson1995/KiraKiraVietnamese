var toAdd = 0;

/**
 * Change textbox's size on keyboard pressing
 * 押すキーボードでテキストボックスのサイズを変更する。
 * 
 * @param  {DOM Object}
 * @return {void}
 */
 function changeTextboxWidth(input) {
 	input.size= parseInt(input.value.length);
 }

/**
 * Create a new sentence
 * 新しいセンテンスを作成する。
 * 
 * @return {void}
 */
 function newSentence() {
 	var div = document.createElement('div');
 	div.className = 'row sentence';
 	div.setAttribute('data-insert-sentence-id', ++toAdd);

 	var colLabel = document.createElement('div');
 	colLabel.className = 'col-md-1';

 	var label = document.createElement('label');
 	label.innerHTML = ++sentenceNo;
 	colLabel.appendChild(label);
 	div.appendChild(colLabel);

 	var sentencePartsHolder = document.createElement('div');
 	sentencePartsHolder.className = 'form-group col-md-10 sentenceParts-holder';

 	var tabble = document.createElement('div');
 	tabble.className = 'tabble';

 	var inputSentenceNo = document.createElement('input');
 	inputSentenceNo.setAttribute('type', 'hidden');
 	inputSentenceNo.name = 'insert[' + toAdd + '][sentenceNo]';
 	inputSentenceNo.value = sentenceNo;
 	tabble.appendChild(inputSentenceNo);

 	tabble.appendChild(createPart());
 	sentencePartsHolder.appendChild(tabble);

 	var addPart = document.createElement('div');
 	addPart.className = 'addPart';

 	var addPartBtn = document.createElement('button');
 	addPartBtn.className = 'addPartBtn';
 	addPartBtn.setAttribute('type', 'button');

 	i = document.createElement('i');
 	i.className = 'fa fa-plus-circle fa-2x';
 	addPartBtn.appendChild(i);

 	$(addPartBtn).click(function() {
 		newPart(this);
 	});

 	addPart.appendChild(addPartBtn);
 	sentencePartsHolder.appendChild(addPart);

 	div.appendChild(sentencePartsHolder);

 	var deleteSentence = document.createElement('div');
 	deleteSentence.className = 'deleteSentence';

 	var deleteSentenceBtn = document.createElement('button')
 	deleteSentenceBtn.className = 'horizontal close';
 	deleteSentenceBtn.setAttribute('type', 'button');

 	var i = document.createElement('i');
 	i.className = 'fa fa-trash fa-1x';
 	deleteSentenceBtn.appendChild(i);

 	$(deleteSentenceBtn).click(function() {
 		var sentence = $(this).closest('div.row.sentence');
 		if (sentence.attr('data-sentence-id')) {
 			if (toDelete) {
 				toDelete += ','
 			}
 			toDelete += sentence.attr('data-sentence-id');
 		}

 		sentence.next().remove();
 		sentence.remove();

 		sentenceNo = $('div.row.sentence').length;
 		for (var i = 0; i < $('div.row.sentence').length; i++) {
 			$('div.row.sentence').eq(i).find('label')[0].innerHTML = '' + (i+1) + '.';
 		}
 	});

 	deleteSentence.appendChild(deleteSentenceBtn);

 	div.appendChild(deleteSentence);

 	$(div).hover(function() {
 		$(this).find('button.addPartBtn').fadeIn(60);
 		$(this).find('.deleteSentence').fadeIn(60);
 	}, function() {
 		$(this).find('button.addPartBtn').fadeOut(60);
 		$(this).find('.deleteSentence').fadeOut(60);
 	});

 	document.getElementById('sentencesHolder').appendChild(div);
 	var hr =   document.createElement('hr')
 	document.getElementById('sentencesHolder').appendChild(hr);
 }

/**
 * Store id of content to be deleted
 * 削除する内容のイドを保存する。
 * 
 * @type {String}
 */
 var toDelete = '';

/**
 * Delete a sentence
 *　センテンスを削除する。
 *
 * @param  {DOM Object}
 *
 * @return {void}
 */
 function deleteSentence(sentence) {
 	if (sentence.attr('data-sentence-id')) {
 		if (toDelete) {
 			toDelete += ','
 		}
 		toDelete += sentence.attr('data-sentence-id');
 	}

 	sentence.next().remove();
 	sentence.remove();

 	sentenceNo = $('div.row.sentence').length;
 	for (var i = 0; i < $('div.row.sentence').length; i++) {
 		$('div.row.sentence').eq(i).find('label')[0].innerHTML = '' + (i+1) + '.';
 	}
 }

/**
 * Create a new sentence part
 * 新しいセンテンスの一部を作成する。
 *
 * @param  {DOM Object}
 *
 * @return {void}
 */
 function newPart(button) {
 	var tabble = $(button).closest('div.sentenceParts-holder').find('.tabble');
 	var existedSentenceParts = tabble.find('.sentenceParts');
 	var sentencePartsCount = existedSentenceParts.length;

 	var partno = 0;
 	if (sentencePartsCount) {
 		var sample = $(existedSentenceParts[existedSentenceParts.length - 1]).find('.option').eq(0).find('textarea')[0];

 		var name = sample.getAttribute('name');

 		var newName = name.split('[');
 		var partNo = newName[3].replace(']', '');

 		newName[3] = '' + (parseInt(partNo) + 1) + ']';
 		newName = newName.toString().replace(/,/g, '[');

 		tabble[0].appendChild(createPart(newName));
 	} else {
 		var name = tabble[0].firstElementChild.getAttribute('name');

 		var newName = name.split('[');
 		newName[2] = 'sentence][0][]';
 		newName = newName.toString().replace(/,/g, '[');
 		console.log(newName);

 		tabble[0].appendChild(createPart(newName));
 	}
 }

/**
 * Create a new option
 * 新しいオプションを作成する。
 *
 * @param  {DOM Object}
 *
 * @return {void}
 */
 function newOption(button) {
 	var newOption = $(button.previousElementSibling).clone();
 	$(newOption).find('textarea')[0].innerHTML = '';

 	$(newOption).find('.deleteOption').click(function() {
 		deleteOption(this);
 	});

 	$(newOption).hover(function() {
 		$(this.firstElementChild).fadeIn(60);
 	}, function() {
 		$(this.firstElementChild).fadeOut(60);
 	});
 	$(newOption).insertBefore(button);
 }

/**
 * Delete an option
 *　オプションを削除する。
 *
 * @param  {DOM Object}
 *
 * @return {void}
 */
 function deleteOption(button) {
 	if($(button).closest('div.sentenceParts')[0].children.length == 2) {
 		$(button).closest('div.sentenceParts').remove();
 		return;
 	}

 	$(button).closest('div.option').remove();
 }

/**
 * Creat a sentence part's DOM object
 *　文章部分の「DOM」のオブジェクトを作成する。
 *
 * @param  {string}
 *
 * @return {DOM Object}
 */
 function createPart(optionName = null) {
 	var sentenceParts = document.createElement('div');
 	sentenceParts.className = 'sentenceParts';

 	sentenceParts.appendChild(createOption(optionName));

 	var controlBtnHolder = document.createElement('div');
 	controlBtnHolder.className = 'controlBtn-holder';

 	var addInputBtn = document.createElement('button')
 	addInputBtn.className = 'addInputBtn';
 	addInputBtn.setAttribute('type', 'button');

 	$(addInputBtn).click(function() {
 		newOption(this.parentElement);
 	});

 	var i = document.createElement('i');
 	i.className = 'fa fa-plus-circle';
 	addInputBtn.appendChild(i);
 	controlBtnHolder.appendChild(addInputBtn);
 	sentenceParts.appendChild(controlBtnHolder);

 	$(sentenceParts).hover(function() {
 		$(this).find('button.addInputBtn').fadeIn(60);
 		$(this).find('button.deleteInputBtn').fadeIn(60);
 	}, function() {
 		$(this).find('button.addInputBtn').fadeOut(60);
 		$(this).find('button.deleteInputBtn').fadeOut(60);
 	})

 	return sentenceParts;
 }

/**
 * Create sentence option's DOM object
 *　文章のオプションの「DOM」オブジェクトを作成する。
 *
 * @param  {string}
 *
 * @return {DOM Object}
 */
 function createOption(optionName) {
 	var option = document.createElement('div');
 	option.className = 'option aligned';

 	var deleteOption = document.createElement('button');
 	deleteOption.className = 'close deleteOption';
 	deleteOption.setAttribute('aria-label', 'Delete');

 	var btnText = document.createElement('span');
 	btnText.setAttribute('aria-hidden', 'true');
 	btnText.innerHTML = '×';
 	deleteOption.appendChild(btnText);

 	$(deleteOption).click(function() {
 		if($(this).closest('div.sentenceParts')[0].children.length == 2) {
 			$(this).closest('div.sentenceParts').remove();
 			return;
 		}

 		$(this).closest('div.option').remove();
 	});

 	option.appendChild(deleteOption);

 	var textarea = document.createElement('textarea');
 	textarea.className = 'form-control vld-spc';
 	textarea.setAttribute('rows', '1');
 	textarea.setAttribute('maxlength', '200');
 	textarea.setAttribute('name', optionName ? optionName : 'insert[' + toAdd + '][sentence][0][]');
 	textarea.setAttribute('required', '');

 	$(textarea).on('keydown', function() {
 		var el = this;
 		setTimeout(function(){
 			el.style.cssText = 'height:' + el.scrollHeight + 'px';
 		},0);
 	});

 	option.appendChild(textarea);

 	$(option).hover(function() {
 		$(this.firstElementChild).fadeIn(60);
 	}, function() {
 		$(this.firstElementChild).fadeOut(60);
 	});

 	return option;
 }

/**
 * Create a new sentence upon button click
  * ボタンをクリックすると、新しいセンテンスを作成する。
  */
  $('#newSentenceBtn').click(function() {
  	newSentence();
  });

/**
 * Create a new sentence part upon button click
 * ボタンをクリックすると、新しい文章部分を作成する。
 */
 $('.addPartBtn').click(function() {
 	newPart(this);
 });

/**
 * Change textarea's height based on input's row
 *　入力行によって、テキストエリアの高さを変更する。
 */
 $('textarea').each(function() {
 	this.style.cssText = 'height:' + this.scrollHeight + 'px';
 });

/**
 * Determine and change textarea's height upon keyboard press
 *　キーボードをクリックすると、テキストエリアの高さを決定して変更する。
 */
 $('textarea').on('keydown', function() {
 	var el = this;
 	setTimeout(function(){
 		el.style.cssText = 'height:' + el.scrollHeight + 'px';
 	},0);
 });

/**
 * Show delete option button by hovering on a sentence part
 *　文章部分にホバリングすると、「Delete」オプションを表す。
 */
 $('.option').hover(function() {
 	$(this.firstElementChild).fadeIn(60);
 }, function() {
 	$(this.firstElementChild).fadeOut(60);
 });

/**
 * Delete a sentence option upon button click
 * ボタンをクリックすると、センテンスオプションを削除する。
 */
 $('button.close.deleteOption').click(function() {
 	deleteOption(this);
 });

/**
 * Create a new sentence option upon button ｃlick
 * ボタンをクリックすると、新しいセンテンスオプションを作成する。
 */
 $('button.addInputBtn').click(function() {
 	newOption(this.parentElement);
 });

/**
 * Show add and delete button by hovering on a sentence
 * センテンスでのホバイングによって、「Add」と「Delete」ボタンを表示する。
 */
 $('.row.sentence').hover(function() {
 	$(this).find('button.addPartBtn').fadeIn(60);
 	$(this).find('.deleteSentence').fadeIn(60);
 }, function() {
 	$(this).find('button.addPartBtn').fadeOut(60);
 	$(this).find('.deleteSentence').fadeOut(60);
 })

/**
 * Show add option button by hovering on a sentence part
 * 文章部分でのホバイングによって、「Add」オプションを表示する。
 */
 $('.sentenceParts').hover(function() {
 	$(this).find('button.addInputBtn').fadeIn(60);
 	$(this).find('button.deleteInputBtn').fadeIn(60);
 }, function() {
 	$(this).find('button.addInputBtn').fadeOut(60);
 	$(this).find('button.deleteInputBtn').fadeOut(60);
 });

/**
 * Delete a sentence upon button click
 * ボタンをクリックすると、センテンスを削除する。
 */
 $('button.horizontal.close').click(function() {
 	deleteSentence($(this).closest('div.row.sentence'));
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
 $("#p14Form").submit( function(eventObj) {
 	$('.alert').remove();
 	if (validate_chgColor()) {
 		return false;
 	}
 	
 	if (toDelete) {
 		$('<input />').attr('type', 'hidden')
 		.attr('name', 'delete')
 		.attr('value', toDelete)
 		.appendTo('#p14Form');
 		return true;
 	}
 });