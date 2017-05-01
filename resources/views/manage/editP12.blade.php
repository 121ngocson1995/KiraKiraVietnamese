@extends('userLayout')

@section('header-more')

<style type="text/css">
	div.title {
		padding: 0 2em;
		text-align: center;
		margin-top: 2em;
	}
	div.description {
		padding: 0 3em;
		margin-bottom: 2em;
	}
	.sentence-input {
		/*width: 100%;*/
		display: inline-block;
	}
	#wrapper {
		padding: 1em 4em;
	}
	textarea {
		resize: vertical;
	}
	div.sentence-holder {
		padding: 3em 0;
	}
	div.sentenceNo {
		display: inline-block;
		margin-right: 1em;
	}
	div.sentenceParts, div.word {
		display: inline-block;
	}
	label {
		font-size: 1.2em !important;
		font-weight: bold !important;
	}
	hr {
		margin: 5px 0;
		border-top: 1px solid #b3b3b3;
	}
	.fa-save {
		margin-left: 0;
		margin-right: 0.3em;
	}
	.fa-plus, .fa-trash {
		margin: 0;
	}
	#saveBtn-holder {
		text-align: center;
		margin-top: 2em;
	}
	.deleteContent {
		position: absolute;
		right: 0;
		margin-right: 3em;
		display: none;
	}
	.close, .close:hover {
		color: black;
	}
</style>

@stop

@section('content')

<script type="text/javascript">
	$('.listBtn').removeClass('active');
	$('#li-edit').addClass('active');
</script>
<div class="container">
	<div class="title"><h2>Edit Practice 12: Group interaction for lesson {{ $lessonNo }}</h2></div>
	<div class="row description" style="text-align: center; font-size: 1.5em">
		Change requirement's content and translation by writing into text fields below
	</div>
	<div id="wrapper">
		<form id="p12Form" method="post" action="/editP12">
			{{ csrf_field() }}
			<input type="hidden" name="lessonId" value="{{ $lessonId }}">
			<div id="plusBtn" class="row" style="width: 100%; height: 150px; text-align: center; display: none;">
				<span style="padding: 0.4em; font-size: 5em; cursor: pointer;" class="addContent">
					<i class="fa fa-plus"></i>
				</span>
			</div>
			<div class="holder">
				@php
				$sentenceNo = 0;
				@endphp
				@if (count($p12))
				<input id="oldId" type="hidden" name="data-text-id" value="{{ $p12[0]->id }}">
				<div class="row">
					<div class="col-md-6 form-group">
						<label for="text_content">Requirement:</label>
						<textarea name="update[{{ $p12[0]->id }}][content]" id="text_content" cols="30" rows="10" placeholder="Enter requirement here" maxlength="1500" class="form-control vld-spc" required>{{ $p12[0]->content }}</textarea>
					</div>
					<div class="col-md-6 form-group">
						<label for="text_content_translate">Requirement's translation:</label>
						<textarea name="update[{{ $p12[0]->id }}][content_translate]" id="text_content_translate" cols="30" rows="10" placeholder="Enter translation for the requirement here" maxlength="1500" class="form-control vld-spc"  required>{{ $p12[0]->content_translate }}</textarea>
					</div>
					<div class="deleteContent">
						<button type="button" class="horizontal close">
							<i class="fa fa-trash fa-1x"></i>
						</button>
					</div>
				</div>
				@else
				<div class="row">
					<div class="col-md-6 form-group">
						<label for="text_content">Requirement:</label>
						<textarea name="insert[content]" id="text_content" cols="30" rows="10" placeholder="Enter requirement here" mmaxlength="1500" class="form-control vld-spc" required></textarea>
					</div>
					<div class="col-md-6 form-group">
						<label for="text_content_translate">Requirement's translation:</label>
						<textarea name="insert[content_translate]" id="text_content_translate" cols="30" rows="10" placeholder="Enter translation for the requirement here" maxlength="1500" class="form-control vld-spc" required></textarea>
					</div>
					<div class="deleteContent">
						<button type="button" class="horizontal close">
							<i class="fa fa-trash fa-1x"></i>
						</button>
					</div>
				</div>
				@endif
			</div>
			<div id="saveBtn-holder" class="row">
				<button id="saveBtn" class="btn btn-success" type="submit"><i class="fa fa-save"></i><span class="saveBtnText">Save</span></button>
			</div>
		</form>
	</div>
</div>

<script>

	var toDelete = '';

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

	</script>
	@stop