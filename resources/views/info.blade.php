@extends('userLayout')

@section('content')

@php
$user = \Auth::user();
@endphp

<script type="text/javascript">
	$('.listBtn').removeClass('active');
	$('#li-info').addClass('active');
</script>
<link href="http://bootstrap-live-customizer.com/bootstrap-3.3.5/fonts/glyphicons-halflings-regular.eot">
<style>

	div.teacher_img {
		margin-bottom: 1em;
	}
	.teacher_img .img_container {
		width: 250px;
		height: 250px;
		overflow: hidden;
	}
	.teacher_img img {
		width: 600px;
		max-width: 100%;
		text-align: center;
	}
	div.container-fluid.author {
		background-color: initial;
		text-align: center;
		/*padding: 0 100px 50px 100px;*/
	}
	div.label-wrapper {
		margin-bottom: 8px;
	}
	i.fa ~ label {
		margin-left: 0.5em;
		margin-bottom: 0;
	}
	.textbox {
		height: auto;
		background: rgba(255,255,255,0);
		color: #333;
		padding: 0 1.5em;
		border: none;
		border-bottom: 2px solid rgba(0, 153, 255, 0);
		border-radius: 1px;
		font-size: 1.4em;
		font-family: 'josefin_sansregular', sans-serif;
		outline: none;
		-webkit-transition: all 250ms ease-in;
		-moz-transition: all 250ms ease-in;
		-ms-transition: all 250ms ease-in;
		-o-transition: all 250ms ease-in;
		transition: all 250ms ease-in;
	}
	.textbox.username {
		font-size: 3em;
		padding: 0;
	}
	.textbox:focus {
		background: white;
		border-bottom: 2px solid rgba(0, 153, 255, 1);
	}
	input.textbox.username {
		text-align: center;
	}
	.col-sm-4.form-group {
		padding-left:3em;
	}
	div.row.info {
		margin-bottom: 2em;
	}
	div.row.save {
		padding-bottom: 2em;
		text-align: center;
	}
	button#save {
		font-size: 1.3em;
	}
	span.role {
		font-size: 1.5em;
		font-style: italic;
	}
	input::placeholder {
		font-size: 0.7em;
		color: #bfbfbf;
		transition: all 250ms
	}
	input:focus::placeholder {
		font-size: 0.7em;
		color: #8c8c8c;
	}
	.img_container {
		cursor: pointer;
	}
	.avatar_img {
		background: url("{{ asset('img/avatar/' . $user->avatar) }}") no-repeat center;
		background-size: cover;
		width: 100%;
		height: 100%;
	}
	.img_container .img-box {
		width: 100%;
		height: 100%;
		border-radius: 50%;
		border: 7px solid transparent;
		overflow: hidden;
	}
	.img_container .img-box:after {
		content: "";
		position: absolute;
		transform: translate(90px, -160px);
		font-family: "Glyphicons Halflings";
		font-size: 3.33333em;
		color: #fff;
		text-shadow: 0px 0px 10px #000;
		opacity: 0;
		display: none;
	}
	.img_container:hover .img-box:after {
		opacity: 1;
		display: block;
	}
	.img_container:hover .avatar_img {
		opacity: 0.6;
	}
	.img_container:hover .image-avatar {
		/*opacity: 0.8;*/
	}
	.help-block {
		font-weight: 600;
		font-style: italic;
		color: red;
		margin-top: 15px;
	}
	.modal-dialog {
		height: 100%;
		width: 400px;
		margin: 0 auto !important;
	}
	.modal-content {
		vertical-align: middle;
		top: 60%;
		transform: translateY(-70%);
	}
</style>

<div class="container">
	@if (session('msg'))
	<div class="alert alert-success">
		{{ session('msg') }}
	</div>
	@endif
		@foreach (['danger', 'warning', 'success', 'info'] as $msg)
			@if(Session::has('alert-' . $msg))
			<div class="alert alert-success alert-dismissable">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>{{ Session::get('alert-' . $msg) }}</strong>
			</div>
			@endif
		@endforeach
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
					Learner
					@elseif ($user->role == 1)
					Teacher
					@elseif ($user->role == 2)
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
					<div class="input-group">
						<input type="text" class="textbox first-name" name="first-name" id="first-name" value="{{ $user->first_name }}" placeholder="Enter your first name" maxlength="30" required>
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
					<div class="input-group">
						<input type="text" class="textbox last-name" name="last-name" id="last-name" value="{{ $user->last_name }}" placeholder="Enter your last name" maxlength="30" required>
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

				@if ($errors->has('date-of-birth'))
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
					<div class="input-group">
						<input type="email" class="textbox email" name="email" id="email" value="{{ $user->email }}" maxlength="191" required>
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
					<div class="input-group">
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
						<select class="textbox" name="country" id="country">
							@foreach ($countries as $code => $name)
								<option value="{{ $code }}">{{ $name }}</option>
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

<script>

	/**
	 * change Textbox Width 
	 * @param  {DOM} input 
	 * @return {void}     
	 */
	function changeTextboxWidth(input) {
		input.size= parseInt(input.value.length);
	}

	$('.img_container').click(function() {
		$('input.uploadAvatar').click();
	});

	$('input.uploadAvatar').on('change', function() {
		var ext = $('.uploadAvatar').val().split('.').pop().toLowerCase();
		
		if($.inArray(ext, ['png','jpg']) == -1) {
			$('.help-block.ext').show();
			return;
		}

		document.getElementById('avatarForm').submit();
	});

	$("#avatarForm").on('submit',(function(e) {
		e.preventDefault();
		$.ajax({
			url: "/editAvatar",
			type: "put",
			data: new FormData(this),
		}).done(function (data) {
			alert('okay');
		}).fail(function () {
			alert('Your request could not be done at the moment');
		});
	}));
</script>
@stop

