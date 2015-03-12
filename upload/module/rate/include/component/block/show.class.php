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
 * @version 		$Id: show.class.php 1680 2010-07-22 01:56:31Z Raymond_Benc $
 */
class Rate_Component_Block_Show extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		$sStars = '';
		for ($i = 1; $i <= (int) $this->getParam('star_total'); $i++)
		{
			$sStars .= '<input name="' . $this->getParam('star_name') . '" type="radio" value="' . $i . '" class="star" disabled="disabled"' . ((int) $this->getParam('star_show') == $i ? ' checked="checked" ' : '') . '/>';
		}

		$this->template()->assign(array(
				'sStarDisplay' => $sStars
			)
		);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('rate.component_block_show_clean')) ? eval($sPlugin) : false);
	}
}

?>