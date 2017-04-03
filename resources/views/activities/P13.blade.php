@extends('activities.layout.activityLayout')

@section('actContent')

<link rel="stylesheet" href="{{ asset('P13_assets/css/styles.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/KiraNav.css') }}">




<div class="prac-grey-section">

	<div id="promo2">
		<div class="jumbotron practice">
			<div class="container">
				<div class="row practice">
					<div class="col-md-12 practice">
						@foreach ($noteArr as $key)
						<p style="font-size: 32px;">{{ $key }}</p>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>


	<article class="container2">
		<blockquote>
			@foreach ($elementData as $value)
			{{ $value->content }}
			@endforeach
		</blockquote>
	</article>
</div>


@stop

@section('description')
In this activity,...
@stop