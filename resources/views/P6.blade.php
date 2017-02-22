@extends('layout')

@section('title')
<h1 style="font-size: 200%" align="center"> Bài 6: Đọc và chọn đáp án đúng</h1>

@stop

@section('content1') 


<form>
	@for($i = 0; $i<$cnt; $i++)
	<div align="center" style="background-color:gray; color:white;padding:5px;">
		<h3>Câu {{$i + 1}}: </h3>
		<p><?php echo $problemArr[$i][0] ?></p>
		<p><?php echo $problemArr[$i][1] ?></p>
	</div>

	
	<div align="center" style="background-color:#e3e3e3; color:black;padding:10px;">
		
		<p><input type="checkbox" name=""><?php echo "A. ". $answerArr[$i][0] ?></p>
		<p><input type="checkbox" name=""><?php echo "B. ". $answerArr[$i][1] ?></p>
		<p><input type="checkbox" name=""><?php echo "C. ". $answerArr[$i][2] ?></p>
	</div>
	@endfor
</form>


@stop