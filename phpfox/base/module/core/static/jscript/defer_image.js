/* With this we load images until the script has finished preparing the DOM
 * which gives a better UX
 */
$Behavior.defer_images = function()
{
	$('.image_deferred').each(function(){
		if ( isset($(this).data('src')) && $(this).data('src').length > 0)
		{
			if ( $(this).is('img') )
			{
				$(this).attr('src', $(this).data('src'));
			}
			else if ($(this).is('a') && isset($(this).data('src')) && $(this).data('src').length > 0)
			{
				$(this).css('background-image', 'url(' + $(this).data('src') + ')');
			}
			$(this).removeAttr('data-src');
		}			
	});
};