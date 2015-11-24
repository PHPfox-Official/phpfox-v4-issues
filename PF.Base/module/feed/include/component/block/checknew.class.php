<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 *
 *
 * @copyright        [PHPFOX_COPYRIGHT]
 * @author           Raymond_Benc
 * @package          Phpfox_Component
 * @version          $Id: loaddates.class.php 5521 2013-03-19 12:58:06Z Raymond_Benc $
 */
class Feed_Component_Block_Checknew extends Phpfox_Component
{
    /**
     * Controller
     */
    public function process()
    {

        $aRows = Feed_Service_Feed::instance()
            ->get();

        $iCtn =  count($aRows);

        if(!$iCtn)
            return false;

        $this->template()
            ->assign([
                'iCnt' => $iCtn,
            ]);
    }

    /**
     * Garbage collector. Is executed after this class has completed
     * its job and the template has also been displayed.
     */
    public function clean()
    {
        (($sPlugin = Phpfox_Plugin::get('feed.component_block_loadnew_clean')) ? eval($sPlugin) : false);
    }
}

?>