@extends('activities.layout.activityLayout')

@section('header-more')

<link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('exten/css/styles.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/KiraNav.css') }}">
<style type="text/css">
    .partName {
        color: white;
        font-size: 2em;
        font-weight: 700;
        text-shadow: 2px 2px 5px black;
    }
    .modal-header {
        background-color: aliceblue;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }
    .modal-body {
        text-align: center;
        margin-bottom: 1em;
    }
    img.riddle-answer {
        width: 300px;
        max-width: 100%;
        height: auto;
    }
    span.riddle-answer {
        font-size: 2em;
        font-weight: 600;
        color: cornflowerblue;
    }
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
    #pStart {
        cursor: pointer;
    }
    #imgStart {
        cursor: pointer;
    }
    article {
    	padding-top: 5%;
    }
    blockquote {
    	float: none;
    	padding: 0;
    	border-top: initial;
    	border-bottom: initial;
    }
	.container2:before {
		transform: translateY(-30%);
	}
	.container2:after {
		transform: translateY(10%);
	}
	.quote-text {
		text-align: center;
	}
	.quote-detail {
		font-family: 'Lobster', cursive;
		font-size: 4em;
		display: inline;
	}
	.fa.fa-quote-left {
		position: absolute;
		transform: translate(-50px);
		font-size: 2em;
	}
	.fa.fa-quote-right {
		position: absolute;
		transform: translate(10px, 60px);
		font-size: 2em;
	}
	.quote-box {
	  border-radius: 15px;
	  position: relative;
	  margin: 10% auto auto auto;
	  width: 450px;
	  padding: 40px 60px;
	  display: table;
	  background-color: #fff;
	}
	.quote-box .quote-text {
	  text-align: center;
	  width: 450px;
	  height: auto;
	  clear: both;
	  font-weight: 500;
	  font-size: 1.75em;
	  opacity: 0;
	}
	.quote-box .quote-text i {
	  font-size: 1.0em;
	  margin-right: 0.4em;
	}
	.quote-box .buttons .button#tweet-quote, .quote-box .buttons .button#tumblr-quote, .quote-box .buttons .button#googleplus-quote, .quote-box .buttons .button#facebook-quote {
	  float: left;
	  padding: 0px;
	  padding-top: 8px;
	  text-align: center;
	  font-size: 1.2em;
	  margin-right: 5px;
	  height: 30px;
	  width: 40px;
	}
	.quote-box .buttons .button#new-quote {
	  float: right;
	}

	#image-quote {
	  float:right;
	  margin-right:2px;
	}
	div.table-responsive.play {
		left: 0 !important;
		position: initial !important;
		transform: initial !important;
		padding-top: 10px;
		margin-right: 2em;
	}
</style>

@stop

@section('actContent')

<div id="promo_extend">
    <div class="jumbotron extend">
        <div class="row" style="text-align: center; padding-top: 12px; padding-bottom: 44px">
            <div class="col-md-12 title_button">
                <div class="btn-group" role="group" style="padding-top: 28px;">
                    @for($i=0; $i<$cnt; $i++)
                    <a id="{{ $i }}" href="#part{{$i+1}}" class="panelt"><button class="btn btn-default" type="button">{{ $typeEn[$elementData[$i]->type] }}</button></a>
                    @endfor
                </div>
                <div id="controlBtn" style="text-align: center;padding-top: 8px;">
                  <div id="btnStart"
                    @if (!$elementData[0]->audio || strcmp($elementData[0]->audio, '') == 0)
                        style="display: none;"
                    @endif
                    >
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

    <div id="part{{ $i+1 }}" class="part">
        <a name="part{{ $i+1 }}"></a>
        <div class="content">
            <div class="content_body">
            @if ($elementData[$i]->type == 0)
            <!-- Hình ảnh Việt Nam -->
            {{-- ベトナムのイメージ --}}
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 carousel fix">
                            <div class="row title_row">
                                <div class="col-md-12">
                                    <h2>{{ $typeVn[$elementData[$i]->type] }}</h2>
                                    <h3>{{ $typeEn[$elementData[$i]->type] }}</h2>
                                    </div>
                                </div>
                                <div class="carousel slide" data-ride="carousel" id="carousel-1">
                                    <div class="carousel-inner" role="listbox">
                                        @for($j=0; $j<count($slide_imgArr[(string)$i]); $j++)
                                        <div class="item @if ($j == 0)
                                        active
                                        @endif">
                                        <img src="{{ \Storage::url($slide_imgArr[(string)$i][$j]) }}" alt="Slide Image" class="center-block">
                                        <div class="carousel-caption"><h3 class="partName"> {{ $slide_nameArr[(string)$i][$j] }} </h3></div>
                                    </div>
                                    @endfor

                                </div>
                                <div class="control"><a class="left carousel-control" href="#carousel-1" role="button" data-slide="prev"><span class="sr-only">Previous</span></a><a class="right carousel-control .control-site"
                                    href="#carousel-1" role="button" data-slide="next"><span class="sr-only">Next</span></a>
                                </div>
                                <ol class="carousel-indicators">
                                    <li data-target="#carousel-1" data-slide-to="0" class="active"></li>
                                    @for($j=1; $j<count($slide_imgArr[(string)$i]); $j++)
                                    <li data-target="#carousel-1" data-slide-to="{{$j}}"></li>
                                    @endfor     
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif ($elementData[$i]->type == 1)
            <!-- Bài hát cho em -->
            {{-- 子供たちの音楽 --}}
                <a href="#part1" class="panelt" ></a>
                <div class="song_body">
                    <div class="container">
                        <div class="col-md-12 carousel fix">
                            <div>
                                <h2>{{ $typeVn[$elementData[$i]->type] }}</h2>
                                <h3>{{ $typeEn[$elementData[$i]->type] }}</h2>
                            </div>
                            <div class="row" style=" margin: 2em 0 0">
                            	<h3 style="font-style: italic;">{{ $elementData[$i]->title }}</h3>
                            </div>
                            <div>
                                <div class="col-sm-5 col-sm-offset-1" style="text-align: center; font-weight: bold; margin-top: 1em; margin-bottom: 1em">
                                    <span>Composer: </span>
                                    <span>{{ $elementData[$i]->song_composer }}</span>
                                </div>
                                <div class="col-sm-5" style="text-align: center; font-weight: bold; margin-top: 1em; margin-bottom: 1em">
                                    <span>Performer: </span>
                                    <span>{{ $elementData[$i]->song_performer }}</span>
                                </div>
                            </div>
                            <div style="text-align: center;">
                                <img class="limit" style="width: 80%;" src=" {{ \Storage::url($thumbArr[1][0]) }} ">
                            </div>
                        </div>
                    </div>
                    <audio id="audio{{ $i }}" src="{{ \Storage::url($elementData[$i]->audio) }}"></audio>
                </div>
            @elseif ($elementData[$i]->type == 2)
            <!-- Em đọc thơ -->
            {{-- 詩 --}}
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 carousel fix">
                            <div class="row title_row">
                                <div class="col-md-12">
                                    <h2>{{ $typeVn[$elementData[$i]->type] }}</h2>
                                    <h3>{{ $typeEn[$elementData[$i]->type] }}</h2>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody class="extendtable">
                                                @for ($k = 0; $k < count($contentArr[$i]) ; $k++)
                                                <tr>
                                                    <td>{{ $contentArr[$i][$k]}}</td>
                                                </tr>
                                                @endfor
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif ($elementData[$i]->type == 3)

            <!-- Thành ngữ - Tục ngữ - Ca dao -->
            {{-- イディオム --}}
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 carousel fix">
                            <div class="row title_row">
                                <div class="col-md-12">
                                    <h2>{{ $typeVn[$elementData[$i]->type] }}</h2>
                                    <h3>{{ $typeEn[$elementData[$i]->type] }}</h2>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">

                                	<div class="quote-text">
                                	    <i class="fa fa-quote-left"> </i>

                                	    <div class="quote-detail">
                                	    @for ($k = 0; $k < count($contentArr[$i]) ; $k++)
											{{ $contentArr[$i][$k]}}
										@endfor
										</div>

                                	    <i class="fa fa-quote-right"></i>
                                	  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif ($elementData[$i]->type == 4)

            <!-- Thử đoán nào -->
            {{-- 謎 --}}
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 carousel fix">
                            <div class="row title_row">
                                <div class="col-md-12">
                                    <h2>{{ $typeVn[$elementData[$i]->type] }}</h2>
                                    <h3>{{ $typeEn[$elementData[$i]->type] }}</h2>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody class="extendtable">
                                                @for ($k = 0; $k < count($contentArr[$i]) ; $k++)
                                                <tr>
                                                    <td>{{ $contentArr[$i][$k]}}</td>
                                                </tr>
                                                @endfor
                                            </tbody>
                                        </table>
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal{{ $i+1 }}">
                                          Answer!
                                        </button>
                                    </div>
                                    
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
               
            @elseif ($elementData[$i]->type == 5)
            <!-- Cùng chơi các bạn ơi -->
            {{-- ゲーム --}}

                <div class="container">
                    <div class="row">
                        <div class="col-md-12 carousel fix">
                            <div class="row title_row">
                                <div class="col-md-12">
                                    <h2>{{ $typeVn[$elementData[$i]->type] }}</h2>
                                    <h3>{{ $typeEn[$elementData[$i]->type] }}</h2>
                                </div>
                            </div>
	                            <div class="row" style="text-align: center;">
									<div style="display: inline-block; width: auto;">
									<div class="table-responsive play">
										    <table class="table">
										        <tbody class="extendtable">
										            @foreach (explode('|', $elementData[$i]->content) as $line)
										            <tr>
										                <td>{{ $line }}</td>
										            </tr>
										            @endforeach
										        </tbody>
										    </table>
										</div>
									</div>
									<img src="{{ \Storage::url($elementData[$i]->thumbnail) }}" style="max-height: 300px; vertical-align: initial;" alt="">

                            </div>
                        </div>
                    </div>
                </div>
            @endif
            </div>

        </div>

    </div>

    @endfor

    @for($i=0; $i<$cnt; $i++)
        @if ($elementData[$i]->type == 4)
            <!-- Modal ・モデル-->
            <div class="modal fade" id="myModal{{ $i+1 }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel{{ $i+1 }}">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h2 class="modal-title writtenFont" id="myModalLabel{{ $i+1 }}">Đáp án</h2>
                    <h3 class="modal-title writtenFont" id="myModalLabel{{ $i+1 }}">Answer</h3>
                  </div>
                  <div class="modal-body">
                    <img class="riddle-answer" src="{{ \Storage::url($elementData[$i]->thumbnail) }}" alt="answer image">
                    <div><span class="riddle-answer writtenFont">{{ $elementData[$i]->riddle_answer }}</span></div>
                  </div>
                </div>
              </div>
            </div>
        @endif
    @endfor

</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.2/jquery.scrollTo.min.js"></script>
<script type="text/javascript">
    var elementData = <?php echo json_encode($elementData); ?>;
    if (elementData[0].audio) {
        $('#wrapper').css('top', '233px');
    }

    var index = 0;

    $('#pStart').click(function() {
        toggleSample(this);
    });

    $('#imgStart').click(function() {
        toggleSample(this);
    });

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
            console.log($('#audio'+index)[0]);
            if($('#audio'+index)[0]) {
                stopAudio();
            }
            $('a.panelt').removeClass('selected');
            $(this).addClass('selected');
            current = $(this);
            $('#wrapper').scrollTo($(this).attr('href'), 800);
            
            index = parseInt($(this).attr('id'));
            if(!elementData[index].audio)
            {
                if ($('#btnStart').is(':visible')) {
                  $('#btnStart').hide();
                  $('#wrapper').css('top', '125px');
                }
            }
            else {
                if (!$('#btnStart').is(':visible')) {
                  $('#btnStart').show();
                  $('#wrapper').css('top', '233px');
                }
            }
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

@stop

@section('actDescription-vi')
Đọc để tìm hiểu bản sắc văn hoá Việt Nam.
@stop

@section('actDescription-en')
Read to explore the culture of Vietnam.
@stop