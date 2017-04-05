@extends('activities.layout.activityLayout')

@section('header-more')

<link rel="stylesheet" href="{{ asset('Situation-styles.css') }}">

<style type="text/css">

  #btnStart, #btnRestart {
    display: flex;
    align-items: center;
    text-align: center;
    z-index: 1;
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
    font-family: 'Patrick Hand', cursive;
    color: white;
  }
  #pStart {
    cursor: pointer;
  }
  #imgStart {
    cursor: pointer;
  }
</style>

@section('actContent')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.2/jquery.scrollTo.min.js"></script>

<div id="promo_extend">
  <div class="jumbotron extend">
    <div class="row" style="text-align: center;">
      <div class="col-md-12 title_button">
        <div class="btn-group" role="group" style="padding-top: 1px;">
          @for($i=0; $i<$cnt; $i++)
          <a href="#part{{$i+1}}" class="panelt"><button class="btn btn-default" data-index="{{$i}}" onclick="setIndex(this)" type="button">S{{ $i+1 }}</button></a>
          @endfor
        </div>
        <div id="controlBtn" style="text-align: center;padding-top: 8px;" >
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

@for($i=0; $i<$cnt; $i++)
<div id="part{{$i+1}}" class="part">
  <a name="part{{$i+1}}"></a>
  <div class="content">
    <a href="#part{{$i}}" class="panelt" ></a>

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
        @for ($j = 0; $j < count($dialogArr[0]) ; $j++)
        <tr>
          <td>{{ $dialogArr[$i][$j]}}</td>
        </tr>
        @endfor
      </tbody>
    </table>
  </div> 

</div>     
</div>

@endfor
</div>
</div>

<script language="JavaScript">
  var index = 0;

  $('#pStart').click(function() {
    toggleSample(this);
  });

  $('#imgStart').click(function() {
    toggleSample(this);
  });

  function setIndex(node) {
    index = node.getAttribute('data-index');
    muteSound();
  }

  function toggleSample(button) {
    if ($("#audio"+index)[0].paused) {
      $('#pStart i').removeClass('fa-play').addClass('fa-pause fa-normal');
      $("#audio"+index)[0].play();
    } else {
      $('#pStart i').removeClass('fa-pause fa-normal').addClass('fa-play');
      $("#audio"+index)[0].pause();
    }
  }

  function muteSound(){
    $('audio').each(function() {
      this.pause();
      this.currentTime = 0;
      $(this).unbind();
    })
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