
@extends('layout')

@section('title')
<link href='//fonts.googleapis.com/css?family=Dekko' rel='stylesheet'>
<link href='//fonts.googleapis.com/css?family=Space Mono' rel='stylesheet'>
<style>
	.header {
		
    	background-color: rgba(153, 194, 255, 0.4);
		padding: 5px;
		border-bottom: solid 2px #cccccc;
		border-radius: 25px;
		text-align: center;
		font-size: 400px;
		font-family: 'Dekko';
		font-weight: 900;
	}
	.content {
		background-image:url('P12_img/bg.jpg');
		font-family: 'Space Mono';
		font-size: 18px;
		background-color:#ccccff;
	}
</style>

<div class='header'>
	<h1>Bài khóa</h1>
	<h3>
	   	@foreach ($noteArr as $key)
			<span>{{ $key }}</span><br>
		@endforeach	
	</h3>
</div>
<hr>
@stop

@section('content1')

<body class='content'>
	@foreach ($dummy as $dummyValue)
	<span>{{ $dummyValue->content }}</span>
	@endforeach
</body>

@stop

@section('description')
In this activity,...
@stop