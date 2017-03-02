@extends('layout')

@section('title')
<h1 style="font-size: 300%" align="center">Situations Page</h1>
<style>
	.img {
		height:250px;
	}
	.paragraph p {
		font-weight: 600;
	}
</style>

<hr>

<script language="JavaScript">
	var contentNow = 0;
	var contentArr = <?php echo json_encode($contentArr); ?>;
	var audioArr = <?php echo json_encode($audioArr); ?>;
	function next(){
		
		while (document.getElementById("content_id").firstChild) {
			document.getElementById("content_id").removeChild(document.getElementById("content_id").firstChild);
		}
		if(contentNow < contentArr.length-1){
			contentNow = parseInt(contentNow) + 1;
		}else{
			window.alert("Bạn đã hoàn thành các tình huống rồi");
		}
		for (var i = 0; i < contentArr[contentNow].length; i++) {
			editContent(contentArr[contentNow][i]);
		}
		editAudio(audioArr[contentNow]);
		document.getElementById("audio").load();
	}

	function chooseD(element){
		
		contentNow = element.getAttribute('id');
		while (document.getElementById("content_id").firstChild) {
			document.getElementById("content_id").removeChild(document.getElementById("content_id").firstChild);
		}

		for (var i = 0; i < contentArr[contentNow].length; i++) {
			editContent(contentArr[contentNow][i]);
		}
		editAudio(audioArr[contentNow]);
		document.getElementById("audio").load();
	}

	function editContent(text) {
		var node = document.createElement("div");
		var textnode = document.createTextNode(text);
		node.appendChild(textnode);
		document.getElementById("content_id").appendChild(node);
	}

	function editAudio(path) {
		document.getElementById("audio_id").setAttribute('src', '{{ URL::asset('') }}' + path);
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
			<img class="img" src="Situation_img/hinh.png">
		</div>
		<div>
			<audio id="audio" controls>
			<source id="audio_id" src="{{ URL::asset($audioArr[0]) }}" type="audio/mpeg">
				Your browser does not support the audio element.
			</audio>
		</div>
	</div>
	<div class="col-sm-3 col-sm-pull-4 paragraph" style="text-align: center; height: 100%">
		<div style="margin-top: 40px">
			@for ($i = 0; $i < count($contentArr[0]) ; $i++)
				<p>{{ $contentArr[0][$i]}}</p>
			@endfor	
		</div>
	</div>
</div>

@stop