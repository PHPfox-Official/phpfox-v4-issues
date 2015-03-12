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
 * @package 		Phpfox_Component
 * @version 		$Id: index.class.php 1068 2009-09-24 09:27:36Z Miguel_Espinoza $
 */
class User_Component_Controller_Admincp_Spam extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		
		if ( ($aVals = $this->request()->getArray('val')))
		{
			if (isset($aVals['question_id']))
			{
				if (Phpfox::getService('user.process')->editSpamQuestion($aVals))
				{
					//die('Finished editing question');
				}
			}
			else if (Phpfox::getService('user.process')->addSpamQuestion($aVals))
			{
				//die('Finished adding question');
			}
		}
		
		$aOut = array();
		$aOut['questions'] = Phpfox::getService('user')->getSpamQuestions();
		
		if ( ($iQuestionId = $this->request()->getInt('id')))
		{
			foreach ($aOut['questions'] as $aQuestion)
			{
				if ($aQuestion['question_id'] == $iQuestionId)
				{
					$aOut['edit'] = $aQuestion;
				}
			}
		}		
		
		$jOut = json_encode($aOut);
		
		$this->template()
				->setBreadCrumb(Phpfox::getPhrase('user.anti_spam_security_questions'))
				->setTitle(Phpfox::getPhrase('user.anti_spam_security_questions'))
				->assign(array('sSiteUsePhrase' => $this->url()->makeUrl('admincp.language.phrase.add', array('last-module' => 'user'))))
				->setHeader(array(
					'admin.spam.js' => 'module_user',
					'admin.spam.css' => 'module_user',
					'<script type="text/javascript">$Behavior.initSpamQuestions = function(){$Core.User.Spam.initAdd();};</script>',
					'<script type="text/javascript">$Behavior.initData = function(){$Core.User.Spam.initPopulate('. $jOut .');};</script>'
				))
				->setPhrase(array(
					'user.setting_require_all_spam_questions_on_signup',
					'user.edit_question'
				));
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('user.component_controller_index_clean')) ? eval($sPlugin) : false);
	}
}

?>