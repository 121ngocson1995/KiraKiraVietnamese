@extends('userLayout')

@section('content')
<link href="{{ asset('css/fileinput.css') }}" media="all" rel="stylesheet" type="text/css"/>
<link href="{{ asset('themes/explorer/theme.css') }}" media="all" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="{{ asset('css/screens/editP2.css') }}">
<script src="{{ asset('js/fileinput.min.js') }}" type="text/javascript"></script>

<script type="text/javascript">
	$('.listBtn').removeClass('active');
	$('#li-edit').addClass('active');
</script>

<div class="container">
	<div class="title"><h2>Edit Practice 2: Listen and find the correct words for lesson {{ $lessonNo }}</h2></div>
	<div class="row description" style="text-align: center; font-size: 1.5em">
		Add new words or change existing ones by writing into appropriate text fields and uploading new audio files.
	</div>
	{!! Form::open(array('url'=>'editP2','method'=>'POST', 'files'=>true, 'id' =>'p2Form')) !!}
	<div id="p2Div">
		<input type="hidden" name="lessonID" value="{{$lessonId}}">
		@if (count($p2) )
		@for ($i = 1; $i <= count($p2)  ; $i++)
		<div class="row origin" id="row{{$i}}" data-line="{{$i}}">
			<div class="col-xs-6">
				<label for="word{{$i}}">Word</label>
				<input type="text" id="word{{$i}}" class="form-control vld-spc" required="true" maxlength="20" name="word{{$i}}" value="{{$p2[$i-1]->word}}">
			</div>
			<div class="col-xs-5">
				<label for="audio{{$i}}">Audio</label>
				<input id="audio{{$i}}" name="audio{{$i}}" type="file" class="file undone audio" data-situ="{{$i}}" data-path-audio="{{$p2[$i-1]->audio}}" data-show-upload="false" data-show-caption="true" data-allowed-file-extensions='["mp3"]'>
			</div>
			<div class="col-xs-1 ">
				<button type="button" class="deleteBtn " onclick="deleteRow(this)"><i class="fa fa-trash"></i></button>
			</div>
			<input type="hidden" id="wordId{{$i}}" class="id" name="wordId{{$i}}" value="{{$p2[$i-1]->id}}">
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

	var p2 = <?php echo json_encode($p2); ?>;
</script>

<script src="{{ asset('js/screens/editP2.js') }}"></script>
@stop