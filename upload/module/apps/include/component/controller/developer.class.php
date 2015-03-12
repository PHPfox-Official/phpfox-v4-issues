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
 * @version 		$Id: controller.class.php 103 2009-01-27 11:32:36Z Raymond_Benc $
 */
class Apps_Component_Controller_Developer extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aMethods = array();
		$aCallbacks = Phpfox::massCallback('getApiSupportedMethods');
		
		foreach ($aCallbacks as $sModule => $aCallback)
		{
			foreach ($aCallback['methods'] as $iKey => $aMethod)
			{
				$aCallback['methods'][$iKey]['response'] = str_replace('[DOMAIN_REPLACE]', Phpfox::getParam('core.host'), str_replace('stdClass&nbsp;', '', highlight_string(print_r(json_decode($aMethod['response']), true), true)));
				
				$sUrl = '/api.php?method=' . $aCallback['module'] . '.' . $aMethod['call'] . '';
				if (isset($aMethod['requires']) && is_array($aMethod['requires']))
				{
					foreach ($aMethod['requires'] as $sRequireKey => $sRequireType)
					{
						$sUrl .= '&amp;' . $sRequireKey . '=#{' . strtoupper($sRequireType) . '}';
					}
				}
				$aCallback['methods'][$iKey]['url'] = $sUrl;
			}
			
			$aMethods[] = $aCallback;				
		}
		
		$sTokenResponse = str_replace('stdClass&nbsp;', '', highlight_string(print_r(json_decode('{"token":"LS0tLS1CRUdJTiBQVUJMSUMgS0VZLS0tLS0KTUc4d0RRWUpLb1pJaHZjTkFRRUJCUUFEWGdBd1d3SlVBdHFZdmVWOXFEdDd6NFhXTXYzS3VZM2JyWXpUKzR0VgpBbERrN1dQWjhqRVpoVzBNWjE1Z3lHdGNlNm5ueFRNenp4SXpHM29BRVIzc0JVRCtYdStHb21JeVV4UE1RN1NtCkVPdFg0ZTNwekp6R081cUxBZ01CQUFFPQotLS0tLUVORCBQVUJMSUMgS0VZLS0tLS0K"}'), true), true));
		
		$this->template()->setTitle(Phpfox::getPhrase('apps.app_developers'))
			->setBreadcrumb(Phpfox::getPhrase('apps.apps'), $this->url()->makeUrl('apps'))
			->setBreadcrumb(Phpfox::getPhrase('apps.developers'), $this->url()->makeUrl('apps.developer'), true)
			->setFullSite()
			->setHeader(array(
					'apps.css' => 'style_css',
					'apps.js' => 'module_apps'
				)
			)
			->assign(array(
					'sSiteName' => Phpfox::getParam('core.site_title'),
					'aMethods' => $aMethods,
					'sSampleCall' => Phpfox::getParam('core.path') . 'api.php?token=#{TOKEN}&amp;method=#{METHOD_NAME}',
					'sTokenSampleCall' => Phpfox::getParam('core.path') . 'token.php?key=$_GET[\'key\']',
					'sTokenResponse' => $sTokenResponse,
					'sAppLink' => $this->url()->makeUrl('apps.add')
				)
			);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('apps.component_controller_developer_clean')) ? eval($sPlugin) : false);
	}
}

?>