@extends('activities.layout.activityLayout')

@section('header-more')
<script src="{{ asset('js/imagesloaded.pkgd.min.js') }}"></script>
<style type="text/css">
	.btn-Choose{
		cursor: pointer;
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

@section('actContent')
<div style="text-align: center; height: 70px">
	<div id="container" style="display: inline-block;"></div>
</div>
<div class="row">
	<div  class="col-sm-9 col-md-6 col-lg-8">
		<table id="content_id" class="table table-hover table_content "  align="center">
			@for ($i = 0; $i < count($elementData) ; $i++)
			<tr>
				<td><i data-id="{{$elementData[$i]['id']}}" disable="true" class="fa fa-hand-o-right fa-2x btn-Choose btn-notChosen" aria-hidden="true" ></i></td>
				<td><span id="sentence{{$elementData[$i]['id']}}">{{$elementData[$i]['sentence']}}</span></td>				
			</tr>
			@endfor
		</table>
		<div style="text-align: center; position: relative;	text-align: center;	left: 25%;">
			<i id="btnStart" class="fa fa-play fa-4x" aria-hidden="true"></i>
			<i id="btnRestart" style="display: none;" class="fa fa-undo fa-4x" aria-hidden="true"></i>
			<span id="timer" style="font-size: 70px"></span>
			<span id="addedTime" style="font-size: 40px; color: grey"></span>
			<div id="sampleGroup"></div>
			<audio id="tick" src="{{ asset('audio/tick.mp3') }}"></audio>
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
	function correctChoice(sentence, icon) {
		$('.fa-times').removeClass("fa-times").addClass("fa-hand-o-right");
		$(sentence).removeClass("notChosen");
		$(sentence).addClass("correctWord");
		$(icon).removeClass("btn-notChosen");
		$(icon).removeClass("fa-hand-o-right");
		$(icon).addClass("fa-check");
		$(icon).unbind();
		$(icon).css('cursor', 'not-allowed');
		$(".btn-notChosen").unbind();
		$(".wrongWord").removeClass("wrongWord").addClass("notChosen");
		changeScore('correct', '' + (parseInt(document.getElementById('correct').innerHTML)  + 1));
	}
	function wrongChoice(sentence, icon) {
		$(sentence).removeClass("notChosen");
		$(sentence).addClass("wrongWord");
		$(icon).removeClass("fa-hand-o-right");
		$(icon).addClass("fa fa-times fa-2x");
	}
	$('#btnStart').click(function() {
		start();
		$('#btnStart').unbind();
		});

	function start() {
		chooseIndex = 0;
		if(tlFinalScore) {
			tlFinalScore.seek(0).pause();
		}
		$("#content_id").find("i").attr('class', 'fa fa-hand-o-right fa-2x btn-Choose btn-notChosen');
		$("#content_id").find("span").removeClass("wrongWord").removeClass("correctWord").addClass("notChosen");
		initScore();
		playSample(0);
		startProgress();
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
		console.log(to);
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
		$('.btn-notChosen').click(function() {
			if ('audio' + $(this).attr("data-id") == playingSample) {
				correctChoice(document.getElementById("sentence"+$(this).attr("data-id")),this);
			} else {
				wrongChoice(document.getElementById("sentence"+$(this).attr("data-id")),this);
			}
		});
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
		$(".fa-hand-o-right").removeClass("fa-hand-o-right").addClass("fa-times");
		var scoreText = $('#scoreText');
		tlFinalScore = new TimelineMax();
		tlFinalScore.to(scoreText, 2, {text:"Final score: "})
		.to(scoreText.parent(), 2, {scale:1.6, ease:Power2.easeOut})
		.to(scoreText.parent(), 0.4, {scale:1.4, ease:Power2.easeOut});
		$('#btnRestart').click(function() {
			start();
		});
		$("#btnRestart").show();
	}
</script>

<script>

	var wordTime = 0;
	var wordNo = 0;


	var sampleGroup = document.getElementById('sampleGroup');
	for (var i = 0; i < soundList.length; i++) {
		var audioFile = document.createElement("audio");
		// audioFile.src = elementData[i].audio;
		audioFile.id = 'audio' + soundList[i]['id'];
		audioFile.innerHTML  = "<source src='" + "{{ URL::asset('') }}" + soundList[i]['audio']+"' type='audio/mp3'>";
		sampleGroup.appendChild(audioFile);


		if (!isNaN(audioFile.duration)) {
			checkTickLoad(this.duration);
		} else {
			audioFile.addEventListener('loadedmetadata', function() {
				checkTickLoad(this.duration);
			});
		}
	}

	function checkTickLoad(duration) {
		wordNo++;
		wordTime += duration;

		if (wordNo == soundList.length) {
			var tick = document.getElementById('tick');
			if (!isNaN(tick.duration)) {
				buildProgressBar(wordTime + wordNo * tick.duration);
			} else {
				tick.addEventListener('loadedmetadata', function() {
					buildProgressBar(wordTime + wordNo * this.duration);
				});
			}
		}
	}

	function buildProgressBar(totalTime) {
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
	}
	// imagesLoaded( document.getElementById('btnRestart'), function() {
	// 	var tl = new TimelineMax();
	// 	tl.to('#btnRestart', 30, {rotation:500, repeat:-1, ease: Power0.easeNone});
	// });
</script>
@stop