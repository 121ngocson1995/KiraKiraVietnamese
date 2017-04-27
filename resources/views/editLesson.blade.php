@extends('userLayout')

@section('content')
<script type="text/javascript">
  $('.listBtn').removeClass('active');
  $('#li-edit').addClass('active');
</script>

<div class="container" >
  <form action="editLesson" id="lessonForm" method="post">
  {{ csrf_field() }}
    <div class="col-md-6 form-lggggine" >
      <div class="form-group">
        <label for="lsnNo">Lesson number</label>
        <input type="number" class="form-control " maxlength="191" min="1" max="2147483647" name="lsnNo" id="lsnNo" required="true" value="{{$lessonData[0]->lessonNo}}">
      </div>
      @if ($errors->has('lsnNo'))
      <div class="help-block">
        <span>{{ $errors->first('lsnNo') }}</span>
      </div>
      @endif
      <div class="form-group">
        <label for="lsnName">Lesson name</label>
        <input type="text" class="form-control vld-spc" maxlength="191" name="lsnName" id="lsnName" required="true" value="{{$lessonData[0]->lesson_name}}">
      </div>  
      @if ($errors->has('lsnName'))
      <div class="help-block">
        <span>{{ $errors->first('lsnName') }}</span>
      </div>
      @endif
      <div class="form-group">
        <label for="lsnAuthor">Author</label>
        <input type="text" class="form-control vld-spc" maxlength="191" name="lsnAuthor" id="lsnAuthor" required="true" value="{{$lessonData[0]->author}}">
      </div>
      @if ($errors->has('lsnAuthor'))
      <div class="help-block">
        <span>{{ $errors->first('lsnAuthor') }}</span>
      </div>
      @endif
    </div>
    <div class="col-md-6" >
      <div class="form-group">
        <label for ="description"> Lesson description</label>
        <textarea  class="form-control vld-spc" maxlength="2000" required="true" name="description" id="description" ></textarea>
      </div>
      @if ($errors->has('description'))
      <div class="help-block">
        <span>{{ $errors->first('description') }}</span>
      </div>
      @endif
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

  // $("#lessonForm").submit( function(eventObj) {
  //   $('.vld-spc').each(function(){
  //     validate_chgColor(this);
  //   })
  //   for (var i = 0; i < $('.vld-spc').length; i++) {
  //     if(!validate_space($('.vld-spc')[i])){
  //       return false;
  //       break;  
  //     }
  //     if(!validate_spcChar($('.vld-spc')[i])){
  //       return false;
  //       break;  
  //     }
  //   }
  //   return true;
  // })

  // function validate_space(textElement) {
  //   var text = textElement.value;
  //   if( text.trim() == "") {
  //     alert ('Empty value is not allowed');
  //     return false;
  //   }else{
  //     return true;
  //   }
  // }

  // function validate_chgColor(textElement) {
  //   var text = textElement.value;
  //   var pattern = new RegExp(/[~`!#$%\@^&*+=\-\[\]\\';/{}|\\":<>]/);
  //   if( text.trim() == "" || pattern.test(text) || text == "") {
  //     $(textElement).attr('style', 'border-color: red;');
  //   }else{
  //     $(textElement).attr('style', 'border-color: #dddddd;');
  //   }
  // }

  // function validate_spcChar(textElement){
  //   var text = textElement.value;
  //   var pattern = new RegExp(/[~`@!#$%\^&*+=\-\[\]\\';/{}|\\":<>]/);
  //   if (pattern.test(text)) {
  //     alert ('Special character is invalid');
  //     return false;
  //   }else{
  //     return true;
  //   }
  // }

</script>

@stop

