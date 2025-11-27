function ajaxpost(urlres, datares, wherecontent){
	$.ajax({
		type: "POST",
		url: urlres,
		data: datares,
		dataType: "html",
		success: function(fillter) {
			$(wherecontent).html(fillter);
		}
	});
}

$(function() {
	$(".subscribe__form").on("submit", function() {
		var _form_subs = $(this).serialize();
		var _action = $(this).attr('action');
		_form_subs = _form_subs + '&action=ajax';
		ajaxpost(_action, _form_subs, ".subscribe__mailing" );
		return false;
	});
});
