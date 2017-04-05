@extends('activities.layout.activityLayout')

@section('actContent')

<link rel="stylesheet" href="{{ asset('Situation-styles.css') }}">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.2/jquery.scrollTo.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.19.1/TweenMax.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.13.2/plugins/TextPlugin.min.js"></script>

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

  .fa {
    margin-left: 0;
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

</style>

<script language="JavaScript">
  var index = 0;
  function setIndex(node) {
    index = node.getAttribute('data-index');
    muteSound();
  }

  function toggleSample(button) {
    if ($("#audio"+index)[0].paused) {
      $("#audio"+index)[0].play();
    } else {
      $("#audio"+index)[0].pause();
    }
  }

  function play() {
    if ($("#audio"+index)[0].paused) {
      $("#audio"+index)[0].play();
    } else {
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

  function imgToReplay() {
    $("#pStart").attr('src', "{{ asset('img/icons/sample_replay.svg') }}");
  }

  function imgToPause(button) {
   $("#pStart").attr('src', "{{ asset('img/icons/sample_pause.svg') }}");
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
      height: height
    });
    $('#mask').css({
      width: mask_width,
      height: height
    });
    $('#wrapper').scrollTo($('a.selected').attr('href'), 0);
  }

</script>

<div id="promo_extend">
    <div class="jumbotron extend">
        <div class="row" style="text-align: center;">
            <div class="col-md-12 title_button">
              <div class="btn-group" role="group" style="padding-top: 1px;">
                  @for($i=0; $i<$cnt; $i++)
                  <a href="#part{{$i+1}}" class="panelt"><button class="btn btn-default" data-index="{{$i}}" onclick="setIndex(this)" type="button">S{{ $i+1 }}</button></a>
                  @endfor
              </div>
              <div id="controlBtn" style="text-align: center;padding-top: 16px; padding-bottom: 16px;">
                <div id="btnStart">
                  <p id="pStart" ><i style="max-width: 50px;" class="fa fa-play fa-2x" onclick="toggleSample(this);" ></i></p>
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
    <div id="part1" class="part">
        <a name="part1"></a>
        <div class="content">
        	<div class="col-sm-4 col-sm-offset-3 col-sm-push-2 image">
        		<div id="thumbnailHolder" style="padding-top: 24px; text-align: center;">
        			<img id="thumbnail" class="img" src="{{ asset($elementData[0]->thumbnail) }}">
        		</div>
            </div>

            <div id="audioHolder" style="text-align: center;">
              <audio id="audio0" src="{{ asset($elementData[0]->audio) }}" type="audio/mpeg" onpause="imgToReplay()" onplay="imgToPause()">
              </audio>
          </div>

          <div class="col-sm-3 col-sm-pull-4 paragraph" style="margin-top: 40px; height: 100%">
              <table class="table">
               <tbody class="extendtable">
                @for ($j = 0; $j < count($dialogArr[0]) ; $j++)
                <tr>
                 <td>{{ $dialogArr[0][$j]}}</td>
             </tr>
             @endfor
         </tbody>
     </table>
 </div> 

</div>
</div>


@for($i=1; $i<$cnt; $i++)
<div id="part{{$i+1}}" class="part">
    <a name="part{{$i+1}}"></a>
    <div class="content">
        <a href="#part{{$i}}" class="panelt" ></a>

        <div class="col-sm-4 col-sm-offset-3 col-sm-push-2 image">
         <div id="thumbnailHolder" style="padding-top: 24px; text-align: center;">
          <img id="thumbnail" class="img" src="{{ asset($elementData[$i]->thumbnail) }}">
      </div>
      <div id="audioHolder" style="text-align: center;">
          <audio id="audio{{$i}}" src="{{ asset($elementData[$i]->audio) }}" type="audio/mpeg" onpause="imgToReplay()" onplay="imgToPause()">
          </audio>
      </div>
  </div>

  <div class="col-sm-3 col-sm-pull-4 paragraph" style="margin-top: 40px; height: 100%">
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




@stop