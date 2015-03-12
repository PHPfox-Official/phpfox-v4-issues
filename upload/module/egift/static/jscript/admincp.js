$(document).ready(function(){
	$('.gift_cell').each(function(){		
		$(this).mouseover(function(){
			$('#gift_manage_' + $(this).attr('id').replace('gift_cell_','')).show();
		}).mouseout(function(){
			$('#gift_manage_' + $(this).attr('id').replace('gift_cell_','')).hide();
		});
	});
});