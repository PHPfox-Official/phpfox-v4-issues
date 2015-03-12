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
 * @version 		$Id: share.class.php 2510 2011-04-07 19:13:26Z Raymond_Benc $
 */
class Photo_Component_Block_Share extends Phpfox_Component
{
    /**
     * Class process method wnich is used to execute this component.
     */
    public function process()
    {

    }

    /**
     * Garbage collector. Is executed after this class has completed
     * its job and the template has also been displayed.
     */
    public function clean()
    {
		(($sPlugin = Phpfox_Plugin::get('photo.component_block_share_clean')) ? eval($sPlugin) : false);
    }
}

?>