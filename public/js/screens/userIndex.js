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

		var userid, oldRole, auth=true;

		$('body').on('click', '.edit-modal', function() {
			userid = $(this).attr('data-user-id');
			oldRole = $(this).attr('data-user-role');
			var tr =  $(this).closest('tr');
			$('#setRoleModal').find('.roleToChoose').empty();

			if(userRole <= oldRole) {
				var msg = 'You do not have enough authority to perform this action.';
				var div_help = document.createElement('div');
				div_help.className = 'alert alert-danger alert-dismissable fade in';
				div_help.innerHTML = '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><span class="help">' +  msg +  '</span>';
				document.getElementById('alert-holder').appendChild(div_help);
				$('#alert-holder')[0].scrollIntoView();

				return false;
			}
			
			if (userRole == 100) {
				var label = document.createElement('label');
				label.className = 'btn radio-role';
				label.innerHTML = '<input id="radio_admin" type="radio" name="role" value="10"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> Admin</span>';
				$('#setRoleModal').find('.roleToChoose').append(label);

				label = document.createElement('label');
				label.className = 'btn radio-role';
				label.innerHTML = '<input id="radio_teacher" type="radio" name="role" value="3"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> Teacher</span>';
				$('#setRoleModal').find('.roleToChoose').append(label);

				label = document.createElement('label');
				label.className = 'btn radio-role';
				label.innerHTML = '<input id="radio_norole" type="radio" name="role" value="0"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> No role</span>';
				$('#setRoleModal').find('.roleToChoose').append(label);
			}
			if (userRole == 10 && oldRole < 10) {
				var label = document.createElement('label');
				label.className = 'btn radio-role';
				label.innerHTML = '<input id="radio_teacher" type="radio" name="role" value="3"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> Teacher</span>';
				$('#setRoleModal').find('.roleToChoose').append(label);

				label = document.createElement('label');
				label.className = 'btn radio-role';
				label.innerHTML = '<input id="radio_norole" type="radio" name="role" value="0"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> No role</span>';
				$('#setRoleModal').find('.roleToChoose').append(label);
			}

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