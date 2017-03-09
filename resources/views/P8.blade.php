@extends('layout')

@section('title')
<h1 style="font-size: 400%" align="center">- Bài 8: Đọc và điền vào chỗ trống</h1>

<hr>



<style type="text/css">
	.ui-state-highlight {
		padding: 6px 15px;
	}
	.dragWord {
		border-radius: 4px;
		border: 1px solid black;
		padding: 6px 15px;
		margin: 1px 5px;
		border-color: black;
		font-size: 25px;
		color: black;
		transition: background 0.8s;
	}
	.dragWord:hover {
		cursor: move;
	}
	.dragWord:active {
		background: gold;
	}
</style>
@stop
@section('content1')
<script langauge="JavaScript">
	var elementData = <?php echo json_encode($elementData); ?>;
	var dialogCnt = <?php echo json_encode($dialogCnt); ?>;
	var dialogNow = 1;
	var checkFinish = new Array();
	var rightAnswerCnt = 0;
	var checkQuestion = true;
	for (var i = 0; i < dialogCnt.length; i++) {

		checkFinish.push({dialogNo:(i+1), finish:false});
	}

	function edit(elementData, dialogNow, dialogCnt){
		while (document.getElementById("content_id").firstChild) {
			document.getElementById("content_id").removeChild(document.getElementById("content_id").firstChild);
		}
		while (document.getElementById("answer_id").firstChild) {
			document.getElementById("answer_id").removeChild(document.getElementById("answer_id").firstChild);
		}
		editContent(elementData, dialogNow);
		editAnswer(elementData, dialogNow);
		editButtonGr(dialogCnt, dialogNow);
	}

	function next() {

		if (checkAnswer(elementData , rightAnswerCnt) || checkQuestion == false) {
			rightAnswerCnt = 0;
			for (var i = 0; i < checkFinish.length; i++) {
				if (checkFinish[i]['dialogNo'] == dialogNow) {
					checkFinish[i]['finish'] = true;
				}
			}

			if(dialogNow < dialogCnt.length){
				dialogNow = parseInt(dialogNow) + 1;
			}else{
				window.alert("Bạn đã hoàn thành bài tập rồi !");
			}
			edit(elementData, dialogNow, dialogCnt);
		}else{
			window.alert("Bạn phải hoàn thành đoạn hội thoại hiện tại thì mới làm tiếp được !");
		}

	}


	function chooseD(element){
		
		dialogNow = element.getAttribute('id');
		var textNode;
		var dialogline = new Array();
		var questionDone;
		
		for (var i = 0; i < checkFinish.length; i++) {
			if (checkFinish[i]['dialogNo'] == dialogNow) {
				questionDone = checkFinish[i]['finish'];
			}
		}
		if (questionDone) {
			while (document.getElementById("content_id").firstChild) {
				document.getElementById("content_id").removeChild(document.getElementById("content_id").firstChild);
			}
			while (document.getElementById("answer_id").firstChild) {
				document.getElementById("answer_id").removeChild(document.getElementById("answer_id").firstChild);
			}
			for (var i = 0; i < elementData.length; i++) {
				if (elementData[i]['dialogNo'] == dialogNow) {
					dialogline.push(elementData[i]);
				}
			}

			for (var j = 0; j < dialogline.length; j++) {
				var line = dialogline[j]['line'];
				for (var i = 0; i < dialogline[j]['answer'].length; i++) {
					line = line.replace("*",dialogline[j]['answer'][i]);
				}

				var node = document.createElement("div");
				node.setAttribute('style', 'font-size: 25px; padding: 15px');	
				textNode = document.createTextNode(line);
				node.appendChild(textNode);
				document.getElementById("content_id").appendChild(node);
			} 
			checkQuestion = false;
		}else{
			edit(elementData, dialogNow, dialogCnt);
		}
		
	}

	function editContent(elementData, dialogNow) {
		var textNode;
		var dialogline = new Array();
		var lineNo = new Array();
		var dialogAnswer = new Array();

		for (var i = 0; i < elementData.length; i++) {
			if (elementData[i]['dialogNo'] == dialogNow) {
				dialogline.push(elementData[i]);
			}
		}
		for (var j = 0; j < dialogline.length; j++) {
			var node = document.createElement("div");
			node.setAttribute('style', 'font-size: 25px; padding: 15px');
			curline = dialogline[j]['line'].split("*");
			var index = 0;
			for (var k = 0; k < curline.length; k++) {
				if (index != curline.length-1) {
					// console.log(curline[k]);
					var dialogNode = document.createElement("div");
					textNode = document.createTextNode(curline[k]);
					dialogNode.setAttribute('style', 'width: 100px; height: 30px; background-color:green; display: inline-block; opacity: 0.1');
					dialogNode.setAttribute('id',dialogline[j]['lineNo']+','+k);
					dialogNode.setAttribute('ondragenter','return false;');
					dialogNode.setAttribute('ondragover','return false;');
					dialogNode.setAttribute('ondrop','drop(this,event)');
					node.appendChild(textNode);

					node.appendChild(dialogNode);
					index++;
				}else{
					textNode = document.createTextNode(curline[k]);
					node.appendChild(textNode);
				}
			}
			document.getElementById("content_id").appendChild(node);
		} 
	}

	function editAnswer(elementData,dialogNow) {
		var dialogAnswer = new Array();
		for (i=0; i < elementData.length ; i++) { 
			if (elementData[i]['dialogNo'] == dialogNow) {
				dialogAnswer.push(elementData[i]);
			}
		}
		dialogAnswer.sort(function(a, b){return 0.5 - Math.random()});
		for (var i = 0; i < dialogAnswer.length; i++) {
			for (var j = 0; j < dialogAnswer[i]['answer'].length; j++) {
				if (dialogAnswer[i]['answer'][j].localeCompare("") != 0) {
					var node = document.createElement("span");
					node.setAttribute('draggable', 'true');
					node.setAttribute('class', 'dragWord ui-state-default');
					node.setAttribute('id', (dialogNow-1)+','+dialogAnswer[i]['lineNo']+','+j);
					node.setAttribute('ondragstart', 'javascript: drag(event)');
					var textnode = document.createTextNode(dialogAnswer[i]['answer'][j]);
					node.appendChild(textnode);
					document.getElementById("answer_id").appendChild(node);}

				}
			}
		}


		function editButtonGr(dialogCnt, dialogNow) {
			while (document.getElementById("btn-group").firstChild) {
				document.getElementById("btn-group").removeChild(document.getElementById("btn-group").firstChild);
			}
			for (var i = 1; i <= dialogCnt.length; i++) {
				var node = document.createElement("button");
				var textNode = document.createTextNode('D'+i);
				node.setAttribute('id', i);
				node.setAttribute('type', 'button');
				node.setAttribute('class', 'btn btn-primary');
				node.setAttribute('onclick', 'JavaScript: chooseD(this)');
				node.appendChild(textNode);
				if (i > dialogNow  ) {
					node.setAttribute('disabled', 'true');
				}

				document.getElementById("btn-group").appendChild(node);
			}

		}

		function checkAnswer(elementData , rightAnswerCnt){
			var dialogAnswer = new Array();
			var result;
			for (var i = 0; i < elementData.length; i++) {
				if (elementData[i]['dialogNo'] == dialogNow) {
					for (var j = 0; j < elementData[i]['answer'].length; j++) {
						if (elementData[i]['answer'][j].localeCompare("")!=0) {
							dialogAnswer.push(elementData[i]['answer'][j]);
						}
					}
				}
			}
			console.log(dialogAnswer);
			if (dialogAnswer.length == rightAnswerCnt) {
				result = true;
			}else{
				for (var i = 0; i < dialogAnswer.length; i++) {
					delete dialogAnswer[i];
				}
				result = false;
			}
			return result;
		}

		function allowDrop(event){
			event.preventDefault();
		}

		function drag(event) {
			event.dataTransfer.setData("Text", event.target.getAttribute("id"));
		}

		function drop(element, event) {
			event.preventDefault();
			var targetId = event.dataTransfer.getData("Text");
			var answerText = document.getElementById(targetId).innerHTML;
			var data = element.getAttribute('id').split(',');
			var lineNo = data[0];
			var answerOrder = data[1];
			var rightAnswer;

			for (var i = 0; i < elementData.length; i++) {
				if (elementData[i]['dialogNo'] == dialogNow && elementData[i]['lineNo'] == lineNo ) {
					rightAnswer = elementData[i]['answer'];
				}
			}

			if (rightAnswer[answerOrder].localeCompare(answerText) == 0) {
				element.innerHTML = answerText;
				element.setAttribute('style', 'width: auto; height: auto; background-color:transparent; display: inline-block; font-weight: 500;');
				document.getElementById(targetId).setAttribute('style', 'opacity: 0;');
				document.getElementById(targetId).setAttribute('draggable', 'false');
				rightAnswerCnt++;
			}
		}

	</script>
	<div id="btn-group" class="btn-group">
		@for ($i = 1; $i <= count($dialogCnt); $i++)
		<button id="{{$i}}" type="button" 
		@if ($i > 1)
		disabled="true" 
		@endif class="btn btn-primary" onclick="JavaScript: chooseD(this)">D{{$i}}</button>
		@endfor
	</div>
	<br>
	<div id="answer_id" style="width: auto; padding: 10px; height: 100px; background-color:white;">
		@php
		$dialogAnswer = array();
		for ($i=0; $i < count($elementData) ; $i++) { 
			if ($elementData[$i]->dialogNo == 1) {
				array_push($dialogAnswer, $elementData[$i]);
			}
		}
		shuffle($dialogAnswer);
		@endphp
		@for ($i = 0; $i < count($dialogAnswer) ; $i++)
		@for ($j = 0; $j < count($dialogAnswer[$i]->answer) ; $j++)
		@if (strcmp($dialogAnswer[$i]->answer[$j], "") != 0 )
		<span id="0,{{$dialogAnswer[$i]->lineNo}},{{$j}}" ondragstart="javascript: drag(event)" draggable="true" class="dragWord ui-state-default">{{$dialogAnswer[$i]->answer[$j]}}</span>
		@endif
		@endfor	
		@endfor
	</div>
	<div class="row">
		<div id="content_id" class="col-sm-10 col-md-10 col-lg-10">
			@for ($i = 0; $i < count($elementData) ; $i++)
			@if ($elementData[$i]->dialogNo == 1)
			@php
			$curline = explode('*', $elementData[$i]->line);
			$index = 0;
			@endphp
			<div style="font-size: 25px; padding: 15px">
				@for ($j = 0; $j < count($curline) ; $j++)
				@if ($index != count($curline)-1)
				{{$curline[$j]}}<div id="{{$elementData[$i]->lineNo}},{{$j}}" style="width: 100px; height: 30px; background-color:green; display: inline-block; opacity: 0.1; font-weight: 500" ondragenter="return false;" ondragover="return false;" ondrop="drop(this,event)"></div>
				@php
				$index++;
				@endphp
				@else
				{{$curline[$j]}}
				@endif
				@endfor
			</div>
			@endif
			@endfor
		</div>
		<div class="col-sm-2 col-md-2 col-lg-2"><button type="button" class="btn btn-primary" onclick="JavaScript: next()">Next</button>
		</div>
	</div>
	@stop