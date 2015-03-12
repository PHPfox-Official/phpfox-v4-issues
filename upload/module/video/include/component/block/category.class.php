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
 * @version 		$Id: category.class.php 1126 2009-10-03 12:05:33Z Miguel_Espinoza $
 */
class Video_Component_Block_Category extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (defined('PHPFOX_IS_USER_PROFILE'))
		{
			return false;
		}
		
		$sCategory = $this->getParam('sCategory');
		
		$aCategories = Phpfox::getService('video.category')->getForBrowse($sCategory);
		
		if (!is_array($aCategories))
		{
			return false;
		}
		
		if (!count($aCategories))
		{
			return false;
		}
		
		$aCallback = $this->getParam('aCallback', false);
		if ($aCallback !== false)
		{
			$sHomeUrl = '/' . $aCallback['url_home'][0] . '/' . implode('/', $aCallback['url_home'][1]) . '/video/';			
			foreach ($aCategories as $iKey => $aCategory)
			{				
				$aCategories[$iKey]['url'] = preg_replace('/^http:\/\/(.*?)\/video\/(.*?)$/i', 'http://\\1' . $sHomeUrl . '\\2', $aCategory['url']);
				if (isset($aCategory['sub']))
				{
					foreach ($aCategory['sub'] as $iSubKey => $aSubCategory)
					{
						$aCategories[$iKey]['sub'][$iSubKey]['url'] = preg_replace('/^http:\/\/(.*?)\/video\/(.*?)$/i', 'http://\\1' . $sHomeUrl . '\\2', $aSubCategory['url']);		
					}
				}
			}		
		}
		
		$this->template()->assign(array(
				'sHeader' => ($sCategory === null ? Phpfox::getPhrase('video.categories') : Phpfox::getPhrase('video.sub_categories')),
				'aCategories' => $aCategories,
				'sCategory' => $sCategory
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
		(($sPlugin = Phpfox_Plugin::get('video.component_block_category_clean')) ? eval($sPlugin) : false);
	}
}

?>