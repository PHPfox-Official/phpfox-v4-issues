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
 * @version 		$Id: link.class.php 7159 2014-02-26 15:44:39Z Fern $
 */
class Like_Component_Block_Link extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$sModule = $sItemTypeId = Phpfox::getLib('module')->getModuleName();
		
		if ($sModule == 'apps' && Phpfox::isModule('pages'))
		{
			$sModule = 'pages';
		}
		if ($sModule == 'core')
		{
			$sModule = $this->getParam('like_type_id');			
			$sModule = explode('_', $sModule);
			$sModule = $sModule[0];
		}
		// http://www.phpfox.com/tracker/view/15136/
		else if ($sModule == 'profile')
		{
			$sModule = $sItemTypeId = $this->getParam('like_type_id');	
			$sModule = explode('_', $sModule);
			$sModule = $sModule[0];
		}
		else if ($sModule == 'profile' && ($this->getParam('like_type_id') == 'feed_comment' || /*$this->getParam('like_type_id') == 'user_status' || */ $this->getParam('like_type_id') == 'feed_mini'))
		{			
			$sOrgModule = $sModule;
		    $sModule = 'feed';
		}
		if (!$this->getParam('aFeed') && ($aVals = $this->request()->getArray('val')) && isset($aVals['is_via_feed']))
		{		    
		    $this->template()->assign(array('aFeed' => array('feed_id' => $aVals['is_via_feed'])));
		}
        
		if (Phpfox::getParam('like.allow_dislike') && Phpfox::hasCallback($sModule, 'getActions'))
		{
			static $iActionIteration = 0;
			$iActionIteration++;
			$aActions = Phpfox::callback($sModule . '.getActions');

			$mReq1 = (!defined('PHPFOX_IS_USER_PROFILE') ? $this->request()->get('req1') : '');
			$mReq2 = $this->request()->get('req2');
			$mReq3 = $this->request()->get('req3');
			
			if (is_string($mReq2) )
			{
				if (is_numeric($mReq3))
				{
					switch($mReq2)
					{
						case 'thread':
							$sItemTypeId .= '-post';
							break;
						default:
							$sItemTypeId .= '-'.$mReq2;
					}
				}
				else if (!is_numeric($mReq2) && !empty($mReq3))
				{
					
					$sItemTypeId .= '-'.$mReq3;
				}
			}
			
			if (!empty($aActions))
			{
				$aOut = array();
				$oServ = Phpfox::getService('like');
				$iRound = 1;
				foreach ($aActions as $sName => $aRow)
				{	
					if (isset($aRow['is_enabled']) && $aRow['is_enabled'] != true)
					{
						continue;
					}
					
					$bCheck1 = ($sItemTypeId != 'profile' && $sItemTypeId !='music' && $aRow['item_type_id'] != $sItemTypeId && $sItemTypeId != 'core');
					$bCheck2 = (!empty($mReq1)) && ($this->getParam('like_type_id') != 'user_status' && $this->getParam('like_type_id') != 'feed_comment') && 						(!isset($aRow['where_to_show']) || !is_array($aRow['where_to_show']) || !in_array($mReq1, $aRow['where_to_show']));
					$bCheck3 = ($sItemTypeId == 'core' && strpos($sName, '-') !== false);
					$bCheck4 = $bCheck2 && (!Phpfox::getService('user')->isUser($mReq1) || $this->getParam('like_type_id') != 'feed_mini');
					//d( ($bCheck1 ? '1':'0'). ($bCheck2 ? '1' : '0') . ($bCheck3 ? '1' :'0') . ($bCheck4 ? '1' : '0')); d($this->getParam('like_type_id') . '  -  ' . $mReq1);
					if (/* Done to filter "albums" from "photos" (or music) */
						$bCheck1
						|| 
						($bCheck2 && $bCheck4)
						||
						$bCheck3
						)					
					{
						continue;
					}
					
					if (isset($sOrgModule) && $this->getParam('like_type_id') == 'feed_mini')
					{
						$aRow['item_type_id'] = 'comment';
					}
					elseif (!isset($sOrgModule) && $aRow['item_type_id'] == 'feed')
					{
						$aRow['item_type_id'] = 'comment';
					}
					elseif (isset($sOrgModule) && $this->getParam('like_type_id') == 'feed_comment')
					{
						$aRow['item_type_id'] = 'feed-comment';
					}
					
					$bIsMarked = $oServ->hasBeenMarked($aRow['action_type_id'], $aRow['item_type_id'], $this->getParam('like_item_id'), Phpfox::getUserId());
					
					$aOut[] = array(
						'item_type_id' => $aRow['item_type_id'],
						'item_id' => $this->getParam('like_item_id'),
						'is_marked' => $bIsMarked,
						'phrase' => $aRow['phrase'],
						'action_type_id' => $aRow['action_type_id'],
						'module_name' => $sModule,
						'iActionIteration' => $iActionIteration .''.$iRound
					);
					$iRound++;
				}
				
				$this->template()->assign(array('aActions' => $aOut));
			}
		}
		
		$this->template()->assign(array(
				'sParentModuleName' => $sModule,
				'aLike' => array(
					'like_type_id' => $this->getParam('like_type_id'),
					'like_item_id' => $this->getParam('like_item_id'),
					'like_is_liked' => $this->getParam('like_is_liked'),
					'like_is_custom' => $this->getParam('like_is_custom')
				)
			)
		);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('like.component_block_link_clean')) ? eval($sPlugin) : false);
		
		$this->template()->clean('aLike');
	}
}

?>
