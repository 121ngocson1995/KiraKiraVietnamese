@extends('userLayout')

@section('header-more')

<link rel="stylesheet" href="{{ asset('css/screens/userIndex.css') }}">

@stop

@section('content')

<script type="text/javascript">
	$('.listBtn').removeClass('active');
	$('#li-users').addClass('active');
</script>
<div class="container">
	<ul class="nav nav-tabs" style="margin: 2em 0;">
		<li class="active"><a class="tab_toggle tab_toggle all_toggle" data-toggle="tab">All</a></li>
		<li><a class="tab_toggle admins_toggle" data-toggle="tab">Admins</a></li>
		<li><a class="tab_toggle teachers_toggle" data-toggle="tab">Teachers</a></li>
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown">Applicants
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a class="tab_toggle pending_toggle" data-toggle="tab">Pending</a></li>
				<li><a class="tab_toggle rejected_toggle" data-toggle="tab">Rejected</a></li>
			</ul>
		</li>
	</ul>
	<div id="alertDiv"></div>
	<div class="search-outer">
		<div class="search">
			<div class="field">

				<input type="text" class="input-search form-control" id="input-search" name="input-search" required>
				<label for="input-search" class="label-search">Search by username, first name, last name or email</label>

			</div>
		</div>
	</div>
	<section id="userList">
		@include('userList.normal')
	</section>

	<div id="setRoleModal" class="modal fade" role="dialog">
		{{ csrf_field() }}
		
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h3 class="modal-title"></h3>
				</div>
				<div class="modal-body">
					<label style="font-size: 1.2em;">Choose one from available roles below:</label>
					<div class="chooseRole">
						<div class="btn-group btn-group roleToChoose" data-toggle="buttons">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary set" data-dismiss="modal">
							<i class="fa fa-pencil"></i>Set
						</button>
						<button type="button" class="btn btn-warning" data-dismiss="modal">
							<i class="fa fa-close"></i>Close
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	var assetPath = '{{ asset('') }}';
	var userRole = {{ \Auth::user()->role }};

	var loading;
	$(document).ready(function(){
		loading = new Image();
		loading.id = 'loadImg';
		loading.style = 'position: absolute; left: 50%; top: 50%; transform: translate(-60%, -60%) scale(0.5, 0.5); z-index: 100000;';
		loading.src = '{{ asset('img/loading-ajax.gif') }}';
	});
</script>

<script src="{{ asset('js/screens/userIndex.js') }}"></script>

@stop

