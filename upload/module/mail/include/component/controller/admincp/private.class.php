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
 * @package  		Module_Mail
 * @version 		$Id: private.class.php 6437 2013-08-12 08:40:14Z Miguel_Espinoza $
 */
class Mail_Component_Controller_Admincp_Private extends Phpfox_Component
{
	public function process()
	{
		Phpfox::getUserParam('mail.can_read_private_messages', true);
		if (($iDeleteId = $this->request()->getInt('delete')))
		{
			if (Phpfox::getService('mail.process')->adminDelete($iDeleteId))
			{
				$this->url()->send('admincp.mail.private', null, Phpfox::getPhrase('mail.message_successfully_deleted'));
			}
		}
		
		$aPages = array(12, 15, 18, 21);
		$aDisplays = array();
		foreach ($aPages as $iPageCnt)
		{
			$aDisplays[$iPageCnt] = Phpfox::getPhrase('core.per_page', array('total' => $iPageCnt));
		}
	
		$aUserGroups = array();
		foreach (Phpfox::getService('user.group')->get() as $aUserGroup)
		{
			$aUserGroups[$aUserGroup['user_group_id']] = $aUserGroup['title'];
		}
		$aAge = array();
		for ($i = 18; $i <= 68; $i++)
		{
			$aAge[$i] = $i;
		}
		
		if (Phpfox::getParam('mail.threaded_mail_conversation'))
		{
			$aOptions = array(
				'1' => array(Phpfox::getPhrase('mail.text'), "AND mt.text LIKE '%[VALUE]%'")
			);			
		}
		else
		{
			$aOptions = array(
				'1' => array(Phpfox::getPhrase('mail.subject_amp_text'), "AND (m.subject LIKE '%[VALUE]%' OR mt.text_parsed LIKE '%[VALUE]%')"),
				'2' => array(Phpfox::getPhrase('mail.subject'), "AND m.subject LIKE '%[VALUE]%'"),
				'3' => array(Phpfox::getPhrase('mail.text'), "AND mt.text LIKE '%[VALUE]%'")
			);
		}

        $iDay = date('d');
        $iMonth = date('m');
		$iYear = date('Y');
		$aFilters = array(
			'display' => array(
				'type' => 'select',
				'options' => $aDisplays,
				'default' => '12'
			),
			'sort' => array(
				'type' => 'select',
				'options' => array(),
				'default' => 'time_updated',
				'alias' => 'm'
			),
			'sort_by' => array(
				'type' => 'select',
				'options' => array(
					'DESC' => Phpfox::getPhrase('core.descending'),
					'ASC' => Phpfox::getPhrase('core.ascending')
				),
				'default' => 'DESC'
			),
			'keyword' => array(
				'type' => 'input:text',
				'size' => 20,
				// 'search' => 'AND m.subject LIKE \'%[VALUE]%\''
			),
			'type' => array(
				'type' => 'input:radio',
				/*
				'options' => array(
					'1' => 'Email & Name',
					'2' => 'Email',
					'3' => 'Name'
				),
				 *
				 */
				'default_view' => '1',
				'prefix' => '<div>',
				'suffix' => '</div>',
				'options' => $aOptions,
				'depend' => 'keyword'
			),
			'group' => array(
				'type' => 'select',
				'options' => $aUserGroups,
				'add_any' => true,
				'search' => 'AND sender.user_group_id = \'[VALUE]\''
			),
			'status' => array(
				'type' => 'select',
				'options' => array(
					'1' => Phpfox::getPhrase('mail.all_members'),
					'2' => Phpfox::getPhrase('mail.featured_members')
				),
				'default_view' => '1',
				'search' => 'FEATURED_[VALUE]'
			),
			'view' => array(
				'type' => 'input:radio',
				'options' => array(
					'online' => Phpfox::getPhrase('mail.online'),
					'updated' => Phpfox::getPhrase('mail.updated'),
				)
			),
			'show' => array(
				'type' => 'select',
				'options' => array(
					'1' => Phpfox::getPhrase('mail.name_and_photo_only'),
					'2' => Phpfox::getPhrase('mail.name_photo_and_users_details')
				),
				'default_view' => (Phpfox::getParam('user.user_browse_display_results_default') == 'name_photo_detail' ? '2' : '1')
			),
			'sender' => array(
				'type' => 'input:text',
				'size' => 20,
				'search' => 'SENDER=\'[VALUE]\''
			),
			'receiver' => array(
				'type' => 'input:text',
				'size' => 20,
				'search' => 'RECEIVER=\'[VALUE]\''
			)
		);
		
		$oFilter = Phpfox::getLib('search')
			->set(array(
				'type' => 'browse',
				'filters' => $aFilters,
				'search' => 'keyword'
			)
		);

		
		$iPage = $this->request()->getInt('page', 1);
		
		define('PHPFOX_IS_PRIVATE_MAIL', true);
		
		list($aMessages, $iCnt) = Phpfox::getService('mail')->getPrivate($oFilter->getConditions(), 10, $oFilter->getSort(), $iPage);
		
		Phpfox::getLib('pager')->set(array('page' => $iPage, 'size' => 10, 'count' => $oFilter->getSearchTotal($iCnt)));
		
		
		$this->template()->setTitle(Phpfox::getPhrase('mail.private_messages'))
			->setHeader('cache', array(
					'mail.css' => 'style_css'					
				)
			)			
			->setBreadCrumb(Phpfox::getPhrase('mail.private_messages'))
			->setBreadcrumb(Phpfox::getPhrase('mail.view_private_messages'), null, true)
			->assign(array(
					'aMessages' => $aMessages
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('mail.component_controller_compose_clean')) ? eval($sPlugin) : false);
	}
}

?>