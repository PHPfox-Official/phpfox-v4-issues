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
 * @version 		$Id: share.class.php 7099 2014-02-10 19:39:10Z Fern $
 */
class Poll_Component_Block_Share extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$this->template()->assign(array(
				'iMaxAnswers' => (int)Phpfox::getUserParam('poll.maximum_answers_count'),
				'iMinAnswers' => 2,
				'sPhraseKey' => 'poll.you_have_reached_your_limit',
				'sPhraseValue' => Phpfox::getPhrase('poll.you_have_reached_your_limit')
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('poll.component_block_share_clean')) ? eval($sPlugin) : false);
	}
}

?>
