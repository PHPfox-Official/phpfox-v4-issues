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
 * @version 		$Id: suggestion.class.php 1418 2010-01-21 18:38:10Z Raymond_Benc $
 */
class Friend_Component_Controller_Suggestion extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$this->template()->setTitle(Phpfox::getPhrase('friend.friend_suggestions'))
			->setBreadcrumb(Phpfox::getPhrase('friend.my_friends'), $this->url()->makeUrl('friend'))
			->setBreadcrumb(Phpfox::getPhrase('friend.suggestions'), null, true)
			->assign(array(
					'aSuggestions' => Phpfox::getService('friend.suggestion')->get()
				)
			);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('friend.component_controller_suggestion_clean')) ? eval($sPlugin) : false);
	}
}

?>