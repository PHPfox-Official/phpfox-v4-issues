$Behavior.profile_controller_designon_update_2 = function()
{ 
	window.designOnUpdate = function() 
	{ 
		$Core.design.updateSorting(); 
	};
};
		
$Behavior.profile_design_init_2 = function() 
{
	$Core.design.init({type_id: 'profile'}); 
};