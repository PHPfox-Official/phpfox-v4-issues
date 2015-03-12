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
 * @package  		Module_Tag
 * @version 		$Id: cloud.class.php 6877 2013-11-12 11:18:43Z Miguel_Espinoza $
 */
class Tag_Component_Block_Cloud extends Phpfox_Component 
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		if ((defined('PHPFOX_IS_USER_PROFILE') || defined('PHPFOX_IS_GROUP_VIEW') || defined('PHPFOX_IS_PAGES_VIEW')) && (!defined('PHPFOX_SHOW_TAGS')))
		{
			return false;
		}

		$sType = $this->getParam('sTagType', null);
		$bNoTagBlock = $this->getParam('bNoTagBlock', false);
		if ($sType === null && !Phpfox::getParam('tag.enable_hashtag_support'))
		{
			return false;
		}
		
		$aRows = Phpfox::getService('tag')->getTagCloud($sType, (($this->getParam('bIsProfile') === true && ($aUser = $this->getParam('aUser'))) ? $aUser['user_id'] : null), $this->getParam('iTagDisplayLimit', null));		

		if (!count($aRows))
		{
			return false;
		}

		if ($this->getParam('bIsProfile') === true && !defined('TAG_ITEM_ID'))
		{	
			foreach ($aRows as $iKey => $aRow)
			{
				$aRows[$iKey]['link'] = Phpfox::getService('user')->getLink($aUser['user_id'], $aUser['user_name'], array($sType, 'tag', $aRow['url']));
			}
		}
		
		if ($bNoTagBlock === false)
		{
			$this->template()->assign(array(
					'sHeader' => Phpfox::getPhrase('tag.trending_topics')
				)
			);
		}
		
		$iSince = (PHPFOX_TIME - (86400 * Phpfox::getParam('tag.tag_days_treading')));
		$sTrendingSince = date(Phpfox::getParam('tag.trending_topics_timestamp'), $iSince);
		if (strpos(Phpfox::getParam('tag.trending_topics_timestamp'), 'F') !== false)
		{
			$sTrendingSince = str_replace(date('F', $iSince), Phpfox::getLib('date')->getMonth(date('n', $iSince)), $sTrendingSince);
		}
		else if (strpos(Phpfox::getParam('tag.trending_topics_timestamp'), 'M') !== false)
		{
			$sTrendingSince = str_replace(date('M', $iSince), substr(Phpfox::getLib('date')->getMonth(date('n', $iSince)), 0, 3), $sTrendingSince);
		}
		
		
		$this->template()->assign(array(
				'aRows' => $aRows,
				'sTagGlobalType' => $sType,
				'sTrendingSince' => $sTrendingSince
			)
		);
		
		if ($sType === null)
		{
			$this->template()->assign(array(
					'sDeleteBlock' => 'dashboard'
				)
			);
		}				
		
		return 'block';	
	}
}

?>