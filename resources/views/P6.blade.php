@extends('layout')

@section('title')
<h1 style="font-size: 200%" align="center"> Bài 6: Đọc và chọn đáp án đúng</h1>

<script type="text/javascript">
	var contentNow = 0;
	function handleClick(checkbox) {
		document.getElementById('right').style.opacity=0;
		document.getElementById('wrong').style.opacity=0;
	} 

	function next() {
		document.getElementById('');
		contentNow ++;
	}

</script>

@stop

@section('content1') 


<form>
	@for($i = 0; $i<$cnt; $i++)
	<div id='content_id' align="center" style="background-color:gray; color:white;padding:5px;">
		<h3>Câu {{$i + 1}}: </h3>
		<p><?php echo $problemArr[$i][0] ?></p>
		<p><?php echo $problemArr[$i][1] ?></p>
	</div>

	
	<div id='content_id' align="center" style="background-color:#e3e3e3; color:black;padding:10px;">
		@php
		$indexes = [0,1,2];
		$m = array_rand($indexes);
		$indexes2 = array_diff($indexes, [$m]);
		$n = array_rand($indexes2);
		$o = array_rand(array_diff($indexes2, [$n]));
		
		@endphp
		<p><input type="checkbox" onclick='handleClick(this);'><?php echo "A. ". $answerArr[$i][$m] ?></p>
		<p><input type="checkbox" onclick='handleClick(this);'><?php echo "B. ". $answerArr[$i][$n] ?></p>
		<p><input type="checkbox" onclick='handleClick(this);'><?php echo "C. ". $answerArr[$i][$o] ?></p>
	</div>
	<input type="button" value="Next" id="nextBtn" onclick="next()">
	@endfor
</form>
<div class="row">
	<div id="right" class="img_right col-sm-6 col-md-6 col-lg-6" ></div>
	<div id="wrong" class="img_wrong col-sm-6 col-md-6 col-lg-6" ></div>
</div>
@stop