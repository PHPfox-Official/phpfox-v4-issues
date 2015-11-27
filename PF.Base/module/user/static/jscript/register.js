
$Core.registration = 
{
	iStep: 1,
	iTotalSteps: 2,
	
	submitForm: function()
	{
		$('#core_js_messages').html('');
		$('#js_signup_error_message').html('');
		$('#js_register_accept').hide();		
		$('#js_registration_holder').hide();		
		$('#js_registration_process').css('height', $('#js_registration_holder').height() + 'px');
		$('#js_registration_process').show();
		
		$('#js_form').ajaxCall('user.getRegistrationStep', 'step=' + this.iStep + '&last=' + (this.iStep == this.iTotalSteps ? '1' : '0') + '&next=' + ((this.iStep + 1) == this.iTotalSteps ? '1' : '0') + '');
	},
	
	updateForm: function(sHtml)
	{
		$('#js_register_step' + this.iStep).hide();
		$('#js_signup_block').append(sHtml);
		$('#js_registration_process').hide();
		$('#js_registration_process').css('height', $('#js_registration_holder').height() + 'px');
		$('#js_registration_holder').show();
		// $('#js_registration_submit').val(oTranslations['user.continue']);
		
		this.iStep++;
	},
	
	showCaptcha: function()
	{
		$('#js_register_capthca_image').show();	
	},

	useSuggested: function(oObj)
	{
		$('#user_name').val($(oObj).html());
		$('#js_verify_username').hide();
		$('#js_signup_user_name').html('<span style="color:green; font-weight:bold;">' + $(oObj).html() + '</span>');
	}
}

$Behavior.user_register_init = function()
{
	$('#js_submit_register_form').click(function()
	{	
		return $Core.registration.submitForm();
	});
	
	/*$("#user_name").bt({
		trigger: ['focus'],
		clickAnywhereToClose: true,
		positions: ['right', 'most'],
		fill: '#F4F4F4',
		strokeStyle: '#666666',
		spikeLength: 15,
		spikeGirth: 10,
		width: 180,
		overlap: 0,
		centerPointY: 1,
		cornerRadius: 0,
		cssStyles: {
			fontFamily: '"Lucida Grande",Helvetica,Arial,Verdana,sans-serif',
			fontSize: '12px',
			padding: '10px 14px'
		},
		shadow: true,
		shadowColor: 'rgba(0,0,0,.5)',
		shadowBlur: 8,
		shadowOffsetX: 4,
		shadowOffsetY: 4,
		shrinkToFit: true
	});*/
};