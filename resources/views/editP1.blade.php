@extends('userLayout')

@section('content')
<style type="text/css">
  .textarea {
    height: 103px !important;
  }
</style>
<script type="text/javascript">
  $('.listBtn').removeClass('active');
  $('#li-edit').addClass('active');
</script>
<div class="container">
  {!! Form::open(array('url'=>'editSitu','method'=>'POST', 'files'=>true)) !!}
  <div id="situForm">
  @foreach ($situation as $situation)
  <div class="row">
    <div class="col-md-3 " >
      <div>
        <span >Situation {{$situation->situationNo}}</span>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label for ="dialog"> Dialog</label>
        <textarea  class="form-control textarea" name="dialog{{$situation->situationNo}}" id="dialog" data-dialog="{{$situation->dialogArr}}" ></textarea>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label for ="image{{$situation->situationNo}}"> Image</label>
        {!! Form::file('image'.$situation->situationNo, array('onchange' => 'ValidateSingleInput_img(this);')) !!}
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label for ="audio{{$situation->situationNo}}"> Audio</label>
        {!! Form::file('audio'.$situation->situationNo, array('onchange' => 'ValidateSingleInput_audio(this);')) !!}
      </div>
    </div>
  </div>
  @endforeach
  </div>
  {!! Form::submit('Save', array('class'=>'info-btn')) !!}
  <button onclick="AddRow()">Add</button>
  {!! Form::close() !!}

</div>
<script type="text/javascript">
  $('.textarea').each(function() {
    $(this).text($(this).attr('data-dialog'));
  });
</script>
<script type="text/javascript">
  var _validFileExtensions_img = [".jpg", ".jpeg", ".bmp", ".gif", ".png"];    
  var _validFileExtensions_audio = [".mp3"]; 
  function ValidateSingleInput_img(oInput) {
    if (oInput.type == "file") {
      var sFileName = oInput.value;
      if (sFileName.length > 0) {
        var blnValid = false;
        for (var j = 0; j < _validFileExtensions_img.length; j++) {
          var sCurExtension = _validFileExtensions_img[j];
          if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
            blnValid = true;
            break;
          }
        }

        if (!blnValid) {
          alert("Sorry, " + sFileName + " is invalid, allowed extensions are: " + _validFileExtensions_img.join(", "));
          oInput.value = "";
          return false;
        }
      }
    }
    return true;
  }

  function ValidateSingleInput_audio(oInput) {
    if (oInput.type == "file") {
      var sFileName = oInput.value;
      if (sFileName.length > 0) {
        var blnValid = false;
        for (var j = 0; j < _validFileExtensions_audio.length; j++) {
          var sCurExtension = _validFileExtensions_audio[j];
          if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
            blnValid = true;
            break;
          }
        }

        if (!blnValid) {
          alert("Sorry, " + sFileName + " is invalid, allowed extensions are: " + _validFileExtensions_audio.join(", "));
          oInput.value = "";
          return false;
        }
      }
    }
    return true;
  }
  var rowAdded = 0;
  function AddRow() {
    rowAdded++;
    var node_row = document.createElement("div");
    node_row.setAttribute('class', 'row');

    var node_situa = document.createElement("div");
    node_situa.setAttribute('class', 'col-md-3');

    var node_situa_div = document.createElement("div");
    var node_situa_span = document.createElement("span");
    var node_situa_text = document.createTextNode('Situation ');
    node_situa_span.appendChild(node_situa_text); 

    var node_situa_div_input = document.createElement("input");
    node_situa_div_input.setAttribute('type', 'number');
    node_situa_div_input.setAttribute('required', 'true');
    node_situa_div_input.setAttribute('name',"situation"+rowAdded);

    node_situa_div.appendChild(node_situa_span);
    node_situa_div.appendChild(node_situa_div_input);

    node_situa.appendChild(node_situa_div);

    var node_dialog = document.createElement("div");
    node_dialog.setAttribute('class', 'col-md-3');

    var node_dialog_div = document.createElement("div");
    node_dialog_div.setAttribute('class', 'form-group');

    var node_dialog_label = document.createElement("label");
    node_dialog_label.setAttribute('for', "dialog"+rowAdded);
    var node_dialog_text = document.createTextNode('Dialog ');
    node_dialog_label.appendChild(node_dialog_text);

    var node_dialog_textArea = document.createElement("textarea");
    node_dialog_textArea.setAttribute('class', 'form-control textarea');
    node_dialog_textArea.setAttribute('name', "dialog"+rowAdded);

    node_dialog_div.appendChild(node_dialog_label);
    node_dialog_div.appendChild(node_dialog_textArea);

    node_dialog.appendChild(node_dialog_div);

    node_row.appendChild(node_situa);
    node_row.appendChild(node_dialog);

    document.getElementById("situForm").appendChild(node_row);

  }
</script>
@stop

