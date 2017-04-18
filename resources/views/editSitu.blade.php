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
	<div class="title"><h2>Edit situations for lesson {{ $lessonId }}</h2></div>
	{!! Form::open(array('url'=>'editSitu','method'=>'POST', 'files'=>true, 'id' =>'situationForm')) !!}
	<div id="situForm">
		<input type="hidden" name="lessonID" value="{{$situation[0]->lesson_id}}">
		@for ($i = 0; $i < count($situation); $i++)
		<div class="row situationRow" id="row{{$i}}" data-line="{{$i}}">
			<div>
				<label class="situNo">Situation <span id="line{{$i}}">{{$situation[$i]->situationNo}}</span>
					<button class="deleteBtn" onclick="deleteRow(this)"><i class="fa fa-trash"></i></button>
				</label>
			</div>
			<div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="dialog{{$situation[$i]->situationNo}}">Dialog</label>
							<textarea class="form-control textarea" name="dialog{{$situation[$i]->situationNo}}" id="dialog{{$situation[$i]->situationNo}}" data-dialog="{{$situation[$i]->dialogArr}}" required></textarea>
						</div>
						@if ($errors->has("dialog".$i))
						<div class="help-block">
							<span>{{ $errors->first('dialog') }}</span>
						</div>
						@endif
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="dialogTrans{{$situation[$i]->situationNo}}">Dialog's translation</label>
							<textarea class="form-control textarea" name="dialogTrans{{$situation[$i]->situationNo}}" id="dialogTrans{{$situation[$i]->situationNo}}" data-dialog="{{$situation[$i]->dialogTransArr}}" required></textarea>
						</div>
						@if ($errors->has('dialogTrans'.$i))
						<div class="help-block">
							<span>{{ $errors->first('dialogTrans') }}</span>
						</div>
						@endif
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="image{{$situation[$i]->situationNo}}">Image</label>
							<input id="image{{ $situation[$i]->situationNo }}" name="image{{ $situation[$i]->situationNo }}" type="file" class="file undone image" data-situ="{{ $situation[$i]->situationNo }}" data-path-image="{{ $situation[$i]->thumbnail }}" data-show-upload="false" data-show-caption="true" data-allowed-file-extensions='["jpg", "png"]'>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="audio{{$situation[$i]->situationNo}}">Audio</label>
							<input id="audio{{ $situation[$i]->situationNo }}" name="audio{{ $situation[$i]->situationNo }}" type="file" class="file undone audio" data-situ="{{ $situation[$i]->situationNo }}" data-path-audio="{{ $situation[$i]->audio }}" data-show-upload="false" data-show-caption="true" data-allowed-file-extensions='["mp3"]'>
						</div>
					</div>
				</div>
			</div>
		</div>
		<hr>
		@endfor
	</div>
	<div class="row" style="text-align: center;">
		<button type="submit" class="btn btn-success editSituControl"><i class="fa fa-save" style="margin-right: 0.5em"></i>Save</button>
		<button type="button" class="btn btn-primary editSituControl" onclick="AddRow()"><i class="fa fa-plus" style="margin-right: 0.5em"></i>Add</button>
	</div>
	{!! Form::close() !!}

</div>
<script type="text/javascript">
	$('.textarea').each(function() {
		$(this).text($(this).attr('data-dialog'));
	});
</script>
<script type="text/javascript">
	var rowAdded = 0;
	var situation = <?php echo json_encode($situation); ?>;
	var sumOrigin = situation.length;
	var sumLine = situation.length;
	var _validFileExtensions_img = [".jpg",".png"];    
	var _validFileExtensions_audio = [".mp3"]; 

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

	function ValidateSingleInput_img(oInput) {
		if (oInput.type == "file") {
			var sFileName = oInput.value;
			if (sFileName.length > 0) {
				var blnValid = false;
				for (var j = 0; j < _validFileExtensions_img.length; j++) {
					var sCurExtension = _validFileExtensions_img[j];
					if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
						blnValid = true;
						break;
					}
				}

				if (!blnValid) {
					alert("Sorry, " + sFileName.replace(/C:\\fakepath\\/, '') + " is invalid, allowed extensions are: " + _validFileExtensions_img.join(", "));
					oInput.value = "";
					return false;
				}
			}
		}
		$(oInput).removeClass('undone');
		return true;
	}

	function ValidateSingleInput_audio(oInput) {
		if (oInput.type == "file") {
			var sFileName = oInput.value;
			if (sFileName.length > 0) {
				var blnValid = false;
				for (var j = 0; j < _validFileExtensions_audio.length; j++) {
					var sCurExtension = _validFileExtensions_audio[j];
					if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
						blnValid = true;
						break;
					}
				}

				if (!blnValid) {
					alert("Sorry, " + sFileName.replace(/C:\\fakepath\\/, '') + " is invalid, allowed extensions are: " + _validFileExtensions_audio.join(", "));
					oInput.value = "";
					return false;
				}
			}
		}
		$(oInput).removeClass('undone');
		return true;
	}

	function AddRow() {
		rowAdded++;
		var node_rowBig = document.createElement("div");
		node_rowBig.setAttribute('class', 'row');
		node_rowBig.setAttribute('id', "row"+(sumLine));
		node_rowBig.setAttribute('data-line', sumLine);

		/* Create label Situation n */

		var div_label = document.createElement("div");

		var label = document.createElement("label");
		label.setAttribute('class', 'situNo');
		label.innerHTML = 'Situation ';

		var lineSpan = document.createElement("span");
		lineSpan.setAttribute('id', "line"+(sumLine+1));
		lineSpan.innerHTML = sumLine+1;
		label.appendChild(lineSpan);

		var deleteBtn = document.createElement("button");
		deleteBtn.setAttribute('class', 'deleteBtn');
		deleteBtn.setAttribute('onchange', 'deleteRow(this)');

		var icon = document.createElement("i");
		icon.setAttribute('class', 'fa fa-trash');
		deleteBtn.appendChild(icon);
		label.appendChild(deleteBtn);
		div_label.appendChild(label);
		node_rowBig.appendChild(div_label);

		/* Create first row (dialog, dialog_translate) */

		var bigDiv = document.createElement("div");
		var row = document.createElement("div");
		row.setAttribute('class', 'row');

		var col = document.createElement("div");
		col.setAttribute('class', 'col-md-6');

		var form_group = document.createElement("div");
		form_group.setAttribute('class', 'form-group');
		label = document.createElement("label");
		label.setAttribute('for', 'dialog'+(sumLine+1));
		label.innerHTML = 'Dialog';
		form_group.appendChild(label);

		var textarea = document.createElement("textarea");
		textarea.setAttribute('class', 'form-control textarea');
		textarea.setAttribute('required', 'true');
		textarea.setAttribute('name', "dialog"+(sumLine+1));
		textarea.setAttribute('id', "dialog"+(sumLine+1));
		form_group.appendChild(textarea);

		col.appendChild(form_group);
		row.appendChild(col);

		col = document.createElement("div");
		col.setAttribute('class', 'col-md-6');

		form_group = document.createElement("div");
		form_group.setAttribute('class', 'form-group');
		label = document.createElement("label");
		label.setAttribute('for', 'dialogTrans'+(sumLine+1));
		label.innerHTML = 'Dialog';
		form_group.appendChild(label);

		textarea = document.createElement("textarea");
		textarea.setAttribute('class', 'form-control textarea');
		textarea.setAttribute('required', 'true');
		textarea.setAttribute('name', "dialog"+(sumLine+1));
		textarea.setAttribute('id', "dialog"+(sumLine+1));
		form_group.appendChild(textarea);

		col.appendChild(form_group);
		row.appendChild(col);

		bigDiv.appendChild(row);

		/* Create second row (image upload, audio upload) */

		row = document.createElement("div");
		row.setAttribute('class', 'row');

		col = document.createElement("div");
		col.setAttribute('class', 'col-md-6');

		var form_group = document.createElement("div");
		form_group.setAttribute('class', 'form-group');
		label = document.createElement("label");
		label.setAttribute('for', 'image'+(sumLine+1));
		label.innerHTML = 'Image';
		form_group.appendChild(label);

		var image_input = document.createElement("input");
		image_input.setAttribute('type', 'file');
		image_input.setAttribute('id', 'image'+(sumLine+1));
		image_input.setAttribute('name', 'image'+(sumLine+1));
		image_input.setAttribute('class', 'file undone image');
		image_input.setAttribute('data-situ', ""+(sumLine+1));
		image_input.setAttribute('data-show-upload', "false");
		image_input.setAttribute('data-show-caption', "true");
		image_input.setAttribute('ata-allowed-file-extensions', '["jpg", "png"]');
		form_group.appendChild(image_input);

		col.appendChild(form_group);
		row.appendChild(col);

		col = document.createElement("div");
		col.setAttribute('class', 'col-md-6');

		var form_group = document.createElement("div");
		form_group.setAttribute('class', 'form-group');
		label = document.createElement("label");
		label.setAttribute('for', 'image'+(sumLine+1));
		label.innerHTML = 'Image';
		form_group.appendChild(label);

		var audio_input = document.createElement("input");
		audio_input.setAttribute('type', 'file');
		audio_input.setAttribute('id', 'audio'+(sumLine+1));
		audio_input.setAttribute('name', 'audio'+(sumLine+1));
		audio_input.setAttribute('class', 'file undone audio');
		audio_input.setAttribute('data-situ', ""+(sumLine+1));
		audio_input.setAttribute('data-show-upload', "false");
		audio_input.setAttribute('data-show-caption', "true");
		audio_input.setAttribute('ata-allowed-file-extensions', '["mp3"]');
		form_group.appendChild(audio_input);

		col.appendChild(form_group);
		row.appendChild(col);

		bigDiv.appendChild(row);

		node_rowBig.appendChild(bigDiv);

		document.getElementById("situForm").appendChild(node_rowBig);

		var $input = $('input.file[type=file]');
		if ($input.length) {
			$input.fileinput();
		}
		sumLine++;
	}

	function deleteRow(button) {
		var curLine = $(button).closest('.row').attr('data-line');
		if(confirm("Are you sure you want to delete?")){
			$(button).closest('.row').empty().remove();
		}
		for (var i = 0; i < sumLine; i++) {
			if (curLine < i) {
				$("#line"+i).text(i);
				$("#row"+i).attr('data-line', i-1);
				$("#row"+i).attr('id', "row"+(i-1));
				$("#line"+i).attr('id', "line"+(i-1));
				$("#dialog"+(i+1)).attr('name', "dialog"+i);
				$("#dialog"+(i+1)).attr('id', "dialog"+i);
				$("#dialogTrans"+(i+1)).attr('name', "dialogTrans"+i);
				$("#dialogTrans"+(i+1)).attr('id', "dialogTrans"+i);
				$("#image"+(i+1)).attr('name', "image"+i);
				$("#image"+(i+1)).attr('data-situ', i);
				$("#image"+(i+1)).attr('id', "image"+i);
				$("#audio"+(i+1)).attr('name', "audio"+i);
				$("#audio"+(i+1)).attr('data-situ', i);
				$("#audio"+(i+1)).attr('id', "audio"+i);
			}
		}
		sumLine--;
	}

	var node_hidden = document.createElement("input");
	node_hidden.setAttribute('type', 'hidden');
	node_hidden.setAttribute('name',"sumOrigin");
	node_hidden.setAttribute('value', sumOrigin);

	document.getElementById("situForm").appendChild(node_hidden);

	$("#situationForm").submit( function(eventObj) {
		$('<input />').attr('type', 'hidden')
		.attr('name', "sumLine")
		.attr('value', sumLine)
		.appendTo('#situationForm');
		return true;
	});

	$("#situationForm").submit( function(eventObj) {
		var validateFail = false;
		$('.row.situationRow').each(function() {
			var situaNo = parseInt($(this).attr('data-line')) + 1;
			var dialog_text = $("#dialog"+situaNo).val();
			var dialogTrans_text = $("#dialogTrans"+situaNo).val();
			var dialog_count = dialog_text.split("\n").length;
			var dialogTrans_count = dialogTrans_text.split("\n").length;

			if (dialog_count != dialogTrans_count) {
				document.getElementById("dialog"+situaNo).style.borderColor = "red";
				document.getElementById("dialogTrans"+situaNo).style.borderColor = "red";
				validateFail = true;
			}else{
				document.getElementById("dialog"+situaNo).style.borderColor = "transparent";
				document.getElementById("dialogTrans"+situaNo).style.borderColor = "transparent";
			}
		})

		if (validateFail) {
			alert("The number of dialog sentence must equal to the dialog translate. Please check again !");
			return false;
		}

		$('.undone').each(function() {
			if($(this).hasClass('image') && $(this).attr('data-path-image') != ''){
				$('<input />').attr('type', 'hidden')
				.attr('name', "imgPath"+$(this).attr('data-situ'))
				.attr('value', $(this).attr('data-path-image'))
				.appendTo('#situationForm');
				return true;
			}else if($(this).hasClass('audio') && $(this).attr('data-path-audio') != ''){
				$('<input />').attr('type', 'hidden')
				.attr('name', "audioPath"+$(this).attr('data-situ'))
				.attr('value', $(this).attr('data-path-audio'))
				.appendTo('#situationForm');
				return true;
			}
		})
	});

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
	
</script>
@stop