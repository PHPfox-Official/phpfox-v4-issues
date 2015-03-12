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
 * @version 		$Id: holder.class.php 1339 2009-12-19 00:37:55Z Raymond_Benc $
 */
class Core_Component_Block_Holder extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$this->_iUid = $this->getParam('block_custom_id');
		$sBlockLocation = $this->getParam('block_location');
		
		switch ($sBlockLocation)
		{
			case '1':
			case '3':
				$sBlockLocation = 'sidebar';
				break;	
			case '2':
			case '4':
				$sBlockLocation = 'content';
				break;					
		}
		
		$sOriginalContent = ob_get_contents();
		
		ob_clean();
		
		eval(' ?>' . $this->getParam('content') . '<?php ');
		
		$sContent = ob_get_contents();
		
		ob_clean();
		
		echo $sOriginalContent;
		
		return array($sBlockLocation, '<div class="js_sortable" id="js_block_border_custom_block_' . $this->_iUid . '">' . $sContent . '</div>');
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('core.component_block_holder_clean')) ? eval($sPlugin) : false);
	}
	
	public function cacheBlock()
	{
		return true;	
	}
	
	public function getCacheId()
	{
		return 'js_block_border_custom_block_' . $this->_iUid;	
	}
}

?>