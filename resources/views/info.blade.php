@extends('userLayout')

@section('content')
<script type="text/javascript">
  $('.listBtn').removeClass('active');
  $('#li-info').addClass('active');
</script>
  <div class="container">
    <form action="editUser" method="get">
      <div class="col-sm-6 col-md-4">
        <img src="{{ asset('')."img/avatar/".$userData[0]['avatar']}}" alt="" class="img-rounded img-responsive" />
      </div>
      <div class="col-sm-6 col-md-8">
        <span>
          {{$userData[0]['first_name']." ".$userData[0]['last_name']}}</span>
          <br>
          <span>
            Username: {{$userData[0]['username']}}</span>
            <p>
              <i class="glyphicon glyphicon-envelope"></i>Email: <input type="text" name="txtEmail" value="{{$userData[0]['email']}}" id="txtEmail">
              <br />
              <i class="glyphicon glyphicon-gift"></i>DOB: <input type="date" name="txtDOB" value="{{$userData[0]['date_of_birth']}}" id="txtDOB">
              <br>
              <i class="fa fa-venus-mars" aria-hidden="true"></i>Gender: <select id="txtGender" name="txtGender">
              <option value="1" @if ($userData[0]['gender'] == '1')
              selected 
              @endif>Male</option>
              <option value="0" @if ($userData[0]['gender'] == '0')
              selected 
              @endif>Female</option>
            </select>
          </p>
          <!-- Split button -->
          Country: <select class="input-medium bfh-countries" id="txtCountry"  name="txtCountry" data-country="{{$userData[0]['country']}}"></select>
          <br>
          Language: <select class="input-medium bfh-languages" id="txtLanguage" name="txtLanguage" data-language="{{$userData[0]['language']}}"></select>
          <br>
          <button type="submit">Edit</button>
        </div>
      </form>
    </div>
  </div>
</div>
</div>
@stop

