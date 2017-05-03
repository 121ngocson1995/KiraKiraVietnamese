var correctAnswerList;
var toAdd = -1;
var maxColId = $('.order-holder').length ? $('.order-holder')[0].children.length : 0;

/**
 * Edit elements' tab indexes
 *
 * @return {void}
 */
 function reIndex() {
 	var tabIndex = 1;
 	$('input, textarea').each(function() {
 		$(this).attr('tabindex', tabIndex);
 	});
 }

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

 	reIndex();
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

 	reIndex();
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
 	var fail = false;
 	for (var i = 0; i < $('.vld-spc').length; i++) {
 		if(!validate_spcChar($('.vld-spc')[i]) || !validate_space($('.vld-spc')[i]) ) {
 			$(this).attr('style', 'border-color: red;');
 			fail = true;
 		}else{
 			$(this).attr('style', 'border-color: #dddddd;');
 		}
 	}
 	return fail;

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
 	$('.alert').remove();
 	if (validate_chgColor()) {
 		return false;
 	}
 	
 	if(!isOrderFormatCorrect()) {
 		return false;
 	}
 	if (toDelete) {
 		$('<input />').attr('type', 'hidden')
 		.attr('name', 'delete')
 		.attr('value', toDelete)
 		.appendTo('#p11Form');
 		return true;
 	}
 });

 $(document).ready(function () {
 	reIndex();
 });