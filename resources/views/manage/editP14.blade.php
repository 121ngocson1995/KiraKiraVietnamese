@extends('userLayout')

@section('header-more')

<link rel="stylesheet" href="{{ asset('css/screens/editP14.css') }}">

@stop

@section('content')

<script type="text/javascript">
	$('.listBtn').removeClass('active');
	$('#li-edit').addClass('active');
</script>
<div class="container">
	<div class="title"><h2>Edit Practice 14: Learn by heart the following sentence patterns for lesson {{ $lessonNo }}</h2></div>
	<div class="row description" style="text-align: center; font-size: 1.5em">
		Add new sentence's pattern or change existing ones by writing into appropriate text fields below.
	</div>
	<div id="wrapper">
		<form id="p14Form" method="post" action="/editP14">
			{{ csrf_field() }}
			<input type="hidden" name="lessonId" value="{{ $lessonId }}">
			@php
			$sentenceNo = 0;
			@endphp
			<div id="sentencesHolder">
				@if (count($p14))
				@foreach ($p14 as $element)
				<div class="row sentence" data-sentence-id="{{ $element->id }}" data-sentence-no="{{ $element->sentenceNo }}">
					<div class="col-md-1">
						<label>{{ ++$sentenceNo }}.</label>
					</div>
					<div class="form-group col-md-10 sentenceParts-holder">
						<div class="tabble">
							<input type="hidden" name="update[{{ $element->id }}][sentenceNo]" value="{{ $element->sentenceNo }}">
							@for ($partId = 0; $partId < count($element->sentenceParts); $partId++)
							<div class="sentenceParts">
								@for ($optionId = 0; $optionId < count($element->sentenceParts[$partId]); $optionId++)
								<div class="option aligned">
									<button type="button" class="close deleteOption" aria-label="Delete">
										<span aria-hidden="true">×</span>
									</button>
									<textarea class="form-control vld-spc" maxlength="200" rows="1" name="update[{{ $element->id }}][sentence][{{ $partId }}][]" required="">{{ $element->sentenceParts[$partId][$optionId] }}</textarea>
								</div>
								@endfor
								<div class="controlBtn-holder">
									<button class="addInputBtn" type="button"><i class="fa fa-plus-circle"></i></button>
								</div>
							</div>
							@endfor
						</div>
						<div class="addPart">
							<button type="button" class="addPartBtn"><i class="fa fa-plus-circle fa-2x"></i></button>
						</div>
					</div>
					<div class="deleteSentence">
						<button type="button" class="horizontal close">
							<i class="fa fa-trash fa-1x"></i>
						</button>
					</div>
				</div>
				<hr>
				@endforeach
				@endif
			</div>

			<div id="saveBtn-holder" class="row">
				<button id="newSentenceBtn" class="btn btn-primary" type="button"><i class="fa fa-plus"></i><span class="newSentenceBtnText">Add new sentence</span></button>
				<button id="saveBtn" class="btn btn-success" type="submit"><i class="fa fa-save"></i><span class="saveBtnText">Save</span></button>
			</div>
		</form>
	</div>
</div>

<script>
	var sentenceNo = {{ $sentenceNo }};
</script>

<script src="{{ asset('js/screens/editP14.js') }}"></script>
@stop