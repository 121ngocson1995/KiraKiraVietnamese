@extends('userLayout')

@section('content')
<link href="{{ asset('css/fileinput.css') }}" media="all" rel="stylesheet" type="text/css"/>
<link href="{{ asset('themes/explorer/theme.css') }}" media="all" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="{{ asset('css/screens/editP3.css') }}">
<script src="{{ asset('js/fileinput.min.js') }}" type="text/javascript"></script>

<script type="text/javascript">
	$('.listBtn').removeClass('active');
	$('#li-edit').addClass('active');
</script>

<div class="container">
	<div class="title"><h2>Edit Practice 3: Listen to sentences and repeat for lesson {{ $lessonNo }}</h2></div>
	<div class="row description" style="text-align: center; font-size: 1.5em">
		Add new sentences or change existing ones by writing into appropriate text fields and uploading new audio files.
	</div>
	{!! Form::open(array('url'=>'editP3','method'=>'POST', 'files'=>true, 'id' =>'p3Form')) !!}
	<div id="p3Div">
		<input type="hidden" name="lessonID" value="{{$lessonId}}">
		@if (count($p3))
		
		@for ($i = 1; $i <= count($p3)  ; $i++)
		<div class="row origin" id="row{{$i}}" data-line="{{$i}}">
			<div class="col-xs-6">
				<label for="sentence{{$i}}">Sentence</label>
				<input type="text" id="sentence{{$i}}" class="form-control  vld-spc" required="true" maxlength="80" name="sentence{{$i}}" value="{{$p3[$i-1]->sentence}}">
			</div>
			<div class="col-xs-5">
				<label for="audio{{$i}}">Audio</label>
				<input id="audio{{$i}}" name="audio{{$i}}" type="file" class="file undone audio" data-situ="{{$i}}" data-path-audio="{{$p3[$i-1]->audio}}" data-show-upload="false" data-show-caption="true" data-allowed-file-extensions='["mp3"]'>
			</div>
			<div class="col-xs-1 ">
				<button type="button" class="deleteBtn " onclick="deleteRow(this)"><i class="fa fa-trash"></i></button>
			</div>
			<input type="hidden" id="sentenceId{{$i}}" class="id" name="sentenceId{{$i}}" value="{{$p3[$i-1]->id}}">
		</div>
		@endfor
		@endif
	</div>
	<div class="row" style="text-align: center; margin-top: 2em;">
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

	var p3 = <?php echo json_encode($p3); ?>;
</script>

<script src="{{ asset('js/screens/editP3.js') }}"></script>
@stop