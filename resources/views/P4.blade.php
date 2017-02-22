@extends('layout')

@section('title')
<h1 style="font-size: 400%" align="center">- Bài 4: Nghe và tìm câu đúng</h1>

<hr>


<script langauge="JavaScript">
	var checkOrder = new Array();
	var questionList = <?php echo json_encode($dummy); ?>;
	function chooseOrder(element){
			document.getElementById('right').style.opacity=0;
			document.getElementById('wrong').style.opacity=0;
		var questionId = element.name;
		checkOrder.push(questionId);
		var index = checkOrder.indexOf(questionId);
		var questionOrder;
		for (var i = 0; i < questionList.length; i++) {
			if (i == questionId ) {
				questionOrder = questionList[i]['order'];
			}
		}

		if (questionOrder.localeCompare(index) == 0) {
			document.getElementById('right').style.opacity=1;
			element.setAttribute('disabled', 'disabled');
			if (index == questionList.length-1 ) {
				window.alert("Bạn đã hoàn thành bài tập rồi");
			}
		}else{
			document.getElementById('wrong').style.opacity=1;
			checkOrder.splice(index,1);
		}

	}

</script>
@stop

@section('content1')
<div class="row">
	<div class="col-sm-9 col-md-6 col-lg-8">
		<table  class="table table-hover"  align="center">
			@foreach ($dummy as $question)
			<tr>
				<td>{{$question->answer}}</td>
				<td><button type="button" name="{{ $question->id }}"  onclick="javascript: chooseOrder(this)">Chose this</button></td>
			</tr>
			@endforeach
		</table>
	</div>
	<div class="col-sm-3 col-md-6 col-lg-4"><audio controls>
			<source src="{{ URL::asset('P4_audio/test.mp3') }}" type="audio/mpeg">
				Your browser does not support the audio element.
			</audio>
		</div>
	</div>
	<div class="row">
		<div id="right" class="img_right col-sm-6 col-md-6 col-lg-6" ></div>
		<div id="wrong" class="img_wrong col-sm-6 col-md-6 col-lg-6" ></div>
	</div>
	@stop