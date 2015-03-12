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
 * @version 		$Id: block.class.php 103 2009-01-27 11:32:36Z Raymond_Benc $
 */
class Pages_Component_Block_Login extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		// Get the current page. Zero if it's the first page
        $iPage = $this->getParam('page', 1);
		// Get the amount of pages to be shown by page
		$iPageSize = 15;
		// get the total pages, and the pages
		list($iTotal, $aPages) = Phpfox::getService('pages')->getMyLoginPages($iPage, $iPageSize);

		if($iTotal > $iPageSize)
		{
			Phpfox::getLib('pager')->set(
				array(
					'page' => $iPage, 
					'size' => $iPageSize, 
					'count' => $iTotal, 
				)
			);
		}

		$this->template()->assign(array(
				'aPages' => $aPages,
				'sLink' => $this->url()->makeUrl('pages.add'),
				// http://www.phpfox.com/tracker/view/14665
	            'iCurrentPage' => $iPage,
		        'iTotalPages' => ($iTotal/$iPageSize)+1,
		        'iTotal' => $iTotal,
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('pages.component_block_login_clean')) ? eval($sPlugin) : false);
	}
}

?>
