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
 * @version 		$Id: list.class.php 1166 2009-10-09 11:38:32Z Raymond_Benc $
 */
class Marketplace_Component_Block_List extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$iPage = $this->request()->getInt('page');
		$iType = $this->request()->getInt('type', 1);
		$iPageSize = 6;
		
		if (PHPFOX_IS_AJAX)
		{
			$aListing = Phpfox::getService('marketplace')->getListing($this->request()->get('id'), true);
			$this->template()->assign('aListing', $aListing);
		}
		else 
		{
			$aListing = $this->getParam('aListing');			
		}
		
		list($iCnt, $aInvites) = Phpfox::getService('marketplace')->getInvites($aListing['listing_id'], $iType, $iPage, $iPageSize);
		
		Phpfox::getLib('pager')->set(array('ajax' => 'marketplace.listInvites', 'page' => $iPage, 'size' => $iPageSize, 'count' => $iCnt, 'aParams' => array('id' => $aListing['listing_id'])));
		
		$this->template()->assign(array(
				'aInvites' => $aInvites,
				'iType' => $iType	
			)
		);		
		
		if (!PHPFOX_IS_AJAX)
		{		
			$this->template()->assign(array(
					'sHeader' => Phpfox::getPhrase('marketplace.invites'),
					'sBoxJsId' => 'marketplace_members'
				)
			);			
			
			$this->template()->assign(array(
					'aMenu' => array(
						Phpfox::getPhrase('marketplace.visited') => '#marketplace.listInvites?type=1&amp;id=' . $aListing['listing_id'],
						Phpfox::getPhrase('marketplace.not_responded') => '#marketplace.listInvites?type=0&amp;id=' . $aListing['listing_id']
					)
				)
			);			
			
			return 'block';
		}			
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('marketplace.component_block_list_clean')) ? eval($sPlugin) : false);
	}
}

?>