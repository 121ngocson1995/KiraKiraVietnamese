@extends('activities.layout.activityLayout')

@section('actContent')


<style type="text/css">

	body {
		background-color: #4c8a72;
		background-size: cover;
	}

	div.row.big {
		display: flex;
		align-items: center;
		
	}

	.part {
		display:inline-block;
		vertical-align:middle;
		text-align:left;
	}

	div.col-xs-12.holderleft{
		text-align:left;
		font-weight:500;
		padding-top: 24px;
		left: 30%;
	}

	div.col-xs-12.holderright{
		text-align:left;
		font-weight:500;
		padding-top: 24px;
	}

	div.row.pattern{
		font-size:1.5em;
		color: white;
		padding: 2em 4em;
		display: flex;
		align-items: center;
	}

	div.row.pattern > div > div{
		margin:0.3em;

	}

	.order {
		display: inline-block;
	}

</style>

<div class="row pattern">
	@php
	$order = 1;
	@endphp
	@foreach ($sentences as $sentence)
	<div class="col-xs-12 col-md-6">
		<div class="order">{{ $order++ }}.</div>
		@for ($part = 0; $part < count($sentence); $part++)
		<div class="part">
			@foreach ($sentence[$part] as $option)
			<div>{{ $option }}</div>
			@endforeach
		</div>

		@if (array_key_exists($part+1, $sentence) && count($sentence[$part]) > 1)
		<div class="mid part">
			<img src="{{ asset('img/right-bracket.svg') }}" height="90em" alt="left bracket">
		</div>
		@endif

		@if (array_key_exists($part+1, $sentence) && count($sentence[$part+1]) > 1)
		<div class="mid part">
			<img src="{{ asset('img/left-bracket.svg') }}" height="90em" alt="left bracket">
		</div>
		@endif

		{{-- @if (array_key_exists($part+1, $sentence) && count($sentence[$part]) > 1)
		<div class="mid part">
			<svg xmlns="http://www.w3.org/2000/svg" width="50" height="258" viewBox="0 0 50 258.3" preserveAspectRatio="none"><path d="M40.1 136.2c-4.1 3.6-12.1 9.6-12.1 17.4v70.8c0 10.4-2.9 18.4-8.8 24C12.3 255 4.2 258.2 0 258.3V257c8.2-3.1 14.6-5.9 16.2-14.9 0.6-3.4 0.9-10.9 0.9-22.4v-63.4c0-9 5.6-16.8 16.7-23.3 4.5-2.6 7.9-3.9 10.3-3.9 -3.8 0-8.9-2.4-15.2-7.2 -7.9-6-11.8-12.7-11.8-20.1v-63.4c0-14.2-0.9-23.7-2.8-28.6C12.4 4.8 7.3 3.1 0 1.3V0c5.5 1.3 6.2 0.9 13.5 4.9 9.7 5.4 14.5 15.5 14.5 28.7v70.8c0 7.8 7.9 14.1 12.1 17.4 2.7 2.1 5.5 4.5 9.9 5.7v3C45.6 131.7 42.7 133.9 40.1 136.2z"/></svg>
		</div>
		@endif

		@if (array_key_exists($part+1, $sentence) && count($sentence[$part+1]) > 1)
		<div class="mid part">
			<svg xmlns="http://www.w3.org/2000/svg" width="50" height="258" viewBox="0 0 50 258.3" preserveAspectRatio="none"><path d="M0 130.5v-3c4.4-1.2 7.2-3.6 9.9-5.7 4.2-3.3 12.1-9.6 12.1-17.4v-70.8c0-13.2 4.8-23.3 14.5-28.7C43.8 0.9 44.5 1.3 50 0v1.3c-7.3 1.8-12.4 3.5-14.2 8.4 -1.9 4.9-2.8 14.4-2.8 28.6v63.5c0 7.4-3.9 14.1-11.8 20.1 -6.3 4.8-11.3 7.2-15.2 7.2 2.4 0 5.9 1.3 10.3 3.9 11.1 6.6 16.7 14.4 16.7 23.3v63.5c0 11.6 0.3 19.1 0.9 22.4 1.6 9 8 11.8 16.2 14.9v1.3c-4.2-0.1-12.3-3.3-19.2-9.9 -5.9-5.6-8.8-13.6-8.8-24v-70.8c0-7.8-8-13.8-12.1-17.4C7.3 133.9 4.4 131.7 0 130.5z"/></svg>
		</div>
		@endif --}}

		@endfor
	</div>

	@if ($order % 2 == 1)
</div>
<div class="row pattern">
	@endif
	@endforeach
</div>

@stop

@section('actDescription-vi')
Ghi nhớ các mẫu câu được cho bên trên.
@stop

@section('actDescription-en')
Learn by heart the given sentence patterns.
@stop