@extends('layout')

@section('title')
<h1 style="font-size: 300%" align="center">Situations Page</h1>
<style>
	.img {
		height:250px;
		width: inherit;
	}
	.paragraph p {
		font-weight: 600;
	}
</style>

<hr>

<script language="JavaScript">
	var contentNow = 0;
	var dialogArr = <?php echo json_encode($dialogArr); ?>;
	var elementData = <?php echo json_encode($elementData); ?>;

	function chooseD(element){
		
		contentNow = element.getAttribute('id');
		while (document.getElementById("content_id").firstChild) {
			document.getElementById("content_id").removeChild(document.getElementById("content_id").firstChild);
		}

		for (var i = 0; i < dialogArr[contentNow].length; i++) {
			editContent(dialogArr[contentNow][i]);
		}
		editThumbnail(elementData[contentNow].image);
		editAudio(elementData[contentNow].audio);
		document.getElementById("audio").load();
	}

	function editContent(text) {
		var node = document.createElement("p");
		var textnode = document.createTextNode(text);
		node.appendChild(textnode);
		document.getElementById("content_id").appendChild(node);
	}

	function editAudio(path) {
		document.getElementById("audio_id").setAttribute('src', '{{ URL::asset('') }}' + path);
	}

	function editThumbnail(path) {
		document.getElementById("thumbnail").setAttribute('src', '{{ URL::asset('') }}' + path + '?' + new Date().getTime());
	}
</script>
@stop

@section('content1')
<div style="margin: 10px; text-align: center;">
	<div class="btn-group">
		@for ($i = 1; $i <= $cnt; $i++)
		<button id="{{$i-1}}" type="button" class="btn btn-primary" onclick="JavaScript: chooseD(this)">S{{$i}}
		</button>
		@endfor
	</div>
</div >

<div class="row">
	<div class="col-sm-4 col-sm-offset-3 col-sm-push-2 image" style="text-align: center;">
		<div>
			<img id="thumbnail" class="img" src="{{ asset('Situation_img/hinh.png') }}">
		</div>
		<div>
			<audio id="audio" controls>
			<source id="audio_id" src="{{ URL::asset($elementData[0]->audio) }}" type="audio/mpeg">
				Your browser does not support the audio element.
			</audio>
		</div>
	</div>
	<div class="col-sm-3 col-sm-pull-4 paragraph" style="text-align: center; height: 100%">
		<div id="content_id" style="margin-top: 40px">
			@for ($i = 0; $i < count($dialogArr[0]) ; $i++)
				<p>{{ $dialogArr[0][$i]}}</p>
			@endfor	
		</div>
	</div>
</div>

@stop