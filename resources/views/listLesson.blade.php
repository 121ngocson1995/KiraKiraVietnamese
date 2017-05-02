@extends('userLayout')

@section('header-more')

<link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/KiraNav.css') }}">

<style>
	* {
		word-wrap: break-word;
	}
</style>

@stop

@section('content')
<script type="text/javascript">
  $('.listBtn').removeClass('active');
  $('#li-edit').addClass('active');
</script>

<div class="green-section">
	<div class="container">
		<div class="panel-group" role="tablist" aria-multiselectable="true" id="accordion-1">

			@foreach ( $lessonData as $lesson)
			<div class="panel panel-default">
				<div class="panel-heading" role="tab">
					<h4 class="panel-title"><a role="button" data-toggle="collapse" data-parent="#accordion-1" aria-expanded="true" href="#accordion-1 .item-{{ $lesson->lessonNo }}">Lesson {{ $lesson->lessonNo }}</a></h4>
				</div>
				<div class="panel-collapse collapse in item-{{ $lesson->lessonNo }}" role="tabpanel">
					<div class="panel-body">
						<span> </span>
						<div class="row">
							<div class="col-md-12 btn-group" role="group">
								<div class="container-fluid well span6">
									<div class="row-fluid">
										<div class="span8">
											<h3>{{$lesson->lesson_name}}</h3>
											<h6>Description: {{ $lesson->description }}</h6>
											<h6>Author:{{ $lesson->author }}</h6>	
										</div>

										<div class="span2">
											<div>
												<a class="btn btn-info modify" data-lessonNo="{{$lesson->lessonNo}}" href="#">Modify</a>
												<a class="btn btn-danger delete" data-lessonNo="{{$lesson->lessonNo}}" data-confirm="Are you sure to delete this lesson?" onclick="deleteLesson(this)" href="#">Delete</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
				@endforeach

			</div>
		</div>
	</div>
</div>
<script type="text/javascript">

	$('.modify').click(function(e) {
		e.preventDefault();

		modifyLesson($(this).attr('data-lessonNo'));
	})

	function modifyLesson(lessonNo) {
		window.location = '/preEditLesson' + lessonNo;
	}

	function deleteLesson(lessonNo) {
		window.location = '/deleteLesson' + lessonNo;
	}
	function deleteLesson(button) {
		var lessonNo = $(button).attr('data-lessonNo');
		if(confirm("Are you sure to delete this lesson?")){
			window.location = '/deleteLesson' + lessonNo;
		}
	}
</script>
@stop