@extends('activities.layout.activityLayout')

@section('actContent')
<link href='//fonts.googleapis.com/css?family=Dekko' rel='stylesheet'>
<link href='//fonts.googleapis.com/css?family=Space Mono' rel='stylesheet'>
<style>
	.header {
    	background-color: rgba(153, 194, 255, 0.4);
		padding: 5px;
		border-bottom: solid 2px #cccccc;
		border-radius: 25px;
		text-align: center;	
		font-family: 'Dekko';

	}
	.wallpaper {
		background-image:url('P12_img/bg.jpg');
		background-color:#ccccff;
	}
	.content {
		font-family: 'Space Mono';
		font-size: 18px;
	}
</style>

<div class='header'>
	<h1>Ghi nhớ các mẫu câu sau</h1>
</div>
<hr>

<body class='wallpaper'>
{{-- <table align="center" class="content">

	@foreach($open as $key)
		<tr>
			<td> {{ $key }}</td>
		</tr>
	@endforeach 
<li> {{ $nounArr[$i][$j]}} </li> 
</table> --}}

	<style type="text/css">
		.text {
			display: inline-block;
			vertical-align: middle;
		}
		.group {
			margin-top: 0;
			margin-bottom: 0;
			display: inline-block;
			vertical-align: middle;
		}
		.contain {
			margin-top: 10px;
			margin-bottom: 10px;
		}
	</style>
	
	@for($i=0; $i<$cnt; $i++)
		<div class="contain">
			<?php $cnt2 = count($nounArr[$i]); ?>
			<span class="text">{{ $open[$i] }}</span>
			<ul class="group" style="display: inline-block;">
				@for($j=0; $j<$cnt2; $j++)
					@if($cnt2!=1)
						<li> {{ $nounArr[$i][$j]}} </li>
					@endif 
				@endfor
			</ul>
			<span class="text">{{ $close[$i] }}</span>

			<hr>
		</div>
	@endfor


</body>
@stop

@section('actDescription-vi')
	Ghi nhớ các mẫu câu được cho bên trên.
@stop

@section('actDescription-en')
	Memorize the given sentence pattern.
@stop