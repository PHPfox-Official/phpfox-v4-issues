
document.write('<link rel="stylesheet" type="text/css" href="' + getParam('sStylePath') + 'drag.css?v=' + getParam('sVersion') + '" />');
document.write('<script type="text/javascript" src="' + getParam('sJsStatic') + 'jscript/jquery/plugin/jquery.tablednd.js?v=' + getParam('sVersion') + '"></script>');

Core_drag =
{
	init: function(aParams)
	{
		$(document).ready(function() 
		{    
    		$(aParams['table']).tableDnD(
    		{
    			dragHandle: 'drag_handle',
    			onDragClass: 'drag_my_class',
    			onDrop: function (oTable, oRow)
    			{    				
    				iCnt = 0;
    				sParams = '';
    				$('.drag_handle input').each(function()
    				{
    					iCnt++;
    					
    					sParams += '&' + $(this).attr('name') + '=' + iCnt;
    				});   
    				
    				$('.drag_handle_input').each(function()
    				{
    					sParams += '&' + $(this).attr('name') + '=' + $(this).attr('value');
    				});
    				
    				$Core.ajaxMessage();
    				$.ajaxCall(aParams['ajax'], sParams + '&global_ajax_message=true');
    			}    			
    		});
		
    		$(aParams['table'] + " tr.checkRow").hover(                                       
				function() 
				{ 
					$(this.cells[0]).addClass('drag_show_handle'); 
				},                                       
				function() 
				{ 
					$(this.cells[0]).removeClass('drag_show_handle'); 
				}                     
			);		
		});		
	}
};