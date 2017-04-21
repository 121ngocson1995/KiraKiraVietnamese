@extends('userLayout')

@section('header-more')

<style type="text/css">
	.sentence-input {
		/*width: 100%;*/
		display: inline-block;
	}
	#wrapper {
		padding: 2em 4em;
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
	.fa {
		margin-left: 0;
		margin-right: 0.3em;
	}
	#saveBtn-holder {
		text-align: center;
		margin-top: 2em;
	}
</style>

@stop

@section('content')

<script type="text/javascript">
	$('.listBtn').removeClass('active');
	$('#li-edit').addClass('active');
</script>
<div class="container">
	<div id="wrapper">
		<form id="p12Form" method="post" action="/editP12">
			{{ csrf_field() }}
			<input type="hidden" name="lessonId" value="{{ $lessonId }}">
			<div class="sentences">
				@php
				$sentenceNo = 0;
				@endphp
				@if (count($p12))
				<div class="row">
					<div class="col-md-6 form-group">
						<label for="text_content">Requirement:</label>
						<textarea name="update[{{ $p12[0]->id }}][content]" id="text_content" cols="30" rows="10" placeholder="Enter requirement here" maxlength="191" class="form-control" required>{{ $p12[0]->content }}</textarea>
					</div>
					<div class="col-md-6 form-group">
						<label for="text_content_translate">Requirement's translation:</label>
						<textarea name="update[{{ $p12[0]->id }}][content_translate]" id="text_content_translate" cols="30" rows="10" placeholder="Enter translation for the requirement here" maxlength="191" class="form-control" maxlength="191" required>{{ $p12[0]->content_translate }}</textarea>
					</div>
				</div>
				@else
				<div class="row">
					<div class="col-md-6 form-group">
						<label for="text_content">Requirement:</label>
						<textarea name="insert[content]" id="text_content" cols="30" rows="10" placeholder="Enter requirement here" maxlength="191" class="form-control" required></textarea>
					</div>
					<div class="col-md-6 form-group">
						<label for="text_content_translate">Requirement's translation:</label>
						<textarea name="insert[content_translate]" id="text_content_translate" cols="30" rows="10" placeholder="Enter translation for the requirement here" maxlength="191" class="form-control" required></textarea>
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

</script>
@stop