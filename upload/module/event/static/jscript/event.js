$Behavior.initViewEvent = function()
{
	var bDisable = true;
	if ($('.js_event_rsvp:checked').length < 1)
	{
		$('#btn_rsvp_submit').attr('disabled', 'disabled');
		$('.js_event_rsvp').click(function(){
			$('#btn_rsvp_submit').removeAttr('disabled','');
		});
	}	
}