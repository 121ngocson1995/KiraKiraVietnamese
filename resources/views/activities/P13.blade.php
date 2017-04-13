@extends('activities.layout.activityLayout')

@section('actContent')

<link rel="stylesheet" href="{{ asset('P13_assets/css/styles.css') }}">

<style>
	body {
		background: url({{ asset('P13_assets/img/p13.svg') }}) no-repeat center center fixed;
		background-size: cover;
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
	#promo2 {
		padding-top: 0;
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