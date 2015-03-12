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
 * @version 		$Id: timezone.class.php 2525 2011-04-13 18:03:20Z Raymond_Benc $
 */
class Forum_Component_Block_Timezone extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$sCurrentTimeZone = (Phpfox::getTimeZone() == '0' ? '' : ' ' . ((substr(Phpfox::getTimeZone(), 0, 1) == '-') ? Phpfox::getTimeZone() : '+' . Phpfox::getTimeZone()));

		if (substr(Phpfox::getTimeZone(),0,1) == 'z' && PHPFOX_USE_DATE_TIME)
		{
			$aTimeZones = Phpfox::getService('core')->getTimeZones();
			if (isset($aTimeZones[Phpfox::getTimeZone()]))
			{
				$oDTZ = new DateTime('now', new DateTimeZone($aTimeZones[Phpfox::getTimeZone()]));
				$sCurrentTimeZone = $oDTZ->getOffset()/3600;
			}

		}
		$this->template()->assign(array(
				'sCurrentSiteTime' => Phpfox::getTime(Phpfox::getParam('forum.global_forum_timezone'), PHPFOX_TIME),
				'sCurrentTimeZone' => $sCurrentTimeZone
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('forum.component_block_timezone_clean')) ? eval($sPlugin) : false);
	}
}

?>