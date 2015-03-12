<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 *
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Admincp
 * @version 		$Id: search.class.php 3296 2011-10-12 13:29:57Z Raymond_Benc $
 */
class Admincp_Component_Controller_Setting_Search extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if ($sVar = $this->request()->get('var'))
		{
			if (preg_match('/(.*)\.(.*)/i', $sVar, $aMatches) && isset($aMatches[2]))
			{
				$sVar = $aMatches[2];
				$aResults = Phpfox::getService('admincp.setting')->search("setting.module_id = '" . Phpfox::getLib('database')->escape($aMatches[1]) . "' AND setting.var_name = '" . Phpfox::getLib('database')->escape($sVar) . "'");
			}
			else 
			{
				$aResults = Phpfox::getService('admincp.setting')->search("setting.var_name = '" . Phpfox::getLib('database')->escape($sVar) . "'");
			}

			if (isset($aResults[0]['var_name']))
			{
				$iId = $aResults[0]['module_id'];
				$sUrl = $this->url()->makeUrl('admincp.setting.edit').'module-id_'.$iId.'/#'. $aResults[0]['var_name'];
				
				$this->url()->send($sUrl);
			}
			else
			{
				$this->template()->assign(array(
						'sMessage' => Phpfox::getPhrase('admincp.your_search_did_not_return_any_results')
					)
				);
			}
		}
	}
}

?>