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
 * @version 		$Id: add.class.php 3860 2012-01-19 11:58:49Z Raymond_Benc $
 */
class Newsletter_Component_Controller_Admincp_Add extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		// When they first submit the newsletter this block adds it to the ongoing or scheduling
		if ($aVals = $this->request()->getArray('val'))
		{			
			$aNewsletter = Phpfox::getService('newsletter.process')->add($aVals, Phpfox::getUserId());
			if ($aNewsletter['state'] == 1)
			{
				$this->url()->send('admincp.newsletter.add', array('job' => $aNewsletter['newsletter_id']), Phpfox::getPhrase('newsletter.processing_job_newsletter_id', array('newsletter_id' => $aNewsletter['newsletter_id'])));
			}
			elseif ($aNewsletter === false)
			{
			}
			else
			{
				$this->url()->send('admincp.newsletter.manage', null, null);
			}
		}
		// when refreshed by the flow we should get an integer here pointing to the pending job
		elseif ($iJob = $this->request()->getInt('job'))
		{
			list($iContinue,$iPerc) = Phpfox::getService('newsletter.process')->processJob($iJob);			
			if (is_int($iContinue) && $iPerc < 100)
			{
				$sMessage = Phpfox::getPhrase('newsletter.5_seconds_break_processing_job_continue_total_completed_perc', array('continue' => $iContinue, 'perc' => $iPerc));
				$sLink = $this->url()->makeUrl('admincp.newsletter.add', array('job' => $iContinue));
				$this->template()->setHeader('<META HTTP-EQUIV="refresh" content="5;URL='.$sLink.'">')
					->assign(array('sMessage' => $sMessage));
				//$this->url()->send('admincp.newsletter.add', array('job' => $iContinue));
			}
			elseif ($iContinue === true || $iPerc >= 100) // completed successfully
			{
				$this->url()->send('admincp.newsletter.manage', null, Phpfox::getPhrase('newsletter.job_completed_successfully'));
			}
			elseif ($iContinue === false)
			{
				$this->url()->send('admincp.newsletter.manage', null, Phpfox::getPhrase('newsletter.there_was_a_problem_with_this_job_feel_free_to_resume_it_at_any_time'));
			}
		}
		if ($iId = $this->request()->getInt('id') || $iId = $this->request()->getInt('job'))
		{
			$aNewsletter = Phpfox::getService('newsletter')->get($iId);
			$this->template()->assign(array(
					'aForms' => $aNewsletter
				)
			);
		}
		$aValidation = array(
			'type_id' => array(
				'title' => Phpfox::getPhrase('newsletter.select_a_newsletter_type'),
				'def' => 'int'
			),
		);

		// 2 = html; 1 = plain text;
		$oValidator = Phpfox::getLib('validator')->set(array('sFormName' => 'js_form', 'aParams' => $aValidation));
		$aAge = array();
		for ($i = 18; $i <= 68; $i++)
		{
			$aAge[$i] = $i;
		}
		$this->template()->assign(array(
				'aAge' => $aAge,
				'aUserGroups' => Phpfox::getService('user.group')->get(),
				'sCreateJs' => $oValidator->createJS(),
				'sGetJsForm' => $oValidator->getJsForm()
			)
		)
		->setTitle(Phpfox::getPhrase('newsletter.newsletter'))
		->setBreadCrumb(Phpfox::getPhrase('newsletter.newsletter'),  $this->url()->makeUrl('admincp.newsletter.add'))
		->setBreadCrumb(Phpfox::getPhrase('newsletter.add_newsletter'), null, true)
		->setPhrase(array(
				'newsletter.min_age_cannot_be_higher_than_max_age',
				'newsletter.max_age_cannot_be_lower_than_the_min_age'
			)
		)		
		->setEditor()
		->setHeader(array('add.js' => 'module_newsletter'));
	}
}
?>
