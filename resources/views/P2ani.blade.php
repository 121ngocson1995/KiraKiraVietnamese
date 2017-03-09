@extends('layouts.app')

@section('content')

<div style="text-align: center; height: 70px">
	<div id="container" style="display: inline-block;"></div>
</div>

<div id="wordGroup" style="text-align: center; padding-bottom: 20px;">
	@foreach ($dummy as $dummyValue)
		<span style="padding: 0px 2px;">
			<button autocomplete="off" id="{{ $dummyValue->correctOrder }}" class="btn playWord notChosen" style="font-size: 18px; padding: 2px 10px" onclick="chooseWord(this)" disabled="">{{ $dummyValue->word }}</button>
		</span>
	@endforeach
</div>

<div style="text-align: center;">
	<button autocomplete="off" id="btnStart" onclick="start()">Start</button>
	<button autocomplete="off" id="btnRestart" onclick="start()" style="display: none;">Redo</button>
	<span id="timer" style="font-size: 70px"></span>
	<span id="addedTime" style="font-size: 40px; color: grey"></span>
	<audio id="sample" src="{{ $dummy[0]->audio }}"></audio>
</div>

<script>
	var chosenOrder = 0;
	var docBar;

	function chooseWord(button) {
		if (parseInt($(button).attr("id")) == chosenOrder) {
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
		chosenOrder++;
	}

	function wrongChoice(button) {
		$(button).removeClass("notChosen");
		$(button).addClass("wrongWord");
	}

	function start() {
		chosenOrder = 0;

		$("#wordGroup").find("button").prop("disabled", false);
		$("#wordGroup").find("button").removeClass("wrongWord").removeClass("correctWord").addClass("notChosen");

		playSample();
		startProgress();

		$("#btnStart").prop("disabled", true);
		$("#btnRestart").prop("disabled", true);
		$("#btnStart").hide();
		$("#btnRestart").hide();
		startCountdown();
	}

	function playSample() {
		$('#sample')[0].play();
	}

	function startProgress() {
		if (docBar) {
			docBar.destroy();
		}

		var bar = new ProgressBar.Line("#container", {
			strokeWidth: 4,
			duration: $("#sample")[0].duration * 1000,
			color: '#FFEA82',
			trailColor: '#eee',
			trailWidth: 1,
			svgStyle: {width: '100%', height: '100%'},
			from: {color: '#1affa3'},
			to: {color: '#ED6A5A'},
			step: (state, bar) => {
				bar.path.setAttribute('stroke', state.color);
			}
		});

		docBar = bar;

		bar.animate(1.0);
	}

	function startCountdown() {
		var count = $("#sample")[0].duration * 100;
		count = parseInt(count.toFixed(0));
	    
	    var counter = setInterval(function () {
	    	if (count <= 0)
	        {
	            clearInterval(counter);

	            startAddedTime();

	            return;
	         }
	         count--;
	         document.getElementById("timer").innerHTML=(count /100).toFixed(1);
	    }, 10);
	}

	function startAddedTime() {
		var count = 500;
	    
	    var counter = setInterval(function () {
	    	if (count <= 0)
	        {
	            clearInterval(counter);

	            showResult();

	            return;
	         }
	         count--;
	         document.getElementById("addedTime").innerHTML="+" + (count /100).toFixed(1);
	    }, 10);
	}

	function showResult() {
		document.getElementById("timer").innerHTML = "";
        document.getElementById("addedTime").innerHTML = "";
		$(".notChosen").removeClass("notChosen").addClass("wrongWord");
		$("#wordGroup").find("button").prop("disabled", true);
		$("#btnRestart").prop("disabled", false);
		$("#btnRestart").show();
	}
</script>
<script src="{{ asset('js/progressbar.js') }}"></script>

@stop()