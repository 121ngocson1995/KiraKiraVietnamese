@extends('userLayout')

@section('content')
<script type="text/javascript">
  $('.listBtn').removeClass('active');
  $('#li-add').addClass('active');
</script>
<section id="contact">
  <div class="contact-section">
    <div class="container">
      <form action="addLesson" method="get">
        <div class="col-md-6 form-line">
          <div class="form-group">
            <label for="lsnNo">Lesson number</label>
            <input type="text" class="form-control" name="lsnNo" id="lsnNo" placeholder=" Enter lesson number">
          </div>
          <div class="form-group">
            <label for="lsnName">Lesson name</label>
            <input type="text" class="form-control" name="lsnName" id="lsnName" placeholder=" Enter lesson name">
          </div>  
          <div class="form-group">
            <label for="lsnAuthor">Author</label>
            <input type="text" class="form-control" name="lsnAuthor" id="lsnAuthor" placeholder=" Enter author's name">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for ="description"> Lesson description</label>
            <textarea  class="form-control" name="description" id="description" placeholder="Enter description"></textarea>
          </div>
          <div>

            <button type="submit" class="btn btn-default submit"><i class="fa fa-plus-square-o" aria-hidden="true"></i>  Add lesson</button>
          </div>
          
        </div>
      </form>
    </div>
  </section>
  @stop

