@extends('userLayout')

@section('header-more')

<link rel="stylesheet" href="{{ asset('css/screens/editP10.css') }}">

@stop

@section('content')

<script type="text/javascript">
	$('.listBtn').removeClass('active');
	$('#li-edit').addClass('active');
</script>
<div class="container">
	<div class="title"><h2>Edit Practice 10: Reorder the words to make the complete sentence for lesson {{ $lessonNo }}</h2></div>
	<div class="row description" style="text-align: center; font-size: 1.5em">
		Add or change sentences and words by writing into appropriate text fields below.
	</div>
	<div id="wrapper">
		<form id="p10Form" method="post" action="/editP10">
			{{ csrf_field() }}
			<input type="hidden" name="lessonId" value="{{ $lessonId }}">
			<div class="sentences">
				@php
				$sentenceNo = 0;
				@endphp
				@foreach ($p10Element as $element)
				<div class="row sentence-holder" data-sentence-No="{{ $sentenceNo }}">
					<div class="sentenceNo">
						<label>{{ ++$sentenceNo }}.</label>
					</div>
					<div class="sentenceParts">
						@foreach ($element as $word)
						<div class="word">
							<input type="hidden" name="update[{{ $word->id }}][sentenceNo]" value="{{ $sentenceNo }}">
							<button type="button" class="close deleteOption" aria-label="Delete">
								<span aria-hidden="true">×</span>
							</button>
							<input type="text" class="form-control wordText vld-spc" maxlength="191" name="update[{{ $word->id }}][word]" onkeypress="changeTextboxWidth(this)" value="{{ $word->word }}" required="">
						</div>
						@endforeach
					</div>
					<div class="addPart">
						<button type="button" class="addPartBtn"><i class="fa fa-plus-circle fa-2x"></i></button>
					</div>
					<div class="deleteSentence">
						<button type="button" class="horizontal close">
							<i class="fa fa-trash"></i>
						</button>
					</div>
				</div>
				<hr>
				@endforeach
			</div>
			<div id="saveBtn-holder" class="row">
				<button id="newSentenceBtn" class="btn btn-primary" type="button"><i class="fa fa-plus"></i><span class="newSentenceBtnText">Add new sentence</span></button>
				<button id="saveBtn" class="btn btn-success" type="submit"><i class="fa fa-save"></i><span class="saveBtnText">Save</span></button>
			</div>
		</form>
	</div>
</div>

<script>
	var toAdd = 0;
	var sentenceNo = {{ $sentenceNo }};

	/**
	 * Call function to change textbox's width
	 * テキストボックスの幅を変更する機能を呼び出す。
	 */
	 $('input').each(function() {
	 	changeTextboxWidth(this);
	 });

	/**
	 * Change textbox's width
	 * テキストボックスの幅を変更する。
	 *
	 * @param  {DOM Object}
	 *
	 * @return {void}
	 */
	 function changeTextboxWidth(input) {
	 	input.size = parseInt(input.value.length) + 1;
	 }
	</script>

	<script src="{{ asset('js/screens/editP10.js') }}"></script>
	@stop