@extends('userLayout')

@section('header-more')

<link rel="stylesheet" href="{{ asset('css/screens/editP12.css') }}">

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

<script src="{{ asset('js/screens/editP12.js') }}"></script>
@stop