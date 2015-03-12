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
 * @package  		Module_User
 * @version 		$Id: browse.class.php 7230 2014-03-26 21:14:12Z Fern $
 */
class User_Component_Controller_Browse extends Phpfox_Component
{
    /**
     * Class process method wnich is used to execute this component.
     */
    public function process()
    {    	
        if ($sPlugin = Phpfox_Plugin::get('user.component_controller_browse__1')){eval($sPlugin);if (isset($aPluginReturn)){return $aPluginReturn;}}
        
		$aCallback = $this->getParam('aCallback', false);
		if ($aCallback !== false)
		{
		    if (!Phpfox::getService('group')->hasAccess($aCallback['item'], 'can_view_members'))
		    {
				return Phpfox_Error::display(Phpfox::getPhrase('user.members_section_is_closed'));
		    }
		}

		if (defined('PHPFOX_IS_ADMIN_SEARCH'))
		{
			$aIds = $this->request()->getArray('id');			
			if (($aIds = $this->request()->getArray('id')) && count((array) $aIds))
			{
				Phpfox::getUserParam('user.can_delete_others_account', true);

				if ($this->request()->get('delete'))
				{	
					foreach ($aIds as $iId)
					{
						if (Phpfox::getService('user')->isAdminUser($iId))
						{
							$this->url()->send('current', null, Phpfox::getPhrase('user.you_are_unable_to_delete_a_site_administrator'));
						}

						Phpfox::getService('user.auth')->setUserId($iId);
						Phpfox::massCallback('onDeleteUser', $iId);
						Phpfox::getService('user.auth')->setUserId(null);
					}

					$this->url()->send('current', null, Phpfox::getPhrase('user.user_s_successfully_deleted'));
				}
				elseif ($this->request()->get('ban') || $this->request()->get('unban'))
				{
					foreach ($aIds as $iId)
					{
						if (Phpfox::getService('user')->isAdminUser($iId))
						{
							$this->url()->send('current', null, Phpfox::getPhrase('user.you_are_unable_to_ban_a_site_administrator'));
						}

						Phpfox::getService('user.process')->ban($iId, ($this->request()->get('ban') ? 1 : 0));
					}

					$this->url()->send('current', null, ($this->request()->get('ban') ? Phpfox::getPhrase('user.user_s_successfully_banned') : Phpfox::getPhrase('user.user_s_successfully_un_banned')));
				}
				elseif ($this->request()->get('resend-verify'))
				{
					foreach ($aIds as $iId)
					{
						Phpfox::getService('user.verify.process')->sendMail($iId);
					}

					$this->url()->send('current', null, Phpfox::getPhrase('user.email_verification_s_sent'));
				}
				elseif ($this->request()->get('verify'))
				{
					foreach ($aIds as $iId)
					{
						Phpfox::getService('user.verify.process')->adminVerify($iId);
					}

					$this->url()->send('current', null, Phpfox::getPhrase('user.user_s_verified'));
				}
				elseif ($this->request()->get('approve'))
				{
					foreach ($aIds as $iId)
					{
						Phpfox::getService('user.process')->userPending($iId, '1');
					}

					$this->url()->send('current', null, Phpfox::getPhrase('user.user_s_successfully_approved'));
				}
			}
		}
		else // is not admincp
		{
			$aCheckParams = array(
			'url' => $this->url()->makeUrl('user.browse'),
			'start' => 2,
			'reqs' => array(
					'2' => array('browse')
				)
			);
		
			if (Phpfox::getParam('core.force_404_check') && !PHPFOX_IS_AJAX && !Phpfox::getService('core.redirect')->check404($aCheckParams))
			{
				return Phpfox::getLib('module')->setController('error.404');
			}
		}

		$aPages = (Phpfox::isMobile() ? array(10) : array(21, 31, 41, 51));
		$aDisplays = array();
		foreach ($aPages as $iPageCnt)
		{
		    $aDisplays[$iPageCnt] = Phpfox::getPhrase('core.per_page', array('total' => $iPageCnt));
		}

		$aSorts = array(
			'u.full_name' => Phpfox::getPhrase('user.name'),
		    'u.joined' => Phpfox::getPhrase('user.joined'),
		    'u.last_login' => Phpfox::getPhrase('user.last_login'),
		    'ufield.total_rating' => Phpfox::getPhrase('user.rating')
		);

		$aAge = array();
		for ($i = Phpfox::getService('user')->age(Phpfox::getService('user')->buildAge(1, 1, Phpfox::getParam('user.date_of_birth_end'))); $i <= Phpfox::getService('user')->age(Phpfox::getService('user')->buildAge(1, 1, Phpfox::getParam('user.date_of_birth_start'))); $i++)
		{
		    $aAge[$i] = $i;
		}

		$iDay = date('d');
		$iMonth = date('m');
		$iYear = date('Y');

		$aUserGroups = array();
		foreach (Phpfox::getService('user.group')->get() as $aUserGroup)
		{
		    $aUserGroups[$aUserGroup['user_group_id']] = Phpfox::getLib('locale')->convert($aUserGroup['title']);
		}

		$aGenders = Phpfox::getService('core')->getGenders();
		$aGenders[''] = (count($aGenders) == '2' ? Phpfox::getPhrase('user.both') : Phpfox::getPhrase('core.all'));

		if (($sPlugin = Phpfox_Plugin::get('user.component_controller_browse_genders')))
		{
		    eval($sPlugin);
		}

		$sDefaultOrderName = 'u.full_name';
		$sDefaultSort = 'ASC';
		if (Phpfox::getParam('user.user_browse_default_result') == 'last_login')
		{
			$sDefaultOrderName = 'u.last_login';
			$sDefaultSort = 'DESC';
		}

		$aFilters = array(
			'display' => array(
			    'type' => 'select',
			    'options' => $aDisplays,
			    'default' => 21
			),
			'sort' => array(
			    'type' => 'select',
			    'options' => $aSorts,
			    'default' => $sDefaultOrderName
		    ),
			'sort_by' => array(
			    'type' => 'select',
			    'options' => array(
				    'DESC' => Phpfox::getPhrase('core.descending'),
				    'ASC' => Phpfox::getPhrase('core.ascending')
			    ),
			    'default' => $sDefaultSort
			),
		    'keyword' => array(
			    'type' => 'input:text',
			    'size' => 15,
		    	'class' => 'txt_input'
		    ),
		    'type' => array(
			    'type' => 'select',
			    'options' => array(
				    '0' => array(Phpfox::getPhrase('user.email_name'), 'AND ((u.full_name LIKE \'%[VALUE]%\' OR (u.email LIKE \'%[VALUE]@%\' OR u.email = \'[VALUE]\'))' . (defined('PHPFOX_IS_ADMIN_SEARCH') ? ' OR u.email LIKE \'%[VALUE]\'' : '') .')'),
			    	'1' => array(Phpfox::getPhrase('user.email'), 'AND ((u.email LIKE \'%[VALUE]@%\' OR u.email = \'[VALUE]\'' . (defined('PHPFOX_IS_ADMIN_SEARCH') ? ' OR u.email LIKE \'%[VALUE]%\'' : '') .'))'),
				    '2' => array(Phpfox::getPhrase('user.name'), 'AND (u.full_name LIKE \'%[VALUE]%\')')
		    	),
		    	'depend' => 'keyword'
		    ),
		    'group' => array(
			    'type' => 'select',
			    'options' => $aUserGroups,
			    'add_any' => true,
			    'search' => 'AND u.user_group_id = \'[VALUE]\''
		    ),
		    'gender' => array(
			    'type' => 'input:radio',
			    'options' => $aGenders,
			    'default_view' => '',
			    'search' => 'AND u.gender = \'[VALUE]\'',
			    'suffix' => '<br />'
		    ),
		    'from' => array(
			    'type' => 'select',
			    'options' => $aAge,
			    'add_any' => true
		    ),
		    'to' => array(
			    'type' => 'select',
			    'options' => $aAge,
			    'add_any' => true
		    ),
		    'country' => array(
			    'type' => 'select',
			    'options' => Phpfox::getService('core.country')->get(),
			    'search' => 'AND u.country_iso = \'[VALUE]\'',
			    'add_any' => true,
			    'style' => 'width:150px;',
			    'id' => 'country_iso'
		    ),
		    'country_child_id' => array(
			    'type' => 'select',
			    'search' => 'AND ufield.country_child_id = \'[VALUE]\'',
			    'clone' => true
		    ),
		    'status' => array(
			    'type' => 'select',
			    'options' => array(
				    '2' => Phpfox::getPhrase('user.all_members'),
				    '1' => Phpfox::getPhrase('user.featured_members'),
				    '4' => Phpfox::getPhrase('user.online'),
				    '3' => Phpfox::getPhrase('user.pending_verification_members'),
				    '5' => Phpfox::getPhrase('user.pending_approval'),
				    '6' => Phpfox::getPhrase('user.not_approved')
			    ),
			    'default_view' => '2',
		    ),
		    'city' => array(
			    'type' => 'input:text',
			    'size' => 15,
			    'search' => 'AND ufield.city_location LIKE \'%[VALUE]%\''
		    ),
		    'zip' => array(
			    'type' => 'input:text',
			    'size' => 10,
			    'search' => 'AND ufield.postal_code = \'[VALUE]\''
		    ),
		    'show' => array(
			    'type' => 'select',
			    'options' => array(
				    '1' => Phpfox::getPhrase('user.name_and_photo_only'),
				    '2' => Phpfox::getPhrase('user.name_photo_and_users_details')
			    ),
			    'default_view' => (Phpfox::getParam('user.user_browse_display_results_default') == 'name_photo_detail' ? '2' : '1')
		    ),
		    'ip' => array(
		    	'type' => 'input:text',
		    	'size' => 10
		    )
		);

		if (!Phpfox::getUserParam('user.can_search_by_zip'))
		{
			unset ($aFilters['zip']);
		}
		if ($sPlugin = Phpfox_Plugin::get('user.component_controller_browse_filter'))
		{
		    eval($sPlugin);
		}

		$aSearchParams = array(
			'type' => 'browse',
			'filters' => $aFilters,
			'search' => 'keyword',
			'custom_search' => true
		);
		
		if (!defined('PHPFOX_IS_ADMIN_SEARCH'))
		{
			$aSearchParams['no_session_search'] = true;
		}
		
		$oFilter = Phpfox::getLib('search')->set($aSearchParams);

		$sStatus = $oFilter->get('status');
		$sView = $this->request()->get('view');
		$aCustomSearch = $oFilter->getCustom();
		$bIsOnline = false;
		$bPendingMail = false;
		$mFeatured = false;
		$bIsGender = false;

		switch ((int) $sStatus)
		{
		    case 1: 
		    $mFeatured = true; 
		    break; 
		    case 3: 
		        if (defined('PHPFOX_IS_ADMIN_SEARCH')) 
		        { 
		            $oFilter->setCondition('AND u.status_id = 1'); 
		        } 
		    break; 
		    case 4: 
		    $bIsOnline = true; 
		    break; 
		    case 5: 
		        if (defined('PHPFOX_IS_ADMIN_SEARCH')) 
		        { 
		            $oFilter->setCondition('AND u.view_id = 1'); 
		        } 
		        break; 
		    case 6: 
		        if (defined('PHPFOX_IS_ADMIN_SEARCH')) 
		        { 
		            $oFilter->setCondition('AND u.view_id = 2'); 
		        } 
		        break; 
		    default: 
		
		    break; 
		}

		$this->template()->setTitle(Phpfox::getPhrase('user.browse_members'))->setBreadcrumb(Phpfox::getPhrase('user.browse_members'), ($aCallback !== false ? $this->url()->makeUrl($aCallback['url_home']) : $this->url()->makeUrl((defined('PHPFOX_IS_ADMIN_SEARCH') ? 'admincp.' : '') . 'user.browse')));

		if (!empty($sView))
		{
		    switch ($sView)
		    {
			case 'online':
			    $bIsOnline = true;
			    break;
			case 'featured':
			    $mFeatured = true;
			    break;
			case 'spam':
			    $oFilter->setCondition('u.total_spam > ' . (int) Phpfox::getParam('core.auto_deny_items'));
			    break;
			case 'pending':
				if (defined('PHPFOX_IS_ADMIN_SEARCH'))
				{
					$oFilter->setCondition('u.view_id = 1');
				}
				break;
			case 'top':
				$bExtendContent = true;
				$oFilter->setSort('ufield.total_rating');
				$oFilter->setCondition('AND ufield.total_rating > ' . Phpfox::getParam('user.min_count_for_top_rating'));
				if (($iUserGenderTop = $this->request()->getInt('topgender')))
				{
					$oFilter->setCondition('AND u.gender = ' . (int) $iUserGenderTop);
				}

				$iFilterCount = 0;
				$aFilterMenuCache = array();

					$aFilterMenu = array(
						Phpfox::getPhrase('user.all') => '',
						Phpfox::getPhrase('user.male') => '1',
						Phpfox::getPhrase('user.female') => '2'
					);

					if ($sPlugin = Phpfox_Plugin::get('user.component_controller_browse_genders_top_users'))
					{
					    eval($sPlugin);
					}

					$this->template()->setTitle(Phpfox::getPhrase('user.top_rated_members'))
						->setBreadcrumb(Phpfox::getPhrase('user.top_rated_members'), $this->url()->makeUrl('user.browse', array('view' => 'top')));

					foreach ($aFilterMenu as $sMenuName => $sMenuLink)
					{
						$iFilterCount++;
						$aFilterMenuCache[] = array(
							'name' => $sMenuName,
							'link' => $this->url()->makeUrl('user.browse', array('view' => 'top', 'topgender' => $sMenuLink)),
							'active' => ($this->request()->get('topgender') == $sMenuLink ? true : false),
							'last' => (count($aFilterMenu) === $iFilterCount ? true : false)
						);

						if ($this->request()->get('topgender') == $sMenuLink)
						{
							$this->template()->setTitle($sMenuName)->setBreadcrumb($sMenuName, null, true);
						}
					}

				$this->template()->assign(array(
							'aFilterMenus' => $aFilterMenuCache
						)
					);

				break;
			default:

			    break;
		    }
		}

		if (($iFrom = $oFilter->get('from')) || ($iFrom = $this->request()->getInt('from')))
		{
		    $oFilter->setcondition('AND u.birthday_search <= \'' . Phpfox::getLib('date')->mktime(0, 0, 0, 1, 1, $iYear - $iFrom). '\'' . ((defined('PHPFOX_IS_ADMIN_SEARCH') && Phpfox::getUserParam('user.remove_users_hidden_age')) ? '' : ' AND ufield.dob_setting IN(0,1,2)'));
		    $bIsGender = true;
		}
		if (($iTo = $oFilter->get('to')) || ($iTo = $this->request()->getInt('to')))
		{
		    $oFilter->setcondition('AND u.birthday_search >= \'' . Phpfox::getLib('date')->mktime(0, 0, 0, 1, 1, $iYear - $iTo) .'\'' . ((defined('PHPFOX_IS_ADMIN_SEARCH') && Phpfox::getUserParam('user.remove_users_hidden_age')) ? '' : ' AND ufield.dob_setting IN(0,1,2)'));
		    $bIsGender = true;
		}

		if (($sLocation = $this->request()->get('location')))
		{
		    $oFilter->setCondition('AND u.country_iso = \'' . Phpfox::getLib('database')->escape($sLocation) . '\'');
		}

		if (($sGender = $this->request()->getInt('gender')))
		{
		    $oFilter->setCondition('AND u.gender = \'' . Phpfox::getLib('database')->escape($sGender) . '\'');
		}

		if (($sLocationChild = $this->request()->getInt('state')))
		{
		    $oFilter->setCondition('AND ufield.country_child_id = \'' . Phpfox::getLib('database')->escape($sLocationChild) . '\'');
		}

		if (($sLocationCity = $this->request()->get('city-name')))
		{
		    $oFilter->setCondition('AND ufield.city_location = \'' . Phpfox::getLib('database')->escape(Phpfox::getLib('parse.input')->convert($sLocationCity)) . '\'');
		}

		if (!defined('PHPFOX_IS_ADMIN_SEARCH'))
		{
			$oFilter->setCondition('AND u.status_id = 0 AND u.view_id = 0');
		}
		else
		{
			$oFilter->setCondition('AND u.profile_page_id = 0');
		}

		if (defined('PHPFOX_IS_ADMIN_SEARCH') && ($sIp = $oFilter->get('ip')))
		{
			Phpfox::getService('user.browse')->ip($sIp);
		}

		$bExtend = (defined('PHPFOX_IS_ADMIN_SEARCH') ? true : (((($oFilter->get('show') && $oFilter->get('show') == '2') || (!$oFilter->get('show') && Phpfox::getParam('user.user_browse_display_results_default') == 'name_photo_detail')) ? true : false)));
		$iPage = $this->request()->getInt('page');
		$iPageSize = $oFilter->getDisplay();
		
		if (($sPlugin = Phpfox_Plugin::get('user.component_controller_browse_filter_process')))
		{
		    eval($sPlugin);
		}		

		list($iCnt, $aUsers) = Phpfox::getService('user.browse')->conditions($oFilter->getConditions())
		    ->callback($aCallback)
		    ->sort($oFilter->getSort())
		    ->page($oFilter->getPage())
		    ->limit($iPageSize)
		    ->online($bIsOnline)
		    ->extend((isset($bExtendContent) ? true : $bExtend))
		    ->featured($mFeatured)
		    ->pending($bPendingMail)
		    ->custom($aCustomSearch)
		    ->gender($bIsGender)
		    ->get();

		/*
		foreach ($aUsers as $iIndex => $aUser)
		{
			$aUsers[$iIndex]['full_name'] = substr($aUser['full_name'], 0, Phpfox::getParam('user.maximum_length_for_full_name'));
		}
		*/
		
		$iCnt = $oFilter->getSearchTotal($iCnt);
		$aNewCustomValues = array();
		if ($aCustomValues = $this->request()->get('custom'))
		{
		    foreach ($aCustomValues as $iKey => $sCustomValue)
		    {
			$aNewCustomValues['custom[' . $iKey . ']'] = $sCustomValue;
		    }
		}
		else
		{
		    $aCustomValues = array();
		}

		if (!(defined('PHPFOX_IS_ADMIN_SEARCH')))
		{
			//Phpfox::getLib('pager')->set(array('page' => $iPage, 'size' => $iPageSize, 'count' => $iCnt, 'ajax' => 'user.mainBrowse'));
			Phpfox::getLib('pager')->set(array('page' => $iPage, 'size' => $iPageSize, 'count' => $iCnt, 'ajax' => 'user.mainBrowse', 'aParams' => $aNewCustomValues));
		}
		else
		{
			Phpfox::getLib('pager')->set(array('page' => $iPage, 'size' => $iPageSize, 'count' => $iCnt));
		}
		
		Phpfox::getLib('url')->setParam('page', $iPage);
		
		// http://www.phpfox.com/tracker/view/15277/
		if($iPage > Phpfox::getLib('pager')->getTotalPages())
		{
			Phpfox::getLib('url')->send('error.404');
		}
		
		if ($this->request()->get('featured') == 1)
		{
		    $this->template()->setHeader(array(
				'drag.js' => 'static_script',
				'<script type="text/javascript">$Behavior.coreDragInit = function() { Core_drag.init({table: \'#js_drag_drop\', ajax: \'user.setFeaturedOrder\'}); }</script>'
				)
			)
			->assign(array('bShowFeatured' => 1));
		}
		foreach ($aUsers as $iKey => $aUser)
		{
			if (!isset($aUser['user_group_id']) || empty($aUser['user_group_id']) ||  $aUser['user_group_id'] < 1)
			{
				$aUser['user_group_id'] = $aUsers[$iKey]['user_group_id'] = 5;
				Phpfox::getService('user.process')->updateUserGroup($aUser['user_id'], 5);
				$aUsers[$iKey]['user_group_title'] = Phpfox::getPhrase('user.user_banned');
			}
			$aBanned = Phpfox::getService('ban')->isUserBanned($aUser);
			$aUsers[$iKey]['is_banned'] = $aBanned['is_banned'];
		}
		$aCustomFields = Phpfox::getService('custom')->getForPublic('user_profile');


		$this->template()
		    ->setHeader('cache', array(
		    		'pager.css' => 'style_css',
		    		'country.js' => 'module_core'
		    	)
		    )
		    ->assign(array(
			    'aUsers' => $aUsers,
			    'bExtend' => $bExtend,
			    'aCallback' => $aCallback,
			    'bIsSearch' => $oFilter->isSearch(),
				'bIsInSearchMode' => ($this->request()->getInt('search-id') ? true : false),
			    'aForms' => $aCustomSearch,
			    'aCustomFields' => $aCustomFields,
			    'sView' => $sView				
		    )
		);

		// add breadcrumb if its in the featured members page and not in admin
		if (!(defined('PHPFOX_IS_ADMIN_SEARCH')))
		{
		    Phpfox::getUserParam('user.can_browse_users_in_public', true);
		    
		    $this->template()->setHeader('cache', array(
		    		'browse.css' => 'style_css'		    		    	
		    	)
		    );
			
			if (!Phpfox::isMobile())
			{
				$this->template()->setHeader('cache', array(
						'browse.js' => 'module_user'	    	
					)
				);			
			}

			if ($this->request()->get('view') == 'featured')
		    {
				$this->template()->setBreadCrumb(Phpfox::getPhrase('user.featured_members'), null, true);

				$sTitle = Phpfox::getPhrase('user.title_featured_members');
				if (!empty($sTitle))
				{
				    $this->template()->setTitle($sTitle);
				}
		    }
		    elseif($this->request()->get('view') == 'online')
		    {
				$this->template()->setBreadCrumb(Phpfox::getPhrase('user.menu_who_s_online'), null, true);
				$sTitle = Phpfox::getPhrase('user.title_who_s_online');
				if (!empty($sTitle))
				{
				    $this->template()->setTitle($sTitle);
				}
		    }
		}

		if ($aCallback !== false)
		{
		    $this->template()->rebuildMenu('user.browse', $aCallback['url'])->removeUrl('user.browse', 'user.browse.view_featured');
		}
    }
}

?>

