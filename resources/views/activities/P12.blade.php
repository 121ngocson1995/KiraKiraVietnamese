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
	@foreach ($elementData as $key)
		<h1>{{ $key->title }}</h1>
	@endforeach
</div>
<hr>

<body class='wallpaper'>
<div class='content'>
	@foreach ($elementData as $key)
		<span>{{ $key->content }}</span>
	@endforeach
</div>
	
</body>
@stop

@section('description')
In this activity,...
@stop