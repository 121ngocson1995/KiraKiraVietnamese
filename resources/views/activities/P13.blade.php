@extends('activities.layout.activityLayout')

@section('actContent')

<link rel="stylesheet" href="{{ asset('P13_assets/css/styles.css') }}">
<link rel="stylesheet" href="{{ asset('css/screens/p13.css') }}">

<style>
	body {
		background: url({{ asset('P13_assets/img/p13.svg') }}) no-repeat center center fixed;
		background-size: cover;
	}
</style>

<div class="prac-grey-section">

	<article class="container2">
		<blockquote>
			@foreach ($elementData as $value)
			{{ $value->content }}
			@endforeach
		</blockquote>
	</article>

	<div id="promo2">
		<div class="jumbotron practice">
			<div class="container">
				<div class="row practice">
					<div class="col-md-12 practice">
						@foreach ($noteArr as $key)
						<p>{{ $key }}</p>
						@endforeach
						@foreach ($noteArrEn as $key)
						<p>{{ $key }}</p>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@stop

@section('actDescription-vi')
	Học thuộc lòng bài đọc và làm theo hướng dẫn.
@stop

@section('actDescription-en')
	Memorize the given texts and follow the guide.
@stop