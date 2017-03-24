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
		display: inline-block;
	}
	.dragWord:hover {
		cursor: move;
	}
	.dragWord:active {
		background: gold;
	}
	#btn-group{
		position: relative;
		left: 45%;
	}
	#content_id{
		position: relative;
		left: 30%;
		width: auto;
		max-width: 530px;
	}
	#answer_id{
		text-align: center;
		width: auto;
		padding: 10px;
		height: auto;
		background-color:white;
	}
	#btn-Start{
		position: fixed;
		top: 50%;
		left: 45%;
		width: 200px;
		height: 70px;
		border-radius: 15px;
		font-size: 21px;
		border: 1px solid;
		z-index: 1;
	}
</style>
@stop
@section('content1')
<script langauge="JavaScript">
	var elementData = <?php echo json_encode($elementData); ?>;
	var dialogCnt = <?php echo json_encode($dialogCnt); ?>;
	var dialogNow = 0;
	var checkFinish = new Array();
	var rightAnswerCnt = 0; 
	var checkQuestion = true;
	var countdown;
	var inProgress = false;
	for (var i = 0; i < dialogCnt.length; i++) {

		checkFinish.push({dialogNo:(i), finish:false});
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
		if(countdown)
			countdown.stop();
		$("#countdown").empty();
		countdown = $("#countdown").countdown360({
			radius      : 80,
			seconds     : getDialogAnswer(elementData, dialogNow)*5,
			fontColor   : '#FFFFFF',
			autostart   : true,
			onComplete  : function (){
				showResult();
			}
		});
		$('#btn-Next').hide();
	}

	function next() {
		$("#content").show();
		$('#result').hide();
		$('#result').empty();

		if(dialogNow < dialogCnt.length){
			dialogNow = parseInt(dialogNow) + 1;
		}else{
			window.alert("Bạn đã hoàn thành bài tập rồi !");
			$('#btn-NextAct').show();
			$("#countdown").empty();
		}
		edit(elementData, dialogNow, dialogCnt);
	}

	function chooseD(element){

		dialogNow = element.getAttribute('id');
		var textNode;
		var dialogline = new Array();
		var questionDone;

		$("#content").show();
		$('#result').hide();
		$('#result').empty();

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
					
					var dialogNode = document.createElement("div");
					textNode = document.createTextNode(curline[k]);
					dialogNode.setAttribute('style', 'width: 100px; height: 30px; background-color:#e6ffee; display: inline-block; ');
					dialogNode.setAttribute('id',dialogline[j]['lineNo']+','+k);
					dialogNode.setAttribute('ondragenter','return false;');
					dialogNode.setAttribute('class','blank-sqr');
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
					var node = document.createElement("div");
					node.setAttribute('draggable', 'true');
					node.setAttribute('class', 'dragWord ui-state-default');
					node.setAttribute('id', (dialogNow)+','+dialogAnswer[i]['lineNo']+','+j);
					node.setAttribute('ondragstart', 'javascript: drag(event)');
					var textnode = document.createTextNode(dialogAnswer[i]['answer'][j]);
					node.appendChild(textnode);
					document.getElementById("answer_id").appendChild(node);
				}

			}
		}
	}

	function editButtonGr(dialogCnt, dialogNow){
		while (document.getElementById("btn-group").firstChild) {
			document.getElementById("btn-group").removeChild(document.getElementById("btn-group").firstChild);
		}
		for (var i = 0; i < dialogCnt.length; i++) {
			var node = document.createElement("button");
			var textNode = document.createTextNode('D'+(i+1));
			node.setAttribute('id', i);
			node.setAttribute('autocomplete', 'off');
			node.setAttribute('type', 'button');
			node.setAttribute('class', 'btn btn-primary');
			node.appendChild(textNode);
			if (i != dialogNow  ) {
				node.setAttribute('disabled', 'true');
				node.setAttribute('onclick', 'JavaScript: chooseD(this)');
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
		document.documentElement.scrollTop = document.documentElement.scrollTop + scrollSpeed;
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
			element.setAttribute("class", "sqr");
			element.setAttribute("style", "width: auto; height: auto; background-color:#e6ffee; display: inline-block; font-weight: 500");
			document.getElementById(targetId).remove();
			rightAnswerCnt++;
		}

		if (checkAnswer(elementData , rightAnswerCnt)) {
			$('#btn-Next').show();
			countdown.stop();
			showResult();
		}
	}

	function getDialogAnswer(elementData, dialogNow) {
		var dialogAnswer = new Array();
		var answerCnt = 0;
		for (i=0; i < elementData.length ; i++) { 
			if (elementData[i]['dialogNo'] == dialogNow) {
				dialogAnswer.push(elementData[i]);
			}
		}

		for (var i = 0; i < dialogAnswer.length; i++) {
			for (var j = 0; j < dialogAnswer[i]['answer'].length; j++) {
				if (dialogAnswer[i]['answer'][j].localeCompare("") != 0) {
					answerCnt++;
				}
			}
		}
		return answerCnt;
	}

	function showResult() {
		var result = document.createElement("span");
		result.className = 'result';
		result.innerHTML = 'You are ' + (rightAnswerCnt / getDialogAnswer(elementData, dialogNow) * 100).toFixed(2) + '% correct <br> (' + rightAnswerCnt + '/' + getDialogAnswer(elementData, dialogNow) + ')';
		document.getElementById("result").appendChild(result);
		$('#result').fadeIn(600);
		rightAnswerCnt = 0;

		var blankBlockList =  document.getElementsByClassName("blank-sqr");
		var dialogAnswer = new Array();
		for (i=0; i < elementData.length ; i++) { 
			if (elementData[i]['dialogNo'] == dialogNow) {
				dialogAnswer.push(elementData[i]);
			}
		}

		for (var i = 0; i < blankBlockList.length; i++) {
			var data = blankBlockList[i].id.split(',');
			blankBlockList[i].innerHTML = dialogAnswer[data[0]]['answer'][data[1]];
			blankBlockList[i].setAttribute('style', 'width: auto; height: auto; background-color:#ffc2b3; display: inline-block; ')
		}
		for (var i = 0; i < dialogNow; i++) {
			document.getElementById(i).removeAttribute("disabled");
		}	
		document.getElementById(dialogNow).setAttribute("onclick", "JavaScript: chooseD(this)");
		if (document.getElementById(parseInt(dialogNow)+1) != null) {
			document.getElementById(parseInt(dialogNow)+1).removeAttribute("disabled");
			document.getElementById(parseInt(dialogNow)+1).setAttribute("onclick", "JavaScript: chooseD(this)");
		}

		for (var i = 0; i < checkFinish.length; i++) {
			if (checkFinish[i]['dialogNo'] == dialogNow) {
				checkFinish[i]['finish'] = true;
			}
		}
		$("#answer_id").find("div").removeAttr("draggable");
		$('#btn-Next').show();
	}
</script> 

<div id="btn-group" class="btn-group">
	@for ($i = 0; $i < count($dialogCnt); $i++)
	<button id="{{$i}}" type="button" 
	@if ($i > 0)
	disabled="true" 
	@endif class="btn btn-primary" autocomplete="off" >D{{$i+1}}</button>
	@endfor
</div>
<br>
<button type="button" id="btn-Start" class="btn btn-info" onclick="JavaScript: showPractice()" style="">Start practice</button>
<div id="content" style=" filter: blur(12px); transition: 3s">
	<div id="answer_id"  >
		@php
		$dialogAnswer = array();
		for ($i=0; $i < count($elementData) ; $i++) { 
			if ($elementData[$i]->dialogNo == 0) {
				array_push($dialogAnswer, $elementData[$i]);
			}
		}
		shuffle($dialogAnswer);
		@endphp
		@for ($i = 0; $i < count($dialogAnswer) ; $i++)
		@for ($j = 0; $j < count($dialogAnswer[$i]->answer) ; $j++)
		@if (strcmp($dialogAnswer[$i]->answer[$j], "") != 0 )
		<div id="0,{{$dialogAnswer[$i]->lineNo}},{{$j}}" ondragstart="javascript: drag(event)" draggable="true" class="dragWord ui-state-default">{{$dialogAnswer[$i]->answer[$j]}}</div>
		@endif
		@endfor	
		@endfor
	</div>
	<div class="row" style="position: relative;">
		<div id="content_id" class="col-sm-7 col-md-7 col-lg-7">
			@for ($i = 0; $i < count($elementData) ; $i++)
			@if ($elementData[$i]->dialogNo == 0)
			@php
			$curline = explode('*', $elementData[$i]->line);
			$index = 0;
			@endphp
			<div style="font-size: 25px; padding: 15px">
				@for ($j = 0; $j < count($curline) ; $j++)
				@if ($index != count($curline)-1)
				{{$curline[$j]}}<div id="{{$elementData[$i]->lineNo}},{{$j}}" class="blank-sqr" style="width: 100px; height: 30px; background-color:#e6ffee; display: inline-block; font-weight: 500" ondragenter="return false;" ondragover="return false;" ondrop="drop(this,event)"></div>
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
		<div class="col-sm-5 col-md-5 col-lg-5"  style="text-align: center; vertical-align: middle; float: right; margin-bottom: 20px">
			<div id="countdown"></div>
		</div>
	</div>
</div>
{{-- <button type="button" id="btn-Next" class="btn btn-primary" style=" display: none; "  onclick="JavaScript: next()">Next</button> --}}
<div>
	<div id="result" style="text-align: center;"></div>
</div>
<div id="btn-NextAct">
	<i class="fa fa-arrow-right fa-4x" aria-hidden="true"></i>
	<span id="locationNext"></span>
</div>
<script type="text/javascript">
	var nextAct = <?php echo json_encode(\Request::get('nextAct')); ?>;
	$('#locationNext').html(nextAct['name']);
	$('#btn-NextAct').hide();
	$('#btn-NextAct').click(function(){
		window.location.href="http://localhost:8000/lesson1/"+nextAct['name']; 
	});
</script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
<script src="{{ asset('js/jquery.countdown360.js') }}" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
	countdown = $("#countdown").countdown360({
		radius      : 80,
		seconds     : getDialogAnswer(elementData, dialogNow)*5,
		fontColor   : '#FFFFFF',
		autostart   : false,
		onComplete  : function (){
			showResult();
		}
	});

	function showPractice(){
		$("#content").attr("style", "transition: 1s;");
		$("#btn-Start").remove();
		countdown.start();
	}
</script>

@stop