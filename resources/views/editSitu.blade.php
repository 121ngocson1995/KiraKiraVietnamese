@extends('userLayout')

@section('content')
<link href="{{ asset('css/fileinput.css') }}" media="all" rel="stylesheet" type="text/css"/>
<link href="{{ asset('themes/explorer/theme.css') }}" media="all" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="{{ asset('css/screens/editSitu.css') }}">
<script src="{{ asset('js/fileinput.min.js') }}" type="text/javascript"></script>

<script type="text/javascript">
	$('.listBtn').removeClass('active');
	$('#li-edit').addClass('active');
</script>
<div class="container">
	<div class="title"><h2>Edit situations for lesson {{ $lessonNo }}</h2></div>
	<div class="row description" style="text-align: center; font-size: 1.5em">
		Enter disired content for each situation by writing into appropriate text fields.
	</div>
	{!! Form::open(array('url'=>'editSitu','method'=>'POST', 'files'=>true, 'id' =>'situationForm')) !!}
	<div id="situForm">
		<input type="hidden" name="lessonID" value="{{ $lessonId}}">
		@if (count($situation))

		@for ($i = 0; $i < count($situation); $i++)
		<div class="row origin situationRow" id="row{{$i}}" data-line="{{$i}}">
			<div>
				<label class="situNo">Situation <span id="line{{$i}}">{{$i+1}}</span>
					<input type="hidden" id="situationId{{$i}}" class="id" name="situationId{{$i}}" value="{{$situation[$i]->id}}">
					<button type="button" data-id="{{$situation[$i]->id}}" class="deleteBtn" onclick="deleteRow(this)"><i class="fa fa-trash"></i></button>
				</label>
			</div>
			<div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="dialog{{$i}}">Dialog</label>
							<textarea class="form-control textarea" name="dialog{{$i}}" id="dialog{{$i}}" data-dialog="{{$situation[$i]->dialogArr}}" required maxlength="1600"></textarea>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="dialogTrans{{$i}}">Dialog's translation</label>
							<textarea class="form-control textarea" name="dialogTrans{{$i}}" id="dialogTrans{{$i}}" data-dialog="{{$situation[$i]->dialogTransArr}}" required maxlength="1600"></textarea>
						</div>
						@if ($errors->has('dialogTrans'.$i))
						<div class="alert alert-danger">
							<span>{{ $errors->first('dialogTrans') }}</span>
						</div>
						@endif
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="image{{$i}}">Image</label>
							<input id="image{{ $i }}" name="image{{ $i }}" type="file" class="file undone image" data-situ="{{ $i }}" data-path-image="{{ $situation[$i]->thumbnail }}" data-show-upload="false" data-show-caption="true" data-allowed-file-extensions='["jpg", "png"]'>
						</div>  
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="audio{{$i}}">Audio</label>
							<input id="audio{{ $i }}" name="audio{{ $i }}" type="file" class="file undone audio" data-situ="{{ $i }}" data-path-audio="{{ $situation[$i]->audio }}" data-show-upload="false" data-show-caption="true" data-allowed-file-extensions='["mp3"]'>
						</div>
					</div>
				</div>
			</div>
		</div>
		@endfor
		@endif

		<div class="noteRow">
			@if (count($note))
			@php
			$noteNo = 0;
			@endphp
			<hr class="images">
			@for ($i = 0; $i < count($note); $i++)
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="situNo" for="note">Lesson note {{ ++$noteNo }}</label>
						<button type="button" data-id="{{$note[$i]->id}}" class="deleteNoteBtn" onclick="deleteNote(this)"><i class="fa fa-trash"></i></button>
						<textarea class="form-control note" name="updateNote[{{$note[$i]->id}}][note]" id="note" rows="5" required>{{ $note[$i]->content }}</textarea>
					</div>
				</div>
			</div>
			@endfor
			@endif
		</div>
	</div>
	<div class="row" style="text-align: center;">
		<button type="submit" class="btn btn-success editSituControl"><i class="fa fa-save" style="margin-right: 0.5em"></i>Save</button>
		<button type="button" class="btn btn-primary editSituControl" onclick="addRow()"><i class="fa fa-plus" style="margin-right: 0.5em"></i>Add situation</button>
		<button type="button" class="btn btn-warning editSituControl" onclick="addNote()"><i class="fa fa-plus" style="margin-right: 0.5em"></i>Add lesson note</button>
	</div>
	{!! Form::close() !!}

</div>
<script type="text/javascript">
	$('.textarea').each(function() {
		$(this).text($(this).attr('data-dialog'));
	});

	var situation = <?php echo json_encode($situation); ?>;
</script>

<script src="{{ asset('js/screens/editSitu.js') }}"></script>
@stop