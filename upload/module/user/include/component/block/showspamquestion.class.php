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
 * @package  		Module_Feed
 * @version 		$Id: birth.class.php 4189 2012-05-31 10:16:13Z Raymond_Benc $
 */
class User_Component_Block_ShowSpamQuestion extends Phpfox_Component 
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aQuestions = Phpfox::getService('user')->getSpamQuestions();
		if (empty($aQuestions))
		{
			return false;
		}
		if (Phpfox::getParam('user.require_all_spam_questions_on_signup') == false)
		{
			$aQuestions = array($aQuestions[array_rand($aQuestions)]);
		}
		
		// Hide the url to these images
		$oServ = Phpfox::getService('core');
		foreach ($aQuestions as $iKey => $aQuestion)
		{
			$sHash = $oServ->getHashForImage($aQuestion['image_path']);
			$aQuestions[$iKey]['hash'] = $sHash;
			
			if (!empty($aQuestion['image_path']))
			{
				$aQuestions[$iKey]['image_path'] = Phpfox::getParam('core.url_static') . 'image.php?pq=' .$sHash;
			}
			
		}
		
		$this->template()->assign(array(
				'aQuestions' => $aQuestions
			)
		);
	}
}

?>