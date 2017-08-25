$(document).ready(function(){  
$('#valide').on('click', function(e) {
	e.preventDefault();
	$.ajax({
	url: BASE_URL+'login/hello',
	type: 'POST',
	dataType: 'html',
	data: {nom: 'test'},
})
.done(function(data) {
	console.log("success");
})
.fail(function() {
	verificationNotifications('{"notification":"error"}');
})
.always(function() {
});
});

});