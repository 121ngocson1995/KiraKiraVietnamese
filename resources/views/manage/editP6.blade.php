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
	button.close {
		color: black;
		float: none;
		margin: 0 0.5em;
		outline: none;
		line-height: initial;
	}
	button.close:hover, button.close:focus {
		color: black;
	}
	textarea {
		text-align: center;
		font-size: 1.4em !important;
		resize: vertical;
	}
	hr {
		border-top: 1px solid #b3b3b3;
	}
	input.correctAnswer:focus {
		border-color: #00b300;
		outline: 0;
		-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,0.075), 0 0 8px rgba(0,255,0,.6);
		box-shadow: inset 0 1px 1px rgba(0,0,0,0.075), 0 0 8px rgba(0,255,0,.6);
	}
	input.wrongAnswer:focus {
		border-color: #ff0000;
		outline: 0;
		-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,0.075), 0 0 8px rgba(255, 77, 77, .6);
		box-shadow: inset 0 1px 1px rgba(0,0,0,0.075), 0 0 8px rgba(255,77,77,.6);
	}
	#saveBtn-holder {
		text-align: center;
		margin-top: 2em;
	}
	.fa {
		margin-left: 0;
		margin-right: 0.3em;
	}
	.deleteDialog {
		display: none;
	}
</style>

@stop

@section('content')

<script type="text/javascript">
	$('.listBtn').removeClass('active');
	$('#li-edit').addClass('active');
</script>
<div class="container">
	<div class="title"><h2>Edit Practice 6: Read and find the appropriate answer for lesson {{ \App\Lesson::where('id', '=', $lessonId)->first()->lessonNo }}</h2></div>
	<div class="row description" style="text-align: center; font-size: 1.5em">
		Add questions or change existing ones by inserting contents into text fields below.
	</div>
	<div id="wrapper">
		<form id="p6Form" method="post" action="/editP6">
			{{ csrf_field() }}
			<input type="hidden" name="lessonId" value="{{ $lessonId }}">
			@php
			$dialogNo = 0;
			@endphp
			<div id="wrapAll">
				@foreach ($p6 as $element)
				<div class="row dialog-holder" data-dialog-id="{{ $element->id }}">
					<input type="hidden" class="dialogNo" name="update[{{ $element->id }}][dialogNo]" value="{{ ++$dialogNo }}">
					<div class="col-md-1">
						<label>{{ $dialogNo }}.</label>
					</div>
					<div class="col-md-10">
						<div class="row question-holder">
							<div class="col-md-12 form-group">
								<label for="updateDialog{{ $element->id }}">Question:</label>
								<textarea id="updateDialog{{ $element->id }}" class="form-control" name="update[{{ $element->id }}][dialog]" cols="30" rows="2">{{ str_replace('|', '&#013;&#010;', $element->dialog) }}</textarea>
							</div>
						</div>
						<div class="row answer-holder">
							<div class="col-md-4 form-group">
								<label for="updateCorrectAnswer{{ $element->id }}">Correct answer:</label>
								<input id="updateCorrectAnswer{{ $element->id }}" type="text" name="update[{{ $element->id }}][answers][correct]" class="form-control correctAnswer" value="{{ $element->correctAnswer }}">
							</div>
							<div class="col-md-4 form-group">
								<label for="updateWrongtAnswer1{{ $element->id }}">Wrong answer:</label>
								<input id="wrongtAnswer1{{ $element->id }}" type="text" name="update[{{ $element->id }}][answers][wrong1]" class="form-control wrongAnswer" value="{{ $element->wrongAnswer1 }}">
							</div>
							<div class="col-md-4 form-group">
								<label for="updateWrongtAnswer2{{ $element->id }}">Wrong answer:</label>
								<input id="wrongtAnswer2{{ $element->id }}" type="text" name="update[{{ $element->id }}][answers][wrong2]" class="form-control wrongAnswer" value="{{ $element->wrongAnswer2 }}">
							</div>
						</div>
					</div>
					<div class="col-md-1">
						<div class="deleteDialog">
							<button type="button" class="horizontal close">
								<i class="fa fa-trash fa-1x"></i>
							</button>
						</div>
					</div>
				</div>
				<hr>
				@endforeach
			</div>
			<div id="saveBtn-holder" class="row">
				<button id="newDialogBtn" class="btn btn-primary" type="button"><i class="fa fa-plus"></i><span class="newDialogBtnText">Add new sentence</span></button>
				<button id="saveBtn" class="btn btn-success" type="submit"><i class="fa fa-save"></i><span class="saveBtnText">Save</span></button>
			</div>
		</form>
	</div>
</div>

<script>
	var toAdd = 0;
	var dialogNo = {{ $dialogNo }};

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
		textarea.className = 'form-control';
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
		input.className = 'form-control correctAnswer';
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
		input.type = 'text';
		input.name = 'insert[' + toAdd + '][answers][wrong1]';
		input.className = 'form-control wrongAnswer';
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
		input.name = 'insert[' + toAdd + '][answers][wrong2]';
		input.className = 'form-control wrongAnswer';
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
	}

	var toDelete = '';

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
		if (toDelete) {
			$('<input />').attr('type', 'hidden')
			.attr('name', 'delete')
			.attr('value', toDelete)
			.appendTo('#p6Form');
			return true;
		}
	});

</script>
@stop