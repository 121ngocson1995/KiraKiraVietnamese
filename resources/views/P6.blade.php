@extends('layout')

@section('title')
<h1 style="font-size: 200%" align="center"> Bài 6: Đọc và chọn đáp án đúng</h1>
<style>
	.testClass {
		background: #e3e3e3;
		padding: 10px;
		text-align: center;
		color: pink;
	}
</style>
<script type="text/javascript">
	var contentNow = 0;
	var problemArr = <?php echo json_encode($problemArr); ?>;
	var answerArr = <?php echo json_encode($answerArr); ?>;
	

	function next() {
		while (document.getElementById("problem_id").firstChild) {
			document.getElementById("problem_id").removeChild(document.getElementById("problem_id").firstChild);
		}
		
		if(contentNow < problemArr.length-1){
			contentNow = parseInt(contentNow) + 1;
		}else{
			window.alert("Bạn đã hoàn thành bài tập rồi");
		}
		while (document.getElementById("order_id").firstChild) {
			document.getElementById("order_id").removeChild(document.getElementById("order_id").firstChild);
		}
		editOrder(contentNow + 1);
		for (var i = 0; i < problemArr[contentNow].length; i++) {
			editProblem(problemArr[contentNow][i]);
		}

		while (document.getElementById("answer_id").firstChild) {
			document.getElementById("answer_id").removeChild(document.getElementById("answer_id").firstChild);
		}
		
		for (var i = 0; i < answerArr[contentNow].length; i++) {
			editAnswer(answerArr[contentNow][i]);
		}

	}

	function editOrder(x) {
		var node = document.createElement("div");
		var contentNode = document.createTextNode('Câu '+ x);
		node.appendChild(contentNode);
		document.getElementById("order_id").appendChild(node);
	}

	function editProblem(problem) {
		var node = document.createElement("div");
		var contentNode = document.createTextNode(problem);
		node.appendChild(contentNode);
		var att = document.createAttribute("class");
		att.value = "testClass";
		document.getElementById("problem_id").appendChild(node).setAttributeNode(att);
	}

	function editAnswer(answer) {
		var node = document.createElement("div");
		var contentNode = document.createTextNode(answer);
		node.appendChild(contentNode);
		document.getElementById("answer_id").appendChild(node);
	}

	function handleClick(checkbox) {
		document.getElementById('right').style.opacity=0;
		document.getElementById('wrong').style.opacity=0;
	} 
</script>

@stop

@section('content1') 


<form>
	<div id='order_id'><div>Câu 1</div></div>
	<div id='problem_id' align="center" style="background-color:gray; color:white;padding:10px;">
		
		<p><?php echo $problemArr[0][0] ?></p>
		<p><?php echo $problemArr[0][1] ?></p>
	</div>

	
	<div id='answer_id' align="center" style="background-color:#e3e3e3; color:black;padding:10px;">
		@php
		$indexes = [0,1,2];
		$m = array_rand($indexes);
		$indexes2 = array_diff($indexes, [$m]);
		$n = array_rand($indexes2);
		$o = array_rand(array_diff($indexes2, [$n]));

		@endphp
		<p><input type="checkbox" onclick='handleClick(this);'><?php echo "A. ". $answerArr[0][$m] ?></p>
		<p><input type="checkbox" onclick='handleClick(this);'><?php echo "B. ". $answerArr[0][$n] ?></p>
		<p><input type="checkbox" onclick='handleClick(this);'><?php echo "C. ". $answerArr[0][$o] ?></p>
	</div>
	<input type="button" value="Next" id="nextBtn" onclick="next()">
	
</form>
<div class="row">
	<div id="right" class="img_right col-sm-6 col-md-6 col-lg-6" ></div>
	<div id="wrong" class="img_wrong col-sm-6 col-md-6 col-lg-6" ></div>
</div>
@stop