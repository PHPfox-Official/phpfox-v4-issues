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
 * @version 		$Id: filter.class.php 1247 2009-11-03 16:08:56Z Raymond_Benc $
 */
class Photo_Component_Block_Filter extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if ($this->getParam('bIsTagSearch') === true)
		{
			return false;
		}
		
		$this->template()->assign(array(
				'sHeader' => Phpfox::getPhrase('photo.browse_filter')
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
		(($sPlugin = Phpfox_Plugin::get('photo.component_block_filter_clean')) ? eval($sPlugin) : false);
		
		$this->template()->clean(array(
				'iDisplayTotal',
				'iSelected'
			)
		);		
	}
}

?>