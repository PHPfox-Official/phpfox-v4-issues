<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 *
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package 		Phpfox_Component
 * @version 		$Id: manage.class.php 1168 2009-10-09 14:20:37Z Raymond_Benc $
 */
class Newsletter_Component_Controller_Admincp_Manage extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		// Check if there is any task to handle
		if ($iId = $this->request()->get('delete'))
		{
			if(Phpfox::getService('newsletter.process')->delete($iId)) // purge users
			{
				$this->url()->send('admincp.newsletter.manage', null, Phpfox::getPhrase('newsletter.newsletter_successfully_deleted'));
			}
		}

		// check if there is any pending job or any user pending their newsletter.
		if ($sLink = Phpfox::getService('newsletter')->checkPending())
		{
			$this->template()->assign(array(
					'sError' => $sLink
				)
			);
		}
		$aNewsletters = Phpfox::getService('newsletter')->get();
		
		$this->template()->assign(array(
				'aNewsletters' => $aNewsletters
			)
		)
		->setTitle(Phpfox::getPhrase('newsletter.newsletter'))
		->setPhrase(array(
				'newsletter.min_age_cannot_be_higher_than_max_age',
				'newsletter.max_age_cannot_be_lower_than_the_min_age'
			)
		)
		->setBreadCrumb(Phpfox::getPhrase('newsletter.newsletter'),  $this->url()->makeUrl('admincp.newsletter.add'))
		->setBreadCrumb(Phpfox::getPhrase('newsletter.manage_newsletters'), null, true)
		->setEditor(array(
				)
			)
		->setHeader(array('add.js' => 'module_newsletter'));
	}
}
?>
