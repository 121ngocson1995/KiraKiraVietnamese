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
	input {
		height: 50px !important;
		font-size: 1.25em !important;
		margin: 0 0.2em;
		width: initial !important;
		text-align: center;
		padding: 8px 20px;
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
	div.addPart {
		display: inline-block;
		transform: translateY(4px);
	}
	div.word {
		text-align: right;
	}
	button {
		outline: none;
	}
	button.addPartBtn {
		background: transparent;
		/*font-size: 1.4em;*/
		border: none;
		opacity: 0.4;
		display: none;
	}
	button.addPartBtn:hover {
		opacity: 1;
	}
	button.close {
		color: black;
		float: none;
		margin: 0 0.5em;
		line-height: initial;
		display: none;
	}
	button.close:hover, button.close:focus {
		color: black;
	}
	.deleteSentence {
		position: absolute;
		right: 0;
		margin-right: 5em;
		transform: translateY(-2.7em);
		background: transparent;
		/*font-size: 1.4em;*/
		border: none;
		/*right: 2em;*/
		/*position: absolute;*/
		/*transform: translateY(-20%);*/
		display: none;
	}
	.deleteSentence button {
		display: initial !important;
		position: initial !important;
		margin: 0;
	}

	button.deleteOption {
		float: right;
		margin-left: -30px;
		margin-top: 8px;
	}
	input:focus {
		border-color: red;
	}
</style>

@stop

@section('content')

<script type="text/javascript">
	$('.listBtn').removeClass('active');
	$('#li-edit').addClass('active');
</script>
<div class="container">
	<div class="title"><h2>Edit Practice 10: Reorder the words to make the complete sentence for lesson {{ \App\Lesson::where('id', '=', $lessonId)->first()->lessonNo }}</h2></div>
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
							<input type="text" class="form-control wordText" maxlength="191" name="update[{{ $word->id }}][word]" onkeypress="changeTextboxWidth(this)" value="{{ $word->word }}" required="">
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
	 * テキストボックスの幅を変更するように機能を呼び出す。
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

	/**
	 * Add a new sentence
	 *　新しいセンテンスを追加する。
	 * 
	 * @return {void}
	 */
	 function addSentence() {
	 	var div = document.createElement('div');
	 	div.className = 'row sentence-holder';
	 	div.setAttribute('data-insert-sentence-id', ++toAdd);

	 	var divSentenceNo = document.createElement('div');
	 	divSentenceNo.className = 'sentenceNo';

	 	var label = document.createElement('label');
	 	label.innerHTML = (++sentenceNo) + '.';
	 	divSentenceNo.appendChild(label);
	 	div.appendChild(divSentenceNo);

	 	var sentenceParts = document.createElement('div');
	 	sentenceParts.className = 'sentenceParts';

	 	sentenceParts.appendChild(createWord(sentenceNo));
	 	div.appendChild(sentenceParts);

	 	var addPart = document.createElement('div');
	 	addPart.className = 'addPart';

	 	var button = document.createElement('button');
	 	button.className = 'addPartBtn';
	 	button.setAttribute('type', 'button');

	 	var i = document.createElement('i');
	 	i.className =  'fa fa-plus-circle fa-2x';
	 	button.appendChild(i);

	 	$(button).click(function() {
	 		addWord(this);
	 	});

	 	addPart.appendChild(button);
	 	div.appendChild(addPart);

	 	var deleteSentence = document.createElement('div');
	 	deleteSentence.className = 'deleteSentence';

	 	button = document.createElement('button');
	 	button.className = 'horizontal close';
	 	button.setAttribute('type', 'button');

	 	i = document.createElement('i');
	 	i.className = 'fa fa-trash';
	 	button.appendChild(i);

	 	$(button).click(function() {
	 		var sentence = $(this).closest('.sentence-holder');
	 		$(sentence).find('input.wordText').each(function() {
	 			if($(this).attr('name').indexOf('update') != -1) {
	 				var name = $(this).attr('name');

	 				var id = parseInt(name.split('[')[1].replace(']', ''));

	 				if (toDelete) {
	 					toDelete += ',';
	 				}
	 				toDelete += id;
	 			}
	 		});

	 		sentence.next().remove();
	 		sentence.remove();

	 		sentenceNo = $('div.row.sentence-holder').length;
	 		for (var i = 0; i < $('div.sentence-holder').length; i++) {
	 			$('div.sentence-holder').eq(i).find('label')[0].innerHTML = '' + (i+1) + '.';
	 			$('div.sentence-holder').eq(i).find('input[type="hidden"]').attr('value', '' + (i+1));
	 		}
	 	});

	 	deleteSentence.appendChild(button);
	 	div.appendChild(deleteSentence);

	 	$(div).hover(function() {
	 		$(this).find('button.addPartBtn').fadeIn(60);
	 		$(this).find('.deleteSentence').fadeIn(60);
	 	}, function() {
	 		$(this).find('button.addPartBtn').fadeOut(60);
	 		$(this).find('.deleteSentence').fadeOut(60);
	 	});

	 	document.getElementsByClassName('sentences')[0].appendChild(div);
	 	var hr = document.createElement('hr')
	 	document.getElementsByClassName('sentences')[0].appendChild(hr);

	 	$('.sentences').find('input').last().focus();
	 }

	/**
	 * Store id of content to be deleted
	 * 削除する内容のイドを保存する。
	 * @type {String}
	 */	
	 var toDelete = '';

	/**
	 * Delete a sentence
	 *　センテンスを削除する。
	 *
	 * @param  {DOM Object}
	 *
	 * @return {[type]}
	 */
	 function deleteSentence(sentence) {
	 	$(sentence).find('.word').each(function() {
	 		deleteWord($(this));
	 	});

	 	sentence.next().remove();
	 	sentence.remove();

	 	sentenceNo = $('div.row.sentence-holder').length;
	 	for (var i = 0; i < $('div.sentence-holder').length; i++) {
	 		$('div.sentence-holder').eq(i).find('label')[0].innerHTML = '' + (i+1) + '.';
	 		$('div.sentence-holder').eq(i).find('input[type="hidden"]').attr('value', '' + (i+1));
	 	}
	 }

	/**
	 * Add a new word
	 *　新しい単語を追加する。
	 *
	 * @param {void}
	 */
	 function addWord(button) {
	 	var sentenceParts = $(button).closest('div.sentence-holder').find('.sentenceParts');
	 	var existedWords = sentenceParts.find('.word');
	 	var wordsCount = existedWords.length;

	 	var word = 0;
	 	toAdd++;
	 	var newSentenceNo = parseInt($(button).closest('.sentence-holder').find('label')[0].innerHTML.replace('.' ,''));

	 	sentenceParts[0].appendChild(createWord(newSentenceNo));

	 	$(sentenceParts).find('input').last().focus();
	 }

	/**
	 * Delete a word
	 *　単語を削除する。
	 *
	 * @param  {DOM Object}
	 *
	 * @return {[type]}
	 */
	 function deleteWord(word) {
	 	if(word.find('.wordText').attr('name').indexOf('update') != -1) {
	 		var name = word.find('.wordText').attr('name');

	 		var id = parseInt(name.split('[')[1].replace(']', ''));

	 		if (toDelete) {
	 			toDelete += ',';
	 		}
	 		toDelete += id;
	 	}

	 	word.remove();
	 }

	/**
	 * Return newly created word object
	 *　新しい作成する単語のオブジェクトをリターンする。
	 *
	 * @param  {integer}
	 *
	 * @return {DOM Object}
	 */
	 function createWord(sentenceNo=null) {
	 	var word = document.createElement('div');
	 	word.className = 'word';

	 	var inputSentenceNo = document.createElement('input');
	 	inputSentenceNo.setAttribute('type', 'hidden');
	 	inputSentenceNo.setAttribute('name', 'insert[' + toAdd + '][sentenceNo]');
	 	inputSentenceNo.setAttribute('value', sentenceNo ? sentenceNo.toString() : '1');
	 	word.appendChild(inputSentenceNo);

	 	var button = document.createElement('button');
	 	button.className ='close deleteOption';
	 	button.setAttribute('type', 'button');
	 	button.setAttribute('aria-label', 'Delete');

	 	var span = document.createElement('span');
	 	span.setAttribute('aria-hidden', 'true');
	 	span.innerHTML = '×';
	 	button.appendChild(span);

	 	$(button).click(function() {
	 		deleteWord($(this).closest('div.word'));
	 	});

	 	word.appendChild(button);

	 	var input = document.createElement('input');
	 	input.className = 'form-control wordText';
	 	input.setAttribute('type', 'text');
	 	input.setAttribute('maxlength', '191');
	 	input.setAttribute('name', 'insert[' + toAdd + '][word]');
	 	input.setAttribute('size', '2');
	 	input.setAttribute('required', '');

	 	$(button).click(function() {
	 		deleteWord($(this).closest('div.word'));
	 	});

	 	$(input).on('keypress', function() {
	 		changeTextboxWidth(this);
	 	});

	 	word.appendChild(input);

	 	$(word).hover(function() {
	 		$(this).find('button.deleteOption').fadeIn(60);
	 	}, function() {
	 		$(this).find('button.deleteOption').fadeOut(60);
	 	});

	 	return word;
	 }

	/**
	 * Show Add sentence button when hovering on a sentence
	 *　センテンスにホバリングをすると「Add　sentence」ボタンを表す。
	 *
	 */
	 $('div.sentence-holder').hover(function() {
	 	$(this).find('button.addPartBtn').fadeIn(60);
	 	$(this).find('.deleteSentence').fadeIn(60);
	 }, function() {
	 	$(this).find('button.addPartBtn').fadeOut(60);
	 	$(this).find('.deleteSentence').fadeOut(60);
	 });

	/**
	 * Show Delete button when hovering on a word
	 *　単語にホバリングすると、「Delete」ボタンを表す。
	 */
	 $('.word').hover(function() {
	 	$(this).find('button.deleteOption').fadeIn(60);
	 }, function() {
	 	$(this).find('button.deleteOption').fadeOut(60);
	 });

	/**
	 * Delete word upon button click
	 * ボタンをクリックすると、単語を削除する。
	 * 
	 */
	 $('button.deleteOption').click(function() {
	 	deleteWord($(this).closest('div.word'));
	 });

	/**
	 * Add a new word upon button click
	 * ボタンをクリックすると、新しい単語を追加する。
	 */
	 $('button.addPartBtn').click(function() {
	 	addWord(this);
	 });

	/**
	 * Add a new sentence upon button click
	 * ボタンをクリックすると、新しいセンテンスを追加する。
	 */
	 $('button#newSentenceBtn').click(function() {
	 	addSentence();
	 });

	/**
	 * Delete a sentence upon button click
	 * ボタンをクリックすると、センテンスを削除する。
	 */
	 $('.deleteSentence button').click(function() {
	 	deleteSentence($(this).closest('.sentence-holder'));
	 });

	/**
	 * Add a list of id of element to delete to the submiting form
	 * 提出するフォームを削除するように、様子のイドのリストを追加する。
	 */
	 $("#p10Form").submit( function(eventObj) {
	 	console.log(toDelete);
	 	if (toDelete) {
	 		$('<input />').attr('type', 'hidden')
	 		.attr('name', 'delete')
	 		.attr('value', toDelete)
	 		.appendTo('#p10Form');
	 		return true;
	 	}
	 });

	</script>
	@stop