@extends('userLayout')

@section('header-more')

<link rel="stylesheet" href="{{ asset('css/screens/editP11.css') }}">

@stop

@section('content')

<script type="text/javascript">
	$('.listBtn').removeClass('active');
	$('#li-edit').addClass('active');
</script>
<div class="container">
	<div class="title"><h2>Edit Practice 11: Read and reorder the the sentences to make a complete dialogue for lesson {{ $lessonNo }}</h2></div>
	<div class="row description" style="text-align: center; font-size: 1.5em">
		Change sentences and sentences' order by writing into text fields below
	</div>
	<div id="wrapper">
		<form id="p11Form" method="post" action="/editP11">
			{{ csrf_field() }}
			<input type="hidden" name="lessonId" value="{{ $lessonId }}">
			<table>
				<tr>
					<th><label for="">Sentences</label><hr></th>
					<th><label for="">Order</label><hr></th>
					<th></th>
				</tr>
				<tr class="vertical-close-wrapper">
					<td></td>
					<td class="vertical-close-holder">
						@if (count($p11))
						@for ($i = 0; $i < count(explode(',', $p11[0]->correctOrder)); $i++)
						<button type="button" class="vertical close" aria-label="Delete">
							<span aria-hidden="true">&times;</span>
						</button>
						@endfor
						@endif
					</td>
					<td></td>
				</tr>

				@if (count($p11))
				@foreach ($p11 as $element)
				<tr class="sentence" data-sentence-id="{{ $element->id }}">
					<td class="sentence-holder">
						<input type="text" class="form-control sentence-input vld-spc" maxlength="80" name="update[{{ $element->id }}][sentence]" value="{{ $element->sentence }}" required="">
					</td>
					<td class="order-holder">
						@php
						$orderNo = 0;
						@endphp

						@foreach ( explode(',', $element->correctOrder) as $order)
						<input type="number" min="1" class="form-control order-input" name="update[{{ $element->id }}][order][{{ $orderNo }}]" value="{{ (integer)$order + 1 }}" required="">
						@php
						$orderNo++;
						@endphp
						@endforeach
					</td>
					<td class="delete-holder">
						<button type="button" class="horizontal close" aria-label="Delete">
							<span aria-hidden="true"><i class="fa fa-trash fa-1x"></i></span>
						</button>
					</td>
				</tr>
				@endforeach
				@endif
			</table>

			<div id="error"></div>

			<div id="saveBtn-holder" class="row">
				<button id="newSentenceBtn" class="btn btn-primary" type="button"><i class="fa fa-plus"></i><span class="newSentenceBtnText">Add new sentence</span></button>
				<button id="newOrderBtn" class="btn btn-warning" type="button"><i class="fa fa-plus"></i><span class="newOrderBtnText">Add new order</span></button>
				<button id="saveBtn" class="btn btn-success" type="submit"><i class="fa fa-save"></i><span class="saveBtnText">Save</span></button>
			</div>
		</form>
	</div>
</div>

<script src="{{ asset('js/screens/editP11.js') }}"></script>
@stop