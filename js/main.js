console.log('Hello, World!');

$(document).ready(function() {



	$('.gallery-button').click(function() {

		$('.gallery-button').removeClass('gallery-btn-active');

		$(this).addClass('gallery-btn-active');

	});



});