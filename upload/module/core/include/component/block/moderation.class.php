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
 * @package 		Phpfox_Component
 * @version 		$Id: moderation.class.php 4086 2012-04-05 12:32:32Z Raymond_Benc $
 */
class Core_Component_Block_Moderation extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		$aParams = $this->getParam('global_moderation');
		
		$iTotalInputFields = 0;
		$sInputFields = '';
		foreach ((array) $_COOKIE as $sCookieName => $sCookieValue)
		{
			if (preg_match('/js_item_m_/i', $sCookieName) && strpos($sCookieValue, '_'))
			{
				$aParts = explode('_', $sCookieValue);
				if ($aParts[0] == $aParams['name'])
				{
					$sInputFields .= '<div class="js_item_m_' . $aParts[0] . '_' . $aParts[1] . '"><input class="js_global_item_moderate" type="hidden" name="item_moderate[]" value="' . $aParts[1] . '" /></div>';
					$iTotalInputFields++;
				}
			}
		}
				
		$this->template()->assign(array(
				'sInputFields' => $sInputFields,
				'iTotalInputFields' => $iTotalInputFields,
				'aModerationParams' => $aParams,		
				'sCustomModerationFields' => (isset($aParams['custom_fields']) ? $aParams['custom_fields'] : '')
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('core.component_block_moderation_clean')) ? eval($sPlugin) : false);
	}
}

?>