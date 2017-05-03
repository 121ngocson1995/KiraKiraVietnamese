@extends('userLayout')

@section('content')
<link href="{{ asset('css/fileinput.css') }}" media="all" rel="stylesheet" type="text/css"/>
<link href="{{ asset('themes/explorer/theme.css') }}" media="all" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="{{ asset('css/screens/editP5.css') }}">
<script src="{{ asset('js/fileinput.min.js') }}" type="text/javascript"></script>

<script type="text/javascript">
	$('.listBtn').removeClass('active');
	$('#li-edit').addClass('active');
</script>

<div class="container">
	<div class="title"><h2>Edit Practice 5: Listen to dialogues and repeat for lesson {{ $lessonNo }}</h2></div>
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

	var p5 = <?php echo json_encode($p5); ?>;
</script>

<script src="{{ asset('js/screens/editP5.js') }}"></script>
@stop