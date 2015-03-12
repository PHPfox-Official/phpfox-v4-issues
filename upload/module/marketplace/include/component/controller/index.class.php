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
 * @version 		$Id: index.class.php 7254 2014-04-07 15:30:10Z Fern $
 */
class Marketplace_Component_Controller_Index extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::getUserParam('marketplace.can_access_marketplace', true);
		Phpfox::getService('marketplace.process')->sendExpireNotifications();
		
		if ($this->request()->getInt('req2') > 0)
		{
			return Phpfox::getLib('module')->setController('marketplace.view');
		}
		
		if (($sLegacyTitle = $this->request()->get('req2')) && !empty($sLegacyTitle))
		{
			if ($this->request()->get('req3') != '')
			{
				$sLegacyTitle = $this->request()->get('req3');
			}
			
			$aLegacyItem = Phpfox::getService('core')->getLegacyItem(array(
					'field' => array('category_id', 'name'),
					'table' => 'marketplace_category',		
					'redirect' => 'marketplace.category',
					'title' => $sLegacyTitle,
					'search' => 'name_url'
				)
			);		
		}			

		// certain conditions need to apply to sponsor a listing
		if ($this->request()->get('sponsor') == 'help')
		{
		    // check if the user can sponsor items
		    if (!Phpfox::getUserParam('marketplace.can_purchase_sponsor') &&
			!Phpfox::getUserParam('marketplace.can_sponsor_marketplace'))
		    {
				$this->url()->forward($this->url()->makeUrl('marketplace'), Phpfox::getPhrase('subscribe.the_feature_or_section_you_are_attempting_to_use_is_not_permitted_with_your_membership_level'));
		    }
		    else
		    {
				Phpfox::addMessage(Phpfox::getPhrase('marketplace.sponsor_help'));
		    }
		}
		
		if (($iDeleteId = $this->request()->getInt('delete')))
		{
			if (Phpfox::getService('marketplace.process')->delete($iDeleteId))
			{
				$this->url()->send('marketplace', null, Phpfox::getPhrase('marketplace.listing_successfully_deleted'));
			}
		}
		
		if (($iRedirectId = $this->request()->getInt('redirect')) && ($aListing = Phpfox::getService('marketplace')->getListing($iRedirectId, true)))
		{
			$this->url()->send('marketplace.view', array($aListing['title_url']));
		}
		
		$bIsProfile = false;
		if (defined('PHPFOX_IS_AJAX_CONTROLLER'))
		{
			$bIsProfile = true;
			$aUser = Phpfox::getService('user')->get($this->request()->get('profile_id'));
			$this->setParam('aUser', $aUser);
		}
		else 
		{		
			$bIsProfile = $this->getParam('bIsProfile');	
			if ($bIsProfile === true)
			{
				$aUser = $this->getParam('aUser');
			}
		}			
	
		$oServiceMarketplaceBrowse = Phpfox::getService('marketplace.browse');
		$sCategoryUrl = null;
		$sView = $this->request()->get('view');
		
		$bIsUserProfile = false;
		if (defined('PHPFOX_IS_AJAX_CONTROLLER'))
		{
			$bIsUserProfile = true;
			$aUser = Phpfox::getService('user')->get($this->request()->get('profile_id'));
			$this->setParam('aUser', $aUser);
		}		
		
		if (defined('PHPFOX_IS_USER_PROFILE'))
		{
			$bIsUserProfile = true;
			$aUser = $this->getParam('aUser');
		}		
		
		$aCountriesValue = array();
		$aCountries = Phpfox::getService('core.country')->get();
		foreach ($aCountries as $sKey => $sValue)
		{
			$aCountriesValue[] = array(
				'link' => $sKey,
				'phrase' => $sValue
			);	
		}
		
		$aSearchFields = array(				
				'type' => 'marketplace',
				'field' => 'l.listing_id',
				'search_tool' => array(
					'table_alias' => 'l',
					'search' => array(
						'action' => ($bIsProfile === true ? $this->url()->makeUrl($aUser['user_name'], array('marketplace', 'view' => $this->request()->get('view'))) : $this->url()->makeUrl('marketplace', array('view' => $this->request()->get('view')))),
						'default_value' => Phpfox::getPhrase('marketplace.search_listings'),
						'name' => 'search',
						'field' => array('l.title', 'mt.description_parsed')
					),
					'sort' => array(
						'latest' => array('l.is_sponsor DESC, l.time_stamp', Phpfox::getPhrase('marketplace.latest')),
						//'most-viewed' => array('l.total_view', Phpfox::getPhrase('marketplace.most_viewed')),
						'most-liked' => array('l.is_sponsor DESC, l.total_like', Phpfox::getPhrase('marketplace.most_liked')),
						'most-talked' => array('l.is_sponsor DESC, l.total_comment', Phpfox::getPhrase('marketplace.most_discussed'))
					),
					'show' => array(12, 15, 18, 21)					
				)
			);
			
		if (!$bIsUserProfile)
		{
			$aSearchFields['search_tool']['custom_filters'] = array(
						Phpfox::getPhrase('marketplace.location') => array(
							'param' => 'location',
							'default_phrase' => Phpfox::getPhrase('marketplace.anywhere'),
							'data' => $aCountriesValue,
							'height' => '300px',
							'width' => '150px'					
						)
					);
		}
		
		$this->search()->set($aSearchFields);
		
		$aBrowseParams = array(
			'module_id' => 'marketplace',
			'alias' => 'l',
			'field' => 'listing_id',
			'table' => Phpfox::getT('marketplace'),
			'hide_view' => array('pending', 'my')
		);			
		
		// http://www.phpfox.com/tracker/view/14708/
		if(Phpfox::getParam('core.section_privacy_item_browsing'))
		{
			$aBrowseParams['join'] = array(
				'alias' => 'mt',
				'field' => 'listing_id',
				'table' => Phpfox::getT('marketplace_text')				
			);
		}
		
		switch ($sView)
		{
			case 'sold':
				Phpfox::isUser(true);				
				$this->search()->setCondition('AND l.user_id = ' . Phpfox::getUserId());				
				$this->search()->setCondition('AND l.is_sell = 1');
				
				break;
			case 'featured':
				$this->search()->setCondition('AND l.is_featured = 1');
				break;
			case 'my':
				Phpfox::isUser(true);				
				$this->search()->setCondition('AND l.user_id = ' . Phpfox::getUserId());				
				break;
			case 'pending':
				if (Phpfox::getUserParam('marketplace.can_approve_listings'))
				{
					$this->search()->setCondition('AND l.view_id = 1');
					$this->template()->assign('bIsInPendingMode', true);
				}
				break;
			case 'expired':
				if (Phpfox::getParam('marketplace.days_to_expire_listing') > 0 && Phpfox::getUserParam('marketplace.can_view_expired'))
				{
					$iExpireTime = (PHPFOX_TIME - (Phpfox::getParam('marketplace.days_to_expire_listing') * 86400));
					$this->search()->setCondition('AND l.time_stamp < ' . $iExpireTime);
					break;
				}
			case 'invoice':
				$this->url()->send('marketplace.invoice');
				break;
			default:
				if ($bIsProfile === true)
				{
					$this->search()->setCondition("AND l.view_id IN(" . ($aUser['user_id'] == Phpfox::getUserId() ? '0,1' : '0') . ") AND l.privacy IN(" . (Phpfox::getParam('core.section_privacy_item_browsing') ? '%PRIVACY%' : Phpfox::getService('core')->getForBrowse($aUser)) . ") AND l.user_id = " . $aUser['user_id'] . "");	
				}
				else
				{					
					switch ($sView)
					{
						case 'invites':
							Phpfox::isUser(true);
							$oServiceMarketplaceBrowse->seen();								
							break;
					}
					
					if (($sLocation = $this->request()->get('location')))
					{
						$this->search()->setCondition('AND l.country_iso = \'' . Phpfox::getLib('database')->escape($sLocation) . '\'');
					}
					
					$this->search()->setCondition('AND l.view_id = 0 AND l.privacy IN(%PRIVACY%)');
				}
				break;
		}		
		
		if ($this->request()->get('req2') == 'category')
		{
			$sCategoryUrl = $this->request()->getInt('req3');
			$this->search()->setCondition('AND mcd.category_id = ' . (int) $sCategoryUrl);
		}		
		
		$this->setParam('sCategory', $sCategoryUrl);		
		
		$oServiceMarketplaceBrowse->category($sCategoryUrl);	
			
		if (Phpfox::getParam('marketplace.days_to_expire_listing') > 0 && $sView != 'my' && $sView != 'expired')
		{
			$iExpireTime = (PHPFOX_TIME - (Phpfox::getParam('marketplace.days_to_expire_listing') * 86400));
			$this->search()->setCondition(' AND l.time_stamp >=' . $iExpireTime );
		}	
		
		$this->search()->browse()->params($aBrowseParams)->execute();		
		
		// if its a user trying to buy sponsor space he should get only his own listings
		if ($this->request()->get('sponsor') == 'help')
		{
		    $this->search()->setCondition('AND m.user_id = ' . Phpfox::getUserId() . ' AND is_sponsor != 1');
		}
		
		(($sPlugin = Phpfox_Plugin::get('marketplace.component_controller_index_process_filter')) ? eval($sPlugin) : false);
				
		$aFilterMenu = array();
		if (!defined('PHPFOX_IS_USER_PROFILE'))
		{
			$sInviteTotal = '';
			if (Phpfox::isUser() && ($iTotalInvites = Phpfox::getService('marketplace')->getTotalInvites()))
			{
				$sInviteTotal = '<span class="invited">' . $iTotalInvites . '</span>';
			}
			
			$aFilterMenu = array(
				Phpfox::getPhrase('marketplace.all_listings') => '',
				Phpfox::getPhrase('marketplace.my_listings') => 'my',
				Phpfox::getPhrase('marketplace.listing_invites') . $sInviteTotal => 'invites',
				Phpfox::getPhrase('marketplace.invoices') => 'invoice'
			);							
			
			if (Phpfox::getUserParam('marketplace.can_view_expired'))
			{
				$aFilterMenu[Phpfox::getPhrase('marketplace.expired')] = 'expired';
			}
			if (Phpfox::isModule('friend') && !Phpfox::getParam('core.friends_only_community'))
			{
				$aFilterMenu[Phpfox::getPhrase('marketplace.friends_listings')] = 'friend';	
			}			
			
			if (Phpfox::isModule('event') && Phpfox::getUserParam('event.can_approve_events'))
			{
				$iPendingTotal = Phpfox::getService('marketplace')->getPendingTotal();

				if ($iPendingTotal)
				{
					$aFilterMenu[Phpfox::getPhrase('marketplace.pending_listings') . '<span class="pending">' . $iPendingTotal . '</span>'] = 'pending';
				}
			}
		}			
		
		$this->template()->setTitle(($bIsProfile ? Phpfox::getPhrase('marketplace.full_name_s_listings', array('full_name' => $aUser['full_name'])) : Phpfox::getPhrase('marketplace.marketplace')))
			->setBreadcrumb(Phpfox::getPhrase('marketplace.marketplace'), ($bIsUserProfile ? $this->url()->makeUrl($aUser['user_name'], 'marketplace') : $this->url()->makeUrl('marketplace')))
			->setHeader('cache', array(
					'pager.css' => 'style_css',
					'country.js' => 'module_core',
					'browse.css' => 'module_marketplace',
					'comment.css' => 'style_css',
					'feed.js' => 'module_feed'						
				)
			)
			->assign(array(
					'aListings' => $this->search()->browse()->getRows(),
					'sCategoryUrl' => $sCategoryUrl,
					'sListingView' => $sView					
				)
			);
			
		(($sPlugin = Phpfox_Plugin::get('marketplace.component_controller_process_end')) ? eval($sPlugin) : false);
			
		$this->template()->buildSectionMenu('marketplace', $aFilterMenu);
		
		if ($sCategoryUrl !== null)
		{
			$aCategories = Phpfox::getService('marketplace.category')->getParentBreadcrumb($sCategoryUrl);			
			$iCnt = 0;
			foreach ($aCategories as $aCategory)
			{
				$iCnt++;
				
				$this->template()->setTitle($aCategory[0]);				
				
				if ($bIsUserProfile)
				{
					$aCategory[1] = str_replace('/marketplace/', '/' . $aUser['user_name'] . '/marketplace/', $aCategory[1]);
				}
				
				$this->template()->setBreadcrumb($aCategory[0], $aCategory[1], ($iCnt === count($aCategories) ? true : false));
			}			
		}
		
		$this->setParam('global_moderation', array(
				'name' => 'marketplace',
				'ajax' => 'marketplace.moderation',				
				'menu' => array(
					array(
						'phrase' => Phpfox::getPhrase('marketplace.delete'),
						'action' => 'delete'
					),
					array(
						'phrase' => Phpfox::getPhrase('marketplace.approve'),
						'action' => 'approve'
					),
					array(
						'phrase' => Phpfox::getPhrase('marketplace.feature'),
						'action' => 'feature'
					),
					array(
						'phrase' => Phpfox::getPhrase('marketplace.un_feature'),
						'action' => 'un-feature'
					)					
				)
			)
		);			
		
		Phpfox::getLib('pager')->set(array('page' => $this->search()->getPage(), 'size' => $this->search()->getDisplay(), 'count' => $this->search()->browse()->getCount()));
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('marketplace.component_controller_index_clean')) ? eval($sPlugin) : false);
	}
}

?>
