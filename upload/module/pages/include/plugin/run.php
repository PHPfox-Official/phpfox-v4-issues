<?php

		if (!PHPFOX_IS_AJAX && Phpfox::getUserBy('profile_page_id') > 0)
		{
			$bSend = true;
			if (defined('PHPFOX_IS_PAGE_ADMIN'))
			{
				$bSend = false;				
			}
			else
			{
				$aPage = Phpfox::getService('pages')->getPage(Phpfox::getUserBy('profile_page_id'));				
				$sReq1 = Phpfox::getLib('request')->get('req1');				
				if (empty($aPage['vanity_url']))
				{
					if ($sReq1 == 'pages')
					{
						// $bSend = false;
					}
				}
			}

			if ($bSend && !Phpfox::getService('pages')->isInPage())
			{
				Phpfox::getLib('url')->forward(Phpfox::getService('pages')->getUrl($aPage['page_id'], $aPage['title'], $aPage['vanity_url']));
			}
		}

?>