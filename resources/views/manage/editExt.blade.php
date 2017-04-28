@extends('userLayout')

@section('header-more')

<link href="{{ asset('css/fileinput.css') }}" media="all" rel="stylesheet" type="text/css"/>
<link href="{{ asset('themes/explorer/theme.css') }}" media="all" rel="stylesheet" type="text/css"/>
<script src="{{ asset('js/fileinput.min.js') }}" type="text/javascript"></script>

<style type="text/css">
	div.title {
		padding: 0 2em;
		text-align: center;
		margin-top: 2em;
	}
	div.description {
		padding: 0 3em;
		margin-bottom: 2em;
	}
	.sentence-input {
		/*width: 100%;*/
		display: inline-block;
	}
	#wrapper {
		padding: 1em 4em;
	}
	textarea {
		resize: vertical;
	}
	textarea.song-lyrics, textarea.poem-content, textarea.riddle-content, textarea.play-content textarea.idiom-content {
		text-align: center;
	}
	label {
		font-size: 1.2em !important;
		font-weight: bold !important;
	}
	.fa {
		margin-left: 0;
		margin-right: 0.3em;
	}
	#saveBtn-holder {
		text-align: center;
		margin-top: 2em;
	}
	.deleteContent {
		position: absolute;
		right: 0;
		margin-right: 3em;
		display: none;
	}
	.close, .close:hover {
		color: black;
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
	
	button {
		outline: none;
	}
	.deleteImage {
		margin-top: 38px;
	}
	.tab-content {
		margin-top: 2em;
	}
	hr.images {
		margin-top: 25px;
		margin-bottom: 30px;
		border-top: 1px solid #b3b3b3;
		width: 60%;
	}
	@media (min-width: 768px) {
		.col-sm-5 {
			width: 46%;
		}
		.col-sm-1 {
			width: 4%;
		}
	}
	.newImage {
		text-align: center;
	}
	.active .fa {
		margin-right: 0;
	}
	.deletePart {
		opacity: 0.3;
		cursor: pointer;
	}
	.deletePart:hover {
		opacity: 1;
	}
	.fa-normal {
		margin-right: 0;
	}
</style>

@stop

@section('content')

<script type="text/javascript">
	$('.listBtn').removeClass('active');
	$('#li-edit').addClass('active');
</script>
<div class="container">
	<div class="title"><h2>Edit Extension: Language and Culture for lesson {{ \App\Lesson::where('id', '=', $lessonId)->first()->lessonNo }}</h2></div>
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

			<div id="update{{ $element->id }}" class="tab-pane fade in">
				<input type="hidden" class="extInfo" name="update[{{ $element->id }}][type]" value="{{ $element->type }}">
				<input type="hidden" name="prefix" value="update[{{ $element->id }}]" disabled="" readonly="readonly">
				<input type="hidden" name="imgNo" value="{{ count($imgNo) }}" readonly="">

				<div class="row">
					<div class="col-sm-12 form-group">
						<label for="updateimages{{ $element->id }}-title">Title:</label>
						<input id="updateimages{{ $element->id }}-title" name="update[{{ $element->id }}][title]" type="text" class="form-control" placeholder="Enter title for this colection of images" value="{{ $element->title }}" required="">
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
							<input id="update-image-{{ $element->id }}-{{ $j }}-caption" name="update[{{ $element->id }}][caption][]" type="text" class="form-control" placeholder="Enter caption" value="{{ $captions[$j] }}" required>
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

			<div id="update{{ $element->id }}" class="tab-pane fade in">
				<input type="hidden" class="extInfo" name="update[{{ $element->id }}][type]" value="{{ $element->type }}">
				<input type="hidden" name="prefix" value="update[{{ $element->id }}]" readonly="">
				<input type="hidden" name="imgNo" value="{{ count($imgNo) }}" readonly="">

				<div class="row">
					<div class="col-sm-12 form-group">
						<label for="updatesong{{ $element->id }}-title">Title:</label>
						<input id="updatesong{{ $element->id }}-title" name="update[{{ $element->id }}][title]" type="text" class="form-control" placeholder="Enter title for this song" value="{{ $element->title }}" required="">
					</div>
				</div>
				<hr class="images">
				<div class="row masterHolder">
					<div class="row">
						<div class="col-sm-6 form-group">
							<label for="update-song-{{ $element->id }}-composer">Composer:</label>
							<input id="update-song-{{ $element->id }}-composer" name="update[{{ $element->id }}][composer]" type="text" class="form-control" placeholder="Enter the name of the composer" value="{{ $element->song_composer }}" required="">
						</div>
						<div class="col-sm-6 form-group">
							<label for="update-song-{{ $element->id }}-performer">Performer:</label>
							<input id="update-song-{{ $element->id }}-performer" name="update[{{ $element->id }}][performer]" type="text" class="form-control" placeholder="Enter the namne of the performer" value="{{ $element->song_performer }}" required="">
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
							<textarea id="update-song-{{ $element->id }}-content" name="update[{{ $element->id }}][content]" rows="10" class="form-control song-lyrics" placeholder="Enter lyrics of the song" required="">{{ str_replace('|', '&#013;&#010;', $element->content) }}</textarea>
						</div>
					</div>
				</div>
			</div>

			@elseif ($element->type == 2)

			<div id="update{{ $element->id }}" class="tab-pane fade in">
				<input type="hidden" class="extInfo" name="update[{{ $element->id }}][type]" value="{{ $element->type }}">
				<input type="hidden" name="prefix" value="update[{{ $element->id }}]" readonly="">
				<input type="hidden" name="imgNo" value="{{ count($imgNo) }}" readonly="">

				<div class="row">
					<div class="col-sm-12 form-group">
						<label for="updatepoem{{ $element->id }}-title">Title:</label>
						<input id="updatepoem{{ $element->id }}-title" name="update[{{ $element->id }}][title]" type="text" class="form-control" placeholder="Enter title for this poem" value="{{ $element->title }}" required="">
					</div>
				</div>
				<hr class="images">
				<div class="row masterHolder">
					<div class="col-sm-12 form-group">
						<label for="updatepoem{{ $element->id }}-content">Content:</label>
						<textarea id="updatepoem{{ $element->id }}-content" name="update[{{ $element->id }}][content]" type="text" rows="8" class="form-control poem-content" placeholder="Enter content of the poem" required="">{{ str_replace('|', '&#013;&#010;', $element->content) }}</textarea>
					</div>
				</div>
			</div>

			@elseif ($element->type == 3)

			<div id="update{{ $element->id }}" class="tab-pane fade in">
				<input type="hidden" class="extInfo" name="update[{{ $element->id }}][type]" value="{{ $element->type }}">
				<input type="hidden" name="prefix" value="update[{{ $element->id }}]" readonly="">
				<input type="hidden" name="imgNo" value="{{ count($imgNo) }}" readonly="">

				<div class="row">
					<div class="col-sm-12 form-group">
						<label for="updateidiom{{ $element->id }}-content">Idioms – Proverbs – Folk-song:</label>
						<textarea id="updateidiom{{ $element->id }}-content" name="update[{{ $element->id }}][content]" type="text" class="form-control idiom-content" placeholder="Enter an idiom, a proverb or a folk song" required="">{{ $element->content }}</textarea>
					</div>
				</div>
			</div>

			@elseif ($element->type == 4)

			<div id="update{{ $element->id }}" class="tab-pane fade in">
				<input type="hidden" class="extInfo" name="update[{{ $element->id }}][type]" value="{{ $element->type }}">
				<input type="hidden" name="prefix" value="update[{{ $element->id }}]" readonly="">
				<input type="hidden" name="imgNo" value="{{ count($imgNo) }}" readonly="">

				<div class="row">
					<div class="col-sm-12 form-group">
						<label for="updateriddle{{ $element->id }}-title">Title:</label>
						<input id="updateriddle{{ $element->id }}-title" name="update[{{ $element->id }}][title]" type="text" class="form-control" placeholder="Enter title for this riddle" value="{{ $element->title }}" required="">
					</div>
				</div>
				<hr class="images">
				<div class="row masterHolder">
					<div class="row">
						<div class="col-sm-6 form-group">
							<label for="update-riddle-{{ $element->id }}-answer">Answer:</label>
							<input id="update-riddle-{{ $element->id }}-answer" name="update[{{ $element->id }}][answer]" type="text" class="form-control">
						</div>
						<div class="col-sm-6 form-group">
							<label for="update-riddle-{{ $element->id }}-thumbnail">Upload illustration:</label>
							<input id="update-riddle-{{ $element->id }}-thumbnail" name="update[{{ $element->id }}][thumbnail]" type="file" class="file" data-show-upload="false" data-show-caption="true" data-allowed-file-extensions='["jpg","png"]'>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 form-group">
							<label for="updateriddle{{ $element->id }}-content">Riddle:</label>
							<textarea id="updateriddle{{ $element->id }}-content" name="update[{{ $element->id }}][content]" type="text" class="form-control riddle-content" rows="8" placeholder="Enter content of the riddle" required="">{{ str_replace('|', '&#013;&#010;', $element->content) }}</textarea>
						</div>
					</div>
				</div>
			</div>

			@elseif ($element->type == 5)

			<div id="update{{ $element->id }}" class="tab-pane fade in">
				<input type="hidden" class="extInfo" name="update[{{ $element->id }}][type]" value="{{ $element->type }}">
				<input type="hidden" name="prefix" value="update[{{ $element->id }}]" readonly="">
				<input type="hidden" name="imgNo" value="{{ count($imgNo) }}" readonly="">

				<div class="row">
					<div class="col-sm-12 form-group">
						<label for="updateplay{{ $element->id }}-title">Title:</label>
						<input id="updateplay{{ $element->id }}-title" name="update[{{ $element->id }}][title]" type="text" class="form-control" placeholder="Enter title for this game" value="{{ $element->title }}" required="">
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
							<textarea id="updateplay{{ $element->id }}-content" name="update[{{ $element->id }}][content]" type="text" class="form-control play-content" rows="8" placeholder="Enter content of the game" required="">{{ str_replace('|', '&#013;&#010;', $element->content) }}</textarea>
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
		$('.tab-pane').eq(0).addClass('active');
	}

	var toAdd = '';
	var imgNo = <?php echo json_encode($imgNo); ?>;
	var insertId = 0;

	/**
	 * @param  {DOM Object}
	 * @return {void}
	 */
	 function newImage(trigger) {
	 	var tabContent = $(trigger).closest('.tab-pane');
	 	var holder = tabContent.find('.masterHolder');
	 	var imgCnt = holder.children().length;

	 	var imageHolder = document.createElement('div');
	 	imageHolder.className = 'row imageHolder';

	 	var col1 = document.createElement('div');
	 	col1.className = 'col-sm-1';

	 	var label = document.createElement('label');
	 	label.className = 'imgNo';
	 	label.innerHTML = imgCnt + 1 +'.';
	 	col1.appendChild(label);
	 	imageHolder.appendChild(col1);

	 	var col5 = document.createElement('div');
	 	col5.className = 'col-sm-5 form-group';

	 	label = document.createElement('label');
	 	label.for = 'insert-image-' + insertId + '-caption';
	 	label.innerHTML = 'Image caption:';
	 	col5.appendChild(label);

	 	var input = document.createElement('input');
	 	input.id = 'insert-image-' + insertId + '-caption';
	 	input.type = 'text';
	 	input.className = 'form-control';
	 	input.name = tabContent.find('input[name="prefix"]')[0].value + '[caption][]';
	 	input.setAttribute('required', '');
	 	col5.appendChild(input);
	 	imageHolder.appendChild(col5);

	 	col5 = document.createElement('div');
	 	col5.className = 'col-sm-5 form-group';

	 	label = document.createElement('label');
	 	label.for = 'insert-image-' + insertId + 'image';
	 	label.innerHTML = 'Upload image:';
	 	col5.appendChild(label);

	 	input = document.createElement('input');
	 	input.id = 'insert-image-' + insertId + '-image';
	 	input.type = 'file';
	 	input.className = 'file';
	 	input.name = tabContent.find('input[name="prefix"]')[0].value + '[image][' + tabContent.find('.imageHolder').length + ']';
	 	input.setAttribute('data-show-upload', 'false');
	 	input.setAttribute('data-show-caption', 'true');
	 	input.setAttribute('data-allowed-file-extensions', '["jpg","png"]');
	 	input.setAttribute('required', '');
	 	col5.appendChild(input);
	 	imageHolder.appendChild(col5);

	 	col1 = document.createElement('div');
	 	col1.className = 'col-sm-1';

	 	var deleteDialog = document.createElement('div');
	 	deleteDialog.className = 'deleteImage';

	 	var button = document.createElement('button');
	 	button.className = 'horizontal close';
	 	button.type = 'button';

	 	var i = document.createElement('i');
	 	i.className = 'fa fa-trash fa-1x';
	 	button.appendChild(i);

	 	$(button).click(function() {
	 		deleteImage($(this).closest('div.row'));
	 	});

	 	deleteDialog.appendChild(button);
	 	col1.appendChild(deleteDialog);
	 	imageHolder.appendChild(col1);

	 	holder[0].appendChild(imageHolder);

	 	var $input = $('input.file[type=file]');
	 	if ($input.length) {
	 		$input.fileinput();
	 	}

	 	insertId++;
	 }

	/**
	 * Delete an image from slideshow
	 * 
	 * @param  {DOM Object}
	 * @return {void}
	 */
	 function deleteImage(row) {
	 	var parent = $(row).parent();
	 	row.remove();

	 	// var totoalImg = imgNo[parseInt(row.closest('.tab-content').find('input[name="imgNo"]')[0].value)];
	 	var imgCnt = 1;
	 	console.log(row.closest('.tab-pane'));
	 	var prefix = parent.closest('.tab-pane').find('input[name="prefix"]')[0].value;
	 	parent.find('.imageHolder').each(function() {
	 		$(this).find('label.imgNo').html(imgCnt + '.');
	 		$(this).find('input[type="file"]').attr('name', prefix + '[image][' + imgCnt-1 + ']');
	 		imgCnt++
	 	});
	 }

	 /**
	  * Add new tab pane for inputting Images content
	  *
	  * @return {void}
	  */
	  function addImagesPart() {
	  	var tabPane = document.createElement('div');
	  	tabPane.id = 'insert' + insertId;
	  	tabPane.className = 'tab-pane fade in active';

	  	var inputType = document.createElement('input');
	  	inputType.className = 'extInfo';
	  	inputType.setAttribute('type', 'hidden');
	  	inputType.setAttribute('name', 'insert[' + insertId + '][type]');
	  	inputType.setAttribute('value', '0');
	  	tabPane.appendChild(inputType);

	  	inputType = document.createElement('input');
	  	inputType.setAttribute('type', 'hidden');
	  	inputType.setAttribute('name', 'prefix');
	  	inputType.setAttribute('value', 'insert[' + insertId + ']');
	  	tabPane.appendChild(inputType);

	  	var rowBig = document.createElement('div');
	  	rowBig.className = 'row';

	  	var col12 = document.createElement('div');
	  	col12.className = 'col-sm-12 form-group';

	  	var label = document.createElement('label');
	  	label.for = 'insert-images-' + insertId + '-title';
	  	label.innerHTML = 'Title:';
	  	col12.appendChild(label);

	  	var input = document.createElement('input');
	  	input.id = 'insert-images-' + insertId + '-title';
	  	input.type = 'text';
	  	input.className = 'form-control';
	  	input.name = 'insert[' + insertId + '][title]';
	  	input.setAttribute('required', '');
	  	input.setAttribute('placeholder', 'Enter title for this colection of images');
	  	col12.appendChild(input);
	  	rowBig.appendChild(col12);

	  	tabPane.appendChild(rowBig);

	  	var hr = document.createElement('hr');
	  	hr.className = 'images';
	  	tabPane.appendChild(hr);

	  	var masterHolder = document.createElement('div');
	  	masterHolder.className = 'row masterHolder';

	  	var imageHolder = document.createElement('div');
	  	imageHolder.className = 'row imageHolder';

	  	var col1 = document.createElement('div');
	  	col1.className = 'col-sm-1 form-group';
	  	col1.innerHTML = '<label class="imgNo">1.</label>';
	  	imageHolder.appendChild(col1);

	  	var col5 = document.createElement('div');
	  	col5.className = 'col-sm-5 form-group';

	  	label = document.createElement('label');
	  	label.for = 'insert-images-' + insertId + '-0-caption';
	  	label.innerHTML = 'Image caption:';
	  	col5.appendChild(label);

	  	input = document.createElement('input');
	  	input.id = 'insert-images-' + insertId + '-0-caption';
	  	input.type = 'text';
	  	input.className = 'form-control';
	  	input.name = 'insert[' + insertId + '][caption][]';
	  	col5.appendChild(input);
	  	imageHolder.appendChild(col5);

	  	col5 = document.createElement('div');
	  	col5.className = 'col-sm-5 form-group';

	  	label = document.createElement('label');
	  	label.for = 'insert-images-' + insertId + '-thumbnail';
	  	label.innerHTML = 'Upload image:';
	  	col5.appendChild(label);

	  	input = document.createElement('input');
	  	input.id = 'insert-images-' + insertId + '-thumbnail';
	  	input.type = 'file';
	  	input.className = 'file';
	  	input.name = 'insert[' + insertId + '][thumbnail]';
	  	input.setAttribute('required', '');
	  	input.setAttribute('data-show-upload', 'false');
	  	input.setAttribute('data-show-caption', 'true');
	  	input.setAttribute('data-allowed-file-extensions', '["jpg","png"]');
	  	col5.appendChild(input);
	  	imageHolder.appendChild(col5);

	  	col1 = document.createElement('div');
	  	col1.className = 'col-sm-1';

	  	var deleteImageDiv = document.createElement('div');
	  	deleteImageDiv.className = 'deleteImage';

	  	var button = document.createElement('button');
	  	button.type = 'button';
	  	button.className = 'horizontal close';
	  	button.innerHTML = '<i class="fa fa-trash fa-1x"></i>';
	  	deleteImageDiv.appendChild(button);

	  	$(deleteImageDiv).click(function() {
	  		deleteImage($(this).closest('div.row'));
	  	});

	  	col1.appendChild(deleteImageDiv);
	  	imageHolder.appendChild(col1);

	  	masterHolder.appendChild(imageHolder);
	  	tabPane.appendChild(masterHolder);

	  	var newImageDiv = document.createElement('div');
	  	newImageDiv.className = 'row newImage';

	  	var newImageBtn = document.createElement('div');
	  	newImageBtn.className = 'btn btn-primary newImageBtn';
	  	newImageBtn.type = 'button';
	  	newImageBtn.innerHTML = '<i class="fa fa-plus"></i> <span class="newImageBtnText">Add new sentence</span>';
	  	newImageDiv.appendChild(newImageBtn);

	  	$(newImageBtn).click(function() {
	  		newImage(this);
	  	});

	  	tabPane.appendChild(newImageDiv);

	  	$('.tab-pane').removeClass('active');
	  	$('.nav-tabs li').removeClass('active');

	  	document.getElementsByClassName('tab-content')[0].appendChild(tabPane);
	  	addTabBtn('insert' + insertId, 'Images');

	  	var $input = $('input.file[type=file]');
	  	if ($input.length) {
	  		$input.fileinput();
	  	}

	  	insertId++;
	  }

	 /**
	  * Add new tab pane for inputting Song content
	  *
	  * @return {void}
	  */
	  function addSongPart() {
	  	var tabPane = document.createElement('div');
	  	tabPane.id = 'insert' + insertId;
	  	tabPane.className = 'tab-pane fade in active';

	  	var inputType = document.createElement('input');
	  	inputType.className = 'extInfo';
	  	inputType.setAttribute('type', 'hidden');
	  	inputType.setAttribute('name', 'insert[' + insertId + '][type]');
	  	inputType.setAttribute('value', '1');
	  	tabPane.appendChild(inputType);

	  	inputType = document.createElement('input');
	  	inputType.setAttribute('type', 'hidden');
	  	inputType.setAttribute('name', 'prefix');
	  	inputType.setAttribute('value', 'insert[' + insertId + ']');
	  	tabPane.appendChild(inputType);

	  	var rowBig = document.createElement('div');
	  	rowBig.className = 'row';

	  	var col12 = document.createElement('div');
	  	col12.className = 'col-sm-12 form-group';

	  	var label = document.createElement('label');
	  	label.for = 'insert-song-' + insertId + '-title';
	  	label.innerHTML = 'Title:';
	  	col12.appendChild(label);

	  	var input = document.createElement('input');
	  	input.id = 'insert-song-' + insertId + '-title';
	  	input.type = 'text';
	  	input.className = 'form-control';
	  	input.name = 'insert[' + insertId + '][title]';
	  	input.setAttribute('required', '');
	  	input.setAttribute('placeholder', 'Enter title for this song');
	  	col12.appendChild(input);
	  	rowBig.appendChild(col12);

	  	tabPane.appendChild(rowBig);

	  	var hr = document.createElement('hr');
	  	hr.className = 'images';
	  	tabPane.appendChild(hr);

	  	var masterHolder = document.createElement('div');
	  	masterHolder.className = 'row masterHolder';

	  	var row = document.createElement('div');
	  	row.className = 'row';

	  	var col6 = document.createElement('div');
	  	col6.className = 'col-sm-6 form-group';

	  	label = document.createElement('label');
	  	label.for = 'insert-song-' + insertId + '-composer';
	  	label.innerHTML = 'Composer:';
	  	col6.appendChild(label);

	  	input = document.createElement('input');
	  	input.id = 'insert-song-' + insertId + '-composer';
	  	input.type = 'text';
	  	input.className = 'form-control';
	  	input.name = 'insert[' + insertId + '][composer]';
	  	col6.appendChild(input);
	  	row.appendChild(col6);

	  	col6 = document.createElement('div');
	  	col6.className = 'col-sm-6 form-group';

	  	label = document.createElement('label');
	  	label.for = 'insert-riddle-' + insertId + '-performer';
	  	label.innerHTML = 'Performer:';
	  	col6.appendChild(label);

	  	input = document.createElement('input');
	  	input.id = 'insert-song-' + insertId + '-performer';
	  	input.type = 'text';
	  	input.className = 'form-control';
	  	input.name = 'insert[' + insertId + '][performer]';
	  	col6.appendChild(input);
	  	row.appendChild(col6);
	  	masterHolder.appendChild(row);

	  	row = document.createElement('div');
	  	row.className = 'row';

	  	col6 = document.createElement('div');
	  	col6.className = 'col-sm-6 form-group';

	  	label = document.createElement('label');
	  	label.for = 'insert-song-' + insertId + '-thumbnail';
	  	label.innerHTML = 'Upload sheet music:';
	  	col6.appendChild(label);

	  	input = document.createElement('input');
	  	input.id = 'insert-song-' + insertId + '-thumbnail';
	  	input.type = 'file';
	  	input.className = 'file';
	  	input.name = 'insert[' + insertId + '][thumbnail]';
	  	input.setAttribute('required', '');
	  	input.setAttribute('data-show-upload', 'false');
	  	input.setAttribute('data-show-caption', 'true');
	  	input.setAttribute('data-allowed-file-extensions', '["jpg","png"]');
	  	col6.appendChild(input);
	  	row.appendChild(col6);

	  	col6 = document.createElement('div');
	  	col6.className = 'col-sm-6 form-group';

	  	label = document.createElement('label');
	  	label.for = 'insert-song-' + insertId + '-song';
	  	label.innerHTML = 'Upload song:';
	  	col6.appendChild(label);

	  	input = document.createElement('input');
	  	input.id = 'insert-song-' + insertId + '-song';
	  	input.type = 'file';
	  	input.className = 'file';
	  	input.name = 'insert[' + insertId + '][song]';
	  	input.setAttribute('required', '');
	  	input.setAttribute('data-show-upload', 'false');
	  	input.setAttribute('data-show-caption', 'true');
	  	input.setAttribute('data-allowed-file-extensions', '["mp3"]');
	  	col6.appendChild(input);
	  	row.appendChild(col6);
	  	masterHolder.appendChild(row);

	  	row = document.createElement('div');
	  	row.className = 'row';

	  	col12 = document.createElement('div');
	  	col12.className = 'col-sm-12 form-group';

	  	label = document.createElement('label');
	  	label.for = 'insert-song-' + insertId + '-content';
	  	label.innerHTML = 'Lyrics:';
	  	col12.appendChild(label);

	  	var textarea = document.createElement('textarea');
	  	textarea.id = 'insert-song-' + insertId + '-content';
	  	textarea.type = 'text';
	  	textarea.className = 'form-control song-lyrics';
	  	textarea.name = 'insert[' + insertId + '][content]';
	  	textarea.setAttribute('rows', '10');
	  	textarea.setAttribute('required', '');
	  	textarea.setAttribute('placeholder', 'Enter lyrics of the song');
	  	col12.appendChild(textarea);
	  	row.appendChild(col12);
	  	masterHolder.appendChild(row);

	  	tabPane.appendChild(masterHolder);

	  	$('.tab-pane').removeClass('active');
	  	$('.nav-tabs li').removeClass('active');

	  	document.getElementsByClassName('tab-content')[0].appendChild(tabPane);
	  	addTabBtn('insert' + insertId, 'Song');

	  	var $input = $('input.file[type=file]');
	  	if ($input.length) {
	  		$input.fileinput();
	  	}

	  	insertId++;
	  }

	 /**
	  * Add new tab pane for inputting Poem content
	  *
	  * @return {void}
	  */
	  function addPoemPart() {
	  	var tabPane = document.createElement('div');
	  	tabPane.id = 'insert' + insertId;
	  	tabPane.className = 'tab-pane fade in active';

	  	var inputType = document.createElement('input');
	  	inputType.className = 'extInfo';
	  	inputType.setAttribute('type', 'hidden');
	  	inputType.setAttribute('name', 'insert[' + insertId + '][type]');
	  	inputType.setAttribute('value', '2');
	  	tabPane.appendChild(inputType);

	  	inputType = document.createElement('input');
	  	inputType.setAttribute('type', 'hidden');
	  	inputType.setAttribute('name', 'prefix');
	  	inputType.setAttribute('value', 'insert[' + insertId + ']');
	  	tabPane.appendChild(inputType);

	  	var rowBig = document.createElement('div');
	  	rowBig.className = 'row';

	  	var col12 = document.createElement('div');
	  	col12.className = 'col-sm-12 form-group';

	  	var label = document.createElement('label');
	  	label.for = 'insert-poem-' + insertId + '-title';
	  	label.innerHTML = 'Title:';
	  	col12.appendChild(label);

	  	var input = document.createElement('input');
	  	input.id = 'insert-poem-' + insertId + '-title';
	  	input.type = 'text';
	  	input.className = 'form-control';
	  	input.name = 'insert[' + insertId + '][title]';
	  	input.setAttribute('required', '');
	  	input.setAttribute('placeholder', 'Enter title for this poem');
	  	col12.appendChild(input);
	  	rowBig.appendChild(col12);

	  	tabPane.appendChild(rowBig);

	  	var hr = document.createElement('hr');
	  	hr.className = 'images';
	  	tabPane.appendChild(hr);

	  	var masterHolder = document.createElement('div');
	  	masterHolder.className = 'row masterHolder';

	  	col12 = document.createElement('div');
	  	col12.className = 'col-sm-12 form-group';

	  	label = document.createElement('label');
	  	label.for = 'insert-poem-' + insertId + '-thumbnail';
	  	label.innerHTML = 'Content:';
	  	col12.appendChild(label);

	  	var textarea = document.createElement('textarea');
	  	textarea.id = 'insert-poem-' + insertId + '-content';
	  	textarea.type = 'text';
	  	textarea.className = 'form-control poem-content';
	  	textarea.name = 'insert[' + insertId + '][content]';
	  	textarea.setAttribute('required', '');
	  	textarea.setAttribute('rows', '8');
	  	textarea.setAttribute('placeholder', 'Enter content of the poem');
	  	col12.appendChild(textarea);
	  	masterHolder.appendChild(col12);

	  	tabPane.appendChild(masterHolder);

	  	$('.tab-pane').removeClass('active');
	  	$('.nav-tabs li').removeClass('active');

	  	document.getElementsByClassName('tab-content')[0].appendChild(tabPane);
	  	addTabBtn('insert' + insertId, 'Poem');

	  	insertId++;
	  }

	 /**
	  * Add new tab pane for inputting Idiom - proverb - folk song content
	  *
	  * @return {void}
	  */
	  function addIdiomPart() {
	  	var tabPane = document.createElement('div');
	  	tabPane.id = 'insert' + insertId;
	  	tabPane.className = 'tab-pane fade in active';

	  	var inputType = document.createElement('input');
	  	inputType.className = 'extInfo';
	  	inputType.setAttribute('type', 'hidden');
	  	inputType.setAttribute('name', 'insert[' + insertId + '][type]');
	  	inputType.setAttribute('value', '3');
	  	tabPane.appendChild(inputType);

	  	inputType = document.createElement('input');
	  	inputType.setAttribute('type', 'hidden');
	  	inputType.setAttribute('name', 'prefix');
	  	inputType.setAttribute('value', 'insert[' + insertId + ']');
	  	tabPane.appendChild(inputType);

	  	var rowBig = document.createElement('div');
	  	rowBig.className = 'row';

	  	var col12 = document.createElement('div');
	  	col12.className = 'col-sm-12 form-group';

	  	var label = document.createElement('label');
	  	label.for = 'insert-idiom-' + insertId + '-content';
	  	label.innerHTML = 'Idioms – Proverbs – Folk-song:';
	  	col12.appendChild(label);

	  	var textarea = document.createElement('textarea');
	  	textarea.id = 'insert-idiom-' + insertId + '-content';
	  	textarea.type = 'text';
	  	textarea.className = 'form-control idiom-content';
	  	textarea.name = 'insert[' + insertId + '][content]';
	  	textarea.setAttribute('required', '');
	  	textarea.setAttribute('placeholder', 'Enter an idiom, a proverb or a folk song');
	  	col12.appendChild(textarea);
	  	rowBig.appendChild(col12);

	  	tabPane.appendChild(rowBig);

	  	$('.tab-pane').removeClass('active');
	  	$('.nav-tabs li').removeClass('active');

	  	document.getElementsByClassName('tab-content')[0].appendChild(tabPane);
	  	addTabBtn('insert' + insertId, 'Idiom');

	  	insertId++;
	  }

	 /**
	  * Add new tab pane for inputting Riddle content
	  *
	  * @return {void}
	  */
	  function addRiddlePart() {
	  	var tabPane = document.createElement('div');
	  	tabPane.id = 'insert' + insertId;
	  	tabPane.className = 'tab-pane fade in active';

	  	var inputType = document.createElement('input');
	  	inputType.setAttribute('type', 'hidden');
	  	inputType.setAttribute('name', 'insert[' + insertId + '][type]');
	  	inputType.setAttribute('value', '4');
	  	tabPane.appendChild(inputType);

	  	inputType = document.createElement('input');
	  	inputType.setAttribute('type', 'hidden');
	  	inputType.setAttribute('name', 'prefix');
	  	inputType.setAttribute('value', 'insert[' + insertId + ']');
	  	tabPane.appendChild(inputType);

	  	var rowBig = document.createElement('div');
	  	rowBig.className = 'row';

	  	var col12 = document.createElement('div');
	  	col12.className = 'col-sm-12 form-group';

	  	var label = document.createElement('label');
	  	label.for = 'insert-riddle-' + insertId + '-title';
	  	label.innerHTML = 'Title:';
	  	col12.appendChild(label);

	  	var input = document.createElement('input');
	  	input.id = 'insert-riddle-' + insertId + '-title';
	  	input.type = 'text';
	  	input.className = 'form-control';
	  	input.name = 'insert[' + insertId + '][title]';
	  	input.setAttribute('required', '');
	  	input.setAttribute('placeholder', 'Enter title for this riddle');
	  	col12.appendChild(input);
	  	rowBig.appendChild(col12);

	  	tabPane.appendChild(rowBig);

	  	var hr = document.createElement('hr');
	  	hr.className = 'images';
	  	tabPane.appendChild(hr);

	  	var masterHolder = document.createElement('div');
	  	masterHolder.className = 'row masterHolder';

	  	var row = document.createElement('div');
	  	row.className = 'row';

	  	var col6 = document.createElement('div');
	  	col6.className = 'col-sm-6 form-group';

	  	label = document.createElement('label');
	  	label.for = 'insert-riddle-' + insertId + '-answer';
	  	label.innerHTML = 'Answer:';
	  	col6.appendChild(label);

	  	input = document.createElement('input');
	  	input.id = 'insert-riddle-' + insertId + '-answer';
	  	input.type = 'text';
	  	input.className = 'form-control';
	  	input.name = 'insert[' + insertId + '][answer]';
	  	col6.appendChild(input);
	  	row.appendChild(col6);

	  	col6 = document.createElement('div');
	  	col6.className = 'col-sm-6 form-group';

	  	label = document.createElement('label');
	  	label.for = 'insert-riddle-' + insertId + '-thumbnail';
	  	label.innerHTML = 'Upload illustration:';
	  	col6.appendChild(label);

	  	input = document.createElement('input');
	  	input.id = 'insert-riddle-' + insertId + '-thumbnail';
	  	input.type = 'file';
	  	input.className = 'file';
	  	input.name = 'insert[' + insertId + '][thumbnail]';
	  	input.setAttribute('required', '');
	  	input.setAttribute('data-show-upload', 'false');
	  	input.setAttribute('data-show-caption', 'true');
	  	input.setAttribute('data-allowed-file-extensions', '["jpg","png"]');
	  	col6.appendChild(input);
	  	row.appendChild(col6);
	  	masterHolder.appendChild(row);

	  	row = document.createElement('div');
	  	row.className = 'row';

	  	col12 = document.createElement('div');
	  	col12.className = 'col-sm-12 form-group';

	  	label = document.createElement('label');
	  	label.for = 'insert-riddle-' + insertId + '-content';
	  	label.innerHTML = 'Content:';
	  	col12.appendChild(label);

	  	var textarea = document.createElement('textarea');
	  	textarea.id = 'insert-riddle-' + insertId + '-content';
	  	textarea.type = 'text';
	  	textarea.className = 'form-control riddle-content';
	  	textarea.name = 'insert[' + insertId + '][content]';
	  	textarea.setAttribute('rows', '8');
	  	textarea.setAttribute('required', '');
	  	textarea.setAttribute('placeholder', 'Enter content of the riddle');
	  	col12.appendChild(textarea);
	  	row.appendChild(col12);
	  	masterHolder.appendChild(row);

	  	tabPane.appendChild(masterHolder);

	  	$('.tab-pane').removeClass('active');
	  	$('.nav-tabs li').removeClass('active');

	  	document.getElementsByClassName('tab-content')[0].appendChild(tabPane);
	  	addTabBtn('insert' + insertId, 'Riddle');

	  	var $input = $('input.file[type=file]');
	  	if ($input.length) {
	  		$input.fileinput();
	  	}

	  	insertId++;
	  }

	 /**
	  * Add new tab pane for inputting Game content
	  *
	  * @return {void}
	  */
	  function addPlayPart() {
	  	var tabPane = document.createElement('div');
	  	tabPane.id = 'insert' + insertId;
	  	tabPane.className = 'tab-pane fade in active';

	  	var inputType = document.createElement('input');
	  	inputType.className = 'extInfo';
	  	inputType.setAttribute('type', 'hidden');
	  	inputType.setAttribute('name', 'insert[' + insertId + '][type]');
	  	inputType.setAttribute('value', '5');
	  	tabPane.appendChild(inputType);

	  	inputType = document.createElement('input');
	  	inputType.setAttribute('type', 'hidden');
	  	inputType.setAttribute('name', 'prefix');
	  	inputType.setAttribute('value', 'insert[' + insertId + ']');
	  	tabPane.appendChild(inputType);

	  	var rowBig = document.createElement('div');
	  	rowBig.className = 'row';

	  	var col12 = document.createElement('div');
	  	col12.className = 'col-sm-12 form-group';

	  	var label = document.createElement('label');
	  	label.for = 'insert-play-' + insertId + '-title';
	  	label.innerHTML = 'Title:';
	  	col12.appendChild(label);

	  	var input = document.createElement('input');
	  	input.id = 'insert-play-' + insertId + '-title';
	  	input.type = 'text';
	  	input.className = 'form-control';
	  	input.name = 'insert[' + insertId + '][title]';
	  	input.setAttribute('required', '');
	  	input.setAttribute('placeholder', 'Enter title for this game');
	  	col12.appendChild(input);
	  	rowBig.appendChild(col12);

	  	tabPane.appendChild(rowBig);

	  	var hr = document.createElement('hr');
	  	hr.className = 'images';
	  	tabPane.appendChild(hr);

	  	var masterHolder = document.createElement('div');
	  	masterHolder.className = 'row masterHolder';

	  	var row = document.createElement('div');
	  	row.className = 'row';

	  	col12 = document.createElement('div');
	  	col12.className = 'col-sm-12 form-group';

	  	label = document.createElement('label');
	  	label.for = 'insert-play-' + insertId + '-thumbnail';
	  	label.innerHTML = 'Upload illustration:';
	  	col12.appendChild(label);

	  	input = document.createElement('input');
	  	input.id = 'insert-play-' + insertId + '-thumbnail';
	  	input.type = 'file';
	  	input.className = 'file';
	  	input.name = 'insert[' + insertId + '][thumbnail]';
	  	input.setAttribute('required', '');
	  	input.setAttribute('data-show-upload', 'false');
	  	input.setAttribute('data-show-caption', 'true');
	  	input.setAttribute('data-allowed-file-extensions', '["jpg","png"]');
	  	col12.appendChild(input);
	  	row.appendChild(col12);
	  	masterHolder.appendChild(row);

	  	tabPane.appendChild(row);

	  	row = document.createElement('div');
	  	row.className = 'row';

	  	col12 = document.createElement('div');
	  	col12.className = 'col-sm-12 form-group';

	  	label = document.createElement('label');
	  	label.for = 'insert-play-' + insertId + '-content';
	  	label.innerHTML = 'Content:';
	  	col12.appendChild(label);

	  	var textarea = document.createElement('textarea');
	  	textarea.id = 'insert-play-' + insertId + '-content';
	  	textarea.type = 'text';
	  	textarea.className = 'form-control play-content';
	  	textarea.name = 'insert[' + insertId + '][content]';
	  	textarea.setAttribute('rows', '8');
	  	textarea.setAttribute('required', '');
	  	textarea.setAttribute('placeholder', 'Enter content of the game');
	  	col12.appendChild(textarea);
	  	row.appendChild(col12);
	  	masterHolder.appendChild(row);

	  	tabPane.appendChild(row);

	  	$('.tab-pane').removeClass('active');
	  	$('.nav-tabs li').removeClass('active');

	  	document.getElementsByClassName('tab-content')[0].appendChild(tabPane);
	  	addTabBtn('insert' + insertId, 'Game');

	  	var $input = $('input.file[type=file]');
	  	if ($input.length) {
	  		$input.fileinput();
	  	}

	  	insertId++;
	  }

	  /**
	   * Store id of content to be deleted
	   * 
	   * @type {String}
	   */
	   var toDelete = '';

	 /**
	  * Delete chosen tab pane
	  *
	  * @return {void}
	  */
	  function deletePart(button) {
	  	var deleteId = $(button).closest('li').find('a').attr('href');
	  	var deletePaneInfo = $(deleteId).find('.extInfo');
	  	if (deletePaneInfo.length) {
	  		deletePaneInfoDetail = deletePaneInfo.attr('name').split('[');
	  		if(deletePaneInfoDetail[0] == 'update') {
	  			if (toDelete) {
	  				toDelete += ',';
	  			}
	  			toDelete += deletePaneInfoDetail[1].replace(']', '');
	  		}
	  	}

	  	var oldTabNav = $('.nav-tabs li.active');
	  	var oldTabPane = $('.tab-content div.active');

	  	if (oldTabNav[0] == $(button).closest('li')[0]) {
	  		oldTabNav = $(button).closest('li').prev();
	  		var oldTabPaneId = $(button).closest('li').prev().find('a').attr('href');
	  		oldTabPane = $(oldTabPaneId);
	  	}

	  	var nextTabPane = $(button).closest('li').find('a').attr('href');
	  	$(nextTabPane).remove();
	  	$(button).closest('li').remove();

	  	oldTabNav.addClass('active');
	  	oldTabPane.addClass('active in');
	  }

	 /**
	  * Create new tab in tab list for newly created tab pane
	  * 
	  * @param {string}
	  * @param {string}
	  * @return {void}
	  */
	  function addTabBtn(pane_id, type) {
	  	var li = document.createElement('li');
	  	li.className = 'active';
	  	var a = document.createElement('a');
	  	a.setAttribute('data-toggle', 'tab');
	  	a.setAttribute('href', '#' + pane_id);
	  	a.innerHTML = type + ' ';
	  	var i = document.createElement('i');
	  	i.className = 'fa fa-times deletePart';
	  	$(i).click(function() {
	  		deletePart(this);
	  	});
	  	a.appendChild(i);
	  	li.appendChild(a);
	  	$(li).insertBefore($('#addPartBtn'));
	  }

	  /**
	   * Add a new image to the current Images panel
	   */
	  $('.newImageBtn').click(function() {
	  	newImage(this);
	  });

	  /**
	   * Delete a row containing image information from Images pane
	   */
	  $('.deleteImage').click(function() {
	  	deleteImage($(this).closest('div.row'));
	  });

	  /**
	   * Add an "Images" pane
	   */
	  $('.addPart.images').click(function() {
	  	addImagesPart();
	  });

	  /**
	   * Add a "Song" pane
	   */
	  $('.addPart.song').click(function() {
	  	addSongPart();
	  });

	  /**
	   * Add a "Poem" pane
	   */
	  $('.addPart.poem').click(function() {
	  	addPoemPart();
	  });

	  /**
	   * Add a "Idiom" pane
	   */
	  $('.addPart.idiom').click(function() {
	  	addIdiomPart();
	  });

	  /**
	   * Add a "Riddle" pane
	   */
	  $('.addPart.riddle').click(function() {
	  	addRiddlePart();
	  });

	  /**
	   * Add a "Riddle" pane
	   */
	  $('.addPart.play').click(function() {
	  	addPlayPart();
	  });

	  /**
	   * Delete a pane
	   */
	  $('.nav-tabs .deletePart').click(function() {
	  	deletePart(this);
	  });

	  /**
	   * Add a list of id of element to delete to the submiting form
	   */
	  $("#extForm").submit( function(eventObj) {
	  	var extensionNo = 1;
	  	$('.tab-pane').each(function() {
	  		$('<input />').attr('type', 'hidden')
	  		.attr('name', $(this).find('input[name="prefix"]')[0].value + '[extensionNo]')
	  		.attr('value', extensionNo++)
	  		.appendTo('#extForm');
	  	});

	  	if (toDelete) {
	  		$('<input />').attr('type', 'hidden')
	  		.attr('name', 'delete')
	  		.attr('value', toDelete)
	  		.appendTo('#extForm');
	  		return true;
	  	}
	  });

	</script>
	@stop