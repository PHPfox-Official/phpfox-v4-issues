
$Behavior.clickCustomChangeGroup = function()
{
	$('.js_custom_change_group').click(function()
	{		
		$(this).parents('ul:first').find('li').removeClass('active');
		$(this).parent().addClass('active');
		$('.js_custom_groups').hide();
		$('.js_custom_group_' + this.id.replace('group_', '')).show();				
		
		return false;
	});
}

/**
 * Displays or hides the "relationship with" input
 */
$Behavior.displayRelationshipChange = function()
{	
	if (typeof aRelationshipChange == 'undefined'){
		return;
	}
	
	/* Should we display the "with" field? */
	/* get the selected value */
	var $iSelected = $('#relation :selected').val();
	var $bShow = false;
	if (isset(aRelationshipChange[$iSelected]))
	{
		$bShow = true;
	}
	
	if ($bShow == true)
	{
		$('#relation_with').show();
	}
	else
	{
		$('#relation_with').hide();
	}
	
	$('.js_relation_with_message').hide();
	
	if ($('#relation option:selected').val() == 3 || $('#relation option:selected').val() == 4)
	{
		$('#relation_with_message_to').show();
	}
	else
	{
		$('#relation_with_message_with').show();
	}
}
