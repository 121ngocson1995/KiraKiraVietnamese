@extends('activities.layout.activityLayout')

@section('actContent')

<hr>

<style type="text/css">
	body {
		background: url({{asset('img/P8/seaBackGround.svg')}}) no-repeat center bottom fixed;
		background-size: cover;
		text-decoration-color: white;
	}
	.flexContainer p {
		position: absolute;
		width: 100%;
		color: #30ccff;
		top: 50%;
		left: 50%;
		transform: translate(-50%,-50%);
		z-index: 1;
		color: mediumblue;
	}
/*	.dragWord {
		border-radius: 9px;
		border: 1px solid black;
		padding: 6px 15px;
		margin: 1px 5px;
		border-color: black;
		font-size: 25px;
		color: black;
		transition: background 0.8s;
		display: inline-block;
	}*/
	.dragWord:hover {
		cursor: pointer;
	}
	#btn-group{
		position: relative;
		left: 45%;
	}
	#content_id{
		padding-left: 2%;
		color: mediumblue;
		text-align: left;
	}
/*	#answer_id{
		text-align: center;
		width: auto;
		padding: 10px;
		height: auto;
		background-color:transparent;
	}*/
	.blank-sqr{
		/*border: 1px solid;*/
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
		background-color:#30ff30;
		display: inline-block;
		font-weight: 500;
		transition: 1s;
	}
	.btn,.btn[disabled]{
		margin: 10px;
		border: 2px solid;
		border-radius: 30px;
		width: 80px;
		height: 40px;
		background-color: white;
		color: cornflowerblue;
		opacity: 1;
	}
	.btn:hover,.btn[disabled]:hover{
		background-color: cornflowerblue;
		color: white;
	}
	#wordGroup {
		/*		overflow-y: scroll;*/
		padding-top: 20px;
	}
	.notChoose-sqr{
		height: calc(100% + 10px);
		text-align: center;
		border-radius: 9px;
		background-color:#ff6666;
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
		while (document.getElementById("wordGroup").firstChild) {
			document.getElementById("wordGroup").removeChild(document.getElementById("wordGroup").firstChild);
		}
		editContent(elementData, dialogNow);
		editAnswer(elementData, dialogNow);
		editButtonGr(dialogCnt, dialogNow);
		if(countdown)
			countdown.stop();
		$("#countdown").empty();
		countdown = $("#countdown").countdown360({
			radius      : 80,
			seconds     : 60,
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

		//checkQuestionDone() 

		if (questionDone) {
			$("#countdown").empty();
			while (document.getElementById("content_id").firstChild) {
				document.getElementById("content_id").removeChild(document.getElementById("content_id").firstChild);
			}
			while (document.getElementById("wordGroup").firstChild) {
				document.getElementById("wordGroup").removeChild(document.getElementById("wordGroup").firstChild);
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
				node.setAttribute('style', 'font-size: 1.0em; padding: 15px');	
				textNode = document.createTextNode(line);
				node.appendChild(textNode);
				document.getElementById("content_id").appendChild(node);
			} 
			checkQuestion = false;
			//showAnswer();
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
			node.setAttribute('style', 'font-size: 1.0em; padding: 15px');
			curline = dialogline[j]['line'].split("*");
			var index = 0;
			for (var k = 0; k < curline.length; k++) {
				if (index != curline.length-1) {
					var dialogNode = document.createElement("div");
					textNode = document.createTextNode(curline[k]);
					dialogNode.setAttribute('id',"d"+dialogNow+"line"+j+"question"+k);
					dialogNode.setAttribute('data-answer-content', dialogline[j]['answer'][k]);
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
					var node_wordSpan = document.createElement("div");
					node_wordSpan.setAttribute('class', 'wordSpan dragWord');
					node_wordSpan.setAttribute('id', "d"+dialogNow+"line"+i+"answer"+j);
					node_wordSpan.setAttribute('data-answer-content', dialogAnswer[i]['answer'][j]);
					node_wordSpan.setAttribute('style', "display: inline-block;");

					var node_flexContainer = document.createElement("div");
					node_flexContainer.setAttribute('class', 'flexContainer');
					node_flexContainer.setAttribute('style', "display: flex;");

					var node_p = document.createElement("p");
					node_p.setAttribute('class', 'tbn word ui-state-default');
					node_p.setAttribute('style', " opacity: 0; font-size: 1.0em;");

					var textnode = document.createTextNode(dialogAnswer[i]['answer'][j]);

					node_p.appendChild(textnode);

					var node_btnBg = document.createElement("div");
					node_btnBg.setAttribute("class", "btnBg");

					var node_img = document.createElement("img");
					node_img.setAttribute("class", "wordCloud");
					node_img.setAttribute('style', " opacity: 0; width: 60%;");
					node_img.setAttribute('src', "{{ asset('img/P8/word.svg') }}");
					node_img.setAttribute('alt', "start button");

					node_btnBg.appendChild(node_img);
					node_flexContainer.appendChild(node_btnBg);
					node_flexContainer.appendChild(node_p);
					node_wordSpan.appendChild(node_flexContainer);
					document.getElementById("wordGroup").appendChild(node_wordSpan);
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
		result.setAttribute('style','font-size:25px;');
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
<div id="btn-group">
	@for ($i = 0; $i < count($dialogCnt); $i++)
	<button id="{{$i}}" type="button" 
	@if ($i > 0)
	disabled="true" 
	@endif class="btn btn-primary" autocomplete="off" >D{{$i+1}}</button>
	@endfor
</div>
<br>
<div id="content" style="padding: 0 5%;">
	<div id="wordGroup" class="col-xs-4" style=" text-align: center;">
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
		<div class="wordSpan dragWord " id="d0line{{$i}}answer{{$j}}" data-answer-content="{{$dialogAnswer[$i]->answer[$j]}}" style="display: inline-block;">
			<div class="flexContainer" style="display: flex">
				<p class="tbn word ui-state-default"  style=" opacity: 0; font-size: 1.0em;">{{$dialogAnswer[$i]->answer[$j]}}</p>
				<div class="btnBg">
					<img class="wordCloud" style="opacity: 0; width: 45%;" src="{{ asset('img/P8/word.svg') }}" alt="start button">
				</div>
			</div>
		</div>
		@endif
		@endfor	
		@endfor
	</div>
	<div id="content_id" class="col-xs-5" style=" text-align:left;" >
		@for ($i = 0; $i < count($elementData) ; $i++)
		@if ($elementData[$i]->dialogNo == 0)
		@php
		$curline = explode('*', $elementData[$i]->line);
		$index = 0;
		@endphp
		<div style="font-size: 1.0em; padding: 15px">
			@for ($j = 0; $j < count($curline) ; $j++)
			@if ($index != count($curline)-1)
			{{$curline[$j]}}<div id="d0line{{$i}}question{{$j}}" data-answer-content="{{$elementData[$i]->answer[$j]}}" class="blank-sqr dropWord"></div>
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
	<div class="col-xs-3" style="text-align: center; vertical-align: middle; float: right; margin-bottom: 20px " >
		<div id="countdown" ></div>
		<div id="result" style="font-size: 45px text-align: center; "></div>
	</div>
</div>
{{-- <button type="button" id="btn-Next" class="btn btn-primary" style=" display: none; "  onclick="JavaScript: next()">Next</button> --}}
</div>


<script src="{{ asset('js/jquery.countdown360.js') }}" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
	countdown = $("#countdown").countdown360({
		radius      : 100,
		seconds     : 60,
		fontColor   : '#FFFFFF',
		autostart   : false,
		onComplete  : function (){
			showResult();
		}
	});

	window.onload = function() {
		initDroppable();
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
		// $('.dropWord').each(function() {
		// 	console.log($(this));
		// });
		TweenMax.staggerFrom('.wordSpan', 0.5, {scale:0, delay:0.5}, 0.2);
		TweenMax.staggerTo('.wordSpan', 0.5, {opacity:1,delay:0.5}, 0.2);
		$('.tbn').css('opacity','1');
		$('.wordCloud').css('opacity','1');
		$(".dragWord").draggable({
			// scroll: true,
			// scrollSensitivity: 20,
			// scrollSpeed: 20,
			// cursor: "crosshair", cursorAt: { top: 50, left: 50 },
			create: function(){
				$(this).data('position',$(this).position());
			},
			cursor:'move',
			
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
			var answer_node = $("#wordGroup").find(".dragWord"); 
			for (var i = 0; i < answer_node.length; i++) {
				if (answer_node[i].getAttribute('data-answer-content') == answer_content) {
					answer_node[i].className += answer_class;
				}
			}
			answer_class = answer_class.replace(" ","");

			$(this).droppable({
				accept: '.'+answer_class,
				drop: function(event, ui) {
					/* place draggable element at the middle of drop target */
					var dropTarget = $(this);
					dropTarget.css('width', 'auto');
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
					dropTarget.droppable('destroy');
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

@section('actDescription-vi')
Lựa chọn từ thích hợp rồi kéo thả vào chỗ trống.
@stop

@section('actDescription-en')
Find the appropriate word, hold the word and move it to the appropriate space.
@stop