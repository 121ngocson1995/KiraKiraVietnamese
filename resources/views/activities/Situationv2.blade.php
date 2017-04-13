@extends('activities.layout.activityLayout')

@section('header-more')

<link rel="stylesheet" href="{{ asset('Situation-styles.css') }}">

<style type="text/css">
  * {
    letter-spacing: .075em;
  }
  #btnStart, #btnRestart {
    display: flex;
    align-items: center;
    text-align: center;
    z-index: 1;
  }
  button.selected{
    background-color: #a58895;
    color:white;
  }
  #btnStart p, #btnRestart p {
    position: absolute;
    color: #33ccff;
    left: 50%;
    transform: translateX(-50%);
    z-index: 1;
  }
  #startBtn, #restartBtn {
    width: 400px;
    max-width: 40%;
    margin: auto;
  }

  .fa-normal {
    margin-left: 0 !important;
  }
  .fa-play {
    margin-left: 0.15em;
  }
  .fa-2x {
    font-size: 2em;
  }

  td {
    font-size: 32px;
    font-family: "Open Sans";
    color: white;
  }
  #pStart {
    cursor: pointer;
  }
  #imgStart {
    cursor: pointer;
  }
  td {
    padding: 0 0 0.2em 0 !important;
    border-top: initial !important;
  }
  .jumbotron {
    padding: 1.5em 0 !important;
    margin-bottom: 0 !important;
  }
  .dialogVi {
    font-size: 0.9em;
    font-weight: 500;
    margin: 0;
  }
  .dialogEn {
    font-size: 0.6em;
    font-weight: 400;
    font-style: italic;
    margin: 0;
  }
  .note-content {
    font-size: 1.6em;
    color: white;
    padding: 2em !important;
    border-radius: 20px;
    background-color: rgba(0, 172, 230, 0.8);
  }
</style>

@section('actContent')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.2/jquery.scrollTo.min.js"></script>

<div id="background">
  <img id="landBottom" style="position: fixed; bottom: 0; width: 100%" src="{{ asset('img/situation/bg-land.svg') }}" alt="">
</div>
<div id="promo_extend">
  <div class="jumbotron extend">
    <div class="row" style="text-align: center;">
      <div class="col-md-12 title_button">
        <div id="situation-group" class="btn-group" role="group" style="padding-top: 1px;">
          @php
          $index = 0;
          @endphp
          @for($i=0; $i<count($elementData); $i++)
          <a href="#part{{ ++$index }}" class="panelt "><button class="btn btn-default" data-index="{{ $i }}" onclick="setIndex(this)" type="button">S{{ $i+1 }}</button></a>
          @endfor
          @if (count($note_content) == 1)
          <a href="#part{{ ++$index }}" class="panelt note"><button class="btn btn-success" data-index="{{ $i }}" onclick="setIndexNote(this)" type="button">Note</button></a>
          @else
          @for($i=0; $i<count($note_content); $i++)
          <a href="#part{{ ++$index }}" class="panelt note"><button class="btn btn-success" data-index="{{ $i }}" onclick="setIndexNote(this)" type="button">Note {{ $i+1 }}</button></a>
          @endfor
          @endif
        </div>
        <button id="collapsePlay" style="display: none;" data-toggle="collapse" data-target="#controlBtn"></button>
        <div id="controlBtn" class="collapse 
        @if ($elementData[0]->audio && strcmp($elementData[0]->audio, '') != 0)
        in
        @endif
        " style="text-align: center;padding-top: 8px;" >
        <div id="btnStart">
          <p id="pStart">
            <i style="max-width: 50px;" class="fa fa-play fa-2x"></i>
          </p>
          <div id="startBtn" class="btnBg">
            <img id="imgStart" style="width: 50%; max-width: 100px;" src="{{ asset('img/testAnimate/flower1.svg') }}" alt="start button">
          </div>
        </div>
      </div>
    </div>    
  </div>
</div>
</div>

<div id="wrapper">
  <div id="mask">
    @php
    $index = 0;
    @endphp
    @for($i=0; $i<count($elementData); $i++)
    <div id="part{{ ++$index }}" class="part">
      <a name="part{{ $index }}"></a>
      <div class="content">
        <a href="#part{{ $index }}" class="panelt" ></a>
        <div class="col-sm-4 col-sm-offset-3 col-sm-push-2 image">
          <div id="thumbnailHolder" style="padding-top: 24px; text-align: center;">
            <img id="thumbnail" class="img" src="{{ asset($elementData[$i]->thumbnail) }}">
          </div>
          <div id="audioHolder" style="text-align: center;">
            <audio id="audio{{$i}}" src="{{ asset($elementData[$i]->audio) }}" type="audio/mpeg">
            </audio>
          </div>
        </div>
        <div class="col-sm-3 col-sm-pull-4 paragraph" style="margin-top: 40px;">
          <table class="table">
            <tbody class="extendtable">
              @for ($j = 0; $j < count($dialogArr[$i]) ; $j++)
              <tr>
                <td>
                  <p class="dialogVi writtenFont">{{ $dialogArr[$i][$j]}}</p>
                  <p class="dialogEn">{{ $dialogArrEn[$i][$j]}}</p>
                </td>
              </tr>
              @endfor
            </tbody>
          </table>
        </div>
      </div>
    </div>
    @endfor
    @for($i=0; $i<count($note_content); $i++)
    <div id="part{{ ++$index }}" class="part">
      <a name="part{{ $index }}"></a>
      <div class="content">
        <a href="#part{{ $index }}" class="panelt" ></a>
        <div class="col-sm-10 col-sm-offset-1 note-content writtenFont">
          @foreach ($note_content[$i] as $noteLine)
            <p>{{ $noteLine }}</p>
          @endforeach
        </div>
      </div>
    </div>
    @endfor
  </div>
</div>

<script language="JavaScript">
  var elementData = <?php echo json_encode($elementData); ?>;
  if (elementData[0].audio) {
    $('#wrapper').css('top', '198px');
  }

  var index = 0;

  $('#pStart').click(function() {
    toggleSample(this);
  });

  $('#imgStart').click(function() {
    toggleSample(this);
  });

  function setIndex(node) {
    var audioArr = <?php echo json_encode($audioArr); ?>;
    stopAudio();
    $('.btn').removeClass('selected');
    node.setAttribute('class', 'btn btn-default selected');
    index = node.getAttribute('data-index');
    $('#situation-group a button').prop('disabled', false);
    node.disabled = true;
    if(!elementData[index].audio)
    {
      if ($('#controlBtn').hasClass('in')) {
        $('#pStart').unbind('click');
        $('#imgStart').unbind('click');
        $('#collapsePlay').click();
      }
    }
    else {
      if (!$('#controlBtn').hasClass('in')) {
        $('#pStart').click(function() {
          toggleSample(this);
        });

        $('#imgStart').click(function() {
          toggleSample(this);
        });

        $('#collapsePlay').click();
      }
    }
  }

  function setIndexNote(node) {
    stopAudio();
    $('.btn').removeClass('selected');
    node.setAttribute('class', 'btn btn-success selected');
    $('#situation-group a button').prop('disabled', false);
    node.disabled = true;
 
    if ($('#controlBtn').hasClass('in')) {
      $('#pStart').unbind('click');
      $('#imgStart').unbind('click');
      $('#collapsePlay').click();
    }
  }

  function toggleSample(button) {
    if ($("#audio"+index)[0].paused) {
      playAudio();
    } else {
      pauseAudio();
    }
  }

  var audioTimeout;

  function playAudio() {
    $('#pStart i').removeClass('fa-play').addClass('fa-pause fa-normal');
    $("#audio"+index)[0].play();

    if (audioTimeout) {
      clearTimeout(audioTimeout);
    }

    audioTimeout = setTimeout(function() {
      $('#pStart i').removeClass('fa-pause fa-normal').addClass('fa-play');
    }, (document.getElementById("audio"+index).duration - document.getElementById("audio"+index).currentTime) * 1000);
  }

  function pauseAudio() {
    $('#pStart i').removeClass('fa-pause fa-normal').addClass('fa-play');
    $("#audio"+index)[0].pause();
  }

  function stopAudio() {
    pauseAudio();
    $("#audio"+index)[0].currentTime = 0;
  }

  $(document).ready(function() {
    $('a.panelt').click(function() {
      $('a.panelt').removeClass('selected');
      $(this).addClass('selected');
      current = $(this);
      $('#wrapper').scrollTo($(this).attr('href'), 800);
      return false;
    });
    width = $(window).width();
    mask_width = width * $('.part').length;
    $('#wrapper, .part').css({
      width: width,
    });
    $('#mask').css({
      width: mask_width,
    });
    $(window).resize(function() {
      resizePanelt();
    });
    $('#situation-group a').prop('disabled', false);
    $('#situation-group a button').first().addClass('selected').prop('disabled', true);
  });

  function resizePanelt() {
    width = $(window).width();
    height = $(window).height();
    mask_width = width * $('.part').length;
    $('#debug').html(width + ' ' + height + ' ' + mask_width);
    $('#wrapper, .part').css({
      width: width,
    });
    $('#mask').css({
      width: mask_width,
    });
    $('#wrapper').scrollTo($('a.selected').attr('href'), 0);
  }

</script>

@stop

@section('actDescription-vi')
Rê chuột vào các S và bấm chuột để nghe các tình huống tương ứng.
@stop

@section('actDescription-en')
Click S buttons to listen to corresponded situation.
@stop