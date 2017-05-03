var toAdd = '';
var insertId = 0;

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
 	input.className = 'form-control vld-spc';
 	input.name = tabContent.find('input[name="prefix"]')[0].value + '[caption][]';
 	input.setAttribute('required', '');
 	input.setAttribute('maxlength', '200');
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
 	reIndex();
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
 	input.className = 'form-control vld-spc';
 	input.name = 'insert[' + insertId + '][title]';
 	input.setAttribute('required', '');
 	input.setAttribute('maxlength', '200');
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
 	input.className = 'form-control vld-spc';
 	input.setAttribute('maxlength', '200');
 	input.name = 'insert[' + insertId + '][caption][]';
 	col5.appendChild(input);
 	imageHolder.appendChild(col5);

 	col5 = document.createElement('div');
 	col5.className = 'col-sm-5 form-group';

 	label = document.createElement('label');
 	label.for = 'insert-images-' + insertId + '-image';
 	label.innerHTML = 'Upload image:';
 	col5.appendChild(label);

 	input = document.createElement('input');
 	input.id = 'insert-images-' + insertId + '-image';
 	input.type = 'file';
 	input.className = 'file';
 	input.name = 'insert[' + insertId + '][image]';
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
 	reIndex();
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
 	input.className = 'form-control vld-spc';
 	input.name = 'insert[' + insertId + '][title]';
 	input.setAttribute('required', '');
 	input.setAttribute('maxlength', '200');
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
 	input.className = 'form-control vld-spc';
 	input.setAttribute('maxlength', '200');
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
 	input.className = 'form-control vld-spc';
 	input.setAttribute('maxlength', '200');
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
 	textarea.className = 'form-control song-lyrics vld-spc';
 	textarea.name = 'insert[' + insertId + '][content]';
 	textarea.setAttribute('rows', '10');
 	textarea.setAttribute('required', '');
 	textarea.setAttribute('maxlength', '2000');
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
 	reIndex();
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
 	input.className = 'form-control vld-spc';
 	input.name = 'insert[' + insertId + '][title]';
 	input.setAttribute('required', '');
 	input.setAttribute('maxlength', '200');
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
 	textarea.className = 'form-control poem-content vld-spc';
 	textarea.name = 'insert[' + insertId + '][content]';
 	textarea.setAttribute('required', '');
 	textarea.setAttribute('maxlength', '2000');
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
 	reIndex();
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
 	textarea.className = 'form-control idiom-content vld-spc';
 	textarea.name = 'insert[' + insertId + '][content]';
 	textarea.setAttribute('required', '');
 	textarea.setAttribute('maxlength', '2000');
 	textarea.setAttribute('placeholder', 'Enter an idiom, a proverb or a folk song');
 	col12.appendChild(textarea);
 	rowBig.appendChild(col12);

 	tabPane.appendChild(rowBig);

 	$('.tab-pane').removeClass('active');
 	$('.nav-tabs li').removeClass('active');

 	document.getElementsByClassName('tab-content')[0].appendChild(tabPane);
 	addTabBtn('insert' + insertId, 'Idiom');

 	insertId++;
 	reIndex();
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
 	input.className = 'form-control vld-spc';
 	input.name = 'insert[' + insertId + '][title]';
 	input.setAttribute('required', '');
 	input.setAttribute('maxlength', '200');
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
 	input.className = 'form-control vld-spc';
 	input.setAttribute('maxlength', '200');
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
 	textarea.className = 'form-control riddle-content vld-spc';
 	textarea.name = 'insert[' + insertId + '][content]';
 	textarea.setAttribute('rows', '8');
 	textarea.setAttribute('maxlength', '2000');
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
 	
 	reIndex();
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
 	input.className = 'form-control vld-spc';
 	input.name = 'insert[' + insertId + '][title]';
 	input.setAttribute('required', '');
 	input.setAttribute('maxlength', '200');
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
 	textarea.className = 'form-control play-content vld-spc';
 	textarea.name = 'insert[' + insertId + '][content]';
 	textarea.setAttribute('rows', '8');
 	textarea.setAttribute('maxlength', '2000');
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
 	reIndex();
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

 function validate_chgColor() {
 	$('.alert').remove();
 	var fail = false;
 	for (var i = 0; i < $('.vld-spc').length; i++) {
 		if(!validate_spcChar($('.vld-spc')[i]) || !validate_space($('.vld-spc')[i]) ) {
 			$('.vld-spc').eq(i).attr('style', 'border-color: red;');
 			fail = $('.vld-spc')[i];
 		}else{
 			$('.vld-spc').eq(i).attr('style', 'border-color: #dddddd;');
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
 	var pattern = new RegExp(/[~`@#$%\^&*+=\\[\]\\;/{}|\\<>]/);
 	if (pattern.test(text)) {
 		showMesg(textElement, 'Special character is invalid');
 		return false;
 	}else{
 		return true;
 	}
 }

 $('#saveBtn').click(function(e) {
 	var error = false;

 	$('input:invalid').each(function () {
 		focusError(this);
 		error = true;
 		return false;
 	});

 	if (!error) {
 		$('textarea:invalid').each(function () {
 			focusError(this);
 			error = true;
 			return false;
 		});
 	}
 	
 	if (!error) {
 		if ((errorElement = validate_chgColor()) != false) {
 			focusError(errorElement);

 			return false;
 		}
 	}
 });

 function focusError(element) {
 	
 	$(element).closest('.tab-content').find('.tab-pane').removeClass('in active');
 	$(element).closest('.tab-pane').addClass('in active');

 	element.focus();

 	$('ul.nav.nav-tabs').find('li').removeClass('active')
 	$('ul.nav.nav-tabs').find('li').eq($(element).closest('.tab-pane').prevAll().length).addClass('active');
 }

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

 $(document).ready(function () {
 	reIndex();
 });