@extends('layouts.app')

@section('content')

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.19.1/TweenMax.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.13.2/plugins/TextPlugin.min.js"></script>

<style>
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
</style>

<div style="text-align: center; height: 70px">
	<div id="container" style="display: inline-block;"></div>
</div>

<div id="wordGroup" style="text-align: center; padding-bottom: 20px;">
	@foreach ($textRender as $text)
		<span style="padding: 0px 2px;">
			<button autocomplete="off" id="{{ $text['id'] }}" class="btn playWord notChosen" style="font-size: 18px; padding: 2px 10px" onclick="chooseWord(this)" disabled="">{{ $text['word'] }}</button>
		</span>
	@endforeach
</div>

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

	// function startCountdown() {
	// 	var count = $("#sample")[0].duration * 100;
	// 	count = parseInt(count.toFixed(0));
	    
	//     var counter = setInterval(function () {
	//     	if (count <= 0)
	//         {
	//             clearInterval(counter);

	//             startAddedTime();

	//             return;
	//         }
	//         count--;
	//         document.getElementById("timer").innerHTML=(count /100).toFixed(1);
	//     }, 10);
	// }

	// function startAddedTime() {
	// 	var count = 500;
	    
	//     var counter = setInterval(function () {
	//     	if (count <= 0)
	//         {
	//             clearInterval(counter);

	//             showResult();

	//             return;
	//          }
	//          count--;
	//          document.getElementById("addedTime").innerHTML="+" + (count /100).toFixed(1);
	//     }, 10);
	// }

	// function showResult() {
	// 	document.getElementById("timer").innerHTML = "";
	// 	document.getElementById("addedTime").innerHTML = "";
	// 	$(".notChosen").removeClass("notChosen").addClass("wrongWord");
	// 	$("#wordGroup").find("button").prop("disabled", true);
	// 	$("#btnRestart").prop("disabled", false);
	// 	$("#btnRestart").show();
	// }

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

@stop()