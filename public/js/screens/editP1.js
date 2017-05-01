var $input = $('input.file[type=file]');
if ($input.length) {
	$input.fileinput({
		maxFileSize: 1000
	});
}

var sumLine = p1.length;
var deleteLine = 0;
var addLine = 0;
$("#p1Form").submit( function(eventObj) {
	$('<input />').attr('type', 'hidden')
	.attr('name', "sumLine")
	.attr('value', sumLine)
	.appendTo('#p1Form');
	return true;
});

/**
 * Add new row of word and audio
 * 単語と音響の行を追加する。
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
 	var div_word = document.createElement("div");
 	div_word.setAttribute('class', "col-xs-6");
 	label_word = document.createElement("label");
 	label_word.setAttribute('for', 'wordAdd'+ addLine);
 	label_word.innerHTML = 'Word';
 	var word_input = document.createElement("input");
 	word_input.setAttribute('type', "text");
 	word_input.setAttribute('maxlength', "20");
 	word_input.setAttribute('class', "form-control vld-spc");
 	word_input.setAttribute('name', "wordAdd"+ addLine);
 	word_input.setAttribute('required', "true");
 	div_word.appendChild(label_word);
 	div_word.appendChild(word_input);
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
 	node_rowBig.appendChild(div_word);
 	node_rowBig.appendChild(div_audio);
 	node_rowBig.appendChild(div_btn);
 	document.getElementById("p1Div").appendChild(node_rowBig);
 	var $input = $('input.file[type=file]');
 	if ($input.length) {
 		$input.fileinput({
 			maxFileSize: 1000
 		});
 	}
 }

/**
 * delete a row of word and audio
 * 単語と音響の行を削除する。
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
 		document.getElementById('p1Form').appendChild(node_delete);
 		$(button).closest('.row').empty().remove();

 		for (var i = 0; i < sumLine; i++) {
 			if (curLine < i) {
 				$("#row"+i).attr('data-line', i-1);
 				$("#row"+i).attr('id', "row"+(i-1));
 				$("#wordId"+i).attr('name', "wordId"+(i-1));
 				$("#wordId"+i).attr('id', "wordId"+(i-1));
 				$("#word"+(i)).attr('name', "word"+(i-1));
 				$("#word"+(i)).attr('id', "word"+(i-1));
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
 	if ($(element).parent().find('.alert.alert-danger').length) {
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

 $("#p1Form").submit( function(eventObj) {
 	$('.alert').remove();
 	if (validate_chgColor()) {
 		return false;
 	}
 	var node_delete = document.createElement('input');
 	node_delete.setAttribute('type', 'hidden');
 	node_delete.setAttribute('name', 'sumDelete');
 	node_delete.setAttribute('value', deleteLine);
 	document.getElementById('p1Form').appendChild(node_delete);

 	var node_add = document.createElement('input');
 	node_add.setAttribute('type', 'hidden');
 	node_add.setAttribute('name', 'sumAdd');
 	node_add.setAttribute('value', addLine);
 	document.getElementById('p1Form').appendChild(node_add);

 	var node_origin = document.createElement("input");
 	node_origin.setAttribute('type', 'hidden');
 	node_origin.setAttribute('name',"sumOrigin");
 	node_origin.setAttribute('value', $('.origin').length);
 	document.getElementById('p1Form').appendChild(node_origin);
 	$('.undone').each(function() {
 		if($(this).hasClass('audio') && $(this).attr('data-path-audio') != ''){
 			$('<input />').attr('type', 'hidden')
 			.attr('name', "audioPath"+$(this).attr('data-situ'))
 			.attr('value', $(this).attr('data-path-audio'))
 			.appendTo('#p1Form');
 			return true;
 		}
 	})
 })