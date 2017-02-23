@extends('layout')

@section('title')
<h1 style="font-size: 200%" align="center">Đọc và chọn đáp án đúng</h1>

<script type="text/javascript">
	var contentNow = 0;
	var problemArr = <?php echo json_encode($problemArr); ?>;
	var answerArr = <?php echo json_encode($answerArr); ?>;
	var arr = <?php echo json_encode($arr); ?>;
	function next() {

		var char = 65;
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
			editAnswer(answerArr[contentNow][i], char, i);
			char++;
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
		node.setAttribute("style", "background-color : gray; color : white; padding : 10px;");
		var contentNode = document.createTextNode(problem);
		node.appendChild(contentNode);
		document.getElementById("problem_id").appendChild(node);
	}

	function editAnswer(answer, char, id) {
		var node = document.createElement("div");
		var node1 = document.createElement("p");
		var node2 = document.createElement("input");
		var test = String.fromCharCode(char);
		var contNode1 = document.createTextNode(test + ". " + answer);
		node2.setAttribute('type', 'checkbox');
		node2.setAttribute('name', id);
		node2.setAttribute('onclick', 'handleClick(this);');
		node1.appendChild(node2);
		node1.appendChild(contNode1);
		node.appendChild(node1);
		document.getElementById("answer_id").appendChild(node1);

}  

function handleClick(element) {
			document.getElementById('right').style.opacity=0;
			document.getElementById('wrong').style.opacity=0;
			var answerId = element.name;
			console.log(answerId);
			if (answerId == 0) {
				document.getElementById('right').style.opacity=1;
				document.getElementById("answer_id").setAttribute('color', 'green');
				element.setAttribute('disabled', 'disabled');
			}else{
				document.getElementById('wrong').style.opacity=1;
				element.setAttribute('disabled', 'disabled');
			}
		} 
	
</script>

@stop

@section('content1') 


<form>
	<div id='order_id'><div>Câu 1</div></div>
	<div id='problem_id' align="center" style="background-color:gray; color:white ;padding:10px;">
		<p><?php echo $problemArr[0][0] ?></p>
		<p><?php echo $problemArr[0][1] ?></p>
	</div>
	<div id='answer_id' align="center" style="background-color:#e3e3e3; color:black;padding:10px;">
		<p>
			<input type="checkbox" name="{{ $arr[0][0] }}" onclick='handleClick(this);'>
			<?php echo "A. ". $answerArr[0][$arr[0][0]] ?>
		</p>
		<p>
			<input type="checkbox" name="{{ $arr[0][1] }}" onclick='handleClick(this);'>
			<?php echo "B. ". $answerArr[0][$arr[0][1]] ?>
		</p>
		<p>
			<input type="checkbox" name="{{ $arr[0][2] }}" onclick='handleClick(this);'>
			<?php echo "C. ". $answerArr[0][$arr[0][2]] ?>
		</p>
	</div>
		<br>
		<p align="center">
			<input type="button" value="Back" id="nextBtn" onclick="back()">
			<input type="button" value="Next" id="nextBtn" onclick="next()">
		</p>
	
</form>
<div class="row">
	<div id="right" class="img_right col-sm-6 col-md-6 col-lg-6" ></div>
	<div id="wrong" class="img_wrong col-sm-6 col-md-6 col-lg-6" ></div>
</div>
@stop