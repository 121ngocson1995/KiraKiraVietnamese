@extends('userLayout')

@section('header-more')

<style type="text/css">
	.sentence-input {
		/*width: 100%;*/
		display: inline-block;
	}
	#wrapper {
		padding: 4em;
	}
	.close-col {
		text-align: center;
	}
	input.order-input {
		text-align: center;
	}
	button.close {
		color: black;
		float: none;
		/*position: absolute;*/
		/*right: 4em;*/
		/*transform: translateY(30%);*/
		margin: 0 0.5em;
		outline: none;
		line-height: initial;
	}
	button.close:hover, button.close:focus {
		color: black;
	}
	.form-group {
		vertical-align: middle;
	}
	span.label.sentenceNo {
		width: 2.5em;
		font-size: 1.2em;
		transform: translateY(17%);
		display: inline-block
	}
	div.row.allAnswers {
		margin-top: 5em;
	}
	a.pill-toggle {
		transition: all 0.2s;
	}
	div#saveBtn-holder {
		margin-top: 1em;
		text-align: center;
	}
	.fa {
		margin-left: 0;
		margin-right: 0.3em;
	}
	.order-input {
		width: 3em;
		display: inline-block;
	}
	table {
		width: 100%;
	}
	table td, table th {
		padding: 0.5em;
	}
	td.order-holder {
		width: 1px;
		white-space: nowrap;
	}
	td.delete-holder {
		width: 1px;
		white-space: nowrap;
		text-align: center;
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
		<form method="post" action="/editP11">
			{{ csrf_field() }}
			<input type="hidden" name="lessonId" value="{{ $lessonId }}">
			<table>
				<tr>
					<th><label for="">Sentences</label></th>
					<th><label for="">Order</label></th>
					<th><label for=""">Delete</label></th>
				</tr>

				@if (count($p11))
				@foreach ($p11 as $element)
				<tr data-sentence-id="{{ $element->id }}">
					<td class="sentence-holder">
						<input type="text" class="form-control sentence-input" name="update[{{ $element->id }}][sentence]" value="{{ $element->sentence }}">
					</td>
					<td class="order-holder">
						@php
						$orderNo = 0;
						@endphp

						@foreach ( explode(',', $element->correctOrder) as $order)
						<input type="text" class="form-control order-input" name="update[{{ $element->id }}][order][{{ $orderNo }}]" value="{{ $order }}" required="">
						@php
						$orderNo++;
						@endphp
						@endforeach
					</td>
					<td class="delete-holder">
						<button type="button" class="close" aria-label="Delete">
							<span aria-hidden="true">&times;</span>
						</button>
					</td>
				</tr>
				@endforeach
				@endif
			</table>

			<div id="saveBtn-holder" class="row">
				<button id="newSentenceBtn" class="btn btn-primary" type="button"><i class="fa fa-plus"></i><span class="newSentenceBtnText">Add new sentence</span></button>
				<button id="newOrder" class="btn btn-warning" type="button"><i class="fa fa-plus"></i><span class="newOrderText">Add new order</span></button>
				<button id="saveBtn" class="btn btn-success" type="submit"><i class="fa fa-save"></i><span class="saveBtnText">Save</span></button>
			</div>

			{{-- <div id="answer-holder" class="row allAnswers"><label for="">There is currently a total of <span id="answers_number">{{ count($correctAnswerList) }}</span> answers for this practice</label>
				@php
				$i = 0;
				@endphp
				<ul class="nav nav-pills nav-justified">
					@foreach ( $correctAnswerList as $answer)
					<li><a id="answer{{ $i++ }}" class="pill-toggle" data-toggle="pill" href="#wrapper">{{ $i }}</a></li>
					@endforeach
				</ul>
			</div> --}}
		</form>
	</div>
</div>

<script>
	var correctAnswerList;
	var toAdd = 0;

	function newSentence() {
		var tr = document.createElement('tr');

		var td = document.createElement('td');
		td.className = 'sentence-holder';
		var sentenceInput = document.createElement('input');
		sentenceInput.setAttribute('type', 'text');
		sentenceInput.setAttribute('name', 'update[' + toAdd++ + '][sentence]');
		sentenceInput.className = 'form-control sentence-input';
		td.appendChild(sentenceInput);
		tr.appendChild(td);

		td = document.createElement('td');
		td.className = 'order-holder';
		for (var i = 0; i < document.getElementsByClassName('order-holder')[0].children.length; i++) {
			
			var orderInput = document.createElement('input');
			orderInput.setAttribute('type', 'text');
			orderInput.className = 'form-control order-input';
			orderInput.setAttribute('name', 'update[' + toAdd + '][order][' + i + ']');
			orderInput.setAttribute('required', '');
			td.appendChild(orderInput);
			$(td).append("&nbsp;");
		}
		tr.appendChild(td);

		td = document.createElement('td');
		td.className = 'delete-holder';

		var closeBtn = document.createElement('button');
		closeBtn.setAttribute('type', 'button');
		closeBtn.setAttribute('aria-label', 'Delete');
		closeBtn.className = 'close';

		var closeSpan = document.createElement('span');
		closeSpan.setAttribute('aria-hidden', 'true');
		closeSpan.innerHTML = '×';
		closeBtn.appendChild(closeSpan);

		td.appendChild(closeBtn);
		tr.appendChild(td);

		document.getElementsByTagName('tbody')[0].appendChild(tr);
	}

	var toDelete = '';

	function deleteSentence(sentenceRow) {
		if (sentenceRow.attr('data-sentence-id')) {
			if (toDelete) {
				toDelete += ','
			}
			toDelete += sentenceRow.attr('data-sentence-id');
		}

		sentenceRow.get(0).parentElement.removeChild(sentenceRow.get(0));
	}

	// function showOrder(orderNo) {
	// 	var answerToShow = correctAnswerList[orderNo];

	// 	for (var i = 0; i < answerToShow.id.length; i++) {
	// 		for (var j = 0; j < document.getElementById('content-holder').childNodes.length; j++) {

	// 			if ($('#content-holder').children()[j].getAttribute('data-sentence-id') == answerToShow.id[i]) {

	// 				console.log('a');

	// 				$('.order-input').eq(j).attr('value', parseInt(answerToShow.order[i]) + 1);

	// 				break;
	// 			}
	// 		}
	// 	}
	// }

	// function saveOrder() {
	// 	if (!hasEnoughOrder()) {
	// 		alert('You haven\'t finished ordering yet.');
	// 		return;
	// 	}

	// 	var newAnswer = makeAnswer();

	// 	correctAnswerList.push();
	// }

	// function hasEnoughOrder() {
	// 	$('#content-holder').children().each(function() {
	// 		if ($(this).find('span.sentenceNo').length != 1) {
	// 			return false;
	// 		}
	// 	});

	// 	return true;
	// }

	function makeAnswer() {

	}

	$('#newSentenceBtn').click(function() {
		newSentence();
	});

	$('#newOrderBtn').click(function() {
		saveOrder();
	});

	$('.close').click(function() {
		deleteSentence($(this).closest('tr'));
	})

	$('.pill-toggle').click(function(e) {
		e.preventDefault();
		$('.pill-toggle').parent().removeClass('active');
		$(this).parent().addClass('active');

		var orderNo = $(this).attr('id').replace('answer', '');
		showOrder(orderNo);
	});

	$("#situationForm").submit( function(eventObj) {
		var validateFail = false;
		$('.row.situationRow').each(function() {
			var situaNo = parseInt($(this).attr('data-line')) + 1;
			var dialog_text = $("#dialog"+situaNo).val();
			var dialogTrans_text = $("#dialogTrans"+situaNo).val();
			var dialog_count = dialog_text.split("\n").length;
			var dialogTrans_count = dialogTrans_text.split("\n").length;

			if (dialog_count != dialogTrans_count) {
				document.getElementById("dialog"+situaNo).style.borderColor = "red";
				document.getElementById("dialogTrans"+situaNo).style.borderColor = "red";
				validateFail = true;
			}else{
				document.getElementById("dialog"+situaNo).style.borderColor = "transparent";
				document.getElementById("dialogTrans"+situaNo).style.borderColor = "transparent";
			}
		})

		if (validateFail) {
			alert("The number of dialog sentence must equal to the dialog translate. Please check again !");
			return false;
		}

		$('.undone').each(function() {
			if($(this).hasClass('image') && $(this).attr('data-path-image') != ''){
				$('<input />').attr('type', 'hidden')
				.attr('name', "imgPath"+$(this).attr('data-situ'))
				.attr('value', $(this).attr('data-path-image'))
				.appendTo('#situationForm');
				return true;
			}else if($(this).hasClass('audio') && $(this).attr('data-path-audio') != ''){
				$('<input />').attr('type', 'hidden')
				.attr('name', "audioPath"+$(this).attr('data-situ'))
				.attr('value', $(this).attr('data-path-audio'))
				.appendTo('#situationForm');
				return true;
			}
		})
	});
</script>
@stop

