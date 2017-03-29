@extends('activities.layout.activityLayout')

@section('actContent')

<link rel="stylesheet" href="{{ asset('Situation-styles.css') }}">

{{-- <style>
	@media screen and (max-width: 768px) {
		.img {
			height:50%;
			width: auto;
		}
		.paragraph p {
			font-weight: 600;
		}
	}
	.img {
		height:300px;
		width: inherit;
	}
	.paragraph p {
		font-weight: 600;
	}

</style> --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.2/jquery.scrollTo.min.js"></script>
<script language="JavaScript">
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
        <div class="row" style="text-align: center; padding-top: 12px; padding-bottom: 44px">
            <div class="col-md-12 title_button">
                <div class="btn-group" role="group" style="">
                    @for($i=0; $i<$cnt; $i++)
                    <a href="#part{{$i+1}}" class="panelt"><button class="btn btn-default" type="button">S{{ $i+1 }}</button></a>
                    @endfor
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
        		<div id="thumbnailHolder">
        			<img id="thumbnail" class="img" src="{{ asset($elementData[0]->thumbnail) }}">
        		</div>
        		<div id="audioHolder">
        			<audio id="audio" controls src="{{ asset($elementData[0]->audio) }}" type="audio/mpeg">
        				Your browser does not support the audio element.
        			</audio>
        		</div>
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
                	<div id="thumbnailHolder">
                		<img id="thumbnail" class="img" src="{{ asset($elementData[$i]->thumbnail) }}">
                	</div>
                
                	<div id="audioHolder">
               			<audio id="audio" controls src="{{ asset($elementData[$i]->audio) }}" type="audio/mpeg">
               				Your browser does not support the audio element.
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