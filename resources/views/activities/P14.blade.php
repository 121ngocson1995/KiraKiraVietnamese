@extends('activities.layout.activityLayout')

@section('actContent')


<style type="text/css">

	div.body {
		background-color: #4c8a72;
		background-size: cover;
	}

	div.row.big {
		display: flex;
		align-items: center;
		
	}

	div.left, div.mid, div.right, div.end, div.order{
		display:inline-block;
		vertical-align:middle;
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
	}

	div.row.pattern > div > div{
		margin:0.3em;

	}

	div.right{
		text-align:left;
	}

	@media (max-width: 768px) {
		div.col-xs-12.holderleft {
			text-align:left;
			font-weight:500;
			padding-top: 24px;
			padding-left: 24px;
			left: 0%;
		}
	}

	@media (max-width: 768px) {
		div.col-xs-12.holderright {
			text-align:center;
			font-weight:500;
			padding-top: 24px;
		}
	}

</style>

<div class="body">
@for($k=0; $k<$cntRow; $k++)

<?php $m = count($nounArr[2 * $k]); ?>
<div class="row big">

	<div class="col-md-6">
		<div class="row pattern">
			<div class="col-xs-12 holderleft">
				{{-- left mid right end --}}
				<div class="order">{{2*$k+1 . ".  "}}</div>
				@if((count($nounArr[2*$k])!=1) && (!($open[2*$k]) == NULL))	
				<div class="left">
					<div><span>{{ $open[2*$k] }} </span></div>
				</div>

				<div class="mid">
					<div><img src="{{ asset('img/left-bracket.svg') }}" height="90em"></div>
				</div>

				<div class="right">
					@for($j=0; $j<$m; $j++)
					<div><span>{{ $nounArr[2*$k][$j] }}</span></div>
					@endfor
				</div>

				<div class="end">
					<div><span>{{ $close[2*$k] }}</span></div>
				</div>
				@endif

				{{-- right mid end --}}
				@if((count($nounArr[2*$k])!=1) && (($open[2*$k]) === ""))
				<div class="right">
					@for($j=0; $j<$m; $j++)
					<div><span>{{ $nounArr[2*$k][$j] }}</span></div>
					@endfor
				</div>

				<div class="mid">
					<div><img src="{{ asset('img/right-bracket.svg') }}" height="90em"></div>
				</div>

				<div class="end">
					<div><span>{{ $close[2*$k] }}</span></div>
				</div>
				@endif

				{{-- end --}}
				@if((count($nounArr[2*$k])==1) && (($open[2*$k]) === ""))
				<div class="end">
					<div><span>{{ $close[2*$k] }}</span></div>
				</div>
				@endif

			</div>
		</div>
	</div>

	@if($k<$cntRow-1)
	<?php $n = count($nounArr[2*$k+1]); ?>
	<div class="col-md-6">
		<div class="row pattern">
			<div class="col-xs-12 holderright">
				{{-- left mid right end --}}
				<div class="order">{{2*$k+2 . ".  "}}</div>
				@if((count($nounArr[2*$k+1])!=1) && (!($open[2*$k+1]) == NULL))	
				<div class="left">
					<div><span>{{ $open[2*$k+1] }} </span></div>
				</div>

				<div class="mid">
					<div><img src="{{ asset('img/left-bracket.svg') }}" height="90em"></div>
				</div>

				<div class="right">
					@for($j=0; $j<$n; $j++)
					<div><span>{{ $nounArr[2*$k+1][$j] }}</span></div>
					@endfor
				</div>

				<div class="end">
					<div><span>{{ $close[2*$k+1] }}</span></div>
				</div>
				@endif

				{{-- right mid end --}}
				@if((count($nounArr[2*$k+1])!=1) && (($open[2*$k+1]) === ""))
				<div class="right">
					@for($j=0; $j<$n; $j++)
					<div><span>{{ $nounArr[2*$k+1][$j] }}</span></div>
					@endfor
				</div>

				<div class="mid">
					<div><img src="{{ asset('img/right-bracket.svg') }}" height="90em"></div>
				</div>

				<div class="end">
					<div><span>{{ $close[2*$k+1] }}</span></div>
				</div>
				@endif

				{{-- end --}}
				@if((count($nounArr[2*$k+1])==1) && (($open[2*$k+1]) === ""))
				<div class="end">
					<div><span>{{ $close[2*$k+1] }}</span></div>
				</div>
				@endif

			</div>
		</div>
	</div>
	@endif

</div>

@endfor
</div>

@stop

@section('actDescription-vi')
	Ghi nhớ các mẫu câu được cho bên trên.
@stop

@section('actDescription-en')
	Learn by heart the given sentence patterns.
@stop