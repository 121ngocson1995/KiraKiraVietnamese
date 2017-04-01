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
	<h1>Bài khóa</h1>
	<h3>
	   	@foreach ($noteArr as $key)
			<span>{{ $key }}</span><br>
		@endforeach	
	</h3>
</div>
<hr>

<body class='wallpaper'>
	<div class='content'>
		@foreach ($elementData as $value)
			<span>{{ $value->content }}</span>
		@endforeach
	</div>
	
</body>

@stop

@section('actDescription-vi')
	Ghi nhớ bài đọc và viết một bài đọc với chủ đề cho sẵn.
@stop

@section('actDescription-en')
	Memorize the text and write a short paragraph with the given topic.
@stop