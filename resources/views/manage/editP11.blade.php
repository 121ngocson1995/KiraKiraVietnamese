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
		padding: 0;
		width: 40px;
		display: inline-block;
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
	table {
		width: 100%;
	}
	table td {
		padding: 0.5em;
	}
	table th {
		padding: 0 0.5em;
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
	button.vertical.close {
		width: 40px;
		margin: 0;
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
		<form id="p11Form" method="post" action="/editP11">
			{{ csrf_field() }}
			<input type="hidden" name="lessonId" value="{{ $lessonId }}">
			<table>
				<tr>
					<th><label for="">Sentences</label><hr></th>
					<th><label for="">Order</label><hr></th>
					<th></th>
				</tr>
				<tr class="vertical-close-wrapper">
					<td></td>
					<td class="vertical-close-holder">
						@for ($i = 0; $i < count($p11); $i++)
						<button type="button" class="vertical close" aria-label="Delete">
							<span aria-hidden="true">&times;</span>
						</button>
						@endfor
					</td>
					<td></td>
				</tr>

				@if (count($p11))
				@foreach ($p11 as $element)
				<tr class="sentence" data-sentence-id="{{ $element->id }}">
					<td class="sentence-holder">
						<input type="text" class="form-control sentence-input" name="update[{{ $element->id }}][sentence]" value="{{ $element->sentence }}" required="">
					</td>
					<td class="order-holder">
						@php
						$orderNo = 0;
						@endphp

						@foreach ( explode(',', $element->correctOrder) as $order)
						<input type="text" class="form-control order-input" name="update[{{ $element->id }}][order][{{ (integer)$orderNo +1 }}]" value="{{ $order }}" required="">
						@php
						$orderNo++;
						@endphp
						@endforeach
					</td>
					<td class="delete-holder">
						<button type="button" class="horizontal close" aria-label="Delete">
							<span aria-hidden="true">&times;</span>
						</button>
					</td>
				</tr>
				@endforeach
				@endif
			</table>

			<div id="saveBtn-holder" class="row">
				<button id="newSentenceBtn" class="btn btn-primary" type="button"><i class="fa fa-plus"></i><span class="newSentenceBtnText">Add new sentence</span></button>
				<button id="newOrderBtn" class="btn btn-warning" type="button"><i class="fa fa-plus"></i><span class="newOrderBtnText">Add new order</span></button>
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
	var toAdd = -1;
	var maxColId = $('.order-holder')[0].children.length;

	function newSentence() {
		var tr = document.createElement('tr');
		tr.className = 'sentence';
		tr.setAttribute('data-insert-sentence-id', ++toAdd);

		var td = document.createElement('td');
		td.className = 'sentence-holder';
		var sentenceInput = document.createElement('input');
		sentenceInput.setAttribute('type', 'text');
		sentenceInput.className = 'form-control sentence-input';
		sentenceInput.setAttribute('name', 'insert[' + toAdd + '][sentence]');
		sentenceInput.setAttribute('required', '');
		td.appendChild(sentenceInput);
		tr.appendChild(td);

		td = document.createElement('td');
		td.className = 'order-holder';
		for (var i = 0; i < document.getElementsByClassName('order-holder')[0].children.length; i++) {
			
			var orderInput = document.createElement('input');
			orderInput.setAttribute('type', 'text');
			orderInput.className = 'form-control order-input';
			orderInput.setAttribute('name', 'insert[' + toAdd + '][order][' + i + ']');
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
		closeBtn.className = 'horizontal close';

		$(closeBtn).click(function() {
			deleteSentence($(this).closest('tr'));
		})

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

	function deleteOrder(orderColumn) {
		var closeHolder = $('.vertical-close-wrapper').find('.vertical-close-holder').get(0);

		if (closeHolder.children[orderColumn].nextSibling && closeHolder.children[orderColumn].nextSibling.nodeValue == '\xa0') {
			$(closeHolder.children[orderColumn].nextSibling).remove();
		}

		closeHolder.removeChild(closeHolder.children[orderColumn]);

		for (var i = 0; i < $('tr.sentence').length; i++) {
			var tr = $('tr.sentence')[i];

			var orderHolder = $(tr).find('.order-holder').get(0);

			if (orderHolder.children[orderColumn].nextSibling && orderHolder.children[orderColumn].nextSibling.nodeValue == '\xa0') {
				$(orderHolder.children[orderColumn].nextSibling).remove();
			}
			orderHolder.removeChild(orderHolder.children[orderColumn]);
		}
	}

	function newOrder() {
		for (var i = 0; i < $('tr.sentence').length; i++) {
			var tr = $('tr.sentence')[i];

			var orderHolder = $(tr).find('.order-holder').get(0);
			// console.log(orderHolder);

			var orderInput = document.createElement('input');
			orderInput.setAttribute('type', 'text');
			orderInput.className = 'form-control order-input';
			orderInput.setAttribute('name', (tr.getAttribute('data-sentence-id') ? 'update[' + tr.getAttribute('data-sentence-id') : 'insert[' + tr.getAttribute('data-insert-sentence-id')) + '][order][' + maxColId + ']');
			orderInput.setAttribute('required', '');
			orderHolder.appendChild(orderInput);
			$(orderHolder).append("&nbsp;");
		}
		maxColId++;

		var closeBtn = document.createElement('button');
		closeBtn.setAttribute('type', 'button');
		closeBtn.setAttribute('aria-label', 'Delete');
		closeBtn.className = 'vertical close';

		$(closeBtn).click(function() {
			deleteOrder([].indexOf.call(this.parentNode.children, this));
		})

		var closeSpan = document.createElement('span');
		closeSpan.setAttribute('aria-hidden', 'true');
		closeSpan.innerHTML = '×';
		closeBtn.appendChild(closeSpan);

		var closeHolder = $('.vertical-close-wrapper').find('.vertical-close-holder').get(0);
		closeHolder.appendChild(closeBtn);
		$(closeHolder).append("&nbsp;");
	}

	function checkOrderValue() {
		
	}

	$('#newSentenceBtn').click(function() {
		newSentence();
	});

	$('#newOrderBtn').click(function() {
		newOrder();
	});

	$('.horizontal.close').click(function() {
		deleteSentence($(this).closest('tr'));
	})

	$('.vertical.close').click(function() {
		deleteOrder([].indexOf.call(this.parentNode.children, this));
	})

	$('.pill-toggle').click(function(e) {
		e.preventDefault();
		$('.pill-toggle').parent().removeClass('active');
		$(this).parent().addClass('active');

		var orderNo = $(this).attr('id').replace('answer', '');
		showOrder(orderNo);
	});

	$("#p11Form").submit( function(eventObj) {
		checkOrderValue();

		if (toDelete) {
			$('<input />').attr('type', 'hidden')
			.attr('name', 'delete')
			.attr('value', toDelete)
			.appendTo('#p11Form');
			return true;
		}
	});
</script>
@stop

