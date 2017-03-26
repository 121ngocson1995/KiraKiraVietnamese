@extends('activities.layout.activityLayout')

@section('actContent')

<div id="promo_extend">
    <div class="jumbotron extend">
        <div class="row" style="text-align: center; padding-top: 12px; padding-bottom: 44px">
            <div class="col-md-12 title_button">
                <div class="btn-group" role="group" style="">
                    @for($i=0; $i<$cnt; $i++)
                    <a href="#part{{$i+1}}" class="panelt"><button class="btn btn-default" type="button">{{ $typeArr[$i] }}</button></a>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.2/jquery.scrollTo.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('a.panelt').click(function() {
            $('a.panelt').removeClass('selected');
            $(this).addClass('selected');
            current = $(this);
            $('#wrapper').scrollTo($(this).attr('href'), 800);
            return false;
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

<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('exten_assets/css/styles.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/KiraNav.css') }}">

<div id="wrapper">
  <div id="mask">
    <div id="part1" class="part">
        <a name="part1"></a>
        <div class="content">
            <div class="img_body">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 carousel fix">
                            <div class="row title_row">
                                <div class="col-md-12">
                                    <h2>Hình ảnh đất nước - con người Việt Nam</h2>
                                </div>
                            </div>
                            <div class="carousel slide" data-ride="carousel" id="carousel-1">
                                <div class="carousel-inner" role="listbox">
                                    <div class="item"><img src="{{ asset('exten_assets/img/bando.jpg') }}" alt="Slide Image" class="center-block"></div>
                                    <div class="item"><img src="{{ asset('exten_assets/img/2003.jpg') }}" alt="Slide Image" class="center-block"></div>
                                    <div class="item"><img src="{{ asset('exten_assets/img/cotco.jpg') }}" alt="Slide Image" class="center-block"></div>
                                    <div class="item"><img src="{{ asset('exten_assets/img/2005.jpg') }}" alt="Slide Image" class="center-block"></div>
                                    <div class="item"><img src="{{ asset('exten_assets/img/2006.jpg') }}" alt="Slide Image" class="center-block"></div>
                                    <div class="item"><img src="{{ asset('exten_assets/img/2007.jpg') }}" alt="Slide Image" class="center-block"></div>
                                    <div class="item"><img src="{{ asset('exten_assets/img/2008.jpg') }}" alt="Slide Image" class="center-block"></div>
                                    <div class="item active"><img src="{{ asset('exten_assets/img/donglua.jpg') }}" alt="Slide Image" class="center-block"></div>
                                </div>
                                <div class="control"><a class="left carousel-control" href="#carousel-1" role="button" data-slide="prev"><span class="sr-only">Previous</span></a><a class="right carousel-control .control-site"
                                    href="#carousel-1" role="button" data-slide="next"><span class="sr-only">Next</span></a>
                                </div>
                                <ol class="carousel-indicators">
                                    <li data-target="#carousel-1" data-slide-to="0"></li>
                                    <li data-target="#carousel-1" data-slide-to="1"></li>
                                    <li data-target="#carousel-1" data-slide-to="2"></li>
                                    <li data-target="#carousel-1" data-slide-to="3"></li>
                                    <li data-target="#carousel-1" data-slide-to="4"></li>
                                    <li data-target="#carousel-1" data-slide-to="5"></li>
                                    <li data-target="#carousel-1" data-slide-to="6"></li>
                                    <li data-target="#carousel-1" data-slide-to="7" class="active"></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    @for($i=1; $i<$cnt; $i++)
        <div id="part{{$i+1}}" class="part">
            <a name="part{{$i+1}}"></a>
            <div class="content">
                <a href="#part{{$i}}" class="panelt" ></a>
                <div class="content_body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 carousel fix">
                                <div class="row title_row">
                                    <div class="col-md-12">
                                    <h2>{{ $titleArr[$i] }}</h2>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr></tr>
                                                </thead>
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
                </div>
            </div>     
        </div>
        
    @endfor

  </div>
</div>


@stop