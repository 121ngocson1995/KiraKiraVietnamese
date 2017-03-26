@extends('activities.layout.activityLayout')

@section('actContent')

<hr>

<style type="text/css">
	.ui-state-highlight {
		padding: 6px 15px;
	}
	.dragWord {
		border-radius: 9px;
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
		left: 27%;
		width: auto;
		max-width: 870px;
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
	.blank-sqr{
		border: 1px solid;
		border-radius: 9px;
		width: 200px;
		height: 45px;
		background-color: #e6ffee;
		display: inline-block;
		font-weight: 500;
		transition: 1s;
	}
	.sqr{
		height: calc(100% + 10px);
		text-align: center;
		border-radius: 9px;
		padding: 0px 15px;
		margin: 1px 5px;
		background-color:#e6ffee;
		display: inline-block;
		font-weight: 500;
		transition: 1s;
	}
	.notChoose-sqr{
		height: calc(100% + 10px);
		text-align: center;
		border: 1px solid;
		border-radius: 9px;
		background-color:#ffc2b3;
		display: inline-block;
		font-weight: 500;
		transition: 1s;
		padding: 0px 15px;
		margin: 1px 5px;
	}
</style>

<script langauge="JavaScript">
	var elementData = <?php echo json_encode($elementData); ?>;
	var dialogCnt = <?php echo json_encode($dialogCnt); ?>;
	var dialogNow = 0;
	var checkFinish = new Array();
	var rightAnswerCnt = 0;
	var checkQuestion = true;
	var countdown;
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
	}

	function chooseD(element){
		
		dialogNow = element.getAttribute('id');
		var textNode;
		var dialogSentence = new Array();
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
					dialogSentence.push(elementData[i]);
				}
			}

			for (var j = 0; j < dialogSentence.length; j++) {
				var sentence = dialogSentence[j]['line'];
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
			edit(elementData, dialogNow, dialogCnt);
			initDroppable();
			console.log('almost done');
		}
		
	}

	function editContent(elementData, dialogNow) {
		var textNode;
		var dialogSentence = new Array();
		var sentenceNo = new Array();
		var dialogAnswer = new Array();

		for (var i = 0; i < elementData.length; i++) {
			if (elementData[i]['dialogNo'] == dialogNow) {
				dialogSentence.push(elementData[i]);
			}
		}
		for (var j = 0; j < dialogSentence.length; j++) {
			var node = document.createElement("div");
			node.setAttribute('style', 'font-size: 25px; padding: 15px');
			curLine = dialogSentence[j]['line'].split("*");
			var index = 0;
			for (var k = 0; k < curLine.length; k++) {
				if (index != curLine.length-1) {
					var dialogNode = document.createElement("div");
					textNode = document.createTextNode(curLine[k]);
					dialogNode.setAttribute('id',"d"+dialogNow+"line"+j+"question"+k);
					dialogNode.setAttribute('data-answer-content', dialogSentence[j]['answer'][k]);
					dialogNode.setAttribute('class','blank-sqr dropWord');
					node.appendChild(textNode);

					node.appendChild(dialogNode);
					index++;
				}else{
					textNode = document.createTextNode(curLine[k]);
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
					node.setAttribute('class', 'dragWord ui-state-default');
					node.setAttribute('id', "d"+dialogNow+"line"+i+"answer"+j);
					node.setAttribute('data-answer-content', dialogAnswer[i]['answer'][j]);
					var textnode = document.createTextNode(dialogAnswer[i]['answer'][j]);
					node.appendChild(textnode);
					document.getElementById("answer_id").appendChild(node);
				}
			}
		}
	}

	function editButtonGr(dialogCnt, dialogNow) {
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
	
	// function allowDrop(event){
	// 	event.preventDefault();
	// }

	// function drag(event) {
	// 	event.dataTransfer.setData("Text", event.target.getAttribute("id"));
	// }

	// function drop(element, event) {
	// 	event.preventDefault();
	// 	var targetId = event.dataTransfer.getData("Text");
	// 	var answerText = document.getElementById(targetId).innerHTML;
	// 	var data = element.getAttribute('id').split(',');
	// 	var sentenceNo = data[0];
	// 	var answerOrder = data[1];
	// 	var rightAnswer;

	// 	for (var i = 0; i < elementData.length; i++) {
	// 		if (elementData[i]['dialogNo'] == dialogNow && elementData[i]['lineNo'] == sentenceNo ) {
	// 			rightAnswer = elementData[i]['answer'];
	// 		}
	// 	}

	// 	if (rightAnswer[answerOrder].localeCompare(answerText) == 0) {
	// 		element.innerHTML = answerText;
	// 		element.setAttribute("class", "sqr");
	// 		element.setAttribute("style", "width: auto; height: auto; background-color:#e6ffee; display: inline-block; font-weight: 500");
	// 		document.getElementById(targetId).remove();
	// 		rightAnswerCnt++;
	// 	}

	// 	if (checkAnswer(elementData , rightAnswerCnt)) {
	// 		$('#btn-Next').show();
	// 		countdown.stop();
	// 		showResult();
	// 	}
	// }

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

		$('.blank-sqr').each(function(){
			var data = $(this).attr('data-answer-content');

			$(this).text(data);
			$(this).removeClass('blank-sqr');
			$(this).droppable('destroy');
			$(this).addClass('notChoose-sqr');
		});
		$('.dragWord').each(function(){
			$(this).draggable('destroy');
			$(this).css('background', 'transparent');
		});
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
	}

</script>
<div style="-moz-user-select: none; -webkit-user-select: none; -ms-user-select:none; user-select:none;-o-user-select:none;" unselectable="on" onselectstart="return false;" 
onmousedown="return false;">
<div id="btn-group" class="btn-group">
	@for ($i = 0; $i < count($dialogCnt); $i++)
	<button id="{{$i}}" type="button" 
	@if ($i > 0)
	disabled="true" 
	@endif class="btn btn-primary" autocomplete="off" >D{{$i+1}}</button>
	@endfor
</div>
<br>
<button type="button" id="btn-Start" class="btn btn-info" onclick="JavaScript: showPractice()">Start practice</button>
<div id="content" style=" filter: blur(12px); transition: 3s">
	<div id="answer_id" style="width: auto; padding: 10px; height: 100px; background-color:white;">
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
		<div id="d0line{{$i}}answer{{$j}}" data-answer-content="{{$dialogAnswer[$i]->answer[$j]}}" class="dragWord ui-state-default">{{$dialogAnswer[$i]->answer[$j]}}</div>
		@endif
		@endfor	
		@endfor
	</div>
	<div class="row" style="position: relative;">
		<div id="content_id" class="col-sm-6 col-md-6 col-lg-6">
			@for ($i = 0; $i < count($elementData) ; $i++)
			@if ($elementData[$i]->dialogNo == 0)
			@php
			$curLine = explode('*', $elementData[$i]->line);
			$index = 0;
			@endphp
			<div style="font-size: 25px; padding: 15px">
				@for ($j = 0; $j < count($curLine) ; $j++)
				@if ($index != count($curLine)-1)
				{{$curLine[$j]}}<div id="d0line{{$i}}question{{$j}}" data-answer-content="{{$elementData[$i]->answer[$j]}}" class="blank-sqr dropWord"></div>
				@php
				$index++;
				@endphp
				@else
				{{$curLine[$j]}}
				@endif
				@endfor
			</div>
			@endif
			@endfor
		</div>
		<div class="col-sm-6 col-md-6 col-lg-6"  style="text-align: center; vertical-align: middle; float: right; margin-bottom: 20px">
			<div id="countdown"></div>
		</div>
	</div>
</div>
{{-- <button type="button" id="btn-Next" class="btn btn-primary" style=" display: none; "  onclick="JavaScript: next()">Next</button> --}}
<div>
	<div id="result" style="text-align: center;"></div>
</div>
</div>

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
		initDroppable();
		$("#content").attr("style", "transition: 1s;");
		$("#btn-Start").remove();
		countdown.start();
	}
</script>

<script>
	function test() {
		/* change position of draggable element along with drop target */
		countdown.stop();
		showResult();
	}
	var correctNo = 0;
	var totalQuestion = 0;

	window.onresize = function() {
		$('.dropWord').each(function() {
			rePosition($(this), $(this).data('curDrag'));
		});
	}


	function initDroppable() {
		// $('.dropWord').each(function() {
		// 	console.log($(this));
		// });
		$(".dragWord").draggable({
			// scroll: true,
			// scrollSensitivity: 20,
			// scrollSpeed: 20,
			// cursor: "crosshair", cursorAt: { top: 50, left: 50 },
			create: function(){
				$(this).data('position',$(this).position());
			},
			cursor:'move',
			drag: function(){
				$(this).css('background', 'gold');
			},
			// cursorAt: { left: Math.floor(this.width / 2), top: Math.floor(this.height / 2) },
			// start:function(){$(this).stop(true,true)},
			revert: 'invalid',
			start:function(){
				$(this).stop(true,true);
			},
			stop: function( event, ui ) {
				$(this).css('background', 'transparent');
			},
			stack: ".dragWord"
		});

		$('.dropWord').each(function() {
			var dropTarget = $(this);
			var answer_content = dropTarget.attr('data-answer-content');
			var answer_class = dropTarget.attr('id');
			answer_class = " " + answer_class;
			var answer_div = $("#answer_id").find("div"); 
			for (var i = 0; i < answer_div.length; i++) {
				if (answer_div[i].getAttribute('data-answer-content') == answer_content) {
					answer_div[i].className += answer_class;
				}
			}
			answer_class = answer_class.replace(" ","");

			$(this).droppable({
				accept: '.'+answer_class,
				drop: function(event, ui) {
					/* place draggable element at the middle of drop target */
					var dropTarget = $(this);
					dropTarget.css('width', ui.draggable.css('width'));

					ui.draggable.position({
						my: "center",
						at: "center",
						of: dropTarget,
						using: function(pos) {
							$(this).animate(pos, 200, "linear");
							setTimeout(function() {
								ui.draggable.css('background', 'initial');
							}, 200);
						}
					});
					

					var answerText = ui.draggable.attr('data-answer-content');
					dropTarget.text(answerText);
					dropTarget.attr("class", "sqr");
					ui.draggable.remove();
					rightAnswerCnt++;

					if (checkAnswer(elementData , rightAnswerCnt)) {
						countdown.stop();
						showResult();
					}

					$('.dropWord').each(function() {
						rePosition($(this), $(this).data('curDrag'));
					})
				}
			});
		})
		
	}


	function rePosition(drop, drag) {
		/* change position of draggable element along with drop target */
		if (drop.data('curDrag')) {
			drag.position({
				my: "center",
				at: "center",
				of: drop,
				using: function(pos) {
					$(this).animate(pos, 0, "linear");
				}
			});
		}
	}
</script>
@stop