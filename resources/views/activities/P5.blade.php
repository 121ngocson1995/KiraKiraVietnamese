@extends('activities.layout.activityLayout')

@section('actContent')
 <hr>
 <script type="text/javascript">
 	function playWord(audioPath) {
		var auRecord = document.getElementById("sample");

		auRecord.src = audioPath;
		auRecord.play();
	} 
 </script>
 
 <div class="row">
 	<div id="content_id" class="col-sm-9 col-md-6 col-lg-8">
 	<audio id="sample"></audio>
 		@for ($i = 0; $i < count($contentArr) ; $i++)
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
 		@endfor
 	</div>
 </div>

 @stop