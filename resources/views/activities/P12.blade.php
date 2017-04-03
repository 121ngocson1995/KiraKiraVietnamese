@extends('activities.layout.activityLayout')

@section('actContent')

<link rel="stylesheet" href="{{ asset('P12_assets/css/styles.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/KiraNav.css') }}">


<div id="promo3">
	<div class="jumbotron p12">
		<div class="container">
			<div class="row p12">
				<div class="col-md-12">
					@foreach ($elementData as $key)
					<p>{{ $key->content }}</p>
					@endforeach
				</div>
			</div>
		</div>
	</div>
</div>

@stop

@section('description')
In this activity,...
@stop