@extends('userLayout')

@section('content')

@php
$user = \Auth::user();
@endphp

<script type="text/javascript">
	$('.listBtn').removeClass('active');
	$('#li-info').addClass('active');
</script>
{{-- <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script> --}}
<link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker3.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/screens/userInfo.css') }}">
<link href="http://bootstrap-live-customizer.com/bootstrap-3.3.5/fonts/glyphicons-halflings-regular.eot">
<style>
	.avatar_img {
		background: url("{{ \Storage::url($user->avatar) }}") no-repeat center;
		background-size: cover;
		width: 100%;
		height: 100%;
	}
</style>

<div class="container">
	@if ($errors->has('pass'))
	<div class="alert alert-danger alert-dismissable">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>{{ $errors->first('pass') }}</strong>
	</div>
	@elseif ($errors->has('pass.newPassword'))
	<div class="alert alert-danger alert-dismissable">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>{{ $errors->first('pass.newPassword') }}</strong>
	</div>
	@endif
	<form action="editUser" method="post">
		{{ csrf_field() }}

		<div class="row container-fluid author">
			<div class="teacher_img">
				<div class="img_container"><div class="img-box">
					<div class="avatar_img"></div>
				</div></div>
				<div class="help-block ext" style="display: none;">
					<strong>Only .jpg or .png is accepted</strong>
				</div>
				@if ($errors->has('avatar'))
				<span class="help-block">
					<strong>{{ $errors->first('avatar') }}</strong>
				</span>
				@endif
			</div>
			<div class="{{ $errors->has('username') ? ' has-error' : '' }}" style="text-align: center;">
				<input type="text" class="textbox username" name="username" id="username" size="7" value="{{ $user->username }}" maxlength="191" onkeypress="changeTextboxWidth(this)" required>

				@if ($errors->has('username'))
				<div class="help-block">
					<span>{{ $errors->first('username') }}</span>
				</div>
				@endif
			</div>
			<div>
				<span class="role">
					@if ( $user->role == 0 )
					No role
					@elseif ($user->role == 1)
					Applicant
					@elseif ($user->role == 2)
					Leaner
					@elseif ($user->role == 3)
					Teacher
					@elseif ($user->role == 10)
					Admin
					@elseif ($user->role == 100)
					Super Admin
					@endif
				</span>
			</div>
		</div>
		<div class="row info">
			<div class="col-sm-4 form-group{{ $errors->has('first-name') ? ' has-error' : '' }}">
				<div class="label-wrapper"><i class="fa fa-user fa" aria-hidden="true"></i><label for="first-name" class="cols-sm-2 control-label">First name:</label></div>
				<div>
					<div class="input-group" style="width: 100%;">
						<input type="text" class="textbox first-name" name="first-name" id="first-name" value="{{ $user->first_name }}" placeholder="Enter your first name" maxlength="30" required style="width: 100%;">
					</div>
				</div>

				@if ($errors->has('first-name'))
				<div class="help-block">
					<span>{{ $errors->first('first-name') }}</span>
				</div>
				@endif
			</div>
			<div class="col-sm-4 form-group{{ $errors->has('last-name') ? ' has-error' : '' }}">
				<div class="label-wrapper"><i class="fa fa-user fa" aria-hidden="true"></i><label for="last-name" class="cols-sm-2 control-label">Last name:</label></div>
				<div>
					<div class="input-group" style="width: 100%;">
						<input type="text" class="textbox last-name" name="last-name" id="last-name" value="{{ $user->last_name }}" placeholder="Enter your last name" maxlength="30" required style="width: 100%;">
					</div>
				</div>

				@if ($errors->has('last-name'))
				<div class="help-block">
					<span>{{ $errors->first('last-name') }}</span>
				</div>
				@endif
			</div>
			<div class="col-sm-4 form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
				<div class="label-wrapper"><i class="fa fa-flag fa" aria-hidden="true"></i><label for="gender" class="cols-sm-2 control-label">Gender:</label></div>
				<div>
					<div class="input-group">
						<select class="textbox" id="gender" name="gender">
							<option value="1"{{ $user->gender === 1 ? ' selected' : '' }}>Male</option>
							<option value="0"{{ $user->gender === 0 ? ' selected' : '' }}>Female</option>
						</select>
					</div>
				</div>

				@if ($errors->has('gender'))
				<div class="help-block">
					<span>{{ $errors->first('date-of-birth') }}</span>
				</div>
				@endif
			</div>
		</div>
		<div class="row info">
			<div class="col-sm-4 form-group{{ $errors->has('email') ? ' has-error' : '' }}">
				<div class="label-wrapper"><i class="fa fa-envelope fa" aria-hidden="true"></i><label for="email" class="cols-sm-2 control-label">Email:</label></div>
				<div>
					<div class="input-group" style="width: 100%;">
						<input type="email" class="textbox email" name="email" id="email" value="{{ $user->email }}" maxlength="191" required style="width: 100%;">
					</div>
				</div>

				@if ($errors->has('email'))
				<div class="help-block">
					<span>{{ $errors->first('email') }}</span>
				</div>
				@endif
			</div>
			<div class="col-sm-4 form-group{{ $errors->has('date-of-birth') ? ' has-error' : '' }}">
				<div class="label-wrapper"><i class="fa fa-calendar fa" aria-hidden="true"></i><label for="date-of-birth" class="cols-sm-2 control-label">Date of birth:</label></div>
				<div>
					<div class="input-group date-of-birth-wrapper">
						<input type="date" class="textbox date-of-birth" name="date-of-birth" id="date-of-birth" value="{{ $user->date_of_birth }}" maxlength="191" required>
					</div>
				</div>

				@if ($errors->has('date-of-birth'))
				<div class="help-block">
					<span>{{ $errors->first('date-of-birth') }}</span>
				</div>
				@endif
			</div>
			<div class="col-sm-4 form-group{{ $errors->has('contry') ? ' has-error' : '' }}">
				<div class="label-wrapper"><i class="fa fa-flag fa" aria-hidden="true"></i><label for="country" class="cols-sm-2 control-label">Living country:</label></div>
				<div>
					<div class="input-group">
						<select class="textbox" name="country" id="country" style="width: 100%">
							@foreach ($countries as $code => $name)
							<option value="{{ $code }}" {{ strcmp($code, $user->country) == 0 ? 'selected' : '' }}>{{ $name }}</option>
							@endforeach
						</select>
					</div>
				</div>

				@if ($errors->has('country'))
				<div class="help-block">
					<span>{{ $errors->first('country') }}</span>
				</div>
				@endif
			</div>
		</div>
		<div class="row save">
			<a href="#custommodal" role="button" class="btn btn-warning" data-toggle="modal" style="font-size: 1.3em;">Change password</a>
			<button type="submit" id="save" class="btn btn-success">Save changes</button>
		</div>
	</form>

	<!-- Modal HTML -->
	<form method="post" action="/chgPassword">
		{{ csrf_field() }}
		<div id="custommodal" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Change password</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="oldPassword">Old password:</label>
							<input id="oldPassword" name="pass[oldPassword]" type="password" class="form-control" maxlength="24" required>
						</div>
						<div class="form-group">
							<label for="newPassword">New password:</label>
							<input id="newPassword" name="pass[newPassword]" type="password" class="form-control" maxlength="24" required>
						</div>
						<div class="form-group">
							<label for="newPasswordConfirm">Confirm new password:</label>
							<input id="newPasswordConfirm" name="pass[password_confirm]" type="password" class="form-control" maxlength="24" required>
						</div>
					</div>
					<div class="modal-footer" style="text-align: center;">
						<button class="btn btn-success">Change</button>
					</div>
				</div>
			</div>
		</div>
	</form>

	{!! Form::open(array('url'=>'/editAvatar','method'=>'POST', 'files'=>true, 'id' =>'avatarForm')) !!}
	{{ csrf_field() }}
	<input type="file" class="uploadAvatar" name="avatar" accept="image/*" style="display: none;">
	{!! Form::close() !!}
</div>

<script src="{{ asset('js/modernizr-custom.js') }}"></script>

<script>

	if (!Modernizr.inputtypes.date) {
		jQuery.getScript("{{ asset('js/bootstrap-datepicker.min.js') }}")
		.done(function(){
			$('.date-of-birth-wrapper').empty();
			while(document.getElementsByClassName('date-of-birth-wrapper')[0].firstChild) {
				document.getElementsByClassName('date-of-birth-wrapper').removeChild(document.getElementsByClassName('date-of-birth-wrapper').firstChild);
			}

			var input = document.createElement('input');
			input.name = "date-of-birth";
			input.id = "date-of-birth";
			input.type = 'text';
			input.className = 'textbox date-of-birth';
			input.value = '{{ $user->date_of_birth }}';
			input.required = '';
			$(input).datepicker({
				format: 'yyyy-mm-dd',
				weekStart: 1,
				container: '.date-of-birth-wrapper'
			});

			document.getElementsByClassName('date-of-birth-wrapper')[0].appendChild(input);
		});
	}
</script>

<script src="{{ asset('js/screens/userInfo.js') }}"></script>

@stop

