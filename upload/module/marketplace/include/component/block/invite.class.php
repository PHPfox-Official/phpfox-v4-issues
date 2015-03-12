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
 * @version 		$Id: invite.class.php 4132 2012-04-25 13:38:46Z Raymond_Benc $
 */
class Marketplace_Component_Block_Invite extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (!Phpfox::isUser())
		{
			return false;
		}
		
		list($iCnt, $aEventInvites) = Phpfox::getService('marketplace')->getUserInvites();
		
		if (!$iCnt)
		{
			return false;
		}
		
		$this->template()->assign(array(
				'sHeader' => Phpfox::getPhrase('marketplace.invites'),
				'aEventInvites' => $aEventInvites
			)
		);
		
		if ($iCnt)
		{
			$this->template()->assign(array(
					'aFooter' => array(
						Phpfox::getPhrase('marketplace.view_all') . ' (' . $iCnt . ')' => $this->url()->makeUrl('marketplace', array('view' => 'invites'))
					)
				)
			);
		}
		
		return 'block';	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('marketplace.component_block_invite_clean')) ? eval($sPlugin) : false);
	}
}

?>