<!DOCTYPE html>
<html>
<body>

 <div class="text-content">
  {!! Form::open(array('url'=>'apply/upload','method'=>'POST', 'files'=>true)) !!}
  <div class="control-group">
    <div class="controls">
      {!! Form::file('image'.'1', array('onchange' => 'ValidateSingleInput(this);')) !!}
    </div>
  </div>
  {!! Form::submit('Submit', array('class'=>'send-btn')) !!}
  {!! Form::close() !!}
</div>

<script type="text/javascript">
  var _validFileExtensions = [".jpg", ".jpeg", ".bmp", ".gif", ".png"];    
  function ValidateSingleInput(oInput) {
    if (oInput.type == "file") {
      var sFileName = oInput.value;
      if (sFileName.length > 0) {
        var blnValid = false;
        for (var j = 0; j < _validFileExtensions.length; j++) {
          var sCurExtension = _validFileExtensions[j];
          if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
            blnValid = true;
            break;
          }
        }

        if (!blnValid) {
          alert("Sorry, " + sFileName + " is invalid, allowed extensions are: " + _validFileExtensions.join(", "));
          oInput.value = "";
          return false;
        }
      }
    }
    return true;
  }
</script>
</body>
</html>