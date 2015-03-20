
$Behavior.marketplaceShowImage = function(){

	$('.listing_view_images ._thumbs img').each(function() {
		var t = $(this),
			src = t.attr('src').replace('_120_square', '_400'),
			img = new Image();

		if (src == $('.listing_view_images ._main img').attr('src')) {
			t.addClass('active');
		}

		img.src = src;
	});

	$('.listing_view_images ._thumbs img').click(function() {
		var t = $(this),
			src = t.attr('src').replace('_120_square', '_400');

		$('.listing_view_images ._thumbs img.active').removeClass('active');
		$('.listing_view_images ._main img').attr('src', src);
		t.addClass('active');
	});
}