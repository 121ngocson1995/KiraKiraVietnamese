@extends('layouts.app')

@section('content')
<style>
	.dragSentence {
		border-radius: 4px;
		border: 1px solid transparent;
		padding: 6px 15px;
		margin: 0px 5px;
		background: #b1b1b1;
		font-size: 15px;
		transition: background 0.6s;
	}
	.dragSentence:hover {
		cursor: move;
	}
	.dragSentence:active {
		background: gold;
	}
	#sortable1, #sortable2 {
		list-style-type: none;
		margin: 0;
		float: left;
		margin-right: 10px;
		background: #eee;
		padding: 5px;
		width: 143px;
	}
	#sortable1 li, #sortable2 li {
		margin: 5px;
		padding: 5px; 
		font-size: 1.2em; 
		width: 120px; 
	}

</style>


<ul id="sortable1" class="droptrue">
	@foreach ($dummy as $dummyValue)
		<li id="{{ $dummyValue->correctOrder }}" class="dragSentence ui-state-default">{{ $dummyValue->sentence }}</li>
	@endforeach
</ul>

<ul id="sortable2" class="droptrue">
</ul>


<br style="clear:both">

<script>
	var idsCorrectOrder = [];

	idsCorrectOrder.push(0);

	var sentence = [];
	$( function() {
		$( "ul.droptrue" ).sortable({
			connectWith: "ul"
		});

		$( "ul.dropfalse" ).sortable({
			connectWith: "ul",
			dropOnEmpty: false
		});

		$( "#sortable1, #sortable2" ).disableSelection();

		$( "#sortable2" ).on( "sortupdate", function( event, ui ) {
			checkAnswer();
		} );
	} );

	function checkAnswer() {
		var idsInOrder = [];
		var expect = 1;
    	$("ul#sortable2 li").each(function() {
    		idsInOrder.push(parseInt($(this).attr('id')));
    	});

    	var equal =true;
    	if (idsCorrectOrder.length != idsInOrder.length) {
    		equal = false;
    	} else {
	    	var loop = idsCorrectOrder.length < idsInOrder.length ? idsCorrectOrder.length : idsInOrder.length;
	    	for (var i = 0; i <= loop-1; i++) {
				if (idsInOrder[i] != idsCorrectOrder[i]) {
					equal = false;
					break;
				}
			}
    	}

    	if (equal == true) {
    		idsCorrectOrder.push(parseInt(idsCorrectOrder[idsCorrectOrder.length - 1]) + 1);
    		showResult();
    	} else {
    		
    	}
	}

	function showResult() {
		
	}
</script>

@stop