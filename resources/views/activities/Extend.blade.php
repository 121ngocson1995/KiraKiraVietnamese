@extends('activities.layout.activityLayout')

@section('actContent')

<style type="text/css">
    .partName {
        padding-top: 24px;
        font-weight: 500;
        font-size: 20px;
    }
</style>

<div id="promo_extend">
    <div class="jumbotron extend">
        <div class="row" style="text-align: center; padding-top: 12px; padding-bottom: 44px">
            <div class="col-md-12 title_button">
                <div class="btn-group" role="group" style="padding-top: 28px;">
                    @for($i=0; $i<$cnt; $i++)
                    <a href="#part{{$i+1}}" class="panelt"><button class="btn btn-default" type="button">{{ $typeArr[$i] }}</button></a>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</div>

{{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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

<link rel="stylesheet" href="{{ asset('exten/css/styles.css') }}">
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
                                    <h2>{{ $titleArr[0] }}</h2>
                                </div>
                            </div>
                            <div class="carousel slide" data-ride="carousel" id="carousel-1">
                                <div class="carousel-inner" role="listbox">
                                    <div class="item active">
                                    <img src="{{  asset($imgArr[0]) }}" alt="Slide Image" class="center-block">
                                        <p class="partName"> {{ $imgNameArr[0] }} </p>
                                    </div>

                                    @for($i=1; $i<count($imgArr); $i++)
                                    <div class="item">
                                        <img src="{{  asset($imgArr[$i]) }}" alt="Slide Image" class="center-block">
                                        <p class="partName"> {{ $imgNameArr[$i] }} </p>
                                    </div>
                                    @endfor

                                </div>
                                <div class="control"><a class="left carousel-control" href="#carousel-1" role="button" data-slide="prev"><span class="sr-only">Previous</span></a><a class="right carousel-control .control-site"
                                    href="#carousel-1" role="button" data-slide="next"><span class="sr-only">Next</span></a>
                                </div>
                                <ol class="carousel-indicators">
                                    <li data-target="#carousel-1" data-slide-to="0" class="active"></li>
                                    @for($i=1; $i<count($imgArr); $i++)
                                    <li data-target="#carousel-1" data-slide-to="{{$i}}"></li>
                                    @endfor     
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <div id="part2" class="part">
        <a name="part2"></a>
        <div class="content">
            <a href="#part1" class="panelt" ></a>
            <div class="content_body">
                <div class="container">
                    <div class="col-md-12 carousel fix">
                        <div>
                            <h2>{{ $titleArr[1] }}</h2>
                        </div>                       
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table">
                                    <tbody class="extendtable">
                                        <td style="font-weight: 700;">Mẹ yêu không nào</td>
                                        @for ($k = 0; $k < count($contentArr[1]) ; $k++)
                                        <tr>
                                            <td>{{ $contentArr[1][$k]}}</td>
                                        </tr>
                                        @endfor
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div style="padding-top: 40%;">
                            <h3>Composer: Lê Xuân Thọ</h3>
                            <h3>Pianist: Nguyễn Thành</h3>
                        </div>

                    </div>
                    
                </div>
            </div>
        </div>     
    </div>


    @for($i=2; $i<$cnt; $i++)
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

@section('actDescription-vi')
    Đọc để tìm hiểu bản sắc văn hoá Việt Nam.
@stop

@section('actDescription-en')
    Read to explore the culture of Vietnam.
@stop