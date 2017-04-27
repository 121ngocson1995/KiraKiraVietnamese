@extends('userLayout')

@section('content')
<script type="text/javascript">
  $('.listBtn').removeClass('active');
  $('#li-edit').addClass('active');
</script>

<div class="container" >
<form action="editLesson" id="lessonForm" method="get">
    <div class="col-md-6 form-line" >
      <div class="form-group">
        <label for="lsnNo">Lesson number</label>
        <input type="number" class="form-control " min="1" name="lsnNo" id="lsnNo" required="true" value="{{$lessonData[0]->lessonNo}}">
      </div>
      <div class="form-group">
        <label for="lsnName">Lesson name</label>
        <input type="text" class="form-control vld-spc" name="lsnName" id="lsnName" required="true" value="{{$lessonData[0]->lesson_name}}">
      </div>  
      <div class="form-group">
        <label for="lsnAuthor">Author</label>
        <input type="text" class="form-control vld-spc" name="lsnAuthor" id="lsnAuthor" required="true" value="{{$lessonData[0]->author}}">
      </div>
    </div>
    <div class="col-md-6" >
      <div class="form-group">
        <label for ="description"> Lesson description</label>
        <textarea  class="form-control vld-spc" required="true" name="description" id="description" ></textarea>
      </div>
      <div>
        <input type="text" name="lesson_id" required="true" hidden="true" value="{{ $lessonData[0]->id }}">
        <button type="submit" class="btn btn-info submit"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Save</button>
        <a class="btn btn-info" href="/listAct{{ $lessonData[0]->id }}"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Modify activity</a>
      </div>
    </div>
  </form>
</div>
<script type="text/javascript">
  var lessonData = <?php echo json_encode($lessonData); ?>;
  document.getElementById("description").defaultValue = lessonData[0]['description'];

  $("#lessonForm").submit( function(eventObj) {
    $('.vld-spc').each(function(){
      validate_space_chgColor(this);
    })
    for (var i = 0; i < $('.vld-spc').length; i++) {
      console.log($('.vld-spc')[i]);
      if(!validate_space($('.vld-spc')[i])){
        return false;
        break;  
      }
    }
    return true;
  })

  function validate_space(textElement) {
    var text = textElement.value.trim();
    if( text == "") {
      alert ('Empty value is not allowed');
      return false;
    }else{
      return true;
    }
  }

  function validate_space_chgColor(textElement) {
    var text = textElement.value.trim();
    if( text == "") {
      $(textElement).attr('style', 'border-color: red;');
    }else{
      $(textElement).attr('style', 'border-color: #dddddd;');
    }
  }


</script>

@stop

