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
	<div class="title"><h2>Edit Practice 13: Text for lesson {{ \App\Lesson::where('id', '=', $lessonId)->first()->lessonNo }}</h2></div>
	<div class="row description" style="text-align: center; font-size: 1.5em">
		Change paragraph and text's content as well as translation by writing into text fields below
	</div>
	<div id="wrapper">
		<form id="p13Form" method="post" action="/editP13">
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
				@if (count($p13))
				<input id="oldId" type="hidden" name="data-text-id" value="{{ $p13[0]->id }}">
				<div class="deleteContent">
					<button type="button" class="horizontal close">
						<i class="fa fa-trash fa-1x"></i>
					</button>
				</div>
				<div class="row form-group">
					<div class="col-md-12">
						<label for="text">Paragraph:</label>
						<textarea name="update[{{ $p13[0]->id }}][text]" id="text" cols="30" rows="8" class="form-control" placeholder="Enter example here" required>{{ $p13[0]->content }}</textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 form-group">
						<label for="text_note">Requirement:</label>
						<input name="update[{{ $p13[0]->id }}][note]" id="text_note" placeholder="Enter requirement here" maxlength="191" class="form-control" value="{{ $p13[0]->note }}" required>
					</div>
					<div class="col-md-6 form-group">
						<label for="text_note_translate">Requirement's translation:</label>
						<input name="update[{{ $p13[0]->id }}][note_translate]" id="text_note_translate" placeholder="Enter translation for the requirement here" maxlength="191" class="form-control" maxlength="191" value="{{ $p13[0]->note_translate }}" required>
					</div>
				</div>
				@else
				<div class="row form-group">
					<div class="col-md-12">
						<label for="text">Paragraph:</label>
						<textarea name="insert[text]" id="text" cols="30" rows="8" class="form-control" placeholder="Enter example here" required></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 form-group">
						<label for="text_note">Requirement:</label>
						<input name="insert[note]" id="text_note" placeholder="Enter requirement here" maxlength="191" class="form-control" required>
					</div>
					<div class="col-md-6 form-group">
						<label for="text_note_translate">Requirement's translation:</label>
						<input name="insert[note_translate]" id="text_note_translate" placeholder="Enter translation for the requirement here" maxlength="191" class="form-control" maxlength="191" required>
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
	 * Delete the chosen paragraph
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
	 * @return {void}
	 */
	$('#wrapper').hover(function() {
		$(this).find('.deleteContent').fadeIn(60);
	}, function() {
		$(this).find('.deleteContent').fadeOut(60);
	});

	/**
	 * Trigger addContent function
	 */
	$('.addContent').click(addContent);

	/**
	 * Trigerr deleteContent function
	 */
	$('.deleteContent').click(deleteContent);

	/**
	 * Attach to form the list of id of paragraph to delete
	 * @return {void}
	 */
	$("#p13Form").submit( function(eventObj) {
		if (toDelete) {
			$('<input />').attr('type', 'hidden')
			.attr('name', 'delete')
			.attr('value', toDelete)
			.appendTo('#p13Form');
			return true;
		}
	});

</script>
@stop