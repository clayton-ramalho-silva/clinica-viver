$(document).ready(function() {
	 
	$('.accordionButton').click(function() {

		$('.accordionButton').removeClass('on');
	 	$('.accordionContent').slideUp('fast');
		if($(this).next().is(':hidden') == true) {
			$(this).addClass('on');
			$(this).next().slideDown('fast');
		 } 
	});

	$('.accordionContent').hide();
});