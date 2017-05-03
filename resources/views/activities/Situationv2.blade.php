@extends('activities.layout.activityLayout')

@section('header-more')

<link rel="stylesheet" href="{{ asset('Situation-styles.css') }}">
<link rel="stylesheet" href="{{ asset('css/screens/situation.css') }}">

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
						<img id="thumbnail" class="img" src="{{ \Storage::url($elementData[$i]->thumbnail) }}">
					</div>
					<div id="audioHolder" style="text-align: center;">
						<audio id="audio{{$i}}" src="{{ isset($elementData[$i]->audio) ? \Storage::url($elementData[$i]->audio) : '' }}" type="audio/mpeg">
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
	var audioArr = <?php echo json_encode($audioArr); ?>;
</script>

<script src="{{ asset('js/screens/situation.js') }}"></script>

@stop

@section('actDescription-vi')
Rê chuột vào các S và bấm chuột để nghe các tình huống tương ứng.
@stop

@section('actDescription-en')
Click S buttons to listen to corresponded situation.
@stop