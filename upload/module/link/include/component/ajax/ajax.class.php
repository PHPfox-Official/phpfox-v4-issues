<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox_Ajax
 * @version 		$Id: ajax.class.php 7185 2014-03-11 19:08:04Z Fern $
 */
class Link_Component_Ajax_Ajax extends Phpfox_Ajax
{
	public function preview()
	{
		$this->error(false);
		
		Phpfox::getBlock('link.preview');
		
		if (!Phpfox_Error::isPassed())
		{
			echo json_encode(array('error' => implode('', Phpfox_Error::get())));
		}
		else 
		{
			// http://www.phpfox.com/tracker/view/15230/
			// button has been disabled while the site grabs the URL
			$this->call('<script text/javascript">$("#activity_feed_submit").removeAttr("disabled");</script>');
			// http://www.phpfox.com/tracker/view/15116/
			// $bIsPreview is never set back to false, therefore, once you close the window, you cannot link anything else.
			$this->call('<script text/javascript">$bIsPreview = false;</script>');
			$this->call('<script text/javascript">$Core.loadInit();</script>');
		}
	}
	
	public function addViaStatusUpdate()
	{
		Phpfox::isUser(true);
		
		define('PHPFOX_FORCE_IFRAME', true);
		
		$aVals = (array) $this->get('val');		
		
		$aCallback = null;
		if (isset($aVals['callback_module']) && Phpfox::hasCallback($aVals['callback_module'], 'addLink'))
		{
			$aCallback = Phpfox::callback($aVals['callback_module'] . '.addLink', $aVals);	
		}		
		
                if(!empty($aCallback) && $aCallback['module'] == 'pages')
                {
                    $aPage = Phpfox::getService('pages')->getForView($aCallback['item_id']);
                    if (isset($aPage['use_timeline']) && $aPage['use_timeline'])
                    {
			if (!defined('PAGE_TIME_LINE'))
			{
				define('PAGE_TIME_LINE', true);
			}
                    }
                }
                
		if (($iId = Phpfox::getService('link.process')->add($aVals, false, $aCallback)))
		{
			(($sPlugin = Phpfox_Plugin::get('link.component_ajax_addviastatusupdate')) ? eval($sPlugin) : false);
			
			Phpfox::getService('feed')->callback($aCallback)->processAjax($iId);		
		}		
	}
	
	public function play()
	{
		$sEmbedCode = Phpfox::getService('link')->getEmbedCode($this->get('id'), ($this->get('popup') ? true : false));
		
		if ($this->get('popup'))
		{
			$this->setTitle(Phpfox::getPhrase('link.viewing_video'));
			echo '<div class="t_center">';
			echo $sEmbedCode;
			echo '</div>';
		}		
		elseif ($this->get('feed_id'))
		{
			$this->call('$(\'#js_item_feed_' . $this->get('feed_id') . '\').find(\'.activity_feed_content_link:first\').html(\'' . str_replace("'", "\\'", $sEmbedCode) . '\');');
		}
		else 
		{
			$this->html('#js_global_link_id_' . $this->get('id'), str_replace("'", "\\'", $sEmbedCode));
		}
	}
	
	public function attach()
	{
		Phpfox::isUser(true);
		
		$this->setTitle(Phpfox::getPhrase('link.attach_a_link'));
		
		Phpfox::getBlock('link.attach');		
	}
	
	public function delete()
	{
		Phpfox::isUser(true);
		
		Phpfox::getService('link.process')->delete($this->get('id'));
                
                $this->call("$('.extra_info').show();");
	}
}

?>
