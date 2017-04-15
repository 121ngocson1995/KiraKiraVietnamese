@extends('userLayout')

@section('content')
<script type="text/javascript">
  $('.listBtn').removeClass('active');
  $('#li-edit').addClass('active');
</script>

<div class="container" >
  <form action="editLesson" method="get">
    <div class="col-md-6 form-line" >
      <div class="form-group">
        <label for="lsnNo">Lesson number</label>
        <input type="text" class="form-control" name="lsnNo" id="lsnNo" value="{{$lessonData[0]->lessonNo}}">
      </div>
      <div class="form-group">
        <label for="lsnName">Lesson name</label>
        <input type="text" class="form-control" name="lsnName" id="lsnName" value="{{$lessonData[0]->lesson_name}}">
      </div>  
      <div class="form-group">
        <label for="lsnAuthor">Author</label>
        <input type="text" class="form-control" name="lsnAuthor" id="lsnAuthor" value="{{$lessonData[0]->author}}">
      </div>
    </div>
    <div class="col-md-6" >
      <div class="form-group">
        <label for ="description"> Lesson description</label>
        <textarea  class="form-control" name="description" id="description" ></textarea>
      </div>
      <div>
        <input type="text" name="lesson_id" hidden="true" value="{{ $lessonData[0]->id }}">
        <button type="submit" class="btn btn-info submit"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Save</button>
        <a class="btn btn-info" href="/listAct{{ $lessonData[0]->id }}"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Modify activity</a>
      </div>
    </div>
  </form>
</div>
<script type="text/javascript">
  var lessonData = <?php echo json_encode($lessonData); ?>;
  document.getElementById("description").defaultValue = lessonData[0]['description'];
</script>

@stop
