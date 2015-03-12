
						$Behavior.notificationDeleteLink = function()
						{
							if ($Core.exists('.notification_holder'))
							{
								$('.notification_holder li').mouseover(function(){
									$(this).find('.notification_delete').show();
								});
								
								$('.notification_holder li').mouseout(function(){
									$(this).find('.notification_delete').hide();
								});								
							}
						}