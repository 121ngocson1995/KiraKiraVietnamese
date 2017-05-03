@extends('userLayout')

@section('header-more')

<link rel="stylesheet" href="{{ asset('css/screens/editP13.css') }}">

@stop

@section('content')

<script type="text/javascript">
	$('.listBtn').removeClass('active');
	$('#li-edit').addClass('active');
</script>
<div class="container">
	<div class="title"><h2>Edit Practice 13: Text for lesson {{ $lessonNo }}</h2></div>
	<div class="row description" style="text-align: center; font-size: 1.5em">
		Change paragraph and requirement's content as well as translation by writing into text fields below
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
						<textarea name="update[{{ $p13[0]->id }}][text]" id="text" cols="30" rows="8" class="form-control vld-spc" maxlength="1500" placeholder="Enter example here" required>{{ $p13[0]->content }}</textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 form-group">
						<label for="text_note">Requirement:</label>
						<input name="update[{{ $p13[0]->id }}][note]" id="text_note" placeholder="Enter requirement here" maxlength="191" class="form-control vld-spc" value="{{ $p13[0]->note }}" required>
					</div>
					<div class="col-md-6 form-group">
						<label for="text_note_translate">Requirement's translation:</label>
						<input name="update[{{ $p13[0]->id }}][note_translate]" id="text_note_translate" placeholder="Enter translation for the requirement here" maxlength="191" class="form-control vld-spc" maxlength="191" value="{{ $p13[0]->note_translate }}" required>
					</div>
				</div>
				@else
				<div class="row form-group">
					<div class="col-md-12">
						<label for="text">Paragraph:</label>
						<textarea name="insert[text]" id="text" cols="30" rows="8" class="form-control vld-spc" maxlength="1500" placeholder="Enter example here" required></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 form-group">
						<label for="text_note">Requirement:</label>
						<input name="insert[note]" id="text_note" placeholder="Enter requirement here" maxlength="191" class="form-control vld-spc" required>
					</div>
					<div class="col-md-6 form-group">
						<label for="text_note_translate">Requirement's translation:</label>
						<input name="insert[note_translate]" id="text_note_translate" placeholder="Enter translation for the requirement here"  class="form-control vld-spc" maxlength="191" required>
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

<script src="{{ asset('js/screens/editP13.js') }}"></script>
@stop