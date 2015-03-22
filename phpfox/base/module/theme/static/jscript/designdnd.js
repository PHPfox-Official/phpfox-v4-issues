var $oDesignDnD =
{		
	/* flat array of blocks, used to update/add blocks*/
	sOrder : '',
	
	/* id of the item being dragged, if 0 then its moving existing blocks, else 
	 * its adding a new block */
	mDragging : 0,
	
	iIteration : 0,
	buildOrder : function(oItem)
	{
		this.iIteration++;
		//console.log('|||| iIteration: ' + this.iIteration + ' ||||');
		var iCnt = 0;
		var aCache = new Array();
		var aClones = new Array();
		
		$('.js_sortable').each(function(iIndex, oElement)
		{				
			if ($(oElement).hasClass('do_not_count'))
			{
				/* this item is from the list of blocks to add */
				return true;
			}
			
			if (!empty(oElement.id))
			{					
				if ($(oElement).parents('.js_can_move_blocks').length < 1) 
				{
					return;
				}
				if (oElement.id.match(/clone_(.*)/))
				{
					aClones[oElement.id.replace('clone_', '')] = $(oElement).parents('.js_content_parent:first').attr('id');
				}
									
				aCache[oElement.id] = {						
					id: $(oElement).parents('.js_content_parent:first').attr('id'),
					target: $(oElement).parents('.js_can_move_blocks').attr('id').replace('js_can_move_blocks_','')
				};	
									
				oElement.id = oElement.id.replace('clone_', '');	
			}
		});
		this.sOrder = 'sMode=designdnd&sController='+oParams['sController'];
		for (sBlock in aCache)
		{				
			iCnt++;				
			if (!isset(aClones[sBlock]))
			{	
				this.sOrder += '&val[' + sBlock.replace('clone_', '').replace('js_block_border_', '') + '][ordering]=' + iCnt;
				this.sOrder += '&val[' + sBlock.replace('clone_', '').replace('js_block_border_', '') + '][target]=' + aCache[sBlock]['target'] + '';					
			}
		}
	}
};

/**
 *This function was taken out of enableDnD.update because it is also used 
 * from an ajax response, it seems that the update event did not really
 * act after altering the DOM, and window.dragNDropOrder did not include
 * the new block */


function enableDnD()
{
	$('body').sortable('destroy');
	$('body').sortable({			
		items: '.js_sortable',
		create : function(event, ui)
		{
			$('.js_sortable_header').mouseover(function()
			{
				$(this).find('.js_edit_header_hover').show();
			}).mouseout(function()
			{
				$(this).find('.js_edit_header_hover').hide();
			});	
		},
		update: function(element, ui)
		{				
			$oDesignDnD.buildOrder(this);							
			
			if ( window.mDragging != 0)
			{
				$.ajaxCall('theme.loadNewBlock', 'sId=' +  window.mDragging);
				//$('#' + $oDesignDnD.mDragging).html('<div id="design_dnd_loading">... loading ... </div>');
			}
			else
			{
				$.ajaxCall('theme.updateOrder', $oDesignDnD.sOrder);
			}			
			
			
		},	
		stop : function(element, ui)
		{			
			if (window.mDragging != 0)
			{
				$(ui.item).html('<div class="design_dnd_stop">' + oTranslations['core.loading'] + '...</div>');
			}
		},
		start: function(element, ui)
		{			
			$('.js_temp_place_holder').removeClass('js_temp_place_holder_hide').addClass('js_sort_holder_active');
			$oDesignDnD.mDragging = 0;
			window.mDragging = 0;
			
			if ((ui.item).attr('id').match(/new_/))
			{
				//$oDesignDnD.mDragging = (ui.item).attr('id'); // 0: Moving existing block, 1: Adding block	
				window.mDragging = (ui.item).attr('id');;
			}
			$(ui.item).attr('id', 'clone_' + $(ui.item).attr('id'));			
		},			
		opacity: 0.4,
		helper: 'clone',
		handle: '.js_sortable_header',
		placeholder: 'js_sort_holder',
		cursor: 'move'
	//axis: (oCore['core.can_move_on_a_y_and_x_axis'] ? false : 'y')
	}
	);	
}

$Behavior.dragDropBlocks = function()
{
	enableDnD();		
}