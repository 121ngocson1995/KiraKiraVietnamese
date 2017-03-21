	@extends('layout')

	@section('title')
	<h1 style="font-size: 400%" align="center">- Bài 4: Nghe và tìm câu đúng</h1>
	<style type="text/css">
		.btn-Choose{
			border: 1px solid #0e0101;
			border-radius: 100%;
			width: 20px;
			height: 20px;
			background-color: #e88b8b;
		}
	</style>
	<hr>

	<script langauge="JavaScript">
		var checkOrder = new Array();
		var questionList = <?php echo json_encode($elementData); ?>;
		function chooseOrder(element){
			document.getElementById('right').style.opacity=0;
			document.getElementById('wrong').style.opacity=0;
			var questionId = element.name;
			checkOrder.push(questionId);
			var index = checkOrder.indexOf(questionId);
			var questionOrder;
			for (var i = 0; i < questionList.length; i++) {
				if (i == questionId ) {
					questionOrder = questionList[i]['sentenceOrder'];
				}
			}
			if (questionOrder == index.toString()) {
				document.getElementById('right').style.opacity=1;
				element.setAttribute('disabled', 'disabled');
				if (index == questionList.length-1 ) {
					window.alert("Bạn đã hoàn thành bài tập rồi");
				}
				element.innerHTML = parseInt(questionOrder)+1;
			}else{
				document.getElementById('wrong').style.opacity=1;
				checkOrder.splice(index,1);
			}
		}

	</script>
	@stop

	@section('content1')
	<div style="text-align: center; height: 70px">
		<div id="container" style="display: inline-block;"></div>
	</div>
	<div class="row">
		<div class="col-sm-9 col-md-6 col-lg-8">
			<table  class="table table-hover"  align="center">
				@for ($i = 0; $i < count($elementData) ; $i++)
				<tr>
					<td><button autocomplete="off" class="btn-Choose" type="button" id="{{$elementData[$i]['id']}}"  onclick="chooseWord(this)"></button></td>
					<td>{{$elementData[$i]['sentence']}}</td>
					
				</tr>
				@endfor
			</table>
		</div>
		<div class="col-sm-3 col-md-6 col-lg-4"><audio controls>
			<div style="text-align: center;">
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
	</div>
	<div class="row">
		<div id="right" class="img_right col-sm-6 col-md-6 col-lg-6" ></div>
		<div id="wrong" class="img_wrong col-sm-6 col-md-6 col-lg-6" ></div>
	</div>
</div>
<script src="{{ asset('js/progressbar.js') }}"></script>
<script>
	var docBar;
	var playingSample = -1;

	function chooseWord(button) {
		if ('audio' + $(button).attr("id") == playingSample) {
			correctChoice(button);
		} else {
			wrongChoice(button);
		}
	}

	function correctChoice(button) {
		$(button).removeClass("notChosen");
		$(button).addClass("correctWord");
		$(button).prop("disabled", true);
		$(".wrongWord").removeClass("wrongWord").addClass("notChosen");
		changeScore('correct', '' + (parseInt(document.getElementById('correct').innerHTML)  + 1));
	}

	function wrongChoice(button) {
		$(button).removeClass("notChosen");
		$(button).addClass("wrongWord");
	}

	function start() {
		chosenOrder = 0;

		$("#wordGroup").find("button").prop("disabled", false);
		$("#wordGroup").find("button").removeClass("wrongWord").removeClass("correctWord").addClass("notChosen");

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
		if(index == $("#sampleGroup audio").length) {
			showResult();
			return;
		}
		$(".wrongWord").removeClass("wrongWord").addClass("notChosen");
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
		$("#wordGroup").find("button").prop("disabled", true);
		$("#btnRestart").prop("disabled", false);
		$("#btnRestart").show();
		var scoreText = $('#scoreText');
		var tl = new TimelineMax();
		tl.to(scoreText, 2, {text:"Final score: "})
		.to(scoreText.parent(), 2, {scale:1.6, ease:Power2.easeOut})
		.to(scoreText.parent(), 0.4, {scale:1.4, ease:Power2.easeOut});
	}
</script>

<script>
	var wordTime = 0;
	var wordNo = 0;

	var elementData = <?php echo json_encode($elementData); ?>;
	var sampleGroup = document.getElementById('sampleGroup');
	for (var i = 0; i < elementData.length; i++) {
		var audioFile = document.createElement("audio");
		// audioFile.src = elementData[i].audio;
		audioFile.id = 'audio' + elementData[i].id;
		audioFile.innerHTML  = "<source src='" + elementData[i].audio + "' type='audio/mp3'>";
		sampleGroup.appendChild(audioFile);

		wordNo++;

		if (i != elementData.length - 1) {
			audioFile.addEventListener('loadedmetadata', function() {
				wordTime += this.duration;
			});
		} else {
			audioFile.addEventListener('loadedmetadata', function() {
				wordTime += this.duration;
				
				var totalTime = wordTime + wordNo * document.getElementById('tick').duration;

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