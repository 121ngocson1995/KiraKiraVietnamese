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
	.blank-sqr{
		border: 1px solid;
		border-radius: 9px;
		width: 100px;
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
			initDroppable();
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
					dialogNode.setAttribute('id',dialogline[j]['lineNo']+','+k);
					dialogNode.setAttribute('class','blank-sqr dropWord');
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
					node.setAttribute('class', 'dragWord ui-state-default');
					node.setAttribute('id', (dialogNow)+','+dialogAnswer[i]['lineNo']+','+j);
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

	// function allowDrop(event){
	// 	event.preventDefault();
	// }

	// function drag(event) {
	// 	event.dataTransfer.setData("Text", event.target.getAttribute("id"));
	// 	document.documentElement.scrollTop = document.documentElement.scrollTop + scrollSpeed;
	// }

	// function drop(element, event) {
	// 	event.preventDefault();
	// 	var targetId = event.dataTransfer.getData("Text");
	// 	var answerText = document.getElementById(targetId).innerHTML;
	// 	var data = element.getAttribute('id').split(',');
	// 	var lineNo = data[0];
	// 	var answerOrder = data[1];
	// 	var rightAnswer;

	// 	for (var i = 0; i < elementData.length; i++) {
	// 		if (elementData[i]['dialogNo'] == dialogNow && elementData[i]['lineNo'] == lineNo ) {
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
		var dialogAnswer = new Array();
		for (i=0; i < elementData.length ; i++) { 
			if (elementData[i]['dialogNo'] == dialogNow) {
				dialogAnswer.push(elementData[i]);
			}
		}

		$('.blank-sqr').each(function(){
			var data = $(this).attr('id').split(',');
			var notChoose_id = dialogNow+","+data[0]+","+data[1];

			$(this).text(dialogAnswer[data[0]]['answer'][data[1]]);
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
		$("#answer_id").find("div").removeAttr("draggable");
		$('#btn-Next').show();
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
		<div id="0,{{$dialogAnswer[$i]->lineNo}},{{$j}}"  class="dragWord ui-state-default">{{$dialogAnswer[$i]->answer[$j]}}</div>
		@endif
		@endfor	
		@endfor
	</div>
	<div class="row" style="position: relative;">
		<div id="content_id" class="col-sm-6 col-md-6 col-lg-6">
			@for ($i = 0; $i < count($elementData) ; $i++)
			@if ($elementData[$i]->dialogNo == 0)
			@php
			$curline = explode('*', $elementData[$i]->line);
			$index = 0;
			@endphp
			<div style="font-size: 25px; padding: 15px">
				@for ($j = 0; $j < count($curline) ; $j++)
				@if ($index != count($curline)-1)
				{{$curline[$j]}}<div id="{{$elementData[$i]->lineNo}},{{$j}}" class="blank-sqr dropWord"></div>
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
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js" type="text/javascript"></script>    
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/jquery-ui.min.js"></script>
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
	var correctNo = 0;
	var totalQuestion = 0;

	window.onresize = function() {
		$('.dropWord').each(function() {
			rePosition($(this), $(this).data('curDrag'));
		});
	}


	function initDroppable() {
		$(".dragWord").draggable({
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
			$(this).droppable({

				accept:function(element) { 
					var dropTarget = $(this);
					var data = dropTarget.attr('id').split(',');
					var lineNo = data[0];
					var answerOrder = data[1];
					var rightAnswer;

					for (var i = 0; i < elementData.length; i++) {
						if (elementData[i]['dialogNo'] == dialogNow && elementData[i]['lineNo'] == lineNo ) {
							rightAnswer = elementData[i]['answer'];
						}
					}
					if(element.text() == rightAnswer[answerOrder]){ 
						return true;
					}
				},

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

					var targetId = ui.draggable.attr('id');
					var answerText = document.getElementById(targetId).innerHTML;
					
					dropTarget.text(answerText);
					dropTarget.attr("class", "sqr");
					document.getElementById(targetId).remove();
					rightAnswerCnt++;

					if (checkAnswer(elementData , rightAnswerCnt)) {
						$('#btn-Next').show();
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

	$( function() {
		$( "#draggable, #draggable-nonvalid" ).draggable();
		$( "#droppable" ).droppable({
			accept: "#draggable",
			classes: {
				"ui-droppable-active": "ui-state-active",
				"ui-droppable-hover": "ui-state-hover"
			},
			drop: function( event, ui ) {
				$( this )
				.addClass( "ui-state-highlight" )
				.find( "p" )
				.html( "Dropped!" );
			}
		});
	} );
</script>
@stop