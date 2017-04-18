@if (isset($users))
<div id="load" class="normal" style="position: relative;">
	<table class="table table-hover" id="studentTable">
		<tr class="first_row">
			<th class="head">Name</th>
			<th class="head">Username</th>
			<th class="head">Email</th>
			<th class="head">Date of birth</th>
			<th class="head">Gender</th>
			<th class="head"></th>
		</tr>

		@foreach ($users as $user)
		<tr>
			<td>
				@if (($user->first_name || $user->last_name) && (strcmp($user->first_name, '') != 0 || strcmp($user->last_name, '') != 0))
				{{ $user->first_name . ' ' . $user->last_name }}
				@else
				<span class="unavailable_info">Unavailable</span>
				@endif
			</td>
			<td>
				@if ($user->username && strcmp($user->username, '') != 0)
				{{ $user->username }}
				@else
				<span class="unavailable_info">Unavailable</span>
				@endif
			</td>
			<td>
				@if ($user->email && strcmp($user->email, '') != 0)
				{{ $user->email }}
				@else
				<span class="unavailable_info">Unavailable</span>
				@endif
			</td>
			<td>
				@if ($user->date_of_birth && strcmp($user->date_of_birth, '') != 0)
				{{ $user->date_of_birth }}
				@else
				<span class="unavailable_info">Unavailable</span>
				@endif
			</td>
			<td>
				@if ($user->gender && strcmp($user->gender, '') != 0 && $user->gender == 1)
				Male
				@elseif($user->gender && strcmp($user->gender, '') != 0 && $user->gender == 0)
				Female
				@else
				<span class="unavailable_info">Unavailable</span>
				@endif
			</td>
			<td>
				<button type="button" class="edit-modal btn btn-primary btn-sm" data-user-id="{{ $user->id }}" data-user-username="{{ $user->username }}" data-user-role="{{ $user->role }}"><i class="fa fa-edit"></i>Set role</button>
			</td>
		</tr>
		@endforeach
	</table>
	<div class="row" style="text-align: center;">
		{{ $users->links() }}
	</div>
</div>
@endif