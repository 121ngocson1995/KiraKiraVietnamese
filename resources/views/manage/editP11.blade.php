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
		opacity: 0.4 !important;
	}
	button.close:hover, button.close:focus {
		color: #e60000;
		opacity: 1 !important;
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
	#error .close {
		color: #8a6d3b;
	}
	.alert-warning {
		color: #8a6d3b;
		background-color: #f5e8a3;
		border-color: #f4d18b;
	}
	.orderError {
		background-color: #f2dede;
	}
	input.focus {
		border-color: #66afe9;
		outline: 0;
		-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,0.075), 0 0 8px rgba(102,175,233,0.6);
		box-shadow: inset 0 1px 1px rgba(0,0,0,0.075), 0 0 8px rgba(102,175,233,0.6);
	}
</style>

@stop

@section('content')

<script type="text/javascript">
	$('.listBtn').removeClass('active');
	$('#li-edit').addClass('active');
</script>
<div class="container">
	<div class="title"><h2>Edit Practice 11: Read and reorder the the sentences to make a complete dialogue for lesson {{ $lessonNo }}</h2></div>
	<div class="row description" style="text-align: center; font-size: 1.5em">
		Change sentences and sentences' order by writing into text fields below
	</div>
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
						@if (count($p11))
						@for ($i = 0; $i < count(explode(',', $p11[0]->correctOrder)); $i++)
						<button type="button" class="vertical close" aria-label="Delete">
							<span aria-hidden="true">&times;</span>
						</button>
						@endfor
						@endif
					</td>
					<td></td>
				</tr>

				@if (count($p11))
				@foreach ($p11 as $element)
				<tr class="sentence" data-sentence-id="{{ $element->id }}">
					<td class="sentence-holder">
						<input type="text" class="form-control sentence-input vld-spc" maxlength="80" name="update[{{ $element->id }}][sentence]" value="{{ $element->sentence }}" required="">
					</td>
					<td class="order-holder">
						@php
						$orderNo = 0;
						@endphp

						@foreach ( explode(',', $element->correctOrder) as $order)
						<input type="number" min="1" class="form-control order-input" name="update[{{ $element->id }}][order][{{ $orderNo }}]" value="{{ (integer)$order + 1 }}" required="">
						@php
						$orderNo++;
						@endphp
						@endforeach
					</td>
					<td class="delete-holder">
						<button type="button" class="horizontal close" aria-label="Delete">
							<span aria-hidden="true"><i class="fa fa-trash fa-1x"></i></span>
						</button>
					</td>
				</tr>
				@endforeach
				@endif
			</table>

			<div id="error"></div>

			<div id="saveBtn-holder" class="row">
				<button id="newSentenceBtn" class="btn btn-primary" type="button"><i class="fa fa-plus"></i><span class="newSentenceBtnText">Add new sentence</span></button>
				<button id="newOrderBtn" class="btn btn-warning" type="button"><i class="fa fa-plus"></i><span class="newOrderBtnText">Add new order</span></button>
				<button id="saveBtn" class="btn btn-success" type="submit"><i class="fa fa-save"></i><span class="saveBtnText">Save</span></button>
			</div>
		</form>
	</div>
</div>

<script>
	var correctAnswerList;
	var toAdd = -1;
	var maxColId = $('.order-holder').length ? $('.order-holder')[0].children.length : 0;

	/**
	 * Create a new sentence
	 * 新しいセンテンスを作成する。
	 *
	 * @return {void}
	 */
	 function newSentence() {
	 	var tr = document.createElement('tr');
	 	tr.className = 'sentence';
	 	tr.setAttribute('data-insert-sentence-id', ++toAdd);

	 	var td = document.createElement('td');
	 	td.className = 'sentence-holder';
	 	var sentenceInput = document.createElement('input');
	 	sentenceInput.setAttribute('type', 'text');
	 	sentenceInput.setAttribute('required', 'true');
	 	sentenceInput.setAttribute('maxlength', '80');
	 	sentenceInput.className = 'form-control sentence-input vld-spc';
	 	sentenceInput.setAttribute('name', 'insert[' + toAdd + '][sentence]');
	 	sentenceInput.setAttribute('required', '');
	 	td.appendChild(sentenceInput);
	 	tr.appendChild(td);
	 	td = document.createElement('td');
	 	td.className = 'order-holder';
	 	if (document.getElementsByClassName('order-holder').length) {
	 		for (var i = 0; i < document.getElementsByClassName('order-holder')[0].children.length; i++) {
	 			
	 			var orderInput = document.createElement('input');
	 			orderInput.setAttribute('type', 'text');
	 			orderInput.className = 'form-control order-input';
	 			orderInput.setAttribute('name', 'insert[' + toAdd + '][order][' + i + ']');
	 			orderInput.setAttribute('required', '');
	 			$(orderInput).focus(function() {
	 				focusCol(this);
	 			}).blur(function() {
	 				blurCol(this);
	 			});
	 			td.appendChild(orderInput);
	 			$(td).append("&nbsp;");
	 		}
	 	} else {
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

	 		var orderInput = document.createElement('input');
	 		orderInput.setAttribute('type', 'number');
	 		orderInput.setAttribute('min', '1');
	 		orderInput.className = 'form-control order-input';
	 		orderInput.setAttribute('name', 'insert[' + toAdd + '][order][' + i + ']');
	 		orderInput.setAttribute('required', '');
	 		$(orderInput).focus(function() {
	 			focusCol(this);
	 		}).blur(function() {
	 			blurCol(this);
	 		});
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
	 	closeSpan.innerHTML = '<i class="fa fa-trash fa-1x"></i>';
	 	closeBtn.appendChild(closeSpan);

	 	td.appendChild(closeBtn);
	 	tr.appendChild(td);

	 	document.getElementsByTagName('tbody')[0].appendChild(tr);
	 }

	/**
	 * Store id of content to be deleted
	 * 削除する内容のイドを保存する。
	 *
	 * @type {String}
	 */
	 var toDelete = '';

	 function deleteSentence(sentenceRow) {
	 	if (!confirm('Are you sure you want to delete this sentence?\r\nYou can recover the data by refreshing the page.')) {
	 		return;
	 	}

	 	if (sentenceRow.attr('data-sentence-id')) {
	 		if (toDelete) {
	 			toDelete += ','
	 		}
	 		toDelete += sentenceRow.attr('data-sentence-id');
	 	}

	 	sentenceRow.get(0).parentElement.removeChild(sentenceRow.get(0));

	 	if (!$('tr.sentence').length) {
	 		while(document.getElementsByClassName('vertical-close-holder')[0].firstChild) {
	 			document.getElementsByClassName('vertical-close-holder')[0].removeChild(document.getElementsByClassName('vertical-close-holder')[0].firstChild);
	 		}
	 	}
	 }

	/**
	 * Delete an order
	 *　順序を削除する。
	 * @param  {integer}
	 *
	 * @return {[type]}
	 */
	 function deleteOrder(orderColumn) {
	 	if ($('tr.sentence').find('.order-holder').eq(0).find('input.order-input').length == 1) {
	 		alert('Your dialog must have at least 1 order.');
	 		return;
	 	} else {
		 	if (!confirm('Are you sure you want to delete this order?\r\nYou can recover the data by refreshing the page.')) {
		 		return;
		 	}
		 	
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
	 }

	/**
	 * Create a new order
	 * 新しい順序を作成する。
	 *
	 * @return {void}
	 */
	 function newOrder() {
	 	for (var i = 0; i < $('tr.sentence').length; i++) {
	 		var tr = $('tr.sentence')[i];

	 		var orderHolder = $(tr).find('.order-holder').get(0);

	 		var orderInput = document.createElement('input');
	 		orderInput.setAttribute('type', 'number');
	 		orderInput.className = 'form-control order-input';
	 		orderInput.setAttribute('name', (tr.getAttribute('data-sentence-id') ? 'update[' + tr.getAttribute('data-sentence-id') : 'insert[' + tr.getAttribute('data-insert-sentence-id')) + '][order][' + maxColId + ']');
	 		orderInput.setAttribute('min', '1');
	 		orderInput.setAttribute('required', '');
	 		$(orderInput).focus(function() {
	 			focusCol(this);
	 		}).blur(function() {
	 			blurCol(this);
	 		});
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

	/**
	 * Check if the entered order is in the correct format
	 * 入力した順序を正しいフォーマットするかどうかチェックする。
	 *
	 * @return {Boolean}
	 */
	 function isOrderFormatCorrect() {
	 	var orderList = new Array;
	 	if($('.order-holder').length) {
		 	for (var i = 0; i < $('.order-holder')[0].children.length; i++) {
				var sentenceOrder = new Array;
				for (var j = 0; j < $('tr.sentence').length; j++) {
					var order = $('tr.sentence').eq(j).find('td.order-holder').find('input.order-input').get(i).value;
					sentenceOrder.push(parseInt(order));
				}

				orderList.push(sentenceOrder.sort(function (a, b) { return a - b; }));
			}

			for (var i = 0; i < orderList.length; i++) {
				if (orderList[i][0] != 1) {
					alert('Sentence order must start at 1');
					markError(i);
					return false;
				}

				for (var j = 1; j < orderList[i].length; j++) {
					if (orderList[i][j] != orderList[i][j-1] + 1) {
						alert('Order value is not continuous');
						markError(i);
						return false;
					}
				}
			}
	 	}

		return true;
	}

	/**
	 * Show alert message
	 * 警告メッセージを表示する。
	 *
	 * @param  {string}
	 *
	 * @return {void}
	 */
	 function alert(message) {
	 	var div = document.createElement('div');
	 	div.className = 'alert alert-warning fade in';

	 	var close = document.createElement('a');
	 	close.innerHTML = '×';
	 	close.setAttribute('href', '#');
	 	close.setAttribute('class', 'close');
	 	close.setAttribute('data-dismiss', 'alert');
	 	close.setAttribute('aria-label', 'close');

	 	div.append(close);

	 	var i = document.createElement('i');
	 	i.className = 'fa fa-exclamation';
	 	div.append(i);

	 	var span = document.createElement('i');
	 	span.className = 'error-message';
	 	span.innerHTML = message;
	 	div.append(span);

	 	$('#error').prepend(div);
	 	div.scrollIntoView();
	 }

	/**
	 * Highlight the error section
	 *　間違いの部分を強調表示する。
	 * 
	 * @param  {string}
	 *
	 * @return {void}
	 */
	 function markError(orderNo) {
	 	for (var i = 0; i < $('tr.sentence').length; i++) {
	 		var input = $('tr.sentence').eq(i).find('td.order-holder').find('input.order-input').eq(orderNo);

	 		input.addClass('orderError');

	 		input.on('input', function() {
	 			unmarkError(orderNo);
	 		});
	 	}
	 }

	/**
	 * Unhighlight the error section
	 *　間違いの部分ハイライトを消す。
	 *
	 * @param  {integer}
	 *
	 * @return {void}
	 */
	 function unmarkError(orderNo) {
	 	for (var i = 0; i < $('tr.sentence').length; i++) {
	 		var input = $('tr.sentence').eq(i).find('td.order-holder').find('input.order-input').eq(orderNo);

	 		input.removeClass('orderError');
	 	}
	 }

	/**
	 * Highlight a column
	 *　列を強調表示する。
	 *
	 * @param  {DOM Object}
	 *
	 * @return {void}
	 */
	 function focusCol(input) {
	 	var index = [].indexOf.call(input.parentNode.children, input);
	 	
	 	for (var i = 0; i < $('tr.sentence').length; i++) {
	 		var input = $('tr.sentence').eq(i).find('td.order-holder').find('input.order-input').eq(index).addClass('focus');
	 	}
	 }

	/**
	 * Unhighlight a column
	 *　列のハイライトを消す。
	 *
	 * @param  {DOM Object}
	 *
	 * @return {void}
	 */
	 function blurCol(input) {
	 	var index = [].indexOf.call(input.parentNode.children, input);

	 	for (var i = 0; i < $('tr.sentence').length; i++) {
	 		var input = $('tr.sentence').eq(i).find('td.order-holder').find('input.order-input').eq(index).removeClass('focus');
	 	}
	 }

	/**
	 * Create a new sentence
	 *　新しいセンテンスを作成する。
	 */
	 $('#newSentenceBtn').click(function() {
	 	newSentence();
	 });

	/**
	 * Create a new order
	 *　新しい順序を作成する。
	 */
	 $('#newOrderBtn').click(function() {
	 	newOrder();
	 });

	/**
	 * Delete a sentence upon button click
	 * ボタンをクリックすると、センテンスを削除する。
	 */
	 $('.horizontal.close').click(function() {
	 	deleteSentence($(this).closest('tr'));
	 })

	/**
	 * Delete an order upon button click
	 * ボタンをクリックすると、順序を削除する。
	 */
	 $('.vertical.close').click(function() {
	 	deleteOrder([].indexOf.call(this.parentNode.children, this));
	 })

	/**
	 * Highlight a column when user click an input belonging to that column
	 * ユーザーから入力をクリックすると、その列の入力を強調表示する。
	 */
	 $('input.order-input')
	 .focus(function() {
	 	focusCol(this);
	 }).blur(function() {
	 	blurCol(this);
	 });

	 function validate_chgColor() {
	 	$('.vld-spc').each(function(){
	 		var text = $(this).val();
	 		var pattern = new RegExp(/[~`@#$%\^&*+=\\[\]\\';/{}|\\":<>]/);
	 		if(text.trim() == "" || pattern.test(text)) {
	 			$(this).attr('style', 'border-color: red;');
	 		}else{
	 			$(this).attr('style', 'border-color: #dddddd;');
	 		}
	 	})
	 	
	 }

	 function showMesg(element, msg) {
	 	if ($(element).parent().find('.alert alert-danger').length) {
	 		$(element).parent().find('span.help').html(msg);
	 	} else {
	 		var div_help = document.createElement('div');
	 		div_help.className = 'alert alert-danger';
	 		div_help.innerHTML = '<span class="help">' +  msg +  '</span>';
	 		$(div_help).insertAfter(element);
	 	}
	 }

	 function validate_space(textElement) {
	 	var text = textElement.value;
	 	if( text.trim() == "") {
	 		showMesg(textElement, 'Empty value is not allowed');
	 		return false;
	 	}else{
	 		return true;
	 	}
	 }

	 function validate_spcChar(textElement){
	 	var text = textElement.value;
	 	var pattern = new RegExp(/[~`@#$%\^&*+=\\[\]\\';/{}|\\":<>]/);
	 	if (pattern.test(text)) {
	 		showMesg(textElement, 'Special character is invalid');
	 		return false;
	 	}else{
	 		return true;
	 	}
	 }
	/**
	 * Add a list of id of element to delete to the submiting form
	 * 提出するフォームを削除するように、様子のイドのリストを追加する。
	 */
	 $("#p11Form").submit( function(eventObj) {
	 	var fail = false;
	 	validate_chgColor();
	 	for (var i = 0; i < $('.vld-spc').length; i++) {
	 		if(!validate_space($('.vld-spc')[i])){
	 			fail =true;
	 		}
	 		if(!validate_spcChar($('.vld-spc')[i])){
	 			fail =true;
	 		}
	 	}

	 	if (fail) {
	 		return false;
	 	}
	 	if(!isOrderFormatCorrect()) {
	 		return false;
	 	}
	 	console.log(toDelete);
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