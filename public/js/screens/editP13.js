var toDelete = '';

/**
 * Delete the chosen paragraph
 *　選択する段落を削除する。
 * @return {void}
 */
 function deleteContent() {
 	if ($('#oldId')) {
 		toDelete += $('#oldId')[0].value;
 	}

 	$('.holder').remove();

 	$('#plusBtn').show();
 }

/**
 * Insert new paragraph
 *　新しい段落を挿入する。
 *
 * @return {void}
 */
 function addContent() {
 	var holder = document.createElement('div');
 	holder.className = 'holder';

 	var deleteContent = document.createElement('div');
 	deleteContent.className = 'deleteContent';

 	var button = document.createElement('button');
 	button.className = 'horizontal close';
 	button.type = 'button';

 	var i = document.createElement('i');
 	i.className = 'fa fa-trash fa-1x';
 	button.appendChild(i);

 	$(button).click(function() {
 		if ($('input[type="hidden"]')) {
 			toDelete += $('input[type="hidden"]')[0].value;
 		}

 		$('.holder').remove();

 		$('#plusBtn').show();
 	});
 	deleteContent.appendChild(button);
 	holder.appendChild(deleteContent);

 	var rowBig = document.createElement('div');
 	rowBig.className = 'row form-group';

 	var col12 = document.createElement('div');
 	col12.className = 'col-md-12';

 	var label = document.createElement('label');
 	label.for = 'text';
 	label.innerHTML = 'Paragraph:';
 	col12.appendChild(label);

 	var textarea = document.createElement('textarea');
 	textarea.name = 'insert[text]';
 	textarea.id = 'text';
 	textarea.cols = '30';
 	textarea.rows = '8';
 	textarea.maxlength = '191';
 	textarea.placeholder = 'Enter example here';
 	textarea.className = 'form-control';
 	textarea.setAttribute('required', '');
 	col12.appendChild(textarea);
 	rowBig.appendChild(col12);
 	holder.appendChild(rowBig);

 	var row = document.createElement('div');
 	row.className = 'row';

 	var contentHolder = document.createElement('div');
 	contentHolder.className = 'col-md-6 form-group';

 	var label = document.createElement('label');
 	label.for = 'text_note';
 	label.innerHTML = 'Requirement:';
 	contentHolder.appendChild(label);

 	var input = document.createElement('input');
 	input.name = 'insert[note]';
 	input.id = 'text_note';
 	input.maxlength = '191';
 	input.placeholder = 'Enter requirement here';
 	input.className = 'form-control';
 	input.setAttribute('required', '');
 	contentHolder.appendChild(input);
 	row.appendChild(contentHolder);

 	contentHolder = document.createElement('div');
 	contentHolder.className = 'col-md-6 form-group';

 	label = document.createElement('label');
 	label.for = 'text_note_translate';
 	label.innerHTML = 'Requirement\'s translation:';
 	contentHolder.appendChild(label);

 	input = document.createElement('input');
 	input.name = 'insert[note_translate]';
 	input.id = 'text_note_translate';
 	input.maxlength = '191';
 	input.placeholder = 'Enter translation for the requirement here';
 	input.className = 'form-control';
 	input.setAttribute('required', '');
 	contentHolder.appendChild(input);
 	row.appendChild(contentHolder);

 	holder.appendChild(row);

 	$(holder).insertBefore(document.getElementById('saveBtn-holder'));

 	$('#plusBtn').hide();
 }

/**
 * Show delete button when hovering on paragraph
 *　段落にホバリングをすると「Delete」ボタンを表す。
 * @return {void}
 */
 $('#wrapper').hover(function() {
 	$(this).find('.deleteContent').fadeIn(60);
 }, function() {
 	$(this).find('.deleteContent').fadeOut(60);
 });

/**
 * Trigger addContent function
 *　「addContent」機能をトリガーする。
 */
 $('.addContent').click(addContent);

/**
 * Trigerr deleteContent function
 *　「deleteContent」機能をトリガーする。
 */
 $('.deleteContent').click(deleteContent);

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
 * Attach to form the list of id of paragraph to delete
 *　削除するように、フォームに要求のイドのリスクを付ける。
 * @return {void}
 */
 $("#p13Form").submit( function(eventObj) {
 	$('.alert').remove();
 	if (validate_chgColor()) {
 		return false;
 	}
 	
 	if (toDelete) {
 		$('<input />').attr('type', 'hidden')
 		.attr('name', 'delete')
 		.attr('value', toDelete)
 		.appendTo('#p13Form');
 		return true;
 	}
 });