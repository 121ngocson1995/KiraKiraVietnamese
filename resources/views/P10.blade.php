@extends('layouts.app')

@section('content')
<style>
	.fullscreenDiv {
		width: 100%;
		height: auto;
		bottom: 0px;
		top: 0px;
		left: 0;
		position: absolute;
	}
	#sortable {
		position: fixed;
		top: 42%;
		left: 50%;
		/* bring your own prefixes */
		transform: translate(-50%, -50%);
	}
	#result {
		position: fixed;
		top: 42%;
		left: 50%;
		/* bring your own prefixes */
		transform: translate(-50%, -50%);
		display: none;
	}
	html>body #sortable span {
		padding: 6px 15px;
	}
	.ui-state-highlight {
		padding: 6px 15px;
	}
	.dragWord {
		border-radius: 4px;
		border: 1px solid transparent;
		padding: 6px 15px;
		margin: 0px 5px;
		background: #e6e6e6;
		font-size: 30px;
		transition: background 0.6s;
	}
	.dragWord:hover {
		cursor: move;
	}
	.dragWord:active {
		background: gold;
	}
	.result {
		background-color: transparent;
		padding: 10px;
		border: none;
		border-bottom: solid 2px #cccccc;
		text-align: center;
		font-size: 60px;
		transition: color 0.4s, border-bottom 0.4s;
		cursor: default;
	}
	.result:hover {
		outline: none;
		color: cornflowerblue;
		border-bottom: solid 2px #6495ed;
	}
</style>

<div class='fullscreenDiv'>
	<div id="sortable">
		@foreach ($dummy as $dummyValue)
			<span id="{{ $dummyValue->correctOrder }}" class="dragWord ui-state-default">{{ $dummyValue->word }}</span>
		@endforeach
	</div>
	<div id="result" style="text-align: center; text-align-last: center;"></div>
</div>

<script>
	var sentence = [];

	$( function() {
		$( "#sortable" ).sortable({
			// placeholder: "ui-state-highlight"
		});
		$( "#sortable" ).disableSelection();
		$( "#sortable" ).on( "sortupdate", function( event, ui ) {
			checkAnswer();
		} );
	} );


	function checkAnswer() {
		var order = [];
		sentence = [];

		for (var i = 0; i < $('.dragWord').length; i++) {
			order.push($('.dragWord')[i].id);
			sentence.push($('.dragWord')[i].innerHTML);
		}

		var allCorrect = true;
		for (var i = 1; i < order.length; i++) {
			if (parseInt(order[i]) != parseInt(order[i-1]) + 1) {
				allCorrect = false;
			}
		}

		if (allCorrect == true) {
			showResult();
		}
	}

	function showResult() {
		var result = document.createElement("span");
		result.className = 'result';
		result.innerHTML = mergeWord();
		document.getElementById("result").appendChild(result);
		$('#sortable').fadeOut(600, function () {
			$('#result').fadeIn(600);
		});
	}

	function mergeWord() {
		var result = '';
		var lastIndex = sentence.length - 1;

		for (var i = 0; i <= lastIndex; i++) {
			result += sentence[i];

			if (i < lastIndex) {
				result += ' ';
			} else {
				result += '.';
			}
		}

		result = toSentenceCase(result);

		return result;
	}

	function toSentenceCase(sentence) {
		var fixedSentence = "";
		var n=sentence.split(".");

		for(i=0;i<n.length;i++) {
			var spaceput = "";
			var spaceCount = n[i].replace(/^(\s*).*$/,"$1").length;

			n[i]=n[i].replace(/^\s+/,"");

			var newstring = n[i].charAt(n[i]).toUpperCase() + n[i].slice(1);

			for(j = 0; j < spaceCount; j++)
				spaceput = spaceput +" ";

			fixedSentence = fixedSentence+spaceput+newstring + '.';
		}

		fixedSentence=fixedSentence.substring(0, fixedSentence.length - 1);

		return fixedSentence;
	}
</script>

@stop