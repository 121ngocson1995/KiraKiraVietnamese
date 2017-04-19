@extends('userLayout')

@section('header-more')

<style type="text/css">
	td {
		vertical-align: middle !important;
	}
	.fa {
		margin-left: 0;
		margin-right: 0.5em;
	}
	.unavailable_info {
		color: grey;
		font-size: smaller;
		font-style: italic;
	}
	a.tab_toggle {
		cursor: pointer;
	}
	.table > tbody > tr > th {
		border-top: none !important;
	}

	label.btn span {
		font-size: 1.5em ;
	}


	label.focus {
		outline: none !important;
	}
	label input[type="radio"] ~ i.fa.fa-square-o{
		color: #c8c8c8;
		display: inline;
	}
	label input[type="radio"] ~ i.fa.fa-check-square-o{
		display: none;
	}
	label input[type="radio"]:checked ~ i.fa.fa-square-o{
		display: none;
	}
	label input[type="radio"]:checked ~ i.fa.fa-check-square-o{
		color: #7AA3CC;    display: inline;
	}
	label:hover input[type="radio"] ~ i.fa {
		color: #7AA3CC;
	}

	div[data-toggle="buttons"] label.active{
		color: #7AA3CC;
	}

	div[data-toggle="buttons"] label {
		display: inline-block;
		padding: 6px 12px;
		margin-bottom: 0;
		font-size: 14px;
		font-weight: normal;
		line-height: 2em;
		text-align: left;
		white-space: nowrap;
		vertical-align: top;
		cursor: pointer;
		background-color: none;
		border: 0px solid 
		#c8c8c8;
		border-radius: 3px;
		color: #c8c8c8;
		-webkit-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		-o-user-select: none;
		user-select: none;
	}

	div[data-toggle="buttons"] label:hover {
		color: #7AA3CC;
	}
	#load {
		margin: 2em 0;
	}
	div[data-toggle="buttons"] label:active, div[data-toggle="buttons"] label.active {
		-webkit-box-shadow: none;
		box-shadow: none;
	}
	.search-outer {
		width: 100%;
		text-align: center;
	}
	.search {
		display: inline-grid;
		width: 80%;
	}
	.search .field {
		position: relative;
	}
	.search label {
		background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA4AAAAOCAQAAAC1QeVaAAAAxElEQVR4AXXPIUuDcRDA4Zv4AUSwTLEKVoNlySyCYLO98CCsahGrX0AW/QhmBRHEJghLS4JFBBXDgrJi2In78w8v4v3S8XDh4nd0DTxLEzd2RC2EnrH07trQVDrXqbhs7FvfnBDWDKWTigOpL2oWvZpYKPjio1zVHEt7BdOtaLUtHRX8MmqjRjooeCVttPBOWi+4JT1aLaDjVLpU/5ytn840Dj1IaWSpYmi8yVlTF54qh9K8nn27usJK5fC3yvfhPx7a/AE9dYwDEfKrlAAAAABJRU5ErkJggg==) no-repeat 0 50%;
		color: #b2b2b2;
		left: 50%;
		position: absolute;
		transform: translate(-50%, -50%);
		top: 50%;
		transition: left .4s, transform .4s;
		padding-left: 1.25em;
	}
	.search .input-search {
		padding: .5em 1.75em;
	}
	.search .input-search:focus + label, .search .input-search:valid + label {
		left: .5em;
		transform: translate(0, -50%);
	}
	.search .input-search:valid + label {
		text-indent: -9999px;
	}
	.label-search {
		cursor: text;
		font-weight: 600;
	}

</style>

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
						<div class="btn-group btn-group" data-toggle="buttons">
							<label class="btn radio-role">
								<input id="radio_sadmin" type="radio" name='role' value="100"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> Super admin
							</label>
							<label class="btn radio-role">
								<input id="radio_admin" type="radio" name='role' value="10"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> Admin
							</label>
							<label class="btn radio-role">
								<input id="radio_teacher" type="radio" name='role' value="3"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> Teacher</span>
							</label>
							<label class="btn radio-role">
								<input id="radio_norole" type="radio" name='role' value="0"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> No role</span>
							</label>
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
	var role = 'all';

	$(function() {
		$('body').on('click', '.pagination a', function(e) {
			e.preventDefault();

			$('#load').children().css('opacity', 0.5);
			$('#load').append('<img style="position: absolute; left: 50%; top: 50%; transform: translate(-60%, -60%) scale(0.5, 0.5); z-index: 100000;" src="' + assetPath + 'img/loading-ajax.gif" />');

			var url = $(this).attr('href') + '&type=' + role;

			if(document.getElementById('input-search').value) {
				url += '&keyword=' + document.getElementById('input-search').value;
			}

			getUsers(url);
			// window.history.pushState("", "", url);
		});

		$('body').on('click', 'a.tab_toggle', function(e) {
			filterByRole(role);
		});

		$('#input-search').keypress(function(e) {
			var keyPress = e.keyCode || e.which;
			if (keyPress == '13'){
				var keyword = document.getElementById('input-search').value;
				filterByName(keyword);
			}
		})

		function filterByRole(role) {
			$('#load').children().css('opacity', 0.5);
			$('.main-container').append('<img id="loadImg" style="position: absolute; left: 50%; top: 50%; transform: translate(-60%, -60%) scale(0.5, 0.5); z-index: 100000;" src="' + assetPath + 'img/loading-ajax.gif" />');

			var url = window.location.pathname + '?page=1' + '&type=' + role;
			getUsers(url);
			// window.history.pushState("", "", url);
		}

		function filterByName(keyword) {
			$('#load').children().css('opacity', 0.5);
			$('.main-container').append('<img id="loadImg" style="position: absolute; left: 50%; top: 50%; transform: translate(-60%, -60%) scale(0.5, 0.5); z-index: 100000;" src="' + assetPath + 'img/loading-ajax.gif" />');

			var url = window.location.pathname + '?page=1' + '&type=' + role + '&keyword=' + keyword;
			getUsers(url);
			// window.history.pushState("", "", url);
		}

		function getUsers(url) {
			$.ajax({
				url : url
			}).done(function (data) {
				$('#userList').html(data);
				document.getElementsByClassName('main-container')[0].removeChild(document.getElementById('loadImg'));
			}).fail(function () {
				document.getElementsByClassName('main-container')[0].removeChild(document.getElementById('loadImg'));
				alert('User list could not be loaded.');
			});
		}

		var userid, oldRole;

		$('body').on('click', '.edit-modal', function() {
			userid = $(this).attr('data-user-id');
			oldRole = $(this).attr('data-user-role');
			$('.modal-title').text('Set role for ' + $(this).attr('data-user-username'));
			$('.chooseRole input[type="radio"]').prop('checkd', false);
			if ($(this).attr('data-user-role') == '0') {
				$('#radio_norole').prop('checked', true);
			} else if ($(this).attr('data-user-role') == '3') {
				$('#radio_teacher').prop('checked', true);
			} else if ($(this).attr('data-user-role') == '10') {
				$('#radio_admin').prop('checked', true);
			} else if ($(this).attr('data-user-role') == '100') {
				$('#radio_sadmin').prop('checked', true);
			}
			$('#setRoleModal').modal('show');
		});

		$('.modal-footer').on('click', '.set', function() {
			var newRole;

			for (var i = 0; i < $('.radio-role').length; i++) {
				if ($($('.radio-role')[i]).hasClass('active')) {
					newRole = $($('.radio-role')[i]).find('input').attr('value');
				}
			}

			if (!newRole) {
				newRole = oldRole;
			}

			$.ajax({
				type: 'post',
				url: '/setRole',
				data: {
					'_token': $('input[name=_token]').val(),
					'userid': userid,
					'oldRole' : oldRole,
					'newRole' : newRole
				}
			}).done(function (data) {
				$('#load').children().css('opacity', 0.5);
				$('.main-container').append(loading);

				var url = window.location.pathname + '?page=1' + '&type=' + role;
				getUsers(url);
			}).fail(function () {
				alert('Your request could not be done at the moment');
			});
		});
	});

	$('.all_toggle').click(function() {
		toggle_all();
	})

	$('.admins_toggle').click(function() {
		toggle_admins();
	})

	$('.teachers_toggle').click(function() {
		toggle_teachers();
	})

	$('.pending_toggle').click(function() {
		toggle_pending();
	})

	$('.rejected_toggle').click(function() {
		toggle_rejected();
	})

	function toggle_all() {
		role = 'all';
	}

	function toggle_admins() {
		role = 'admins';
	}

	function toggle_teachers() {
		role = 'teachers';
	}

	function toggle_pending() {
		role = 'pending';
	}

	function toggle_rejected() {
		role = 'rejected';
	}

	var loading;
	$(document).ready(function(){
		loading = new Image();
		loading.id = 'loadImg';
		loading.style = 'position: absolute; left: 50%; top: 50%; transform: translate(-60%, -60%) scale(0.5, 0.5); z-index: 100000;';
		loading.src = '{{ asset('img/loading-ajax.gif') }}';
	});
</script>
@stop

