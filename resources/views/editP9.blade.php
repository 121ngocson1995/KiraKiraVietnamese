@extends('userLayout')

@section('content')
<link href="{{ asset('css/fileinput.css') }}" media="all" rel="stylesheet" type="text/css"/>
<link href="{{ asset('themes/explorer/theme.css') }}" media="all" rel="stylesheet" type="text/css"/>
{{-- <script src="{{ asset('js/plugins/sortable.js') }}" type="text/javascript"></script> --}}
<script src="{{ asset('js/fileinput.min.js') }}" type="text/javascript"></script>
{{-- <script src="{{ asset('themes/explorer/theme.js') }}" type="text/javascript"></script> --}}
<style type="text/css">
	div.title {
		text-align: center;
		margin-bottom: 3em;
	}
	label.situNo {
		font-size: 1.4em;
	}
	.textarea {
		height: 103px !important;
	}
	.file-thumbnail-footer {
		height: initial !important;
	}
	.file-footer-caption {
		display: none !important;
	}
	.kv-file-content {
		height: initial !important;
	}
	.file-preview-image.kv-preview-data {
		height: 100px !important;
	}
	.krajee-default[data-template="audio"] .file-preview-audio {
		height: 100px !important;
	}
	.krajee-default .file-other-icon {
		font-size: 4em;
	}
	.answer, .question {
		padding-left: 2px; 	
		margin: 10px !important;
	}
	.btn-primary{
		width: 40px;
	}
	.fa {
		margin: 0;
	}
	.deleteBtn {
		outline: none;
		/*padding: 0;*/
		border: none;
		background: initial;
		opacity: 0.7;
		transition: all 0.5s;
	}
	.deleteBtn:hover {
		opacity: 1;
	}
	.editSituControl {
		width: 10em;
		margin: 0 0.5em;
	}
</style>
<script type="text/javascript">
	$('.listBtn').removeClass('active');
	$('#li-edit').addClass('active');
</script>
<div class="container">
	<div class="title"><h2>Edit Practice 9: Complete the dialogues for lesson {{ $lessonNo }}</h2></div>
	{!! Form::open(array('url'=>'editP9','method'=>'POST', 'files'=>true, 'id' =>'p9Form')) !!}
	<div id="p9Div">
		<input type="hidden" name="lessonID" value="{{$lessonId}}">
		@if (count($p9))
		@for ($i = 0; $i < count($dialogCnt) ; $i++)
		<div class="row big" id="dialog{{$i}}" data-dialog="{{$i}}">
			<div>
				<label class="situNo">Dialog <span class="dialogIndex" id="line{{$i}}">{{$i+1}}</span>
					<button type="button" class="form-control btn-primary " data-diaNo="{{$i}}" onclick="addRow(this)"><i class="fa fa-plus" style="margin-right: 0.5em"></i></button>
					<button type="button"  class="deleteBtn " onclick="deleteDialog(this)"><i class="fa fa-trash"></i></button>
				</label>
			</div>
			@for ($j = 0; $j < count($p9) ; $j++)
			@if ($p9[$j]->dialogNo == $dialogCnt[$i])
			<div class="row origin" id="dia{{$i}}" data-dialog="{{$i}}" data-line="{{$p9[$j]->lineNo}}" data-id="{{ $p9[$j]->id }}">
				<div id="dia{{$i}}line{{$j}}question" class="col-xs-5 questioncontent">
					<input type="text" id="dia{{$i}}line{{$j}}" name="update[{{ $p9[$j]->id }}][{{$p9[$j]->dialogNo}}][{{ $p9[$j]->lineNo}}][line]" data-line="{{$j}}" class="question form-control vld-spc" maxlength="80" required="true" >
				</div>
				<div id="dia{{$i}}line{{$j}}answer" class="col-xs-5 answercontent" data-sumAnswer="{{count($p9[$j]->answer)}}">
					@for ($k = 0; $k < count($p9[$j]->answer) ; $k++)
					@if ($p9[$j]->answer[$k] != '')
					<input type="text" id="dia{{$i}}line{{$j}}answer{{$k}}" name="update[{{ $p9[$j]->id }}][{{$p9[$j]->dialogNo}}][{{ $p9[$j]->lineNo}}][answer][]" class="form-control answer vld-spc" maxlength="80" required="true" value="{{$p9[$j]->answer[$k]}}">
					@endif
					@endfor
				</div>
				<div id="line{{$j}}answer" class="col-xs-2">
					<button type="button" class="form-control btn-primary col-xs-2" onclick="addAnswer(this)"><i class="fa fa-plus" style="margin-right: 0.5em"></i></button>
					<button type="button" class="deleteBtn col-xs-2"  onclick="deleteRow(this)"><i class="fa fa-trash"></i></button></div>
				</div>
				@endif
				@endfor
			</div>
			@endfor
			@endif
		</div>
		<br>
		<div class="row" style="text-align: center;">
			<button type="submit" class="btn btn-success editSituControl"><i class="fa fa-save" style="margin-right: 0.5em"></i>Save</button>
			<button type="button" class="btn btn-primary editSituControl" onclick="addDialog()"><i class="fa fa-plus" style="margin-right: 0.5em"></i>Add dialog</button>
		</div>
		{!! Form::close() !!}
	</div>
	<script type="text/javascript">
		var p9 = <?php echo json_encode($p9); ?>;
		var dialogCnt = <?php echo json_encode($dialogCnt); ?>;
		var sumDialog = p9.length;
		var deleteDia = 0;
		var addedDialog = 0;
		var rowDelete = 0;

		window.onload= function() {
			start();
		}

		
		function start(){
			for (var i = 0; i < dialogCnt.length; i++) {
				for (var j = 0; j < p9.length; j++) {
					if (p9[j]['dialogNo'] == dialogCnt[i]) {
						var curLine ='';
						for (var k = 0; k < p9[j]['line'].length; k++) {
							curLine = curLine + p9[j]['line'][k] + "\u3007";
						}
						curLine = curLine.slice(0, -1);
						$("#dia"+i+"line"+j).val(curLine);
					}
				}
			}
		}


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
		  
		  $("#p9Form").submit( function(eventObj) {
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
		</script>
		@stop