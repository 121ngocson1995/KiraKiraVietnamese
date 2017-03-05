 @extends('layout')

 @section('title')
 <h1 style="font-size: 400%" align="center">- Bài 5: Nghe phát âm đoạn thoại và nhắc lại </h1>

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
 			window.alert("Bạn đã hoàn thành bài tập rồi");
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
 <div class="btn-group">
 	@for ($i = 1; $i <= $cnt; $i++)
 	<button id="{{$i-1}}" type="button" class="btn btn-primary" onclick="JavaScript: chooseD(this)">D{{$i}}</button>
 	@endfor
 </div>
 <div class="row">
 	<div id="content_id" class="col-sm-9 col-md-6 col-lg-8">
 		@for ($i = 0; $i < count($contentArr[0]) ; $i++)
 		<div>{{ $contentArr[0][$i]}}</div>
 		@endfor
 		<br>
 	</div>
 	<button type="button" class="btn btn-primary" onclick="JavaScript: next()">Next</button>
 	<div class="col-sm-3 col-md-6 col-lg-4"><audio id="audio" controls>
 		<source id="audio_id" src="{{ URL::asset($audioArr[0]) }}" type="audio/mpeg">
 			Your browser does not support the audio element.
 		</audio>
 	</div>
 </div>
 <div class="row">
 	<div id="right" class="img_right col-sm-6 col-md-6 col-lg-6" ></div>
 	<div id="wrong" class="img_wrong col-sm-6 col-md-6 col-lg-6" ></div>
 </div>
 @stop