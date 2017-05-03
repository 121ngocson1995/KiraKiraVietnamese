@extends('userLayout')

@section('content')
<link href="{{ asset('css/fileinput.css') }}" media="all" rel="stylesheet" type="text/css"/>
<link href="{{ asset('themes/explorer/theme.css') }}" media="all" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="{{ asset('css/screens/editP9.css') }}">
<script src="{{ asset('js/fileinput.min.js') }}" type="text/javascript"></script>

<script type="text/javascript">
	$('.listBtn').removeClass('active');
	$('#li-edit').addClass('active');
</script>

<div class="container">
	<div class="title"><h2>Edit Practice 9: Complete the dialogues for lesson {{ $lessonNo }}</h2></div>
	{!! Form::open(array('url'=>'editP9','method'=>'POST', 'files'=>true, 'id' =>'p9Form')) !!}
	<div id="p9Div">
		<input type="hidden" name="lessonID" value="{{$lessonId}}">
		@if (count($p9))
		@for ($i = 0; $i < count($dialogCnt) ; $i++)
		<div class="row big" id="dialog{{$i}}" data-dialog="{{$i}}">
			<div>
				<label class="situNo">Dialog <span class="dialogIndex" id="line{{$i}}">{{$i+1}}</span>
					<button type="button" class="form-control btn-primary " data-diaNo="{{$i}}" onclick="addRow(this)"><i class="fa fa-plus" style="margin-right: 0.5em"></i></button>
					<button type="button"  class="deleteBtn " onclick="deleteDialog(this)"><i class="fa fa-trash"></i></button>
				</label>
			</div>
			@for ($j = 0; $j < count($p9) ; $j++)
			@if ($p9[$j]->dialogNo == $dialogCnt[$i])
			<div class="row origin" id="dia{{$i}}" data-dialog="{{$i}}" data-line="{{$p9[$j]->lineNo}}" data-id="{{ $p9[$j]->id }}">
				<div id="dia{{$i}}line{{$j}}question" class="col-xs-5 questioncontent">
					<input type="text" id="dia{{$i}}line{{$j}}" name="update[{{ $p9[$j]->id }}][{{$p9[$j]->dialogNo}}][{{ $p9[$j]->lineNo}}][line]" data-line="{{$j}}" class="question form-control vld-spc" maxlength="80" required="true" >
				</div>
				<div id="dia{{$i}}line{{$j}}answer" class="col-xs-5 answercontent" data-sumAnswer="{{count($p9[$j]->answer)}}">
					@for ($k = 0; $k < count($p9[$j]->answer) ; $k++)
					@if ($p9[$j]->answer[$k] != '')
					<input type="text" id="dia{{$i}}line{{$j}}answer{{$k}}" name="update[{{ $p9[$j]->id }}][{{$p9[$j]->dialogNo}}][{{ $p9[$j]->lineNo}}][answer][]" class="form-control answer vld-spc" maxlength="80" required="true" value="{{$p9[$j]->answer[$k]}}">
					@endif
					@endfor
				</div>
				<div id="line{{$j}}answer" class="col-xs-2">
					<button type="button" class="form-control btn-primary col-xs-2" onclick="addAnswer(this)"><i class="fa fa-plus" style="margin-right: 0.5em"></i></button>
					<button type="button" class="deleteBtn col-xs-2"  onclick="deleteRow(this)"><i class="fa fa-trash"></i></button>
				</div>
			</div>
			@endif
			@endfor
		</div>
		@endfor
		@endif
	</div>
	<br>
	<div class="row" style="text-align: center;">
		<button type="submit" class="btn btn-success editSituControl"><i class="fa fa-save" style="margin-right: 0.5em"></i>Save</button>
		<button type="button" class="btn btn-primary editSituControl" onclick="addDialog()"><i class="fa fa-plus" style="margin-right: 0.5em"></i>Add dialog</button>
	</div>
	{!! Form::close() !!}
</div>

<script type="text/javascript">
	var p9 = <?php echo json_encode($p9); ?>;
	var dialogCnt = <?php echo json_encode($dialogCnt); ?>;

	window.onload= function() {
		start();
	}

	function start(){
		for (var i = 0; i < dialogCnt.length; i++) {
			for (var j = 0; j < p9.length; j++) {
				if (p9[j]['dialogNo'] == dialogCnt[i]) {
					var curLine ='';
					for (var k = 0; k < p9[j]['line'].length; k++) {
						curLine = curLine + p9[j]['line'][k] + "\u3007";
					}
					curLine = curLine.slice(0, -1);
					$("#dia"+i+"line"+j).val(curLine);
				}
			}
		}
	}
</script>

<script src="{{ asset('js/screens/editP9.js') }}"></script>
@stop