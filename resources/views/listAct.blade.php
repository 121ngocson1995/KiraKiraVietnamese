@extends('userLayout')

@section('header-more')

<style type="text/css">
	div.title {
		text-align: center;
		margin-bottom: 1em;
	}
	div.activityHolder {
		text-align: center;
	}
	div.activity {
		margin: 0.5em;
	}
	.activityBtn {
		font-size: 1.2em;
		font-weight: 600;
		color: white;
		width: 100%;
		max-width: 550px;
	}
</style>

@stop

@section('content')
<script type="text/javascript">
	$('.listBtn').removeClass('active');
	$('#li-edit').addClass('active');
</script>
<div class="container"> 
	<div class="title"><h2>Lesson {{ $lesson->lessonNo }}: All activities</h2></div>
	@foreach ($lesson->activity as $activity)
	<div class="activityHolder">
		<div class="activity">
		<a class="btn btn-info activityBtn" href="/lesson{{ $lesson->id }}/preEdit{{ $activity->name }}" class="activityBtn">{{ $activity->content }}</a>
		</div>
		@endforeach
		<div><a class="btn btn-info" href="/addAct"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Create new activity</a></div>
	</div>
</div>
@stop

