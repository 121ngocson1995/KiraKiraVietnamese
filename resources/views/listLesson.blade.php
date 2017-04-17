@extends('userLayout')

@section('content')

<link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/KiraNav.css') }}">
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
												<a class="btn btn-info" href="/preEditLesson{{$lesson->lessonNo}}">Modify</a>
												<a class="btn btn-danger delete" data-confirm="Are you sure to delete this lesson?"  href="/deleteLesson{{$lesson->lessonNo}}">Delete</a>
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
	var deleteLinks = document.querySelectorAll('.delete');

	for (var i = 0; i < deleteLinks.length; i++) {
		deleteLinks[i].addEventListener('click', function(event) {
			event.preventDefault();

			var choice = confirm(this.getAttribute('data-confirm'));

			if (choice) {
				window.location.href = this.getAttribute('href');
			}
		});
	}
</script>
@stop