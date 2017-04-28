@extends('userLayout')

@section('content')
<link href="{{ asset('css/fileinput.css') }}" media="all" rel="stylesheet" type="text/css"/>
<link href="{{ asset('themes/explorer/theme.css') }}" media="all" rel="stylesheet" type="text/css"/>
{{-- <script src="{{ asset('js/plugins/sortable.js') }}" type="text/javascript"></script> --}}
<script src="{{ asset('js/fileinput.min.js') }}" type="text/javascript"></script>
{{-- <script src="{{ asset('themes/explorer/theme.js') }}" type="text/javascript"></script> --}}
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
	.krajee-default .file-preview-other {
		padding: 10px 10px 0 10px;
	}
	.fa {
		margin: 0;
	}
	.deleteBtn {
		outline: none;
		/*padding: 0;*/
		border: none;
		background: initial;
		opacity: 0.3;
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
	<div class="title"><h2>Edit Practice 5: Listen to dialogues and repeat for lesson {{ \App\Lesson::where('id', '=', $lessonId)->first()->lessonNo }}</h2></div>
	<div class="row description" style="text-align: center; font-size: 1.5em">
		Add new dialogues or change existing ones by writing into appropriate text fields and uploading new audio files.
	</div>
	{!! Form::open(array('url'=>'editP5','method'=>'POST', 'files'=>true, 'id' =>'p5Form')) !!}
	<div id="p5Div">
		<input type="hidden" name="lessonID" value="{{$lessonId}}">
		@if (count($p5))
		
		@for ($i = 0; $i < count($p5)  ; $i++)
		<div class="row origin" id="row{{$i}}" data-line="{{$i}}">
			<div class="col-xs-6">
				<label for="dialog{{$i}}">dialog</label>
				<textarea class="form-control textarea vld-spc" maxlength="20" name="dialog{{$i}}" required="true" id="dialog{{$i}}" data-dialog="{{$p5[$i]->dialogArr}}" required></textarea>
			</div>
			<div class="col-xs-5">
				<label for="audio{{$i}}">Audio</label>
				<input id="audio{{$i}}" name="audio{{$i}}" type="file" class="file undone audio" data-situ="{{$i}}" data-path-audio="{{$p5[$i]->audio}}" data-show-upload="false" data-show-caption="true" data-allowed-file-extensions='["mp3"]'>
			</div>
			<div class="col-xs-1">
				<button type="button" class="deleteBtn " onclick="deleteRow(this)"><i class="fa fa-trash"></i></button>
			</div>
			<input type="hidden" id="dialogId{{$i}}" class="id" name="dialogId{{$i}}" value="{{$p5[$i]->id}}">
		</div>
		@endfor
		@endif
	</div>
	<div class="row" style="text-align: center; margin-top: 2em">
		<button type="submit" class="btn btn-success editSituControl"><i class="fa fa-save" style="margin-right: 0.5em"></i>Save</button>
		<button type="button" class="btn btn-primary editSituControl" onclick="AddRow()"><i class="fa fa-plus" style="margin-right: 0.5em"></i>Add</button>
	</div>
	{!! Form::close() !!}
</div>
<script type="text/javascript">
	var $input = $('input.file[type=file]');
	if ($input.length) {
		$input.fileinput({
			maxFileSize: 1000
		});
	}

	$(document).ready(function(){

		var lines = 2;

		$('.textarea').each(function() {
			$(this).keydown(function(e) {
				newLines = $(this).val().split("\n").length;
				if(e.keyCode == 13 && newLines >= lines) {
					return false;
				}
			});
		});
	});

	var p5 = <?php echo json_encode($p5); ?>;
	var sumLine = p5.length;
	var deleteLine = 0;
	var addLine = 0;

	$('.textarea').each(function() {
		$(this).text($(this).attr('data-dialog'));
	});

	$("#p5Form").submit( function(eventObj) {
		$('<input />').attr('type', 'hidden')
		.attr('name', "sumLine")
		.attr('value', sumLine)
		.appendTo('#p5Form');
		return true;
	});

	/**
	 *  Add new row of sentence and audio
	 * 　センテンスと音響の行を追加する。
	 *
	 *  @return {void}
	 */
	 function AddRow() {
	 	addLine++;
	 	sumLine++;
	 	var node_rowBig = document.createElement("div");
	 	node_rowBig.setAttribute('class', 'row');
	 	node_rowBig.setAttribute('id', "row"+(sumLine));
	 	node_rowBig.setAttribute('data-line', sumLine);
	 	/* Create label Situation n */
	 	var div_dialog  = document.createElement("div");
	 	div_dialog .setAttribute('class', "col-xs-6");
	 	label_dialog  = document.createElement("label");
	 	label_dialog.setAttribute('for', 'dialogAdd'+ addLine);
	 	label_dialog.innerHTML = 'dialog';
	 	var dialog_textarea = document.createElement("textarea");
	 	dialog_textarea.setAttribute('maxlength', "200");
	 	dialog_textarea.setAttribute('class', "form-control textarea vld-spc");
	 	dialog_textarea.setAttribute('required', 'true');
	 	dialog_textarea.setAttribute('name', "dialogAdd"+addLine);
	 	dialog_textarea.setAttribute('id', "dialogAdd"+addLine);
	 	div_dialog.appendChild(label_dialog );
	 	div_dialog.appendChild(dialog_textarea);
	 	var div_audio = document.createElement("div");
	 	div_audio.setAttribute('class', "col-xs-5");
	 	label = document.createElement("label");
	 	label.setAttribute('for', 'audioAdd'+ addLine);
	 	label.innerHTML = 'Audio';
	 	var audio_input = document.createElement("input");
	 	audio_input.setAttribute('type', 'file');
	 	audio_input.setAttribute('required', 'true');
	 	audio_input.setAttribute('id', 'audioAdd'+addLine);
	 	audio_input.setAttribute('name', 'audioAdd'+addLine);
	 	audio_input.setAttribute('class', 'file audio');
	 	audio_input.setAttribute('data-situ', addLine);
	 	audio_input.setAttribute('data-show-upload', "false");
	 	audio_input.setAttribute('data-show-caption', "true");
	 	audio_input.setAttribute('data-allowed-file-extensions', '["mp3"]');
	 	div_audio.appendChild(label);
	 	div_audio.appendChild(audio_input);
	 	var div_btn = document.createElement("div");
	 	div_btn.setAttribute('class', "col-xs-1");
	 	var deleteBtn = document.createElement("button");
	 	deleteBtn.setAttribute('type', 'button');
	 	deleteBtn.setAttribute('class', 'deleteBtn');
	 	deleteBtn.setAttribute('onclick', 'deleteRow(this)');
	 	var icon = document.createElement("i");
	 	icon.setAttribute('class', 'fa fa-trash');
	 	deleteBtn.appendChild(icon);
	 	div_btn.appendChild(deleteBtn);
	 	node_rowBig.appendChild(div_dialog );
	 	node_rowBig.appendChild(div_audio);
	 	node_rowBig.appendChild(div_btn);
	 	document.getElementById("p5Div").appendChild(node_rowBig);
	 	var $input = $('input.file[type=file]');
	 	if ($input.length) {
	 		$input.fileinput({
	 			maxFileSize: 1000
	 		});
	 	}
	 	var lines = 2;

	 	$('.textarea').each(function() {
	 		$(this).keydown(function(e) {
	 			newLines = $(this).val().split("\n").length;
	 			if(e.keyCode == 13 && newLines >= lines) {
	 				return false;
	 			}
	 		});
	 	});
	 }

	/**
	 * delete new row of sentence and audio
	 *　センテンスと音響を削除する。
	 *
	 * @param  {DOM} button
	 * @return {void}   
	 */
	 function deleteRow(button) {
	 	deleteLine++;
	 	var curLine = $(button).closest('.row').attr('data-line');
	 	if(confirm("Are you sure you want to delete?")){
	 		var node_delete = document.createElement('input');
	 		node_delete.setAttribute('type', 'hidden');
	 		node_delete.setAttribute('name', 'delete'+deleteLine);
	 		node_delete.setAttribute('value', $(button).closest('.row').find('.id').attr('value'));
	 		document.getElementById('p5Form').appendChild(node_delete);
	 		$(button).closest('.row').empty().remove();

	 		for (var i = 0; i < sumLine; i++) {
	 			if (curLine < i) {
	 				$("#row"+i).attr('data-line', i-1);	
	 				$("#row"+i).attr('id', "row"+(i-1));
	 				$("#dialogId"+i).attr('name', "dialogId"+(i-1));
	 				$("#dialogId"+i).attr('id', "dialogId"+(i-1));
	 				$("#dialog"+(i)).attr('name', "dialog"+(i-1));
	 				$("#dialog"+(i)).attr('id', "dialog"+(i-1));
	 				$("#audio"+(i)).attr('name', "audio"+(i-1));
	 				$("#audio"+(i)).attr('data-situ', (i-1));
	 				$("#audio"+(i)).attr('id', "audio"+(i-1));
	 			}
	 		}
	 		sumLine--;
	 	}
	 }

	function validate_chgColor() {
	 	$('.vld-spc').each(function(){
	 		var text = $(this).val();
	 		var pattern = new RegExp(/[~`@#$%\^&*+=\\[\]\\';/{}|\\":<>]/);
	 		if(text.trim() == "" || pattern.test(text) ||validate_checkLine($(this))) {
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

	function validate_checkLine(textElement) {
	 	var text = textElement.value;
	 	var text_count = text.split("\n").length;

	 	if (text_count != 2 ) {
	 		showMesg(element, "The number of sentence in a dialog must be 2 !");
	 		return false;
	 	}else{
	 		return true;
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

	$("#p5Form").submit( function(eventObj) {
	 	var fail = false;
	 	validate_chgColor();
	 	for (var i = 0; i < $('.vld-spc').length; i++) {
	 		if(!validate_space($('.vld-spc')[i])){
	 			fail =true;
	 		}
	 		if(!validate_spcChar($('.vld-spc')[i])){
	 			fail =true;
	 		}
	 		if(!validate_checkLine($('.vld-spc')[i])){
	 			fail =true;
	 		}
	 		
	 	}

	 	if (fail) {
	 		return false;
	 	}

	 	var node_delete = document.createElement('input');
	 	node_delete.setAttribute('type', 'hidden');
	 	node_delete.setAttribute('name', 'sumDelete');
	 	node_delete.setAttribute('value', deleteLine);
	 	document.getElementById('p5Form').appendChild(node_delete);
	 	var node_add = document.createElement('input');
	 	node_add.setAttribute('type', 'hidden');
	 	node_add.setAttribute('name', 'sumAdd');
	 	node_add.setAttribute('value', addLine);
	 	document.getElementById('p5Form').appendChild(node_add);
	 	var node_origin = document.createElement("input");
	 	node_origin.setAttribute('type', 'hidden');
	 	node_origin.setAttribute('name',"sumOrigin");
	 	node_origin.setAttribute('value', $('.origin').length);
	 	document.getElementById('p5Form').appendChild(node_origin);
	 	$('.undone').each(function() {
	 		if($(this).hasClass('audio') && $(this).attr('data-path-audio') != ''){
	 			$('<input />').attr('type', 'hidden')
	 			.attr('name', "audioPath"+$(this).attr('data-situ'))
	 			.attr('value', $(this).attr('data-path-audio'))
	 			.appendTo('#p5Form');
	 			return true;
	 		}
	 	})
	 })
	
	$(document).ready(function () {
	 	$('.file.undone').on('change', function(event) {
	 		var filename = this.value;
	 		var extension = filename.split('.').pop();
	 		if ($(this).hasClass('audio')) {
	 			if (extension == 'mp3') {
	 				$(this).removeClass('undone');
	 				return;
	 			}
	 		}
	 		$(this).addClass('undone');
	 	});
	 });
	</script>
	@stop