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
 * @version 		$Id: sponsored.class.php 1723 2010-08-16 08:18:35Z Raymond_Benc $
 */
class Group_Component_Block_Sponsored extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (!Phpfox::isModule('ad'))
		{
			return false;
		}	    
		
		$aSponsorGroup = Phpfox::getService('group')->getRandomSponsored();
	    if (empty($aSponsorGroup))
	    {
			return false;
	    }

	    Phpfox::getService('ad.process')->addSponsorViewsCount($aSponsorGroup['sponsor_id'], 'group');
	    
	    $this->template()->assign(array(
			'sHeader' => Phpfox::getPhrase('group.sponsored_group'),
			'aSponsorGroup' => $aSponsorGroup,
			'aFooter' => array(Phpfox::getPhrase('group.encourage_sponsor') => $this->url()->makeUrl('group', array('view' => 'my', 'sponsor' => '1')))
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
		(($sPlugin = Phpfox_Plugin::get('group.component_block_image_clean')) ? eval($sPlugin) : false);
	}
}

?>