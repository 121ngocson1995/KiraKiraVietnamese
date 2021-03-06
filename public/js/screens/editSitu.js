var rowAdded = 0;
var deletedNote = 0;
var sumLine = situation.length; 
var deletedRow = 0;
var maxLength = 80;

$('.textarea').on('input focus keydown keyup', function() {
	var text = $(this).val();
	var lines = text.split(/(\r\n|\n|\r)/gm); 
	for (var i = 0; i < lines.length; i++) {
		if (lines[i].length > maxLength) {
			lines[i] = lines[i].substring(0, maxLength);
		}
	}
	$(this).val(lines.join(''));
});

/**
 * Add a new situation
 * 新たな「situation」を追加する。
 * 	
 * @return {void}
 */
 function addRow() {
 	rowAdded++;
 	var node_rowBig = document.createElement("div");
 	node_rowBig.setAttribute('class', 'row situationRow');
 	node_rowBig.setAttribute('id', "row"+(sumLine));
 	node_rowBig.setAttribute('data-line', sumLine);

 	/* Create label Situation n */
 	/* 「Situation 」ラベルを作成する。 */

 	var div_label = document.createElement("div");

 	var label = document.createElement("label");
 	label.setAttribute('class', 'situNo');
 	label.innerHTML = 'Situation ';

 	var lineSpan = document.createElement("span");
 	lineSpan.setAttribute('id', "line"+(sumLine));
 	lineSpan.innerHTML = sumLine+1;
 	label.appendChild(lineSpan);

 	var deleteBtn = document.createElement("button");
 	deleteBtn.setAttribute('class', 'deleteBtn');
 	deleteBtn.setAttribute('type', 'button');
 	deleteBtn.setAttribute('onclick', 'deleteRow(this)');

 	var icon = document.createElement("i");
 	icon.setAttribute('class', 'fa fa-trash');
 	deleteBtn.appendChild(icon);
 	label.appendChild(deleteBtn);
 	div_label.appendChild(label);
 	node_rowBig.appendChild(div_label);

 	/* Create first row (dialog, dialog_translate) */
 	/* 最初の(dialog, dialog_translate)行を作成する。 */

 	var bigDiv = document.createElement("div");
 	var row = document.createElement("div");
 	row.setAttribute('class', 'row');

 	var col = document.createElement("div");
 	col.setAttribute('class', 'col-md-6');

 	var form_group = document.createElement("div");
 	form_group.setAttribute('class', 'form-group');
 	label = document.createElement("label");
 	label.setAttribute('for', 'dialogAdd'+(rowAdded));
 	label.innerHTML = 'Dialog';
 	form_group.appendChild(label);

 	var textarea = document.createElement("textarea");
 	textarea.setAttribute('class', 'form-control textarea');
 	textarea.setAttribute('required', 'true');
 	textarea.setAttribute('maxlength', '1600');
 	textarea.setAttribute('name', "dialogAdd"+(rowAdded));
 	textarea.setAttribute('id', "dialog"+(sumLine));
 	form_group.appendChild(textarea);

 	col.appendChild(form_group);
 	row.appendChild(col);

 	col = document.createElement("div");
 	col.setAttribute('class', 'col-md-6');

 	form_group = document.createElement("div");
 	form_group.setAttribute('class', 'form-group');
 	label = document.createElement("label");
 	label.setAttribute('for', 'dialogTrans'+(rowAdded));
 	label.innerHTML = 'Dialog\'s translation';
 	form_group.appendChild(label);

 	textarea = document.createElement("textarea");
 	textarea.setAttribute('class', 'form-control textarea');
 	textarea.setAttribute('required', 'true');
 	textarea.setAttribute('maxlength', '1600');
 	textarea.setAttribute('name', "dialogTransAdd"+(rowAdded));
 	textarea.setAttribute('id', "dialogTrans"+(sumLine));
 	form_group.appendChild(textarea);

 	col.appendChild(form_group);
 	row.appendChild(col);

 	bigDiv.appendChild(row);

 	/* Create second row (image upload, audio upload) */
 	/* 二列目の (image upload, audio upload)行を作成する。 */

 	row = document.createElement("div");
 	row.setAttribute('class', 'row');

 	col = document.createElement("div");
 	col.setAttribute('class', 'col-md-6');

 	var form_group = document.createElement("div");
 	form_group.setAttribute('class', 'form-group');
 	label = document.createElement("label");
 	label.setAttribute('for', 'image'+(sumLine));
 	label.innerHTML = 'Image';
 	form_group.appendChild(label);

 	var image_input = document.createElement("input");
 	image_input.setAttribute('type', 'file');
 	image_input.setAttribute('id', 'imageAdd'+(rowAdded));
 	image_input.setAttribute('name', 'imageAdd'+(rowAdded));
 	image_input.setAttribute('class', 'file undone image');
 	image_input.setAttribute('data-situ', ""+(sumLine));
 	image_input.setAttribute('data-show-upload', "false");
 	image_input.setAttribute('data-show-caption', "true");
 	image_input.setAttribute('data-allowed-file-extensions', '["jpg", "png"]');
 	image_input.setAttribute('required', '');
 	form_group.appendChild(image_input);

 	col.appendChild(form_group);
 	row.appendChild(col);

 	col = document.createElement("div");
 	col.setAttribute('class', 'col-md-6');

 	var form_group = document.createElement("div");
 	form_group.setAttribute('class', 'form-group');
 	label = document.createElement("label");
 	label.setAttribute('for', 'image'+(sumLine));
 	label.innerHTML = 'Audio';
 	form_group.appendChild(label);

 	var audio_input = document.createElement("input");
 	audio_input.setAttribute('type', 'file');
 	audio_input.setAttribute('id', 'audioAdd'+(rowAdded));
 	audio_input.setAttribute('name', 'audioAdd'+(rowAdded));
 	audio_input.setAttribute('class', 'file undone audio');
 	audio_input.setAttribute('data-situ', ""+(sumLine));
 	audio_input.setAttribute('data-show-upload', "false");
 	audio_input.setAttribute('data-show-caption', "true");
 	audio_input.setAttribute('data-allowed-file-extensions', '["mp3"]');
 	form_group.appendChild(audio_input);

 	col.appendChild(form_group);
 	row.appendChild(col);

 	bigDiv.appendChild(row);

 	node_rowBig.appendChild(bigDiv);

 	$(node_rowBig).insertBefore(document.getElementsByClassName('noteRow')[0]);

 	var $input = $('input.file[type=file]');
 	if ($input.length) {
 		$input.fileinput();
 	}
 	sumLine++;
 }

/**
 * delete a situation 
 * 「situation 」を削除する。
 * 
 * @param  {DOM} button
 * @return {void} 
 */
 function deleteRow(button) {
 	deletedRow++;
 	var curLine = $(button).closest('.row').attr('data-line');
 	if(confirm("Are you sure you want to delete?")){
 		var node_delete = document.createElement('input');
 		node_delete.setAttribute('type', 'hidden');
 		node_delete.setAttribute('name', 'delete'+deletedRow);
 		node_delete.setAttribute('value', $(button).attr('data-id'));
 		document.getElementById('situationForm').appendChild(node_delete);
 		$(button).closest('.row').empty().remove();
 		for (var i = 0; i < sumLine; i++) {
 			if (curLine < i) {
 				$("#line"+i).text(i);
 				$("#row"+i).attr('data-line', i-1);
 				$("#row"+i).attr('id', "row"+(i-1));
 				$("#line"+i).attr('id', "line"+(i-1));
 				$("#dialog"+(i)).attr('name', "dialog"+(i-1));
 				$("#dialog"+(i)).attr('id', "dialog"+(i-1));
 				$("#dialogTrans"+(i)).attr('name', "dialogTrans"+(i-1));
 				$("#dialogTrans"+(i)).attr('id', "dialogTrans"+(i-1));
 				$("#image"+(i)).attr('name', "image"+(i-1));
 				$("#image"+(i)).attr('data-situ', (i-1));
 				$("#image"+(i)).attr('id', "image"+(i-1));
 				$("#audio"+(i)).attr('name', "audio"+(i-1));
 				$("#audio"+(i)).attr('data-situ', (i-1));
 				$("#audio"+(i)).attr('id', "audio"+(i-1));
 			}
 		}
 		sumLine--;
 	}
 }

 /**
  * add new note
  * @return {void}
  */
  function addNote() {
  	var div = document.createElement('div');
  	div.className = 'row';
  	div.innerHTML = '<div class="col-md-12"><div class="form-group"><label class="situNo" for="note">Lesson note ' + ($('.noteRow').find('.row').length + 1) + '</label><button type="button" data-id="" class="deleteNoteBtn" onclick="deleteNote(this)"><i class="fa fa-trash"></i></button><textarea class="form-control note" name="insertNote['+$('.note').length+'][note]" id="note" rows="5" required></textarea></div></div>';
  	document.getElementsByClassName('noteRow')[0].appendChild(div);
  }

  var toDeleteNote = '';

 /**
  * delete a note 
  * @param  {DOM} button 
  * @return {void} 
  */
  function deleteNote(button) {
  	if (button.getAttribute('data-id') != '') {
  		if (toDeleteNote != '') {
  			toDeleteNote += ',';
  		}
  		toDeleteNote += button.getAttribute('data-id');
  	}

  	if(confirm("Are you sure you want to delete?")){
  		var node_delete = document.createElement('input');
  		node_delete.setAttribute('type', 'hidden');
  		node_delete.setAttribute('name', 'deleteNote'+deletedNote);
  		node_delete.setAttribute('value', $(button).attr('data-id'));
  		document.getElementById('situationForm').appendChild(node_delete);
  		$(button).closest('.row').empty().remove();
  	}

  	var noteNo = 0;

  	$('.noteRow').find('.row').each(function() {
  		$(this).find('label')[0].innerHTML = 'Lesson note ' + ++noteNo;
  	});
  }

  function validate_chgColor() {
    var fail = false;
    for (var i = 0; i < $('.row.situationRow').length; i++) {
      var situaNo = parseInt($('.row.situationRow')[i].getAttribute('data-line'));
      if(!validate_spcChar($('.row.situationRow')[i]) || !validate_space($('.row.situationRow')[i])|| !validate_checkLine($('.row.situationRow')[i]) ) {

        document.getElementById("dialog"+situaNo).style.borderColor = "red";
        document.getElementById("dialogTrans"+situaNo).style.borderColor = "red";
        fail = true;
      }else{
        document.getElementById("dialog"+situaNo).style.borderColor = "transparent";
        document.getElementById("dialogTrans"+situaNo).style.borderColor = "transparent";
      }
      
    }
    return fail;
  }

  function showMesg(parentElement, msg) {
   if ($(parentElement).find('.alert alert-danger').length) {
    $(parentElement).find('span.help').html(msg);
  } else {
    var div_help = document.createElement('div');
    div_help.className = 'alert alert-danger';
    div_help.innerHTML = '<span class="help">' +  msg +  '</span>';
    parentElement.append(div_help);
  }
}

function validate_spcChar(element){
 var situaNo = parseInt(element.getAttribute('data-line'));
 var dialog_text = $("#dialog"+situaNo).val();
 var dialogTrans_text = $("#dialogTrans"+situaNo).val();
 var pattern = new RegExp(/[~`@#$%\^&*+=\\[\]\\';/{}|\\":<>]/);
 if (pattern.test(dialog_text) ||pattern.test(dialogTrans_text) ) {
  showMesg(element, 'Special character is invalid');
  return false;
}else{
  return true;
}
}

function validate_space(element) {
 var situaNo = parseInt(element.getAttribute('data-line'));
 var dialog_text = $("#dialog"+situaNo).val();
 var dialogTrans_text = $("#dialogTrans"+situaNo).val();
 if( dialog_text.trim() == "" ||dialogTrans_text.trim() == "") {
  showMesg(element, 'Empty value is not allowed');
  return false;
}else{
  return true;
}
}

function validate_checkLine(element) {
 var situaNo = parseInt(element.getAttribute('data-line'));
console.log(situaNo);
 var dialog_text = $("#dialog"+situaNo).val();
 var dialogTrans_text = $("#dialogTrans"+situaNo).val();
 var dialog_count = dialog_text.split("\n").length;
 var dialogTrans_count = dialogTrans_text.split("\n").length;

 if (dialog_count != dialogTrans_count ) {
  showMesg(element, "The number of dialog sentence must equal to the dialog translate. Please check again !");

  return false;
}else{
  return true;
}
}

$(document).ready(function () {
 $('.file.undone').on('change', function(event) {
  var filename = this.value;
  var extension = filename.split('.').pop();

  if($(this).hasClass('image')) {
   if (extension == 'jpg' || extension == 'png') {
    $(this).removeClass('undone');
    return;
  }
} else if ($(this).hasClass('audio')) {
 if (extension == 'mp3') {
  $(this).removeClass('undone');
  return;
}
}

$(this).addClass('undone');
});
});

$("#situationForm").submit( function(eventObj) {
  $('.alert').remove();
  if (validate_chgColor()) {
    return false;
  }


var node_delete = document.createElement('input');
node_delete.setAttribute('type', 'hidden');
node_delete.setAttribute('name', 'sumDelete');
node_delete.setAttribute('value', deletedRow);
document.getElementById('situationForm').appendChild(node_delete);

var node_delete = document.createElement('input');
node_delete.setAttribute('type', 'hidden');
node_delete.setAttribute('name', 'sumNoteDelete');
node_delete.setAttribute('value', deletedNote);
document.getElementById('situationForm').appendChild(node_delete);

var node_add = document.createElement('input');
node_add.setAttribute('type', 'hidden');
node_add.setAttribute('name', 'sumAdd');
node_add.setAttribute('value', rowAdded);
document.getElementById('situationForm').appendChild(node_add);

var node_hidden = document.createElement("input");
node_hidden.setAttribute('type', 'hidden');
node_hidden.setAttribute('name',"sumOrigin");
node_hidden.setAttribute('value', $('.origin').length);

document.getElementById("situForm").appendChild(node_hidden);

$('<input />').attr('type', 'hidden')
.attr('name', "sumLine")
.attr('value', sumLine)
.appendTo('#situationForm');

if (toDeleteNote) {
  $('<input />').attr('type', 'hidden')
  .attr('name', 'deleteNote')
  .attr('value', toDeleteNote)
  .appendTo('#p6Form');
  return true;
}

return true;

});