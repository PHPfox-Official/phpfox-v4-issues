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
 * @version 		$Id: form.class.php 5428 2013-02-25 15:01:29Z Raymond_Benc $
 */
class Privacy_Component_Block_Form extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		$aPrivacyControls = array();
		if (!Phpfox::getParam('core.friends_only_community'))
		{
			$aPrivacyControls[] = array(
				'phrase' => Phpfox::getPhrase('privacy.everyone'),
				'value' => '0'
			);
		}
		if (Phpfox::isModule('friend'))
		{
			$aPrivacyControls[] = array(
			'phrase' => Phpfox::getPhrase('privacy.friends'),
			'value' => '1'
			);
			$aPrivacyControls[] = array(
				'phrase' => Phpfox::getPhrase('privacy.friends_of_friends'),
				'value' => '2'
			);
		}
		
		$aPrivacyControls[] = array(
			'phrase' => Phpfox::getPhrase('privacy.only_me'),
			'value' => '3'
		);
		
		if (Phpfox::isModule('friend') && !(bool) $this->getParam('privacy_no_custom', false))
		{
			$mCustomPrivacyId = $this->getParam('privacy_custom_id', null);

			$aPrivacyControls[] = array(
				'phrase' => Phpfox::getPhrase('privacy.custom_span_click_to_edit_span'),
				'value' => '4',
				'onclick' => '$Core.box(\'privacy.getFriends\', \'\', \'no_page_click=true' . ($mCustomPrivacyId === null ? '' : '&amp;custom-id=' . $mCustomPrivacyId) . '&amp;privacy-array=' . $this->getParam('privacy_array', '') . '\');'
			);
		}
		
		(($sPlugin = Phpfox_Plugin::get('privacy.component_block_form_process')) ? eval($sPlugin) : '');
		
		$aVals = (array) $this->template()->getVar('aForms');
		if (($aPostVals = $this->request()->getArray('val')))
		{
			$aVals = $aPostVals;	
		}
		
		$bNoActive = true;
		$aSelectedPrivacyControl = array();
		foreach ($aPrivacyControls as $iKey => $aPrivacyControl)
		{
			if (!empty($aVals) && isset($aVals[$this->getParam('privacy_name')]))
			{
				if ($aPrivacyControl['value'] == $aVals[$this->getParam('privacy_name')])
				{
					$aPrivacyControl['phrase'] = preg_replace('/<span>(.*)<\/span>/i', '', $aPrivacyControl['phrase']);
					$aSelectedPrivacyControl = $aPrivacyControl;
					$aPrivacyControls[$iKey]['is_active'] = true;
					$bNoActive = false;
					break;
				}
			}			
			else 
			{
				$aSelectedPrivacyControl = $aPrivacyControl;
				break;
			}
		}
		
		if ($bNoActive === true && $this->getParam('default_privacy') != '' && ($iDefaultValue = Phpfox::getService('user.privacy')->getValue($this->getParam('default_privacy'))) && $iDefaultValue > 0)
		{
			foreach ($aPrivacyControls as $iKey => $aPrivacyControl)
			{
				if ($aPrivacyControl['value'] == $iDefaultValue)
				{
					$aPrivacyControl['phrase'] = preg_replace('/<span>(.*)<\/span>/i', '', $aPrivacyControl['phrase']);
					$aSelectedPrivacyControl = $aPrivacyControl;
					$aPrivacyControls[$iKey]['is_active'] = true;
					$bNoActive = false;
					break;					
				}		
			}	
		}
		
		$sPrivacyInfo = $this->getParam('privacy_info');
		if (preg_match('/(.*)\.(.*)/i', $sPrivacyInfo, $aMatches) && isset($aMatches[1]) && Phpfox::isModule($aMatches[1]))
		{
			$sPrivacyInfo = Phpfox::getPhrase($sPrivacyInfo);
		}
        
        if (empty($aSelectedPrivacyControl))
        {
            $aSelectedPrivacyControl = $aPrivacyControls[0];
        }
        
		$this->template()->assign(array(
				'sPrivacyFormType' => $this->getParam('privacy_type'),
				'sPrivacyFormName' => $this->getParam('privacy_name'),
				'sPrivacyFormInfo' => $sPrivacyInfo,
				'bPrivacyNoCustom' => (bool) $this->getParam('privacy_no_custom', false),
				'aPrivacyControls' => $aPrivacyControls,
				'aSelectedPrivacyControl' => $aSelectedPrivacyControl,
				'sPrivacyArray' => $this->getParam('privacy_array', null),
				'bNoActive' => $bNoActive
			)
		);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('privacy.component_block_form_clean')) ? eval($sPlugin) : false);
		
		$this->template()->clean(array(
				'sPrivacyFormName',
				'sPrivacyFormInfo',
				'bPrivacyNoCustom',
				'sPrivacyArray'
			)
		);
		
		$this->clearParam('privacy_no_custom');
		$this->clearParam('privacy_custom_id');
		$this->clearParam('privacy_array');
		$this->clearParam('default_privacy');
	}
}

?>