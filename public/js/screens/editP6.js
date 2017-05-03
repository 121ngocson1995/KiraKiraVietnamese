/**
 * Add new pairs of question and answer
 * @return {void} 
 */
 function newDialog() {
 	var dialogHolder = document.createElement('div');
 	dialogHolder.className = 'row dialog-holder';

 	var dialogNoText = document.createElement('input');
 	dialogNoText.type = 'hidden';
 	dialogNoText.className = 'dialogNo';
 	dialogNoText.name = 'insert[' + ++toAdd + '][dialogNo]';
 	dialogNoText.value = dialogNo;
 	dialogHolder.appendChild(dialogNoText);

 	var col1 = document.createElement('div');
 	col1.className = 'col-md-1';

 	var dialogNoLabel = document.createElement('label');
 	dialogNoLabel.innerHTML = ++dialogNo + '.';
 	col1.appendChild(dialogNoLabel);
 	dialogHolder.appendChild(col1);

 	var col10 = document.createElement('div');
 	col10.className = 'col-md-10';

 	var questionHolder = document.createElement('div');
 	questionHolder.className = 'row question-holder';

 	var formGroup = document.createElement('div');
 	formGroup.className = 'col-md-12 form-group';

 	var label = document.createElement('label');
 	label.setAttribute('for', 'insertDialog' + toAdd);
 	label.innerHTML = 'Question:';
 	formGroup.appendChild(label);

 	var textarea = document.createElement('textarea');
 	textarea.id = 'insertDialog' + toAdd;
 	textarea.setAttribute('maxlength', '200');
 	textarea.className = 'form-control textarea vld-spc';
 	textarea.name = 'insert[' + toAdd + '][dialog]';
 	textarea.rows = '2';
 	formGroup.appendChild(textarea);
 	questionHolder.appendChild(formGroup);
 	col10.appendChild(questionHolder);

 	var answerHolder = document.createElement('div');
 	answerHolder.className = 'row answer-holder';

 	formGroup = document.createElement('div');
 	formGroup.className = 'col-md-4 form-group';

 	var label = document.createElement('label');
 	label.setAttribute('for', 'insertCorrectAnswer' + toAdd);
 	label.innerHTML = 'Correct answer:';
 	formGroup.appendChild(label);

 	var input = document.createElement('input');
 	input.id = 'insertCorrectAnswer' + toAdd;
 	input.type = 'text';
 	input.name = 'insert[' + toAdd + '][answers][correct]';
 	input.className = 'form-control correctAnswer vld-spc';
 	input.setAttribute('maxlength', '20');
 	input.setAttribute('required', 'true');
 	formGroup.appendChild(input);
 	answerHolder.appendChild(formGroup);

 	formGroup = document.createElement('div');
 	formGroup.className = 'col-md-4 form-group';

 	label = document.createElement('label');
 	label.setAttribute('for', 'insertWrongAnswer1' + toAdd);
 	label.innerHTML = 'Wrong answer:';
 	formGroup.appendChild(label);

 	input = document.createElement('input');
 	input.id = 'insertWrongAnswer1' + toAdd;
 	input.setAttribute('maxlength', '20');
 	input.setAttribute('required', 'true');
 	input.type = 'text';
 	input.name = 'insert[' + toAdd + '][answers][wrong1]';
 	input.className = 'form-control wrongAnswer vld-spc';
 	formGroup.appendChild(input);
 	answerHolder.appendChild(formGroup);

 	formGroup = document.createElement('div');
 	formGroup.className = 'col-md-4 form-group';

 	label = document.createElement('label');
 	label.setAttribute('for', 'insertWrongAnswer2' + toAdd);
 	label.innerHTML = 'Wrong answer:';
 	formGroup.appendChild(label);

 	input = document.createElement('input');
 	input.id = 'insertWrongAnswer2' + toAdd;
 	input.type = 'text';
 	input.setAttribute('maxlength', '20');
 	input.setAttribute('required', 'true');
 	input.name = 'insert[' + toAdd + '][answers][wrong2]';
 	input.className = 'form-control wrongAnswer vld-spc';
 	formGroup.appendChild(input);
 	answerHolder.appendChild(formGroup);

 	col10.appendChild(answerHolder);
 	dialogHolder.appendChild(col10);

 	col1 = document.createElement('div');
 	col1.className = 'col-md-1';

 	var deleteDialog = document.createElement('div');
 	deleteDialog.className = 'deleteDialog';

 	var button = document.createElement('button');
 	button.className = 'horizontal close';
 	button.type = 'button';

 	var i = document.createElement('i');
 	i.className = 'fa fa-trash fa-1x';
 	button.appendChild(i);

 	$(button).click(function() {
 		dialog = $(this).closest('.dialog-holder');

 		if (dialog.attr('data-dialog-id')) {
 			if (toDelete) {
 				toDelete += ','
 			}
 			toDelete += dialog.attr('data-dialog-id');
 		}

 		dialog.next().remove();
 		dialog.remove();

 		dialogNo = $('div.row.dialog-holder').length;
 		for (var i = 0; i < dialogNo; i++) {
 			$('div.dialog-holder').eq(i).find('label')[0].innerHTML = '' + (i+1) + '.';
 		}
 	});

 	deleteDialog.appendChild(button);
 	col1.appendChild(deleteDialog);
 	dialogHolder.appendChild(col1);

 	$(dialogHolder).hover(function() {
 		$(this).find('.deleteDialog').fadeIn(60);
 	}, function() {
 		$(this).find('.deleteDialog').fadeOut(60);
 	});

 	document.getElementById('wrapAll').appendChild(dialogHolder);
 	var hr = document.createElement('hr');
 	document.getElementById('wrapAll').appendChild(hr);
 	var lines = 2;

 	$('.textarea').each(function() {
 		$(this).keydown(function(e) {
 			newLines = $(this).val().split("\n").length;
 			if(e.keyCode == 13 && newLines >= lines) {
 				return false;
 			}
 		});
 	});
 }	

 var toDelete = '';

/**
 * delete pairs of question and answer
 * @param  {DOM} dialog 
 * @return {void}   
 */
 function deleteDialog(dialog) {
 	if (dialog.attr('data-dialog-id')) {
 		if (toDelete) {
 			toDelete += ','
 		}
 		toDelete += dialog.attr('data-dialog-id');
 	}

 	dialog.next().remove();
 	dialog.remove();

 	dialogNo = $('div.row.dialog-holder').length;
 	for (var i = 0; i < dialogNo; i++) {
 		$('div.dialog-holder').eq(i).find('label')[0].innerHTML = '' + (i+1) + '.';
 		$('div.dialog-holder').eq(i).find('.dialogNo').attr('value', i+1);
 	}
 }

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

 $('#newDialogBtn').click(function() {
 	newDialog();
 });

 $('div.row.dialog-holder').hover(function() {
 	$(this).find('.deleteDialog').fadeIn(60);
 }, function() {
 	$(this).find('.deleteDialog').fadeOut(60);
 });

 $('.deleteDialog button').click(function() {
 	deleteDialog($(this).closest('.dialog-holder'));
 });

 $("#p6Form").submit( function(eventObj) {
 	$('.alert').remove();

 	if (validate_chgColor()) {
 		return false;
 	}
 	if (toDelete) {
 		$('<input />').attr('type', 'hidden')
 		.attr('name', 'delete')
 		.attr('value', toDelete)
 		.appendTo('#p6Form');
 		return true;
 	}
 });