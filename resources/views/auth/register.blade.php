@extends('layouts.app')

@section('header')

{{-- <link rel="stylesheet" href="{{ asset('css/bootstrap-formhelpers.min.css') }}">
<script src="{{ asset('js/bootstrap-formhelpers.min.js') }}"></script> --}}
<link rel="stylesheet" href="{{ asset('css/register-login.css') }}">
<link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker3.min.css') }}">
<style>
	body {
		height: calc(100% - 65px);
		background-repeat: no-repeat;
		background:url({{ asset('img/register-bg.svg') }}) no-repeat center center fixed;
		font-family: 'Oxygen', sans-serif;
		background-size: cover;
	}
	hr {
		width: 30%;
		color: grey;
	}
	.note {
		float: right;
		margin-right: 0.5em;
		font-size: smaller;
		font-style: italic;
	}
	.alert.alert-danger {
		padding: 6px 25px;
		color: #a94442;
		background-color: #f2dede;
		border-color: #ebccd1;
		font-weight: bolder;
		font-style: italic;
	}
	.form-group > div:nth-child(2) {
		display: inline-block;
		display: ruby;
	}
	.gender-birth .alert.alert-danger {
		display: -webkit-box;
	}
	.dropdown-menu {
		color: initial;
	}
</style>
<link href="{{ asset('css/fileinput.css') }}" media="all" rel="stylesheet" type="text/css"/>
<link href="{{ asset('themes/explorer/theme.css') }}" media="all" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker3.min.css') }}">
<script src="{{ asset('js/fileinput.min.js') }}" type="text/javascript"></script>

@stop

@section('body')

<div class="container">
	<div class="row main">
		<div class="main-login main-center">
			{{-- <h4 style="color: white">Apply to become a teacher at KiraKiraVietnamese</h4> --}}
			{!! Form::open(array('url'=>route('register'),'method'=>'POST', 'files'=>true)) !!}

			<div class="form-group{{ $errors->has('first-name') || $errors->has('last-name') ? ' has-error' : '' }}">
				<label for="name" class="cols-sm-2 control-label">Your Name</label>
				<div style="display: inline-block">
					<div class="col-sm-6 first-name">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
							<input type="text" class="form-control" name="first-name" id="first-name" value="{{ old('first-name') }}" maxlength="30" placeholder="Enter your first name" required autofocus>
						</div>
					</div>
					<div class="col-sm-6 last-name">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
							<input type="text" class="form-control" name="last-name" id="last-name" value="{{ old('last-name') }}" maxlength="30" placeholder="Enter your last-name" required>
						</div>
					</div>
				</div>

				@if ($errors->has('first-name'))
				<div class="alert alert-danger">
					<span>{{ $errors->first('first-name') }}</span>
				</div>
				@endif

				@if ($errors->has('last-name'))
				<div class="alert alert-danger">
					<span>{{ $errors->first('last-name') }}</span>
				</div>
				@endif

				@if ($errors->has('nameWord.*'))
				<div class="alert alert-danger">
					<span>Name can only contain letters.</span>
				</div>
				@endif
			</div>

			<div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
				<label for="username" class="cols-sm-2 control-label">Username</label>
				<div class="cols-sm-10">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-users fa" aria-hidden="true"></i></span>
						<input type="text" class="form-control" name="username" id="username" value="{{ old('username') }}" maxlength="191" placeholder="Enter your Username" required>
					</div>
				</div>

				@if ($errors->has('username'))
				<div class="alert alert-danger">
					<span>{{ $errors->first('username') }}</span>
				</div>
				@endif
			</div>

			<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
				<label for="email" class="cols-sm-2 control-label">Your Email</label>
				<div class="cols-sm-10">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
						<input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" maxlength="191" placeholder="Enter your Email" required>
					</div>
				</div>

				@if ($errors->has('email'))
				<div class="alert alert-danger">
					<span>{{ $errors->first('email') }}</span>
				</div>
				@endif
			</div>

			<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
				<label for="password" class="cols-sm-2 control-label">Password</label>
				<div class="cols-sm-10">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
						<input type="password" class="form-control" name="password" id="password" maxlength="24" pattern=".{6,}" required title="Password must be at least 6 characters" placeholder="Enter your Password" required>
					</div>
				</div>

				@if ($errors->has('password'))
				<div class="alert alert-danger">
					<span>{{ $errors->first('password') }}</span>
				</div>
				@endif
			</div>

			<div class="form-group">
				<label for="password-confirm" class="cols-sm-2 control-label">Confirm Password</label>
				<div class="cols-sm-10">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
						<input type="password" class="form-control" name="password_confirmation" id="password-confirm" maxlength="24" pattern=".{6,}" required title="Password must be at least 6 characters" placeholder="Confirm your Password" required>
					</div>
				</div>
			</div>

			<div class="gender-birth">
				<div style="display: inline-block;">
					<div class="form-group col-sm-5">
						<label for="gender" class="cols-sm-2 control-label">Gender</label>
						{{-- <div style="display: inline-block"> --}}
						<div class="gender">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-transgender fa-lg" aria-hidden="true"></i></span>
								<select class="form-control" id="gender" name="gender">
									<option value="1"{{ old('gender') == null || old('gender') === 1 ? ' selected' : '' }}>Male</option>
									<option value="0"{{ old('gender') === 0 ? ' selected' : '' }}>Female</option>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group col-sm-7">
						<label for="date-of-birth" class="cols-sm-2 control-label">Date of birth</label>
						<div class="date-of-birth">
							<div class="input-group" id="date-of-birth-input-group">
								<span class="input-group-addon"><i class="fa fa-calendar fa-lg" aria-hidden="true"></i></span>
								<input type="date" class="form-control" name="date-of-birth"{{ old('date-of-birth') ? 'value=' . old('date-of-birth')  : '' }} id="date-of-birth" required>
							</div>
						</div>
					</div>
				</div>

				@if ($errors->has('gender'))
				<div class="alert alert-danger">
					<span>{{ $errors->first('gender') }}</span>
				</div>
				@endif

				@if ($errors->has('date-of-birth'))
				<div class="alert alert-danger">
					<span>{{ $errors->first('date-of-birth') }}</span>
				</div>
				@endif
			</div>

			<div class="form-group">
				<label for="cv-upload" class="cols-sm-2 control-label">CV File</label><span class="note">Only .doc, .docx, .pdf; Max size: 10Mb</span>
				<input id="cv-upload" name="cv" type="file" class="file" data-show-upload="false" data-show-caption="true" data-show-preview="false" data-allowed-file-extensions='["pdf", "doc", "docx"]'{{ old('cv') ? ' value=' . old('cv')  : '' }} required>
			</div>

			@if ($errors->has('cv'))
			<div class="alert alert-danger">
				<span>{{ $errors->first('cv') }}</span>
			</div>
			@endif

			<hr>

			<div class="form-group">
				<button type="submit" target="_blank" id="submitBtn" class="btn btn-success btn-lg btn-block login-button">Register</button>
			</div>

			{!! Form::close() !!}
		</div>
	</div>
</div>

<script src="{{ asset('js/modernizr-custom.js') }}"></script>

<script>
	if (!Modernizr.inputtypes.date) {
		jQuery.getScript("{{ asset('js/bootstrap-datepicker.min.js') }}")
		.done(function(){
			var container = $('#date-of-birth').parent()[0];
			$('#date-of-birth').remove();

			var input = document.createElement('input');
			input.name = "date-of-birth";
			input.id = "date-of-birth";
			input.type = 'text';
			input.className = 'form-control';
			input.value = '{{ old('date-of-birth') ? 'value=' . old('date-of-birth')  : '' }}';
			input.required = '';
			$(input).datepicker({
				format: 'yyyy-mm-dd',
				weekStart: 1,
				container: '#date-of-birth-input-group'
			});

			container.appendChild(input);
		});
	}
</script>
@endsection
