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
 * @version 		$Id: add.class.php 2000 2010-10-29 11:24:24Z Raymond_Benc $
 */
class Rss_Component_Controller_Admincp_Add extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$bIsEdit = false;		
		if (($iId = $this->request()->getInt('id')))
		{
			if (($aFeed = Phpfox::getService('rss')->getForEdit($iId)))
			{
				$bIsEdit = true;
				$this->template()->assign('aForms', $aFeed);
			}
		}
		
		if (($aVals = $this->request()->getArray('val')))
		{
			if ($bIsEdit)
			{
				if (Phpfox::getService('rss.process')->update($aFeed['feed_id'], $aVals))
				{
					$this->url()->send('admincp.rss.add', array('id' => $aFeed['feed_id']), Phpfox::getPhrase('rss.feed_successfully_updated'));
				}				
			}
			else 
			{
				if (Phpfox::getService('rss.process')->add($aVals))
				{
					$this->url()->send('admincp.rss', null, Phpfox::getPhrase('rss.feed_successfully_added'));
				}
			}
		}
		
		if (Phpfox::getParam('core.enabled_edit_area'))
		{
			$this->template()->setHeader(array(
					'editarea/edit_area_full.js' => 'static_script',
					'<script type="text/javascript">				
						editAreaLoader.init({
							id: "php_view_code"	
							,start_highlight: true
							,allow_resize: "both"
							,allow_toggle: true
							,word_wrap: false
							,language: "en"
							,syntax: "php"
							,allow_resize: "y"
						});		

						editAreaLoader.init({
							id: "php_group_code"	
							,start_highlight: true
							,allow_resize: "both"
							,allow_toggle: true
							,word_wrap: false
							,language: "en"
							,syntax: "php"
							,allow_resize: "y"
						});		
					</script>'
				)
			);			
		}
		
		$this->template()->setTitle(($bIsEdit ? Phpfox::getPhrase('rss.editing_feed') . ': #' . $aFeed['feed_id'] : Phpfox::getPhrase('rss.add_new_feed')))
			->setBreadcrumb(Phpfox::getPhrase('rss.manage_feeds'), $this->url()->makeUrl('admincp.rss'))
			->setBreadcrumb(($bIsEdit ? Phpfox::getPhrase('rss.editing_feed') . ': #' . $aFeed['feed_id'] : Phpfox::getPhrase('rss.add_new_feed')), null, true)
			->assign(array(
					'bIsEdit' => $bIsEdit,
					'aGroups' => Phpfox::getService('rss.group')->getDropDown()					
				)
			);		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('rss.component_controller_admincp_add_clean')) ? eval($sPlugin) : false);
	}
}

?>