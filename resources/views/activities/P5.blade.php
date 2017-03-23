 @extends('layout')

 @section('title')
 <h1 style="font-size: 400%" align="center">- Bài 5: Nghe phát âm đoạn thoại và nhắc lại </h1>

 <hr>
 <script type="text/javascript">
 	function playWord(audioPath) {
		var auRecord = document.getElementById("sample");

		auRecord.src = audioPath;
		auRecord.play();
	} 
 </script>
 @stop

 @section('content1')
 <div class="row">
 	<div id="content_id" class="col-sm-9 col-md-6 col-lg-8">
 	<audio id="sample"></audio>
 		@for ($i = 0; $i < count($contentArr) ; $i++)
 		@if ($i%2 == 0)
 		<div class="row">
 			<div class="col-sm-6 col-md-6 col-lg-6" align="right">
 				@for ($j = 0; $j < count($contentArr[$i]) ; $j++)
 				<p align="center" >{{ $contentArr[$i][$j]}}</p>
 				@endfor
 			</div>
 			<div class="col-sm-6 col-md-6 col-lg-6" align="left">
 			<input type="image" class="controlBtn" src="{{ asset('img/icons/sample_play.svg') }}" width="10%" height="10%" onclick="playWord('{{ URL::asset($audioArr[$i]) }}')">
 			</div>
 		</div>
 		<hr>
 		@else
 		<div class="row">
 		<div class="col-sm-6 col-md-6 col-lg-6" align="right">
 			<input type="image" class="controlBtn" src="{{ asset('img/icons/sample_play.svg') }}" width="10%" height="10%" onclick="playWord('{{ URL::asset($audioArr[$i]) }}')">
 			</div>
 			<div class="col-sm-6 col-md-6 col-lg-6" >
 				@for ($j = 0; $j < count($contentArr[$i]) ; $j++)
 				<p align="left" >{{ $contentArr[$i][$j]}}</p>
 				@endfor
 			</div>
 		</div> 
 		<hr>
 		@endif
 		@endfor
 	</div>
 </div>

 <div class="row">
 	<div id="right" class="img_right col-sm-6 col-md-6 col-lg-6" ></div>
 	<div id="wrong" class="img_wrong col-sm-6 col-md-6 col-lg-6" ></div>
 </div>
 @stop