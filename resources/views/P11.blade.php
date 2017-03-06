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
		/*width: 143px;*/
		min-width: 10em;
	}
	#sortable1 li, #sortable2 li {
		margin: 5px;
		padding: 5px; 
		font-size: 1.2em; 
		width: 10em; 
	}
	.ui-state-disabled, .ui-state-disabled:hover, .ui-state-disabled:active {
		cursor: default;
		color: white;
		background: green;
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
			connectWith: "ul",
			items: "li:not(.ui-state-disabled)",
			revert: 200
		});

		// $("#sortable1").sortable({
		// 	items: "li:not(.ui-state-disabled)"
		// });

		$( "#sortable1, #sortable2" ).disableSelection();

		$( "#sortable2" ).on( "sortupdate", function( event, ui ) {
			checkAnswer();
		} );
	} );

	function checkAnswer() {
		var idsInOrder = [];
		var expect = 1;
 		var startIndex = 0;
    	$("ul#sortable2 li").each(function() {
    		idsInOrder.push(parseInt($(this).attr('id')));
    	});

   //  	var equal =true;
   //  	if (idsCorrectOrder.length != idsInOrder.length) {
   //  		equal = false;
   //  	} else {
	  //   	var loop = idsCorrectOrder.length < idsInOrder.length ? idsCorrectOrder.length : idsInOrder.length;
	  //   	for (var i = 0; i <= loop-1; i++) {
			// 	if (idsInOrder[i] != idsCorrectOrder[i]) {
			// 		equal = false;
			// 		break;
			// 	}
			// }
   //  	}

   //  	if (equal == true) {
   //  		idsCorrectOrder.push(parseInt(idsCorrectOrder[idsCorrectOrder.length - 1]) + 1);

   //  		$('#sortable2').children().last().addClass('ui-state-disabled');
   //  		$("#sortable2").sortable({
		 //    	items: "li:not(.ui-state-disabled)"
		 //    });
   //  	} else {
    		
   //  	}

		var end = false;
		if (parseInt(idsInOrder[0]) == 0) {
			$($('#sortable2').children()[0]).addClass('ui-state-disabled');

			for (var i = 1; i < idsInOrder.length; i++) {
				if (i == 0 || parseInt(idsInOrder[i]) == parseInt(idsInOrder[i-1]) + 1) {
					$($('#sortable2').children()[i]).addClass('ui-state-disabled');
				} else {
					break;
				}
			}
		}
		$("#sortable2").sortable({
	    	cancel: ".ui-state-disabled"
	    });
		
	}
</script>

@stop

@section('description')
	In this activity, drag and drop sentences from the left box to the right one so that they makes a dialog.
@stop