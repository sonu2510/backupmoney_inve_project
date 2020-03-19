function set_alert_message(message,getClass,icon){
	$("#display_alert_message span").html(message);
	$("#display_alert_message").addClass(getClass);
	$(".seticon").addClass(icon);
	$("#display_alert_message").slideDown(300).delay(3000).slideUp(300);
}

function redirect(url){
	var getPage = url;
	var setPage = getPage.replace(/&amp;/g, '&');
	window.location = setPage;
}

function getUrl(url){
	var setPage = url.replace(/&amp;/g, '&');
	return setPage;
}

function validateUploadImage(file){
	var error = '';
	var ext = file.split('.').pop().toLowerCase();
	if($.inArray(ext, ["jpg", "png", "gif", "bmp","jpeg","PNG","JPG","JPEG","GIF","BMP"]) == -1) {
		error = 'invalid image upload !'
	}
	return error;
}