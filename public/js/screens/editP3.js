var sumLine = p3.length;
var deleteLine = 0;
var addLine = 0;
$("#p3Form").submit( function(eventObj) {
	$('<input />').attr('type', 'hidden')
	.attr('name', "sumLine")
	.attr('value', sumLine)
	.appendTo('#p3Form');
	return true;
});

function reIndex() {
	var tabIndex = 1;
	$('input, textarea').each(function() {
		$(this).attr('tabindex', tabIndex);
	});
}

/**
 * Add new row of sentence and audio
 * センテンスと音響の行を追加する。
 *
 * @return {void}
 */
 function AddRow() {
 	addLine++;
 	sumLine++;
 	var node_rowBig = document.createElement("div");
 	node_rowBig.setAttribute('class', 'row');
 	node_rowBig.setAttribute('id', "row"+(sumLine));
 	node_rowBig.setAttribute('data-line', sumLine);
 	/* Create label Situation n */
 	var div_sentence  = document.createElement("div");
 	div_sentence .setAttribute('class', "col-xs-6");
 	label_sentence  = document.createElement("label");
 	label_sentence.setAttribute('for', 'sentenceAdd'+ addLine);
 	label_sentence.innerHTML = 'Sentence';
 	var sentence_input = document.createElement("input");
 	sentence_input.setAttribute('type', "text");
 	sentence_input.setAttribute('maxlength', "80");
 	sentence_input.setAttribute('class', "form-control vld-spc");
 	sentence_input.setAttribute('name', "sentenceAdd"+ addLine);
 	sentence_input.setAttribute('required', "true");
 	div_sentence.appendChild(label_sentence );
 	div_sentence.appendChild(sentence_input);
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
 	node_rowBig.appendChild(div_sentence );
 	node_rowBig.appendChild(div_audio);
 	node_rowBig.appendChild(div_btn);
 	document.getElementById("p3Div").appendChild(node_rowBig);
 	var $input = $('input.file[type=file]');
 	if ($input.length) {
 		$input.fileinput({
 			maxFileSize: 1000
 		});
 	}

 	reIndex();
 }

/**
 * delete a row of sentence and audio
 *　センテンスと音響の行を削除する。
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
 		document.getElementById('p3Form').appendChild(node_delete);
 		$(button).closest('.row').empty().remove();

 		for (var i = 0; i < sumLine; i++) {
 			if (curLine < i) {
 				$("#row"+i).attr('data-line', i-1);	
 				$("#row"+i).attr('id', "row"+(i-1));
 				$("#sentenceId"+i).attr('name', "sentenceId"+(i-1));
 				$("#sentenceId"+i).attr('id', "sentenceId"+(i-1));
 				$("#sentence"+(i)).attr('name', "sentence"+(i-1));
 				$("#sentence"+(i)).attr('id', "sentence"+(i-1));
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
 	if ($(element).parent().find('.help-block').length) {
 		$(element).parent().find('span.help').html(msg);
 	} else {
 		var div_help = document.createElement('div');
 		div_help.className = 'help-block';
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

 $("#p3Form").submit( function(eventObj) {
 	$('.alert').remove();

 	if (validate_chgColor()) {
 		return false;
 	}

 	var node_delete = document.createElement('input');
 	node_delete.setAttribute('type', 'hidden');
 	node_delete.setAttribute('name', 'sumDelete');
 	node_delete.setAttribute('value', deleteLine);
 	document.getElementById('p3Form').appendChild(node_delete);
 	var node_add = document.createElement('input');
 	node_add.setAttribute('type', 'hidden');
 	node_add.setAttribute('name', 'sumAdd');
 	node_add.setAttribute('value', addLine);
 	document.getElementById('p3Form').appendChild(node_add);
 	var node_origin = document.createElement("input");
 	node_origin.setAttribute('type', 'hidden');
 	node_origin.setAttribute('name',"sumOrigin");
 	node_origin.setAttribute('value', $('.origin').length);
 	document.getElementById('p3Form').appendChild(node_origin);
 	$('.undone').each(function() {
 		if($(this).hasClass('audio') && $(this).attr('data-path-audio') != ''){
 			$('<input />').attr('type', 'hidden')
 			.attr('name', "audioPath"+$(this).attr('data-situ'))
 			.attr('value', $(this).attr('data-path-audio'))
 			.appendTo('#p3Form');
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

 	reIndex();
 });