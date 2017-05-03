@extends('userLayout')

@section('content')
<link href="{{ asset('css/fileinput.css') }}" media="all" rel="stylesheet" type="text/css"/>
<link href="{{ asset('themes/explorer/theme.css') }}" media="all" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="{{ asset('css/screens/editP7.css') }}">
<script src="{{ asset('js/fileinput.min.js') }}" type="text/javascript"></script>

<script type="text/javascript">
	$('.listBtn').removeClass('active');
	$('#li-edit').addClass('active');
</script>
<div class="container">
	<div class="title"><h2>Edit Practice 7: Practice speaking after dialogues for lesson {{ $lessonNo }}</h2></div>
	<div class="row description" style="text-align: center; font-size: 1.5em">
		Add new conversations or change existing ones by writing into appropriate text fields and uploading new audio files.
	</div>
	{!! Form::open(array('url'=>'editP7','method'=>'POST', 'files'=>true, 'id' =>'p7Form')) !!}
	<div id="p7Div">
		<input type="hidden" name="lessonID" value="{{$lessonId}}">
		@if (count($p7))
		
		@for ($i = 0; $i < count($p7)  ; $i++)
		<div class="row origin big" id="dialog{{$i}}" data-dialogIndex="{{$i}}" data-sumline="{{count($contentArr[$i])}}">
			<div class="header">
				<label class="situNo">Dialog <span id="line{{$i}}">{{($p7[$i]->dialogNo)+1}}</span>
				</label>
				<button id="newLineBtn" onclick="addLine(this);" style="margin-left: 10px" class="btn btn-primary" type="button"><i class="fa fa-plus" data-diaglogIndex="{{$i}}" ></i><span class="newLineBtnText">Add new Line</span></button>		
			</div>
			<div class="col-xs-8" id="diaBody{{$i}}">
				<div class="row">
					<div class="col-xs-3">	
						<label for="speaker{{$i}}">Speaker</label>
					</div>
					<div class="col-xs-8">
						<label for="dialogue{{$i}}">Dialogue</label>
					</div>
					<div class="col-xs-1">
					</div>
				</div>
				@for ($j = 0; $j < count($contentArr[$i]); $j++)
				<div class="row" id="row-{{$i}}-{{$j}}" data-curLine="{{$j}}">
					<div class="col-xs-3">	
						<input type="text" class="form-control vld-null" maxlength="20" name="speaker-{{$i.'-'.$j}}" id="speaker-{{$i.'-'.$j}}" value="{{$contentArr[$i][$j][0]}}" ></input>
					</div>
					<div class="col-xs-8">
						<input type="text" class="form-control vld-spc" maxlength="80" name="dialogue-{{$i.'-'.$j}}" " id="dialogue-{{$i.'-'.$j}}" value="{{$contentArr[$i][$j][1]}}" required></input>
					</div>
					<div class="col-xs-1">
						<button type="button" class="deleteBtn " onclick="deleteRow(this)"><i class="fa fa-trash"></i></button>
					</div>
				</div>
				@endfor
			</div>
			<div class="col-xs-3">
				<label for="audio{{$i}}">Audio</label>
				<input id="audio{{$i}}" name="audio{{$i}}" type="file" class="file undone audio" data-situ="{{$i}}" data-path-audio="{{$p7[$i]->audio}}" data-show-upload="false" data-show-caption="true" data-allowed-file-extensions='["mp3"]'>
			</div>
			<div class="col-xs-1">
				<button type="button" class="deleteBtn " onclick="deleteDialog(this)"><i class="fa fa-trash"></i></button>
			</div>
			<input type="hidden" id="dialogId{{$i}}" class="id" name="dialogId{{$i}}" value="{{$p7[$i]->id}}">
		</div>
		@endfor
		@endif
	</div>
	<br>
	<div class="row" style="text-align: center;">
		<button type="submit" class="btn btn-success editSituControl"><i class="fa fa-save" style="margin-right: 0.5em"></i>Save</button>
		<button type="button" class="btn btn-primary editSituControl" onclick="AddDialog()"><i class="fa fa-plus" style="margin-right: 0.5em"></i>Add</button>
	</div>
	{!! Form::close() !!}
</div>
<script type="text/javascript">
	var p7 = <?php echo json_encode($p7); ?>;

	var $input = $('input.file[type=file]');
	if ($input.length) {
		$input.fileinput({
			maxFileSize: 1000
		});
	}
</script>

<script src="{{ asset('js/screens/editP7.js') }}"></script>
@stop