<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package 		Phpfox_Ajax
 * @version 		$Id: ajax.class.php 3860 2012-01-19 11:58:49Z Raymond_Benc $
 */
class Newsletter_Component_Ajax_Ajax extends Phpfox_Ajax
{	
	public function showPlain()
	{
		$sText = $this->get('sText');
		$aToStrip = array('[b]', '[i]', '[/b]', '[/i]', '[u]', '[/u]', '[ul]', '[/ul]');
		$sText = str_replace('</p>', "\n", $sText);
		$this->call('$("#txtPlain").val("'.str_replace($aToStrip, '', strip_tags($sText)).'");');
	}

	public function deleteNewsletter()
	{
		$iId = $this->get('iId');
		if (!Phpfox::getUserParam('newsletter.can_create_newsletter'))
		{
			$this->alert(Phpfox::getPhrase('newsletter.you_are_not_allowed_to_delete_newsletters'));
			return false;
		}
		if (Phpfox::getService('newsletter.process')->delete($iId))
		{
			$this->call('$("#js_newsletter_'.$iId.'").remove();');
		}
		
	}
}

?>