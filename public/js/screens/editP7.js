var sumDialog = p7.length;
var deleteDia = 0;
var addDialog = 0;

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
 * 	Add new Dialog
 *　新たなダイアログを追加する。
 *
 */
 function AddDialog() {
 	addDialog ++;
 	var node_rowBig = document.createElement("div");
 	node_rowBig.setAttribute('class', 'row big');
 	node_rowBig.setAttribute('id', "dialogAdd"+addDialog);
 	node_rowBig.setAttribute('data-dialogIndex', sumDialog);
 	node_rowBig.setAttribute('data-dialogAdd', addDialog);
 	node_rowBig.setAttribute('data-sumline', 0);

 	var node_title = document.createElement("div");
 	node_title.setAttribute('class', 'header');

 	var node_title_label = document.createElement("label");
 	node_title_label.setAttribute('class', 'situNo');
 	node_title_label.innerHTML = 'Dialog ';

 	var node_title_span = document.createElement("span");
 	node_title_span.setAttribute('id', "line"+(sumDialog));
 	node_title_span.innerHTML = sumDialog+1;
 	node_title_label.appendChild(node_title_span);
 	node_title.appendChild(node_title_label);

 	var node_title_btn = document.createElement("button");
 	node_title_btn.setAttribute('class', 'btn btn-primary');
 	node_title_btn.setAttribute('type', 'button');
 	node_title_btn.setAttribute('style', 'margin-left: 10px');
 	node_title_btn.setAttribute('onclick', 'addLine(this)');

 	var icon = document.createElement("i");
 	icon.setAttribute('class', 'fa fa-plus');
 	icon.setAttribute('data-diaglogIndex', sumDialog);

 	node_title_btn.appendChild(icon);
 	node_title_btn.innerHTML = 'Add new Line';
 	node_title.appendChild(node_title_btn);

 	var node_header = document.createElement("div");
 	node_header.setAttribute('class', 'col-xs-8');
 	node_header.setAttribute('id', 'diaBody'+sumDialog);

 	var node_header_row = document.createElement("div");
 	node_header_row.setAttribute('class', 'row');


 	var node_header_speaker = document.createElement("div");
 	node_header_speaker.setAttribute('class', 'col-xs-3');

 	var node_header_spkLabel = document.createElement("label");
 	node_header_spkLabel.setAttribute('for', 'speaker'+sumDialog);
 	node_header_spkLabel.innerHTML= "Speaker";

 	node_header_speaker.appendChild(node_header_spkLabel);

 	var node_header_dialogue = document.createElement("div");
 	node_header_dialogue.setAttribute('class', 'col-xs-8');

 	var node_header_diaLabel = document.createElement("label");
 	node_header_diaLabel.setAttribute('for', 'dialogue'+sumDialog);
 	node_header_diaLabel.innerHTML = "Dialogue";

 	node_header_dialogue.appendChild(node_header_diaLabel);

 	node_header_row.appendChild(node_header_speaker);
 	node_header_row.appendChild(node_header_dialogue);

 	node_header.appendChild(node_header_row);

 	var node_audio = document.createElement("div");
 	node_audio.setAttribute('class', 'col-xs-3');

 	var audio_label = document.createElement("label");
 	audio_label.setAttribute('for', 'audio'+sumDialog);
 	audio_label.innerHTML = 'Audio';

 	var audio_input = document.createElement("input");
 	audio_input.setAttribute('type', 'file');
 	audio_input.setAttribute('required', 'true');
 	audio_input.setAttribute('id', 'audioAdd'+addDialog);
 	audio_input.setAttribute('name', 'audioAdd'+addDialog);
 	audio_input.setAttribute('class', 'file audio');
 	audio_input.setAttribute('data-situ', addDialog);
 	audio_input.setAttribute('data-show-upload', "false");
 	audio_input.setAttribute('data-show-caption', "true");
 	audio_input.setAttribute('data-allowed-file-extensions', '["mp3"]');

 	node_audio.appendChild(audio_label);
 	node_audio.appendChild(audio_input);

 	var div_btn = document.createElement("div");
 	div_btn.setAttribute('class', "col-xs-1");

 	var deleteBtn = document.createElement("button");
 	deleteBtn.setAttribute('type', 'button');
 	deleteBtn.setAttribute('class', 'deleteBtn');
 	deleteBtn.setAttribute('onclick', 'deleteDialog(this)');

 	var icon = document.createElement("i");
 	icon.setAttribute('class', 'fa fa-trash');
 	deleteBtn.appendChild(icon);

 	div_btn.appendChild(deleteBtn);

 	node_rowBig.appendChild(node_title);
 	node_rowBig.appendChild(node_header);
 	node_rowBig.appendChild(node_audio);
 	node_rowBig.appendChild(div_btn );

 	document.getElementById("p7Div").appendChild(node_rowBig);
 	sumDialog++;
 	var $input = $('input.file[type=file]');
 	if ($input.length) {
 		$input.fileinput({
 			maxFileSize: 1000
 		});
 	}

    reIndex();
 }

 /**
  * Add new sentence of selected dialog
  *　選択したダイアログのセンテンスを追加する。
  *
  * @param {DOM} button 
  */
  function addLine(button) {

  	dialogIndex = $(button).closest('.big').attr('data-dialogIndex');
  	dialogAdd = $(button).closest('.big').attr('data-dialogAdd');
  	sumLine = $(button).closest('.big').attr('data-sumline');

  	var node_header_row = document.createElement("div");
  	node_header_row.setAttribute('id', "row-"+dialogIndex+"-"+sumLine);
  	node_header_row.setAttribute('class', "row " + "row-"+dialogIndex+"-"+sumLine);


  	var node_header_speaker = document.createElement("div");
  	node_header_speaker.setAttribute('class', 'col-xs-3');

  	var node_header_spkInput = document.createElement("input");
  	node_header_spkInput.setAttribute('type','text');
  	node_header_spkInput.setAttribute('maxlength','20');
  	node_header_spkInput.setAttribute('class','form-control vld-null');
  	if ($(button).closest('.big').hasClass('origin')) {
  		node_header_spkInput.setAttribute('name',"speaker-"+dialogIndex+"-"+sumLine);
  		node_header_spkInput.setAttribute('id',"speaker-"+dialogIndex+"-"+sumLine);
  	}else{
  		node_header_spkInput.setAttribute('name',"speakerAdd-"+dialogAdd+"-"+sumLine);
  		node_header_spkInput.setAttribute('id',"speakerAdd-"+dialogAdd+"-"+sumLine);	
  	}

  	node_header_spkInput.setAttribute('required','true');

  	node_header_speaker.appendChild(node_header_spkInput);

  	var node_header_dialogue = document.createElement("div");
  	node_header_dialogue.setAttribute('class', 'col-xs-8');

  	var node_header_diaInput = document.createElement("input");
  	node_header_diaInput.setAttribute('type','text');
  	node_header_diaInput.setAttribute('maxlength','80');
  	node_header_diaInput.setAttribute('class','form-control vld-spc');
  	if ($(button).closest('.big').hasClass('origin')) {
  		node_header_diaInput.setAttribute('name',"dialogue-"+dialogIndex+"-"+sumLine);
  		node_header_diaInput.setAttribute('id',"dialogue-"+dialogIndex+"-"+sumLine);
  	}else{
  		node_header_diaInput.setAttribute('name',"dialogueAdd-"+dialogAdd+"-"+sumLine);
  		node_header_diaInput.setAttribute('id',"dialogueAdd-"+dialogAdd+"-"+sumLine);	
  	}
  	node_header_diaInput.setAttribute('required','true');

  	node_header_dialogue.appendChild(node_header_diaInput);

  	var node_header_btn = document.createElement("div");
  	node_header_btn.setAttribute('class', 'col-xs-1');

  	var header_btn = document.createElement("button");
  	header_btn.setAttribute('type','button');
  	header_btn.setAttribute('class','deleteBtn');
  	header_btn.setAttribute('onclick',"deleteRow(this)");

  	var icon_btn = document.createElement("i");
  	icon_btn.setAttribute('class',"fa fa-trash");

  	header_btn.appendChild(icon_btn);
  	node_header_btn.appendChild(header_btn);

  	node_header_row.appendChild(node_header_speaker);
  	node_header_row.appendChild(node_header_dialogue);
  	node_header_row.appendChild(node_header_btn);
  	document.getElementById("diaBody"+dialogIndex).appendChild(node_header_row);
  	sumLine ++;
  	$(button).closest('.big').attr('data-sumline',sumLine);

    reIndex();
  }

 /**
  * delete a sentence of selected dialog
  *　選択したダイアログのセンテンスを削除する。　
  *
  * @param  {DOM} button 
  * @return {void}
  */
  function deleteRow(button) {
  	dialogIndex = $(button).closest('.big').attr('data-dialogIndex');
  	sumLine = $(button).closest('.big').attr('data-sumline');
  	sumLine--;
  	var curLine = $(button).closest('.row').attr('data-curLine');
  	if(confirm("Are you sure you want to delete?")){
  		$(button).closest('.big').attr('data-sumline',sumLine);
  		console.log($(button).closest('.row'));
  		$(button).closest('.row').empty().remove();
  		for (var i = 0; i < sumLine; i++) {
  			if (curLine < i) {
  				$("#row-"+dialogIndex+"-"+i).attr('id', "row-"+dialogIndex+"-"+(i-1));
  				$("#row-"+dialogIndex+"-"+i).attr('data-dialogIndex', (i-1));	
  				$("#row-"+dialogIndex+"-"+i).attr('id', "row-"+dialogIndex+"-"+(i-1));
  				$("#speaker-"+dialogIndex+"-"+i).attr('name', "speaker-"+dialogIndex+"-"+(i-1));
  				$("#speaker-"+dialogIndex+"-"+i).attr('id', "speaker-"+dialogIndex+"-"+(i-1));
  				$("#dialogue-"+dialogIndex+"-"+i).attr('name', "dialogue-"+dialogIndex+"-"+(i-1));
  				$("#dialogue-"+dialogIndex+"-"+i).attr('id', "dialogue-"+dialogIndex+"-"+(i-1));
  			}
  		}
  	}
  }

  /**
   * delete a dialog
   *　ダイアログを削除する。
   *
   * @param  {DOM} button 
   * @return {void}
   */
   function deleteDialog(button) {
   	deleteDia++;
   	var curDialog = $(button).closest('.big').attr('data-dialogIndex');
   	if(confirm("Are you sure you want to delete?")){
   		var node_delete = document.createElement('input');
   		node_delete.setAttribute('type', 'hidden');
   		node_delete.setAttribute('name', 'delete'+deleteDia);
   		node_delete.setAttribute('value', $(button).closest('.row').find('.id').attr('value'));
   		document.getElementById('p7Form').appendChild(node_delete);
   		$(button).closest('.big').empty().remove();
   		for (var i = 0; i < sumDialog; i++) {
   			if (curDialog <  i) {
   				$("#dialogId"+i).attr('name', "dialogId"+(i-1));
   				$("#dialogId"+i).attr('id', "dialogId"+(i-1));
   				$("#dialog"+i).attr('data-dialogIndex', (i-1));
   				var sumLine = $("#dialog"+i).attr('data-sumline');
   				$("#dialog"+i).attr('id', "dialog"+(i-1));	
   				$("#row"+i).attr('data-diaglogIndex', i-1);	
   				$("#row"+i).attr('id', "row"+(i-1));
   				$("#line"+i).html(i);	
   				$("#line"+i).attr('id', "line"+(i-1));
   				$("#diaBody"+i).attr('id', "diaBody"+(i-1));
   				for(var j = 0; j < sumLine; j++){
   					$("#row-"+i+"-"+j).attr('id', "row-"+(i-1)+"-"+j);
   					console.log("#row-"+i+"-"+j);
   					$("#speaker-"+i+"-"+j).attr('name', "speaker-"+(i-1)+"-"+j);
   					console.log("#speaker"+i+"-"+j);
   					$("#speaker-"+i+"-"+j).attr('id', "speaker-"+(i-1)+"-"+j);
   					$("#dialogue-"+i+"-"+j).attr('name', "dialogue-"+(i-1)+"-"+j);
   					$("#dialogue-"+i+"-"+j).attr('id', "dialogue-"+(i-1)+"-"+j);
   					$("#audio"+(i)).attr('data-situ', (i-1));
   					$("#audio"+(i)).attr('id', "audio"+(i-1));
   				}
   			}
   		}
   		sumDialog--;
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
  var pattern = new RegExp(/[~`@#$%\^&*+=\\[\]\\';/{}|\\"<>]/);
  if (pattern.test(text)) {
   showMesg(textElement, 'Special character is invalid');
   return false;
}else{
   return true;
}
}

$("#p7Form").submit( function(eventObj) {
  $('.alert').remove();
  var fail = false;

  for (var i = 0; i < $('.vld-null').length; i++) {
   if(!validate_spcChar($('.vld-null')[i])){
    fail =true;
}
}

if (fail) {
 return false;
}
$('.big').each(function() {
 if($(this).hasClass('origin')){
  $('<input />').attr('type', 'hidden')
  .attr('name', $(this).attr('id'))
  .attr('value', $(this).attr('data-sumline'))
  .appendTo('#p7Form');
  return true;
}else{
  $('<input />').attr('type', 'hidden')
  .attr('name', "dialogAdd"+$(this).attr('data-dialogAdd'))
  .attr('value', $(this).attr('data-sumline'))
  .appendTo('#p7Form');
  return true;
}
})

var node_delete = document.createElement('input');
node_delete.setAttribute('type', 'hidden');
node_delete.setAttribute('name', 'sumDelete');
node_delete.setAttribute('value', deleteDia);
document.getElementById('p7Form').appendChild(node_delete);

var node_add = document.createElement('input');
node_add.setAttribute('type', 'hidden');
node_add.setAttribute('name', 'sumAdd');
node_add.setAttribute('value', addDialog);
document.getElementById('p7Form').appendChild(node_add);

var node_origin = document.createElement("input");
node_origin.setAttribute('type', 'hidden');
node_origin.setAttribute('name',"sumOrigin");
node_origin.setAttribute('value', $('.origin').length);
document.getElementById('p7Form').appendChild(node_origin);

$('.undone').each(function() {
    if($(this).hasClass('audio') && $(this).attr('data-path-audio') != ''){
        $('<input />').attr('type', 'hidden')
        .attr('name', "audioPath"+$(this).attr('data-situ'))
        .attr('value', $(this).attr('data-path-audio'))
        .appendTo('#p7Form');
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