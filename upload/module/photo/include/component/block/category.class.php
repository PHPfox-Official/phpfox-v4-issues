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
 * @package  		Module_Photo
 * @version 		$Id: category.class.php 3685 2011-12-06 11:16:21Z Miguel_Espinoza $
 */
class Photo_Component_Block_Category extends Phpfox_Component
{
    /**
     * Class process method wnich is used to execute this component.
     */
    public function process()
    {
		if (!Phpfox::isAdminPanel())
		{
		    $sCurrentCategory = $this->getParam('sCurrentCategory', null);
			
			$aCategories = Phpfox::getService('photo.category')->getForBrowse($sCurrentCategory, $this->getParam('sPhotoCategorySubSystem', null));
		    if (empty($aCategories))
		    {
				return false;
		    }

			$aCallback = $this->getParam('aCallback', false);
			if ($aCallback !== false && is_array($aCategories))
			{
				$sHomeUrl = '/' . Phpfox::getLib('url')->doRewrite($aCallback['url_home_array'][0]) . '/' . implode('/', $aCallback['url_home_array'][1]) . '/' . Phpfox::getLib('url')->doRewrite('photo') . '/';			
				foreach ($aCategories as $iKey => $aCategory)
				{				
					$aCategories[$iKey]['url'] = preg_replace('/^http:\/\/(.*?)\/' . Phpfox::getLib('url')->doRewrite('photo') . '\/(.*?)$/i', 'http://\\1' . $sHomeUrl . '\\2', $aCategory['url']);
					if (isset($aCategory['sub']))
					{
						foreach ($aCategory['sub'] as $iSubKey => $aSubCategory)
						{
							$aCategories[$iKey]['sub'][$iSubKey]['url'] = preg_replace('/^http:\/\/(.*?)\/' . Phpfox::getLib('url')->doRewrite('photo') . '\/(.*?)$/i', 'http://\\1' . $sHomeUrl . '\\2', $aSubCategory['url']);		
						}
					}
				}		
			}		    
		    
			if (!is_array($aCategories))
			{
				return false;
			}
			
		    $this->template()->assign(array(
					'aCategories' => $aCategories,
					'sHeader' =>  ($this->getParam('hasSubCategories') ? Phpfox::getPhrase('photo.subcategories') : Phpfox::getPhrase('photo.categories')),
		    	)
		    );
		    
		    return 'block';
		}
		
	    if ($this->getParam('bIsTagSearch') === true)
	    {
			return false;
	    }

	    $aCallback = $this->getParam('aCallback', null);

	    $sCategories = Phpfox::getService('photo.category')->get($this->getParam('anchor', true));	    
	    
	    if ($aCallback !== null)
	    {
			$sCategories = preg_replace('/href=\"(.*?)\/photo\/(.*?)\"/i', 'href="' . Phpfox::getLib('url')->makeUrl($aCallback['url_home']) . '\\2"', $sCategories);
	    }

	    $this->template()->assign(array(
			    'sHeader' => Phpfox::getPhrase('photo.categories'),
			    'sCategories' => $sCategories,		    
			    'bParent' => $this->getParam('parent', true)
		    )
	    );	
    }

    /**
     * Garbage collector. Is executed after this class has completed
     * its job and the template has also been displayed.
     */
    public function clean()
    {
		(($sPlugin = Phpfox_Plugin::get('photo.component_block_category_clean')) ? eval($sPlugin) : false);
    }
}

?>