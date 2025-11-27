$(function() {
	$("body").on("click", ".mroot-item", function () {
		$(this).next(".msub1").slideToggle(300);
	});
});