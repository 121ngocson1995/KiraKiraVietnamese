@extends('userLayout')

@section('header-more')

<link rel="stylesheet" href="{{ asset('css/screens/editP6.css') }}">

@stop

@section('content')

<script type="text/javascript">
	$('.listBtn').removeClass('active');
	$('#li-edit').addClass('active');
</script>
<div class="container">
	<div class="title"><h2>Edit Practice 6: Read and find the appropriate answer for lesson {{ $lessonNo }}</h2></div>
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
								<textarea id="updateDialog{{ $element->id }}" class="form-control textarea vld-spc" required="true" maxlength="200" name="update[{{ $element->id }}][dialog]" cols="30" rows="2">{{ str_replace('|', '&#013;&#010;', $element->dialog) }}</textarea>
							</div>
						</div>
						<div class="row answer-holder">
							<div class="col-md-4 form-group">
								<label for="updateCorrectAnswer{{ $element->id }}">Correct answer:</label>
								<input id="updateCorrectAnswer{{ $element->id }}" type="text" name="update[{{ $element->id }}][answers][correct]" class="form-control correctAnswer vld-spc" required="true" maxlength="20" value="{{ $element->correctAnswer }}">
							</div>
							<div class="col-md-4 form-group">
								<label for="updateWrongtAnswer1{{ $element->id }}">Wrong answer:</label>
								<input id="wrongtAnswer1{{ $element->id }}" type="text" name="update[{{ $element->id }}][answers][wrong1]" class="form-control wrongAnswer vld-spc" required="true" maxlength="20" value="{{ $element->wrongAnswer1 }}">
							</div>
							<div class="col-md-4 form-group">
								<label for="updateWrongtAnswer2{{ $element->id }}">Wrong answer:</label>
								<input id="wrongtAnswer2{{ $element->id }}" type="text" name="update[{{ $element->id }}][answers][wrong2]" class="form-control wrongAnswer vld-spc" required="true" maxlength="20" value="{{ $element->wrongAnswer2 }}">
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

	var lines = 2;

	$('.textarea').each(function() {
		$(this).keydown(function(e) {
			newLines = $(this).val().split("\n").length;
			if(e.keyCode == 13 && newLines >= lines) {
				return false;
			}
		});
	});
</script>

<script src="{{ asset('js/screens/editP6.js') }}"></script>
@stop