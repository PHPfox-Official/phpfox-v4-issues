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
 * @version 		$Id: block.class.php 103 2009-01-27 11:32:36Z Raymond_Benc $
 */
class Rate_Component_Block_Display extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (!$aRatingCallback = $this->getParam('aRatingCallback'))
		{
			return Phpfox_Error::display(Phpfox::getPhrase('rate.unable_to_load_rating_callback'));
		}
		
		$aStars = array();
		foreach ($aRatingCallback['stars'] as $iKey => $mStar)
		{
			if (is_numeric($mStar))
			{
				$aStars[$mStar] = $mStar;
			}
			else 
			{
				$aStars[$iKey] = $mStar;
			}
		}		
		
		$aRatingCallback['stars'] = $aStars;
		
		$this->template()->assign(array(
				'aRatingCallback' => $aRatingCallback
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('rate.component_block_display_clean')) ? eval($sPlugin) : false);
	}
}

?>