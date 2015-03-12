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
 * @version 		$Id: add.class.php 6269 2013-07-15 15:25:14Z Raymond_Benc $
 */
class Tag_Component_Block_Add extends Phpfox_Component 
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (Phpfox::getParam('tag.enable_hashtag_support'))
		{
			return false;
		}

		$this->template()->assign(array(
				'sTagType' => $this->getParam('sType'),
				'bSeparate' => $this->getParam('separate', true),
				'iItemId' => $this->getParam('id')
			)
		);	
	}
	
	public function clean()
	{
		$this->template()->clean(array(
				'sTagType',
				'bSeparate',
				'iItemId'
			)
		);	
	}
}

?>