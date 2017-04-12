@extends('userLayout')

@section('content')
<script type="text/javascript">
  $('.listBtn').removeClass('active');
  $('#li-edit').addClass('active');
</script>
<div class="container">
  <form action="editP1" method="get">
    @foreach ($situation as $situation)
    <div class="col-md-6 ">
      <div>
        <span >Situation {{$situation->situationNo}}</span>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for ="dialog"> dialog</label>
        <textarea  class="form-control textarea" name="dialog" id="dialog" data-dialog="{{$situation->dialogArr}}" ></textarea>
      </div>
      <div>
        <input type="text" name="lesson_id" hidden="true" value="">
      </div>
    </div>
    @endforeach

  </form>
</div>
<script type="text/javascript">
  $('.textarea').each(function() {
    $(this).text($(this).attr('data-dialog'));
  });
</script>

@stop

