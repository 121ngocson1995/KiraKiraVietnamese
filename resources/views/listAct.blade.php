@extends('userLayout')

@section('content')
<script type="text/javascript">
  $('.listBtn').removeClass('active');
  $('#li-edit').addClass('active');
</script>
<div style="padding-left: 510px;"><h2>Lesson {{ $lesson->lessonNo }}: Activity list</h2></div>
<div id="container" style="padding-top: 10px;"> 
@foreach ($lesson->activity as $activity)
<div style="padding-left: 410px; margin: 0.5em 2em"><a class="btn btn-info" href="/lesson{{ $lesson->id }}/preEdit{{ $activity->name }}" style = " width: 50%;font-size: 1.2em; font-weight: 600; color: white; text-decoration: none;"  >{{ $activity->content }}</a></div>
@endforeach
<div><a class="btn btn-info" href="/addAct"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Create new activity</a></div>
</div>
@stop

