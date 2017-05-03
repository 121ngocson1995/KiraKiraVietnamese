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
 	var fail = false;
 	for (var i = 0; i < $('.vld-spc').length; i++) {
 		if(!validate_spcChar($('.vld-spc')[i]) || !validate_space($('.vld-spc')[i]) || !validate_checkLine($('.vld-spc')[i])) {
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

 function validate_checkLine(textElement) {
 	var text = textElement.value;
 	var text_count = text.split("\n").length;
 	if (text_count != 2 ) {
 		showMesg(textElement, "The number of sentence in a dialog must be 2 !");
 		return false;
 	}else{
 		return true;
 	}
 }

 function validate_space(textElement) {
 	var text = textElement.value;
 	var text_parts = text.split("\n");
 	for (var i = 0; i < text_parts.length; i++) {
 		if (text_parts[i].trim() == "") {
 			showMesg(textElement, 'Empty sentence is not allowed');
 			return false;
 		}	
 	}
 	if( text.trim() == "") {
 		showMesg(textElement, 'Empty dialog is not allowed');
 		return false;	
 	}
 	return true;
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
 	$('.alert').remove();
 	if (validate_chgColor()) {
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