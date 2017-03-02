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
	var dummy = <?php echo json_encode($dummy); ?>;
	var dialogCnt = <?php echo json_encode($dialogCnt); ?>;
	var dialogNow = 1;
	var checkFinish = new Array();
	var rightAnswerCnt = 0;
	var checkQuestion = true;
	for (var i = 0; i < dialogCnt.length; i++) {

		checkFinish.push({dialogNo:(i+1), finish:false});
	}

	function edit(dummy, dialogNow, dialogCnt){
		while (document.getElementById("content_id").firstChild) {
			document.getElementById("content_id").removeChild(document.getElementById("content_id").firstChild);
		}
		while (document.getElementById("answer_id").firstChild) {
			document.getElementById("answer_id").removeChild(document.getElementById("answer_id").firstChild);
		}
		editContent(dummy, dialogNow);
		editAnswer(dummy, dialogNow);
		editButtonGr(dialogCnt, dialogNow);
	}

	function next() {

		if (checkAnswer(dummy , rightAnswerCnt) || checkQuestion == false) {

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
			edit(dummy, dialogNow, dialogCnt);
		}else{
			window.alert("Bạn phải hoàn thành đoạn hội thoại hiện tại thì mới làm tiếp được !");
		}

	}


	function chooseD(element){
		
		dialogNow = element.getAttribute('id');
		var textNode;
		var dialogSentence = new Array();
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
			for (var i = 0; i < dummy.length; i++) {
				if (dummy[i]['dialogNo'] == dialogNow) {
					dialogSentence.push(dummy[i]);
				}
			}

			for (var j = 0; j < dialogSentence.length; j++) {
				var sentence = dialogSentence[j]['sentence'];
				for (var i = 0; i < dialogSentence[j]['answer'].length; i++) {
					sentence = sentence.replace("*",dialogSentence[j]['answer'][i]);
				}

				var node = document.createElement("div");
				node.setAttribute('style', 'font-size: 25px; padding: 15px');	
				textNode = document.createTextNode(sentence);
				node.appendChild(textNode);
				document.getElementById("content_id").appendChild(node);
			} 
			checkQuestion = false;
		}else{
			edit(dummy, dialogNow, dialogCnt);
		}
		
	}

	function editContent(dummy, dialogNow) {
		var textNode;
		var dialogSentence = new Array();
		var sentenceNo = new Array();
		var dialogAnswer = new Array();

		for (var i = 0; i < dummy.length; i++) {
			if (dummy[i]['dialogNo'] == dialogNow) {
				dialogSentence.push(dummy[i]);
			}
		}
		for (var j = 0; j < dialogSentence.length; j++) {
			var node = document.createElement("div");
			node.setAttribute('style', 'font-size: 25px; padding: 15px');
			curSentence = dialogSentence[j]['sentence'].split("*");
			var index = 0;
			for (var k = 0; k < curSentence.length; k++) {
				if (index != curSentence.length-1) {
					// console.log(curSentence[k]);
					var dialogNode = document.createElement("div");
					textNode = document.createTextNode(curSentence[k]);
					dialogNode.setAttribute('style', 'width: 100px; height: 30px; background-color:green; display: inline-block; opacity: 0.1');
					dialogNode.setAttribute('id',dialogSentence[j]['sentenceNo']+','+k);
					dialogNode.setAttribute('ondragenter','return false;');
					dialogNode.setAttribute('ondragover','return false;');
					dialogNode.setAttribute('ondrop','drop(this,event)');
					node.appendChild(textNode);

					node.appendChild(dialogNode);
					index++;
				}else{
					textNode = document.createTextNode(curSentence[k]);
					node.appendChild(textNode);
				}
			}
			document.getElementById("content_id").appendChild(node);
		} 
	}

	function editAnswer(dummy,dialogNow) {
		var dialogAnswer = new Array();
		for (i=0; i < dummy.length ; i++) { 
			if (dummy[i]['dialogNo'] == dialogNow) {
				dialogAnswer.push(dummy[i]);
			}
		}
		dialogAnswer.sort(function(a, b){return 0.5 - Math.random()});
		for (var i = 0; i < dialogAnswer.length; i++) {
			for (var j = 0; j < dialogAnswer[i]['answer'].length; j++) {
				var node = document.createElement("span");
				node.setAttribute('draggable', 'true');
				node.setAttribute('class', 'dragWord ui-state-default');
				node.setAttribute('id', (dialogNow-1)+','+dialogAnswer[i]['sentenceNo']+','+j);
				node.setAttribute('ondragstart', 'javascript: drag(event)');
				var textnode = document.createTextNode(dialogAnswer[i]['answer'][j]);
				node.appendChild(textnode);
				document.getElementById("answer_id").appendChild(node);
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
			console.log(i);
			document.getElementById("btn-group").appendChild(node);
		}

	}

	function checkAnswer(dummy , rightAnswerCnt){
		var dialogAnswer = new Array();
		var result;
		for (var i = 0; i < dummy.length; i++) {
			if (dummy[i]['dialogNo'] == dialogNow) {
				for (var j = 0; j < dummy[i]['answer'].length; j++) {
					dialogAnswer.push(dummy[i]['answer'][j]);
				}
			}
		}
		if (dialogAnswer.length == rightAnswerCnt) {
			result = true;
			rightAnswerCnt = 0;
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
		event.dataTransfer.setData("Text", event.target.childNodes[0].data);
	}

	function drop(element, event) {
		event.preventDefault();
		var answerText = event.dataTransfer.getData("Text")

		var data = element.getAttribute('id').split(',');
		var sentenceNo = data[0];
		var answerOrder = data[1];
		var rightAnswer;

		for (var i = 0; i < dummy.length; i++) {
			if (dummy[i]['dialogNo'] == dialogNow && dummy[i]['sentenceNo'] == sentenceNo ) {
				rightAnswer = dummy[i]['answer'];
			}
		}
		
		if (rightAnswer[answerOrder].localeCompare(answerText) == 0) {
			element.innerHTML = answerText;
			element.setAttribute('style', 'width: auto; height: auto; background-color:transparent; display: inline-block; font-weight: 500;');
			document.getElementById((dialogNow-1)+','+sentenceNo+','+answerOrder).setAttribute('style', 'opacity: 0;');
			document.getElementById((dialogNow-1)+','+sentenceNo+','+answerOrder).setAttribute('draggable', 'false');
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
	for ($i=0; $i < count($dummy) ; $i++) { 
		if ($dummy[$i]->dialogNo == 1) {
			array_push($dialogAnswer, $dummy[$i]);
		}
	}
	shuffle($dialogAnswer);
	@endphp
	@for ($i = 0; $i < count($dialogAnswer) ; $i++)
	@for ($j = 0; $j < count($dialogAnswer[$i]->answer) ; $j++)
	<span id="0,{{$dialogAnswer[$i]->sentenceNo}},{{$j}}" ondragstart="javascript: drag(event)" draggable="true" class="dragWord ui-state-default">{{$dialogAnswer[$i]->answer[$j]}}</span>
	@endfor	
	@endfor
</div>
<div class="row">
	<div id="content_id" class="col-sm-10 col-md-10 col-lg-10">
		@for ($i = 0; $i < count($dummy) ; $i++)
		@if ($dummy[$i]->dialogNo == 1)
		@php
		$curSentence = explode('*', $dummy[$i]->sentence);
		$index = 0;
		@endphp
		<div style="font-size: 25px; padding: 15px">
			@for ($j = 0; $j < count($curSentence) ; $j++)
			@if ($index != count($curSentence)-1)
			{{$curSentence[$j]}}<div id="{{$dummy[$i]->sentenceNo}},{{$j}}" style="width: 100px; height: 30px; background-color:green; display: inline-block; opacity: 0.1; font-weight: 500" ondragenter="return false;" ondragover="return false;" ondrop="drop(this,event)"></div>
			@php
			$index++;
			@endphp
			@else
			{{$curSentence[$j]}}
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