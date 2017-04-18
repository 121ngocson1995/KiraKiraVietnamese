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
	<div class="title"><h2>Edit P1: Word Memorize for lesson {{ $lessonId }}</h2></div>
	{!! Form::open(array('url'=>'editP1','method'=>'POST', 'files'=>true, 'id' =>'p1Form')) !!}
	<div id="p1Div">
		<input type="hidden" name="situaID" value="{{$p1[0]->lesson_id}}">
		@for ($i = 0; $i < count($p1)  ; $i++)
		<div class="row" id="row{{$i}}" data-line="{{$i}}">
			<div class="col-xs-4">
				<label for="word{{$p1[$i]->id}}">Word</label>
				<input type="text" id="word{{$p1[$i]->id}}" class="form-control"  name="word{{$p1[$i]->id}}" value="{{$p1[$i]->word}}">
			</div>
			<div class="col-xs-4">
				<label for="audio{{$p1[$i]->id}}">Audio</label>
				<input id="audio{{$p1[$i]->id}}" name="audio{{$p1[$i]->id}}" type="file" class="file undone audio" data-situ="{{$p1[$i]->id}}" data-path-audio="{{$p1[$i]->audio}}" data-show-upload="false" data-show-caption="true" data-allowed-file-extensions='["mp3"]'>
			</div>
			<div class="col-xs-4">
				<button type="button" class="deleteBtn" onclick="deleteRow(this)"><i class="fa fa-trash"></i></button>
			</div>
		</div>
		@endfor
	</div>
	<div class="row" style="text-align: center;">
		<button type="submit" class="btn btn-success editSituControl"><i class="fa fa-save" style="margin-right: 0.5em"></i>Save</button>
		<button type="button" class="btn btn-primary editSituControl" onclick="AddRow()"><i class="fa fa-plus" style="margin-right: 0.5em"></i>Add</button>
	</div>
	{!! Form::close() !!}

</div>
<script type="text/javascript">
	var p1 = <?php echo json_encode($p1); ?>;
	var sumOrigin = p1.length;
	var sumLine = p1.length;

	var node_hidden = document.createElement("input");
	node_hidden.setAttribute('type', 'hidden');
	node_hidden.setAttribute('name',"sumOrigin");
	node_hidden.setAttribute('value', sumOrigin);

	document.getElementById("p1Div").appendChild(node_hidden);

	$("#p1Form").submit( function(eventObj) {
		$('<input />').attr('type', 'hidden')
		.attr('name', "sumLine")
		.attr('value', sumLine)
		.appendTo('#p1Form');
		return true;
	});

	function AddRow() {
		var node_rowBig = document.createElement("div");
		node_rowBig.setAttribute('class', 'row');
		node_rowBig.setAttribute('id', "row"+(sumLine));
		node_rowBig.setAttribute('data-line', sumLine);

		/* Create label Situation n */
		var div_word = document.createElement("div");
		div_word.setAttribute('class', "col-xs-4");

		label_word = document.createElement("label");
		label_word.setAttribute('for', 'word'+(sumLine+1));
		label_word.innerHTML = 'Word';

		var word_input = document.createElement("input");
		word_input.setAttribute('type', "text");
		word_input.setAttribute('class', "form-control");
		word_input.setAttribute('name', "word"+(sumLine+1));
		word_input.setAttribute('required', "true");

		div_word.appendChild(label_word);
		div_word.appendChild(word_input);
		var div_audio = document.createElement("div");
		div_audio.setAttribute('class', "col-xs-4");

		label = document.createElement("label");
		label.setAttribute('for', 'audio'+(sumLine+1));
		label.innerHTML = 'Audio';

		var audio_input = document.createElement("input");
		audio_input.setAttribute('type', 'file');
		audio_input.setAttribute('required', 'true');
		audio_input.setAttribute('id', 'audio'+(sumLine+1));
		audio_input.setAttribute('name', 'audio'+(sumLine+1));
		audio_input.setAttribute('class', 'file audio');
		audio_input.setAttribute('data-situ', ""+(sumLine+1));
		audio_input.setAttribute('data-show-upload', "false");
		audio_input.setAttribute('data-show-caption', "true");
		audio_input.setAttribute('data-allowed-file-extensions', '["mp3"]');

		div_audio.appendChild(label);
		div_audio.appendChild(audio_input);

		var div_btn = document.createElement("div");
		div_btn.setAttribute('class', "col-xs-4");

		var deleteBtn = document.createElement("button");
		deleteBtn.setAttribute('type', 'button');
		deleteBtn.setAttribute('class', 'deleteBtn');
		deleteBtn.setAttribute('onchange', 'deleteRow(this)');

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
				$("#row"+i).attr('data-line', i-1);
				$("#row"+i).attr('id', "row"+(i-1));
				$("#word"+(i+1)).attr('name', "word"+i);
				$("#word"+(i+1)).attr('id', "word"+i);
				$("#audio"+(i+1)).attr('name', "audio"+i);
				$("#audio"+(i+1)).attr('data-situ', i);
				$("#audio"+(i+1)).attr('id', "audio"+i);
			}
		}
		sumLine--;
	}

	$("#p1Form").submit( function(eventObj) {
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