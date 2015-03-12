$Core.invite =
	{
		iEnabled : 0,
		localSelector: function(sValue)
		{
			$('.checkbox').each(function(){
				if (sValue == "none")
				{
					$(this).attr('checked', false);
					$('#js_action_selector').attr('disabled', 'disabled');
				}
				if (sValue == "all")
				{
					$(this).attr('checked', true);
					$('#js_action_selector').attr('disabled', '');
				}
			});
		},

		enableDelete: function(oObj)
		{
			if ($(oObj).attr('checked') == true)
			{
				$('#js_action_selector').attr('disabled', '');
				$Core.invite.iEnabled++;
			}
			else
			{
				$Core.invite.iEnabled--;
				if ($Core.invite.iEnabled < 1)
				{
					$('#js_action_selector').attr('disabled', 'disabled');
				}
			}
		},

		doAction: function(sAction)
		{
			if (sAction == "delete")
			{
				$('#js_form').submit();
			}
			return true;
		}
	}


