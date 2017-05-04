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