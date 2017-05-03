@extends('userLayout')

@section('header-more')

<link href="{{ asset('css/fileinput.css') }}" media="all" rel="stylesheet" type="text/css"/>
<link href="{{ asset('themes/explorer/theme.css') }}" media="all" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="{{ asset('css/screens/editExt.css') }}">
<script src="{{ asset('js/fileinput.min.js') }}" type="text/javascript"></script>

@stop

@section('content')

<script type="text/javascript">
	$('.listBtn').removeClass('active');
	$('#li-edit').addClass('active');
</script>
<div class="container">
	<div class="title"><h2>Edit Extension: Language and Culture for lesson {{ $lessonNo }}</h2></div>
	<div class="row description" style="text-align: center; font-size: 1.5em">
		Add new content by clicking the plus sign. Choose a existing content by clicking tabs. Change existing ones by writing into text fields below.
	</div>
	<div id="wrapper">
		{!! Form::open(array('url'=>'editExtensions','method'=>'POST', 'files'=>true, 'id' =>'extForm')) !!}
		<input type="hidden" name="lessonId" value="{{ $lessonId }}">

		@php
		$imgNo = array();
		@endphp

		<ul class="nav nav-tabs">
			@for ($i = 0; $i < count($ext); $i++)
			<li><a data-toggle="tab" href="#update{{ $ext[$i]->id }}">
				@if ($ext[$i]->type == 0)
				Images
				@elseif ($ext[$i]->type == 1)
				Song
				@elseif ($ext[$i]->type == 2)
				Poem
				@elseif ($ext[$i]->type == 3)
				Idiom
				@elseif ($ext[$i]->type == 4)
				Riddle
				@elseif ($ext[$i]->type == 5)
				Game
				@endif
				<i class="fa fa-times fa-normal deletePart"></i></a>
			</li>
			@endfor
			<li id="addPartBtn">
				<a data-toggle="dropdown" href="#"><i class="fa fa-plus fa-normal"></i></a>
				<ul class="dropdown-menu">
					<li><a class="addPart images" href="#">Images</a></li>
					<li><a class="addPart song" href="#">Song</a></li>
					<li><a class="addPart poem" href="#">Poem</a></li>
					<li><a class="addPart idiom" href="#">Idiom</a></li>
					<li><a class="addPart riddle" href="#">Riddle</a></li>
					<li><a class="addPart play" href="#">Game</a></li>
				</ul>
			</li>
		</ul>

		<div class="tab-content">
			@for ($i = 0; $i < count($ext); $i++)

			@php
			$element = $ext[$i];
			@endphp

			@if ($element->type == 0)

			<div id="update{{ $element->id }}" class="tab-pane fade">
				<input type="hidden" class="extInfo" name="update[{{ $element->id }}][type]" value="{{ $element->type }}">
				<input type="hidden" name="prefix" value="update[{{ $element->id }}]" disabled="" readonly="readonly">
				<input type="hidden" name="imgNo" value="{{ count($imgNo) }}" readonly="">

				<div class="row">
					<div class="col-sm-12 form-group">
						<label for="updateimages{{ $element->id }}-title">Title:</label>
						<input id="updateimages{{ $element->id }}-title" name="update[{{ $element->id }}][title]" type="text" class="form-control vld-spc" maxlength="200" placeholder="Enter title for this colection of images" value="{{ $element->title }}" required="">
					</div>
				</div>
				<hr class="images">
				<div class="row masterHolder">
					@php
					$imgNo[] = 0;
					$images = explode('|', $element->slideshow_images);
					$captions = explode('|', $element->slideshow_caption);
					@endphp
					@for ($j = 0; $j < count($images); $j++)
					<div class="row imageHolder">
						<div class="col-sm-1">
							<label class="imgNo">{{ ++$imgNo[count($imgNo)-1] }}.</label>
						</div>
						<div class="col-sm-5 form-group">
							<label for="update-image-{{ $element->id }}-{{ $j }}-caption">Image caption:</label>
							<input id="update-image-{{ $element->id }}-{{ $j }}-caption" name="update[{{ $element->id }}][caption][]" type="text" class="form-control vld-spc" maxlength="200" placeholder="Enter caption" value="{{ $captions[$j] }}" required>
						</div>
						<div class="col-sm-5 form-group">
							<label for="update-image-{{ $element->id }}-{{ $j }}-image">Upload image:</label>
							<input id="update-image-{{ $element->id }}-{{ $j }}-image" name="update[{{ $element->id }}][image][{{ $j }}]" type="file" class="file" data-show-upload="false" data-show-caption="true" data-allowed-file-extensions='["jpg","png"]'>
						</div>
						<div class="col-sm-1">
							<div class="deleteImage">
								<button type="button" class="horizontal close">
									<i class="fa fa-trash fa-1x"></i>
								</button>
							</div>
						</div>
					</div>
					@endfor
				</div>
				<div class="row newImage">
					<button class="btn btn-primary newImageBtn" type="button"><i class="fa fa-plus"></i><span class="newImageBtnText">Add new sentence</span></button>
				</div>
			</div>

			@elseif ($element->type == 1)

			<div id="update{{ $element->id }}" class="tab-pane fade">
				<input type="hidden" class="extInfo" name="update[{{ $element->id }}][type]" value="{{ $element->type }}">
				<input type="hidden" name="prefix" value="update[{{ $element->id }}]" readonly="">
				<input type="hidden" name="imgNo" value="{{ count($imgNo) }}" readonly="">

				<div class="row">
					<div class="col-sm-12 form-group">
						<label for="updatesong{{ $element->id }}-title">Title:</label>
						<input id="updatesong{{ $element->id }}-title" name="update[{{ $element->id }}][title]" type="text" class="form-control vld-spc title" maxlength="200" placeholder="Enter title for this song" value="{{ $element->title }}" required="">
					</div>
				</div>
				<hr class="images">
				<div class="row masterHolder">
					<div class="row">
						<div class="col-sm-6 form-group">
							<label for="update-song-{{ $element->id }}-composer">Composer:</label>
							<input id="update-song-{{ $element->id }}-composer" name="update[{{ $element->id }}][composer]" type="text" class="form-control vld-spc" maxlength="200" placeholder="Enter the name of the composer" value="{{ $element->song_composer }}" required="">
						</div>
						<div class="col-sm-6 form-group">
							<label for="update-song-{{ $element->id }}-performer">Performer:</label>
							<input id="update-song-{{ $element->id }}-performer" name="update[{{ $element->id }}][performer]" type="text" class="form-control vld-spc" maxlength="200" placeholder="Enter the namne of the performer" value="{{ $element->song_performer }}" required="">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label for="update-song-{{ $element->id }}-thumbnail">Upload sheet music:</label>
							<input id="update-song-{{ $element->id }}-thumbnail" name="update[{{ $element->id }}][thumbnail]" type="file" class="file" data-show-upload="false" data-show-caption="true" data-allowed-file-extensions='["jpg","png"]'>
						</div>
						<div class="col-sm-6 form-group">
							<label for="update-song-{{ $element->id }}-song">Upload song:</label>
							<input id="update-song-{{ $element->id }}-song" name="update[{{ $element->id }}][song]" type="file" class="file" data-show-upload="false" data-show-caption="true" data-allowed-file-extensions='["mp3"]'>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 form-group">
							<label for="update-song-{{ $element->id }}-content">Lyrics:</label>
							<textarea id="update-song-{{ $element->id }}-content" name="update[{{ $element->id }}][content]" rows="10" class="form-control song-lyrics vld-spc" maxlength="2000" placeholder="Enter lyrics of the song" required="">{{ str_replace('|', '&#013;&#010;', $element->content) }}</textarea>
						</div>
					</div>
				</div>
			</div>

			@elseif ($element->type == 2)

			<div id="update{{ $element->id }}" class="tab-pane fade">
				<input type="hidden" class="extInfo" name="update[{{ $element->id }}][type]" value="{{ $element->type }}">
				<input type="hidden" name="prefix" value="update[{{ $element->id }}]" readonly="">
				<input type="hidden" name="imgNo" value="{{ count($imgNo) }}" readonly="">

				<div class="row">
					<div class="col-sm-12 form-group">
						<label for="updatepoem{{ $element->id }}-title">Title:</label>
						<input id="updatepoem{{ $element->id }}-title" name="update[{{ $element->id }}][title]" type="text" class="form-control vld-spc" maxlength="200" placeholder="Enter title for this poem" value="{{ $element->title }}" required="">
					</div>
				</div>
				<hr class="images">
				<div class="row masterHolder">
					<div class="col-sm-12 form-group">
						<label for="updatepoem{{ $element->id }}-content">Content:</label>
						<textarea id="updatepoem{{ $element->id }}-content" name="update[{{ $element->id }}][content]" type="text" rows="8" class="form-control poem-content vld-spc" maxlength="2000" placeholder="Enter content of the poem" required="">{{ str_replace('|', '&#013;&#010;', $element->content) }}</textarea>
					</div>
				</div>
			</div>

			@elseif ($element->type == 3)

			<div id="update{{ $element->id }}" class="tab-pane fade">
				<input type="hidden" class="extInfo" name="update[{{ $element->id }}][type]" value="{{ $element->type }}">
				<input type="hidden" name="prefix" value="update[{{ $element->id }}]" readonly="">
				<input type="hidden" name="imgNo" value="{{ count($imgNo) }}" readonly="">

				<div class="row">
					<div class="col-sm-12 form-group">
						<label for="updateidiom{{ $element->id }}-content">Idioms – Proverbs – Folk-song:</label>
						<textarea id="updateidiom{{ $element->id }}-content" name="update[{{ $element->id }}][content]" type="text" class="form-control idiom-content vld-spc" maxlength="2000" placeholder="Enter an idiom, a proverb or a folk song" required="">{{ $element->content }}</textarea>
					</div>
				</div>
			</div>

			@elseif ($element->type == 4)

			<div id="update{{ $element->id }}" class="tab-pane fade">
				<input type="hidden" class="extInfo" name="update[{{ $element->id }}][type]" value="{{ $element->type }}">
				<input type="hidden" name="prefix" value="update[{{ $element->id }}]" readonly="">
				<input type="hidden" name="imgNo" value="{{ count($imgNo) }}" readonly="">

				<div class="row">
					<div class="col-sm-12 form-group">
						<label for="updateriddle{{ $element->id }}-title">Title:</label>
						<input id="updateriddle{{ $element->id }}-title" name="update[{{ $element->id }}][title]" type="text" class="form-control vld-spc" maxlength="200" placeholder="Enter title for this riddle" value="{{ $element->title }}" required="">
					</div>
				</div>
				<hr class="images">
				<div class="row masterHolder">
					<div class="row">
						<div class="col-sm-6 form-group">
							<label for="update-riddle-{{ $element->id }}-answer">Answer:</label>
							<input id="update-riddle-{{ $element->id }}-answer" name="update[{{ $element->id }}][answer]" type="text" maxlength="200" class="form-control vld-spc" value="{{ $element->riddle_answer }}" required>
						</div>
						<div class="col-sm-6 form-group">
							<label for="update-riddle-{{ $element->id }}-thumbnail">Upload illustration:</label>
							<input id="update-riddle-{{ $element->id }}-thumbnail" name="update[{{ $element->id }}][thumbnail]" type="file" class="file" data-show-upload="false" data-show-caption="true" data-allowed-file-extensions='["jpg","png"]'>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 form-group">
							<label for="updateriddle{{ $element->id }}-content">Riddle:</label>
							<textarea id="updateriddle{{ $element->id }}-content" name="update[{{ $element->id }}][content]" type="text" class="form-control riddle-content" maxlength="2000" rows="8" placeholder="Enter content of the riddle" required="">{{ str_replace('|', '&#013;&#010;', $element->content) }}</textarea>
						</div>
					</div>
				</div>
			</div>

			@elseif ($element->type == 5)

			<div id="update{{ $element->id }}" class="tab-pane fade">
				<input type="hidden" class="extInfo" name="update[{{ $element->id }}][type]" value="{{ $element->type }}">
				<input type="hidden" name="prefix" value="update[{{ $element->id }}]" readonly="">
				<input type="hidden" name="imgNo" value="{{ count($imgNo) }}" readonly="">

				<div class="row">
					<div class="col-sm-12 form-group">
						<label for="updateplay{{ $element->id }}-title">Title:</label>
						<input id="updateplay{{ $element->id }}-title" name="update[{{ $element->id }}][title]" type="text" maxlength="200" class="form-control vld-spc" placeholder="Enter title for this game" value="{{ $element->title }}" required="">
					</div>
				</div>
				<hr class="images">
				<div class="row masterHolder">
					<div class="row">
						<div class="col-sm-12 form-group">
							<label for="update-play-{{ $element->id }}-thumbnail">Upload illustration:</label>
							<input id="update-play-{{ $element->id }}-thumbnail" name="update[{{ $element->id }}][thumbnail]" type="file" class="file" data-show-upload="false" data-show-caption="true" data-allowed-file-extensions='["jpg","png"]'>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 form-group">
							<label for="updateplay{{ $element->id }}-content">Content:</label>
							<textarea id="updateplay{{ $element->id }}-content" name="update[{{ $element->id }}][content]" type="text" class="form-control play-content" maxlength="2000" rows="8" placeholder="Enter content of the game" required="">{{ str_replace('|', '&#013;&#010;', $element->content) }}</textarea>
						</div>
					</div>
				</div>
			</div>
			@endif
			@endfor
		</div>
		<div id="saveBtn-holder" class="row">
			<button id="saveBtn" class="btn btn-success" type="submit"><i class="fa fa-save"></i><span class="saveBtnText">Save</span></button>
		</div>
		{!! Form::close() !!}
	</div>
</div>

<script>
	var $input = $('input.file[type=file]');
	if ($input.length) {
		$input.fileinput();
	}

	if ($('.tab-pane').length) {
		$('.nav-tabs li').eq(0).addClass('active');
		$('.tab-pane').eq(0).addClass('in active');
	}

	var imgNo = <?php echo json_encode($imgNo); ?>;
</script>

<script src="{{ asset('js/screens/editExt.js') }}"></script>
@stop