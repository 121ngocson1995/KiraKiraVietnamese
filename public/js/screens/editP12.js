var toDelete = '';

/**
 * Edit elements' tab indexes
 *
 * @return {void}
 */
function reIndex() {
	var tabIndex = 1;
	$('input, textarea').each(function() {
		$(this).attr('tabindex', tabIndex);
	});
}

/**
 * Edit elements' tab indexes
 *
 * @return {void}
 */
function reIndex() {
	var tabIndex = 1;
	$('input, textarea').each(function() {
		$(this).attr('tabindex', tabIndex);
	});
}

/**
 * Delete the chosen requirement
 * 選択する要求を削除する。
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
 * Insert new requirement
 * 新しい要求を挿入する。
 * @return {void}
 */
 function addContent() {
 	var holder = document.createElement('div');
 	holder.className = 'holder';

 	var rowBig = document.createElement('div');
 	rowBig.className = 'row';

 	var contentHolder = document.createElement('div');
 	contentHolder.className = 'col-md-6 form-group';

 	var label = document.createElement('label');
 	label.for = 'text_content';
 	label.innerHTML = 'Requirement:';
 	contentHolder.appendChild(label);

 	var textarea = document.createElement('textarea');
 	textarea.name = 'insert[content]';
 	textarea.id = 'text_content';
 	textarea.cols = '30';
 	textarea.rows = '10';
 	textarea.maxlength = '191';
 	textarea.placeholder = 'Enter requirement here';
 	textarea.className = 'form-control';
 	textarea.setAttribute('required', '');
 	contentHolder.appendChild(textarea);
 	rowBig.appendChild(contentHolder);

 	contentHolder = document.createElement('div');
 	contentHolder.className = 'col-md-6 form-group';

 	label = document.createElement('label');
 	label.for = 'text_content_translate';
 	label.innerHTML = 'Requirement\'s translation:';
 	contentHolder.appendChild(label);

 	textarea = document.createElement('textarea');
 	textarea.name = 'insert[content_translate]';
 	textarea.id = 'text_content_translate';
 	textarea.cols = '30';
 	textarea.rows = '10';
 	textarea.maxlength = '191';
 	textarea.placeholder = 'Enter translation for the requirement here';
 	textarea.className = 'form-control';
 	textarea.setAttribute('required', '');
 	contentHolder.appendChild(textarea);
 	rowBig.appendChild(contentHolder);

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
 	rowBig.appendChild(deleteContent);

 	holder.appendChild(rowBig);

 	$(holder).insertBefore(document.getElementById('saveBtn-holder'));

 	$('#plusBtn').hide();
 	reIndex();
 }

/**
 * Show Delete button when hovering on paragraph
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
 * Trigger deleteContent function
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
 * Attach to form the list of id of requirement to delete
 *　削除するように、フォームに要求のイドのリスクを付ける。
 *
 * @return {void}
 */
 $("#p12Form").submit( function(eventObj) {
 	$('.alert').remove();
 	if (validate_chgColor()) {
 		return false;
 	}
 	
 	if (toDelete) {
 		$('<input />').attr('type', 'hidden')
 		.attr('name', 'delete')
 		.attr('value', toDelete)
 		.appendTo('#p12Form');
 		return true;
 	}
 });

 $(document).ready(function () {
 	reIndex();
 });