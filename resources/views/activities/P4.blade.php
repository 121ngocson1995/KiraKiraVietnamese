		@extends('layout')

		@section('title')
		<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.19.1/TweenMax.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.13.2/plugins/TextPlugin.min.js"></script>
		<h1 style="font-size: 400%" align="center">- Bài 4: Nghe và tìm câu đúng</h1>
		<style type="text/css">
			.btn-Choose{
				border: 1px solid #0e0101;
				border-radius: 100%;
				width: 20px;
				height: 20px;
				background-color: #e88b8b;
			}

			body {

		/*background: url(http://localhost:8000/img/testAnimate/p2bg.svg) no-repeat center bottom fixed;
		background-size: cover;*/
	}
	#scoreText {
		font-size: 2em;
	}
	#correct {
		color: blue;
		font-size: 5em;
	}
	#total {
		color: red;
		font-size: 2em;
	}
	.table_content{
		position: relative;
		width: auto;
		margin-bottom: 22px;
		left: 25%;
		padding: 20px;
	}
</style>
<hr>

<script langauge="JavaScript">
	var checkOrder = new Array();
	var questionList = <?php echo json_encode($elementData); ?>;
	var soundList = <?php echo json_encode($soundArr); ?>;
	var correctOrd = new Array();
	for (var i = 0; i < soundList.length; i++) {
		correctOrd.push(soundList[i]['id']);
	}
	var chooseIndex = 0;
	// function chooseOrder(element){
	// 	document.getElementById('right').style.opacity=0;
	// 	document.getElementById('wrong').style.opacity=0;
	// 	var questionId = element.name;
	// 	checkOrder.push(questionId);
	// 	var index = checkOrder.indexOf(questionId);
	// 	var questionOrder;
	// 	for (var i = 0; i < questionList.length; i++) {
	// 		if (i == questionId ) {
	// 			questionOrder = questionList[i]['sentenceOrder'];
	// 		}
	// 	}
	// 	if (questionOrder == index.toString()) {
	// 		document.getElementById('right').style.opacity=1;
	// 		element.setAttribute('disabled', 'disabled');
	// 		if (index == questionList.length-1 ) {
	// 			window.alert("Bạn đã hoàn thành bài tập rồi");
	// 		}
	// 		element.innerHTML = parseInt(questionOrder)+1;
	// 	}else{
	// 		document.getElementById('wrong').style.opacity=1;
	// 		checkOrder.splice(index,1);
	// 	}
	// }

</script>
@stop

@section('content1')
<div style="text-align: center; height: 70px">
	<div id="container" style="display: inline-block;"></div>
</div>
<div class="row">
	<div  class="col-sm-9 col-md-6 col-lg-8">
		<table id="content_id" class="table table-hover table_content "  align="center">
			@for ($i = 0; $i < count($elementData) ; $i++)
			<tr>
				<td><button autocomplete="off" class="btn-Choose btn-notChosen" disabled="true" type="button" id="{{$elementData[$i]['id']}}"  onclick="chooseWord(this)"></button></td>
				<td><span id="sentence{{$elementData[$i]['id']}}">{{$elementData[$i]['sentence']}}</span></td>				
			</tr>
			@endfor
		</table>
		<div style="text-align: center; position: relative;	text-align: center;	left: 25%;">
			<button autocomplete="off" id="btnStart" onclick="start()">Start</button>
			<button autocomplete="off" id="btnRestart" onclick="start()" style="display: none;">Redo</button>
			<span id="timer" style="font-size: 70px"></span>
			<span id="addedTime" style="font-size: 40px; color: grey"></span>
			<div id="sampleGroup"></div>
			<audio id="tick" src="{{ asset('audio/tick.wav') }}"></audio>
		</div>
		<div id="result" style="text-align: center; display: none;">
			<span id="scoreText">Score: </span>
			<span id="correct"></span>
			<span id="total"></span>
		</div>
	</div>
	

	<div class="col-sm-3 col-md-6 col-lg-4"></div>
</div>
<div id="audio_content"></div>


<script src="{{ asset('js/progressbar.js') }}"></script>
<script>
	var docBar;
	var playingSample = -1;
	var tlFinalScore;

	function chooseWord(button) {
		if ('audio' + $(button).attr("id") == playingSample) {
			correctChoice(document.getElementById("sentence"+$(button).attr("id")),button);
		} else {
			wrongChoice(document.getElementById("sentence"+$(button).attr("id")));
		}
	}

	function correctChoice(sentence, button) {
		$(sentence).removeClass("notChosen");
		$(sentence).addClass("correctWord");
		$(button).removeClass("btn-notChosen");
		$(button).prop("disabled", true);
		$(".btn-notChosen").prop("disabled", true);
		$(".wrongWord").removeClass("wrongWord").addClass("notChosen");
		changeScore('correct', '' + (parseInt(document.getElementById('correct').innerHTML)  + 1));
	}

	function wrongChoice(sentence) {
		$(sentence).removeClass("notChosen");
		$(sentence).addClass("wrongWord");
	}

	function start() {
		chooseIndex = 0;
		if(tlFinalScore) {
			tlFinalScore.seek(0).pause();
		}


		$("#content_id").find("button").prop("disabled", false);
		$("#content_id").find("span").removeClass("wrongWord").removeClass("correctWord").addClass("notChosen");

		initScore();
		playSample(0);
		startProgress();

		$("#btnStart").prop("disabled", true);
		$("#btnRestart").prop("disabled", true);
		$("#btnStart").hide();
		$("#btnRestart").hide();
		// startCountdown();
	}

	function initScore() {
		$('#result').show();
		document.getElementById('scoreText').innerHTML = 'Score: ';
		document.getElementById('correct').innerHTML = '0';
		document.getElementById('total').innerHTML = '/0';

		if (docBar) {
			docBar.set(1);
		}
	}

	function changeScore(text, to) {
		var text = $('#'+text);
		var box = text.parent();
		var tl = new TimelineMax();
		tl.to(box, 0.25, {scale:1.4, ease:Power2.easeOut})
		.set(text, {text:to})
		.to(box, 0.25, {scale:1, ease:Power2.easeOut});

	}

	function playSample(index) {
		// cần sửa 
		if(index == $("#sampleGroup audio").length) {
			showResult();
			return;
		}
		$(".btn-notChosen").prop("disabled", false);
		$(".wrongWord").removeClass("wrongWord").addClass("notChosen");
		chooseIndex++;
		$('#sampleGroup').children().eq(index)[0].play();
		playingSample = $('#sampleGroup').children().eq(index)[0].id;
		changeScore('total', '/' + parseInt(index + 1));
		setTimeout(function() {
			$('#tick')[0].play();
			setTimeout(function() {
				playSample(++index);
			}, $('#tick')[0].duration * 1000);
		}, $('#sampleGroup').children().eq(index)[0].duration * 1000);
	}

	function startProgress() {
		if (docBar) {
			docBar.animate(0);
		}
	}
	function showResult() {

		$(".notChosen").removeClass("notChosen").addClass("wrongWord");
		$("#content_id").find("button").prop("disabled", true);
		var scoreText = $('#scoreText');
		tlFinalScore = new TimelineMax();
		tlFinalScore.to(scoreText, 2, {text:"Final score: "})
		.to(scoreText.parent(), 2, {scale:1.6, ease:Power2.easeOut})
		.to(scoreText.parent(), 0.4, {scale:1.4, ease:Power2.easeOut});
		$("#btnRestart").prop("disabled", false);
		$("#btnRestart").show();
		$('#btn-NextAct').show();
	}
</script>

<script>
	var sentenceTime = 0;
	var sentenceNo = 0;
	var sampleGroup = document.getElementById('sampleGroup');

	for (var i = 0; i < soundList.length; i++) {
		var audioFile = document.createElement("audio");
		// audioFile.src = elementData[i].audio;
		audioFile.id = 'audio' + soundList[i]['id'];
		audioFile.innerHTML  = "<source src='" + "{{ URL::asset('') }}" + soundList[i]['audio']+"' type='audio/mp3'>";
		sampleGroup.appendChild(audioFile);

		sentenceNo++;

		if (i != soundList.length - 1) {
			audioFile.addEventListener('loadedmetadata', function() {
				sentenceTime += this.duration;
			});
		} else {
			audioFile.addEventListener('loadedmetadata', function() {
				sentenceTime += this.duration;
				
				var totalTime = sentenceTime + sentenceNo * document.getElementById('tick').duration;

				docBar = new ProgressBar.Line("#container", {
					strokeWidth: 4,
					duration: totalTime * 1000,
					color: '#FFEA82',
					trailColor: '#eee',
					trailWidth: 1,
					svgStyle: {width: '100%', height: '100%'},
					from: {color: '#ED6A5A'},
					to: {color: '#1affa3'},
					step: (state, bar) => {
						bar.path.setAttribute('stroke', state.color);
					}
				});

				docBar.set(1);
			});
		}
	}
	
</script>
@stop