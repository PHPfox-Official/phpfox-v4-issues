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
 * @version 		$Id: stat.class.php 5385 2013-02-19 09:08:40Z Miguel_Espinoza $
 */
class Quiz_Component_Block_Stat extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if ($this->getParam('bViewingQuiz', false) !== true)
		{
			return false;
		}
		
		// get the recent visitors of this quiz
		$aRecent = '';
		$aRecent = $this->getParam('aTakers', '');
		
		if (!isset($aRecent['iSuccessPercentage']))
		{ 
			$aRecent = Phpfox::getService('quiz')->getRecentTakers($this->request()->get('req2'));	
		}
		
		if ($aRecent === false)
		{
			return false;
		}
        
        if (count($aRecent) > Phpfox::getParam('quiz.takers_to_show'))
		{
            $aRecent = array_splice($aRecent, Phpfox::getParam('quiz.takers_to_show'));
        }
		
		$this->template()->assign(array(
				'sHeader' => Phpfox::getPhrase('quiz.recently_taken_by'),
				'aFooter' => array(
					Phpfox::getPhrase('quiz.view_more') => $this->url()->permalink(array('quiz', 'results'), $this->request()->get('req2'), $this->request()->get('req3'))
				),
				'aQuizTakers' => $aRecent !== false ? $aRecent : array()		
			)
		);
		
		return 'block';
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('quiz.component_block_stat_clean')) ? eval($sPlugin) : false);
	}
}

?>