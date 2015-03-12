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
 * @version 		$Id: ajax.class.php 1284 2009-11-27 23:44:31Z Raymond_Benc $
 */
class Tag_Component_Ajax_Ajax extends Phpfox_Ajax
{
	public function searchUsersTags()
	{
		$aParams = $this->get('val');

		$aParams['tag_list'] = $aParams['tag_list'][0];
		
		if (strstr($aParams['tag_list'], ','))
		{
			$aParts = explode(',', $aParams['tag_list']);
			$aWords = array_reverse($aParts);
			if (isset($aWords[0]))
			{
				$aParams['tag_list'] = trim($aWords[0]);
			}
		}
		
		if (empty($aParams['tag_list']))
		{
			$this->call("oInlineSearch.close('" . $this->get('id') . "');");
						
			return false;
		}
		
		$aRows = Phpfox::getService('tag')->getInlineSearchForUser(Phpfox::getUserId(), $aParams['tag_list'], $this->get('category_id'));
		
		if (count($aRows))
		{
			Phpfox::getLib('template')->assign(array(
					'aRows' => $aRows,
					'sJsId' => $this->get('id'),
					'sSearch' => $aParams['tag_list']
				)
			);
			Phpfox::getLib('template')->getLayout('inline-search');
			
			$this->call("oInlineSearch.display('" . $this->get('id') . "', '" . $this->getContent() . "');");
		}
		else 
		{
			$this->call("oInlineSearch.close('" . $this->get('id') . "');");
		}
	}
	
	public function inlineUpdate()
	{	
		if (($iUserId = Phpfox::getService('tag')->hasAccess($this->get('sType'), $this->get('item_id'), 'edit_own_tags', 'edit_user_tags')) && Phpfox::getService('tag.process')->update($this->get('sType'), $this->get('item_id'), $iUserId, (Phpfox::getLib('parse.format')->isEmpty($this->get('quick_edit_input')) ? null : $this->get('quick_edit_input'))))
		{
			if (Phpfox::getLib('parse.format')->isEmpty($this->get('quick_edit_input')))
			{
				$this->call('$(\'#' . $this->get('id') . '\').parent().remove();');	
			}
			else 
			{
				$aTags = Phpfox::getService('tag')->getTagsById($this->get('sType'), $this->get('item_id'));
				Phpfox::getBlock('tag.item', array('bDontCleanTags' => true, 'sType' => $this->get('sType'), 'sTags' => $aTags[$this->get('item_id')], 'iItemId' => $this->get('item_id'), 'iUserId' => $iUserId, 'bIsInline' => true));
				$this->html('#' . $this->get('id'), Phpfox::getLib('parse.output')->clean($this->getContent(false), false), '.highlightFade()');
				$this->html('#' . $this->get('content'), Phpfox::getLib('parse.output')->parse(Phpfox::getLib('parse.input')->clean($this->get('quick_edit_input'))));
			}
		}
	}
}

?>