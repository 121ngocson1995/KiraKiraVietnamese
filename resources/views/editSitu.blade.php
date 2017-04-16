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
  {!! Form::open(array('url'=>'editSitu','method'=>'POST', 'files'=>true, 'id' =>'situationForm')) !!}
  <div id="situForm">
    <input type="hidden" name="situaID" value="{{$situation[0]->lesson_id}}">
    @for ($i = 0; $i < count($situation); $i++)
    <div class="row" id="row{{$i}}" data-line="{{$i}}">
      <div class="col-md-1 " >
        <div>
          <span >Situation </span><span id="line{{$i}}">{{$situation[$i]->situationNo}}</span>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for ="dialog"> Dialog</label>
          <textarea  class="form-control textarea" name="dialog{{$situation[$i]->situationNo}}" id="dialog{{$situation[$i]->situationNo}}" data-dialog="{{$situation[$i]->dialogArr}}" ></textarea>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for ="dialogTrans"> Dialog translate</label>
          <textarea  class="form-control textarea" name="dialogTrans{{$situation[$i]->situationNo}}" id="dialogTrans{{$situation[$i]->situationNo}}" data-dialog="{{$situation[$i]->dialogTransArr}}" ></textarea>
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label for ="image{{$situation[$i]->situationNo}}"> Image</label>
          {!! Form::file('image'.$situation[$i]->situationNo, array('onchange' => 'ValidateSingleInput_img(this);', 'id' => 'image'.$situation[$i]->situationNo, 'class' => 'undone image', 'data-situ'=> $situation[$i]->situationNo, 'data-path-image' => $situation[$i]->thumbnail)) !!}
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label for ="audio{{$situation[$i]->situationNo}}"> Audio</label>
          {!! Form::file('audio'.$situation[$i]->situationNo, array('onchange' => 'ValidateSingleInput_audio(this);', 'id' => 'audio'.$situation[$i]->situationNo, 'class' => 'undone audio', 'data-situ'=> $situation[$i]->situationNo, 'data-path-audio' => $situation[$i]->audio)) !!}
        </div>
      </div>
      <div class="col-md-1">
        <div class="form-group">
          <button type="button" onclick="javascript: deleteRow(this)">Delete</button>
        </div>
      </div>
    </div>
    @endfor
  </div>
  {!! Form::submit('Save', array('class'=>'info-btn')) !!}
  <button type="button" onclick="AddRow()">Add</button>
  {!! Form::close() !!}

</div>
<script type="text/javascript">
  $('.textarea').each(function() {
    $(this).text($(this).attr('data-dialog'));
  });
</script>
<script type="text/javascript">
  var rowAdded = 0;
  var situation = <?php echo json_encode($situation); ?>;
  var sumOrigin = situation.length;
  var sumLine = situation.length;
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
          alert("Sorry, " + sFileName.replace(/C:\\fakepath\\/, '') + " is invalid, allowed extensions are: " + _validFileExtensions_img.join(", "));
          oInput.value = "";
          return false;
        }
      }
    }
    $(oInput).removeClass('undone');
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
          alert("Sorry, " + sFileName.replace(/C:\\fakepath\\/, '') + " is invalid, allowed extensions are: " + _validFileExtensions_audio.join(", "));
          oInput.value = "";
          return false;
        }
      }
    }
    return true;
  }

  function AddRow() {
    rowAdded++;
    var node_row = document.createElement("div");
    node_row.setAttribute('class', 'row');
    node_row.setAttribute('id', "row"+(sumLine));
    node_row.setAttribute('data-line', sumLine);
    
    var node_situa = document.createElement("div");
    node_situa.setAttribute('class', 'col-md-2');

    var node_situa_div = document.createElement("div");
    var node_situa_span0 = document.createElement("span");
    var node_situa_span1 = document.createElement("span");
    var node_situa_text0 = document.createTextNode('Situation ');
    var node_situa_text1 = document.createTextNode(sumLine+1);
    node_situa_span1.setAttribute('id', "line"+(sumLine));
    node_situa_span0.appendChild(node_situa_text0); 
    node_situa_span1.appendChild(node_situa_text1); 
    

    node_situa_div.appendChild(node_situa_span0);
    node_situa_div.appendChild(node_situa_span1);

    node_situa.appendChild(node_situa_div);

    var node_dialog = document.createElement("div");
    node_dialog.setAttribute('class', 'col-md-3');

    var node_dialog_div = document.createElement("div");
    node_dialog_div.setAttribute('class', 'form-group');

    var node_dialog_label = document.createElement("label");
    node_dialog_label.setAttribute('for', "dialog"+sumLine);
    var node_dialog_text = document.createTextNode('Dialog ');
    node_dialog_label.appendChild(node_dialog_text);

    var node_dialog_textArea = document.createElement("textarea");
    node_dialog_textArea.setAttribute('class', 'form-control textarea');
    node_dialog_textArea.setAttribute('name', "dialog"+sumLine);

    node_dialog_div.appendChild(node_dialog_label);
    node_dialog_div.appendChild(node_dialog_textArea);

    node_dialog.appendChild(node_dialog_div);

    var node_img = document.createElement("div");
    node_img.setAttribute('class', 'col-md-3');

    var node_img_div = document.createElement("div");
    node_img_div.setAttribute('class', 'form-group');

    var node_img_label = document.createElement("label");
    node_img_label.setAttribute('for', "image"+sumLine);
    var node_img_text = document.createTextNode('Image ');
    node_img_label.appendChild(node_img_text);

    var node_img_input = document.createElement("input");
    node_img_input.setAttribute('type', 'file');
    node_img_input.setAttribute('name',"image"+sumLine);
    node_img_input.setAttribute('onchange', 'ValidateSingleInput_img(this);');

    node_img_div.appendChild(node_img_label);
    node_img_div.appendChild(node_img_input);

    node_img.appendChild(node_img_div);

    var node_audio = document.createElement("div");
    node_audio.setAttribute('class', 'col-md-3');

    var node_audio_div = document.createElement("div");
    node_audio_div.setAttribute('class', 'form-group');

    var node_audio_label = document.createElement("label");
    node_audio_label.setAttribute('for', "audio"+sumLine);
    var node_audio_text = document.createTextNode('Audio ');
    node_audio_label.appendChild(node_audio_text);

    var node_audio_input = document.createElement("input");
    node_audio_input.setAttribute('type', 'file');
    node_audio_input.setAttribute('name',"audio"+sumLine);
    node_audio_input.setAttribute('onchange', 'ValidateSingleInput_audio(this);');

    var node_btn = document.createElement("div");
    node_btn.setAttribute('class', 'col-md-1');

    var node_btn_div = document.createElement("div");
    node_img_div.setAttribute('class', 'form-group');

    var node_btn_btn = document.createElement("button");
    node_btn_btn.setAttribute('type', 'button');
    node_btn_btn.setAttribute('onclick', 'javascript: deleteRow(this)');

    var textNode = document.createTextNode('Delete');
    node_btn_btn.appendChild(textNode);
    node_btn_div.appendChild(node_btn_btn);
    node_btn.appendChild(node_btn_div);


    node_audio_div.appendChild(node_audio_label);
    node_audio_div.appendChild(node_audio_input);

    node_audio.appendChild(node_audio_div);

    node_row.appendChild(node_situa);
    node_row.appendChild(node_dialog);
    node_row.appendChild(node_img);
    node_row.appendChild(node_audio);
    node_row.appendChild(node_btn);


    document.getElementById("situForm").appendChild(node_row);
    sumLine++;
  }

  function deleteRow(button) {
    console.log(sumLine);
    var curLine = $(button).closest('.row').attr('data-line');
    console.log(curLine);
    if(confirm("Are you sure you want to delete?")){
      $(button).closest('.row').empty().remove();
    }
    for (var i = 0; i < sumLine; i++) {
      if (curLine < i) {
        $("#line"+i).text(i);
        $("#row"+i).attr('data-line', i-1);
        $("#row"+i).attr('id', "row"+(i-1));
        $("#line"+i).attr('id', "line"+(i-1));
        $("#dialog"+(i+1)).attr('name', "dialog"+i);
        $("#dialog"+(i+1)).attr('id', "dialog"+i);
        $("#image"+(i+1)).attr('name', "image"+i);
        $("#image"+(i+1)).attr('data-situ', i);
        $("#image"+(i+1)).attr('id', "image"+i);
        $("#audio"+(i+1)).attr('name', "audio"+i);
        $("#audio"+(i+1)).attr('data-situ', i);
        $("#audio"+(i+1)).attr('id', "audio"+i);
      }
    }
    sumLine--;
  }

  var node_hidden = document.createElement("input");
  node_hidden.setAttribute('type', 'hidden');
  node_hidden.setAttribute('name',"sumOrigin");
  node_hidden.setAttribute('value', sumOrigin);

  document.getElementById("situForm").appendChild(node_hidden);

  $("#situationForm").submit( function(eventObj) {
    $('<input />').attr('type', 'hidden')
    .attr('name', "sumLine")
    .attr('value', sumLine)
    .appendTo('#situationForm');
    return true;
  });

  $("#situationForm").submit( function(eventObj) {
    $('.undone').each(function() {


      if($(this).hasClass('image')){
        $('<input />').attr('type', 'hidden')
        .attr('name', "imgPath"+$(this).attr('data-situ'))
        .attr('value', $(this).attr('data-path-image'))
        .appendTo('#situationForm');
        return true;
      }else if($(this).hasClass('audio')){
        $('<input />').attr('type', 'hidden')
        .attr('name', "audioPath"+$(this).attr('data-situ'))
        .attr('value', $(this).attr('data-path-audio'))
        .appendTo('#situationForm');
        return true;
      }
    })
  });
  
</script>
@stop

