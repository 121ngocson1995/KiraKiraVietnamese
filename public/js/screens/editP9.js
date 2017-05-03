var sumDialog = p9.length;
var deleteDia = 0;
var addedDialog = 0;
var rowDelete = 0;

$('.question').each(function() {
	this.addEventListener("keydown", function(e) {
		var start = this.selectionStart,
		end = this.selectionEnd,
		value = this.value,
		key = e.keyCode;

		if (key == 8 && value[start-1] == "\u3007") e.preventDefault();
		if (key == 46 && value[start] == "\u3007") e.preventDefault();
		if ((key == 8 || key == 46) && value.substring(start, end).indexOf("\u3007") != -1) e.preventDefault();
	}, false);
});

/**
 * add new answer for dialog
 *　新たなダイアログの回答を追加する。
 *
 * @param {DOM}
 * @return {void}
 */
 function addAnswer(button){
 	$(button).closest('.row').find('.question').val($(button).closest('.row').find('.question').val()+"\u3007");
 	var dialog = $(button).closest('.row').attr('data-dialog');
 	var line = $(button).closest('.row').attr('data-line');
 	var id = $(button).closest('.row').attr('data-id');
 	var answer = $('#dia'+dialog+'line'+line+'answer').attr('data-sumAnswer');

 	var node_input = document.createElement('input');
 	node_input.setAttribute('type', 'text');
 	if ($(button).closest('.row').hasClass('origin')) {
 		node_input.setAttribute('name', "update["+id+"]["+dialog+"]["+line+"][answer][]");
 	}else{
 		node_input.setAttribute('name', "insert["+dialog+"]["+line+"][answer][]");
 	}
 	node_input.setAttribute('class', 'form-control answer vld-spc');
 	node_input.setAttribute('maxlength', '80');
 	node_input.setAttribute('required', 'true');

 	document.getElementById($(button).closest('.row').find('.answercontent').attr('id')).appendChild(node_input);
 }

/**
 * Add a new dialog
 *　新たなダイアログを追加する。
 *　
 * @return {void}
 */
 function addDialog(){
 	addedDialog ++;

 	var row_big = document.createElement('div');
 	row_big.setAttribute('class', 'row big');
 	row_big.setAttribute('id', 'dialog'+$('.big').length);
 	row_big.setAttribute('data-dialog', $('.big').length);

 	var div = document.createElement('div');

 	var label = document.createElement('label');
 	label.setAttribute('class', 'situNo');
 	label.innerHTML = 'Dialog'

 	var span = document.createElement('span');
 	span.setAttribute('class', 'dialogIndex');
 	span.innerHTML = $('.big').length+1;

 	label.appendChild(span);

 	var btn_Add = document.createElement('button');
 	btn_Add.setAttribute("type", 'button');
 	btn_Add.setAttribute("class", 'form-control btn-primary');
 	btn_Add.setAttribute("data-diaNo", $('.big').length );
 	btn_Add.setAttribute("onclick", 'addRow(this)');

 	var icon_add = document.createElement('i');
 	icon_add.setAttribute('style', 'margin-right: 0.5em');
 	icon_add.setAttribute('class', 'fa fa-plus');

 	btn_Add.appendChild(icon_add);

 	var btn_Delete = document.createElement('button');
 	btn_Delete.setAttribute("type", 'button');
 	btn_Delete.setAttribute("class", 'deleteBtn');
 	btn_Delete.setAttribute("onclick", 'deleteDialog(this)');

 	var icon_delete = document.createElement('i');
 	icon_delete.setAttribute('class', 'fa fa-trash');

 	btn_Delete.appendChild(icon_delete);

 	label.appendChild(btn_Add);
 	label.appendChild(btn_Delete);

 	div.appendChild(label);

 	row_big.appendChild(div);

 	var node_row = document.createElement('div');
 	node_row.setAttribute('class', 'row ');
 	node_row.setAttribute('data-dialog', $('.big').length );
 	node_row.setAttribute('data-line', 0);

 	var node_question = document.createElement('div');
 	node_question.setAttribute('class', 'col-xs-5 questioncontent');

 	var input_question = document.createElement('input');
 	input_question .setAttribute('type', 'text');
 	input_question .setAttribute('class', 'question form-control vld-spc');
 	input_question.setAttribute('maxlength', '80');
 	input_question .setAttribute('required', 'true');
 	input_question .setAttribute('name', "insert["+($('.big').length )+"][0][line]");

 	node_question.appendChild(input_question);

 	var node_answer = document.createElement('div');
 	node_answer.setAttribute('class', 'col-xs-5 answercontent');
 	node_answer.setAttribute('id', 'dia'+($('.big').length )+'line0answer');


 	var node_btn = document.createElement('div');
 	node_btn.setAttribute('class', 'col-xs-2');

 	var btn_add = document.createElement('button');
 	btn_add.setAttribute('type', 'button');
 	btn_add.setAttribute('class', 'form-control btn-primary col-xs-2');
 	btn_add.setAttribute('onclick', 'addAnswer(this)');

 	var icon_add = document.createElement('i');
 	icon_add.setAttribute('style', 'margin-right: 0.5em');
 	icon_add.setAttribute('class', 'fa fa-plus');

 	btn_add.appendChild(icon_add);

 	var btn_delete = document.createElement('button');
 	btn_delete.setAttribute('type', 'button');
 	btn_delete.setAttribute('class', 'deleteBtn col-xs-2');
 	btn_delete.setAttribute('onclick', 'deleteRow(this)');

 	var icon_delete = document.createElement('i');
 	icon_delete.setAttribute('style', 'margin-right: 0.5em');
 	icon_delete.setAttribute('class', 'fa fa-trash');

 	btn_delete.appendChild(icon_delete);

 	node_btn.appendChild(btn_add);
 	node_btn.appendChild(btn_delete);

 	node_row.appendChild(node_question);
 	node_row.appendChild(node_answer);
 	node_row.appendChild(node_btn);

 	row_big.appendChild(node_row);

 	document.getElementById('p9Div').appendChild(row_big);

 }

/**
 * Delete a dialog
 *　ダイアログを削除する。
 *
 * @param  {DOM} button 
 * @return {void}
 */
 function deleteDialog(button){
 	if(confirm("Are you sure you want to delete?")){

 		deleteDia ++;
 		var node_delete = document.createElement('input');
 		node_delete.setAttribute('type', 'hidden');
 		node_delete.setAttribute('name', 'deleteDia'+deleteDia);
 		node_delete.setAttribute('value', $(button).closest('.big').attr('data-dialog'));
 		document.getElementById('p9Form').appendChild(node_delete);

 		var deleteIndex = $(button).closest('.big').find('.dialogIndex').html();
 		console.log($(button).closest('.big').find('.dialogIndex'));
 		$('.dialogIndex').each(function() {
 			if ($(this).html() > deleteIndex) {
 				var curIndex = $(this).html();
 				$(this).html( curIndex-1);
 			}
 		});
 		$(button).closest('.big').empty().remove();
 	}
 }

 /**
 	 * 	delete a sentence of dialog
 	 * 	ダイアログのセンテンスを削除する。
 	 * 	
 	 * @param  {DOM} button 
 	 * @return {void}    
 	 */
 	 function deleteRow(button){
 	 	if(confirm("Are you sure you want to delete?")){
 	 		if($(button).closest('.row').hasClass('origin')){
 	 			rowDelete++;
 	 			var node_delete = document.createElement('input');
 	 			node_delete.setAttribute('type', 'hidden');
 	 			node_delete.setAttribute('name', 'delete'+rowDelete);
 	 			node_delete.setAttribute('value', $(button).closest('.row').attr('data-id'));
 	 			document.getElementById('p9Form').appendChild(node_delete);
 	 		}
 	 		$(button).closest('.row').empty();
 	 	}
 	 }
 	 
  /**
  * Add new a sentence of dialog
  * 新たなダイアログのセンテンスを追加する。
  * 
  * @param {DOM} button 
  * @return {void}
  */
  function addRow(button){

  	var node_row = document.createElement('div');
  	node_row.setAttribute('class', 'row ');
  	node_row.setAttribute('data-dialog', $(button).attr('data-diaNo'));
  	node_row.setAttribute('data-line', $(button).closest('.big').find('.question').length);

  	var node_question = document.createElement('div');
  	node_question.setAttribute('class', 'col-xs-5 questioncontent');

  	var input_question = document.createElement('input');
  	input_question .setAttribute('type', 'text');
  	input_question .setAttribute('class', 'question form-control vld-spc');
  	input_question .setAttribute('maxlength', '80');
  	input_question .setAttribute('required', 'true');
  	input_question .setAttribute('name', "insert["+$(button).attr('data-diaNo')+"]["+$(button).closest('.big').find('.question').length+"][line]");

  	node_question.appendChild(input_question);

  	var node_answer = document.createElement('div');
  	node_answer.setAttribute('class', 'col-xs-5 answercontent');
  	node_answer.setAttribute('id', 'dia'+$(button).attr('data-diaNo')+'line'+$(button).closest('.big').find('.question').length+'answer');


  	var node_btn = document.createElement('div');
  	node_btn.setAttribute('class', 'col-xs-2');

  	var btn_add = document.createElement('button');
  	btn_add.setAttribute('type', 'button');
  	btn_add.setAttribute('class', 'form-control btn-primary col-xs-2');
  	btn_add.setAttribute('onclick', 'addAnswer(this)');

  	var icon_add = document.createElement('i');
  	icon_add.setAttribute('style', 'margin-right: 0.5em');
  	icon_add.setAttribute('class', 'fa fa-plus');

  	btn_add.appendChild(icon_add);

  	var btn_delete = document.createElement('button');
  	btn_delete.setAttribute('type', 'button');
  	btn_delete.setAttribute('class', 'deleteBtn col-xs-2');
  	btn_delete.setAttribute('onclick', 'deleteRow(this)');

  	var icon_delete = document.createElement('i');
  	icon_delete.setAttribute('style', 'margin-right: 0.5em');
  	icon_delete.setAttribute('class', 'fa fa-trash');

  	btn_delete.appendChild(icon_delete);

  	node_btn.appendChild(btn_add);
  	node_btn.appendChild(btn_delete);

  	node_row.appendChild(node_question);
  	node_row.appendChild(node_answer);
  	node_row.appendChild(node_btn);

  	document.getElementById('dialog'+$(button).attr('data-diaNo')).appendChild(node_row);
  }

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
  
  function validate_blank() {
  	var dialog_fail =  false;
  	for (var i = 0; i < $('.row.big').length; i++) {
  		var fail = true;
  		for (var j = 0; j < $('.row.big:eq('+i+')').find('input.question').length; j++) {
  			if($('.row.big:eq('+i+')').find('input.question:eq('+j+')').val().includes("\u3007")){
  				fail = false;
  			}
  		}
  		if (fail) {
  			dialog_fail =  true;
  			showMesg($('.row.big')[i], 'Dialog must has at least 1 blank');
  		}
  	}

  	return dialog_fail;
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
  
  $("#p9Form").submit( function(eventObj) {
  	$('.alert').remove();
  	if (validate_blank()) {
  		return false;
  	}

  	if (validate_chgColor()) {
  		return false;
  	}
  	var node_delete_dia = document.createElement('input');
  	node_delete_dia.setAttribute('type', 'hidden');
  	node_delete_dia.setAttribute('name', 'sumDeleteDia');
  	node_delete_dia.setAttribute('value', deleteDia);
  	document.getElementById('p9Form').appendChild(node_delete_dia);

  	var node_delete_row = document.createElement('input');
  	node_delete_row.setAttribute('type', 'hidden');
  	node_delete_row.setAttribute('name', 'sumDeleteRow');
  	node_delete_row.setAttribute('value', rowDelete);
  	document.getElementById('p9Form').appendChild(node_delete_row);
  });