<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 *
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel_Espinoza
 * @package 		Phpfox_Component
 * @version 		$Id: sponsor.class.php 7122 2014-02-18 13:58:38Z Fern $
 */
class Ad_Component_Controller_Sponsor extends Phpfox_Component
{
    /**
     * Class process method wnich is used to execute this component.
     * when getInt(view) it updates the click count for the item, redirects right after
     * when getInt(module) and getInt(id) it shows the Create Sponsor Ad
     * when getInt(add) the user is reviewing a campagin -> dont show the submit
     * when getInt(pay) the user is shown the payment options and nothing else
     */
    public function process()
    {
		// Updating clicks and redirecting. No page is shown because its a redirect
		if (($iView = $this->request()->getInt('view')) != 0)
		{
		    $aUrl = Phpfox::getService('ad')->getSponsor($iView);
		    // split the module if theres a subsection
		    $sModule = $aUrl['module_id'];
		    $sSection = '';
		    
		    if (strpos($aUrl['module_id'], '-') !== false)
		    {
				$aModule = explode('-', $aUrl['module_id']);
				$sModule = $aModule[0];
				$sSection = $aModule[1];
		    }
	
		    if (Phpfox::isModule($sModule))
		    {
				$sLink = Phpfox::callback($sModule.'.getLink', array('item_id' => $aUrl['item_id'], 'section' => $sSection));
				// Update the counter of views (do we need the track table here?)
				// do not log clicks if its an Admin or the creator of the sponsor ad
				if (!Phpfox::isAdmin())
				{
				    Phpfox::getLib('database')->update(Phpfox::getT('ad_sponsor'), array('total_click' => $aUrl['total_click']+1), 'sponsor_id = ' . $aUrl['sponsor_id'] . ' AND user_id != ' . Phpfox::getUserId());
				}
				$this->url()->send($sLink);
		    }
		}
		
		// Check its a user
		Phpfox::isUser(true);
		// define default values
		$sModule = $this->request()->get('section');
		$sFunction = 'getToSponsorInfo';
		$sStatus = $this->request()->get('status');
		$iSponsorId = $this->request()->get('req3');	
	
		$aAge = array();
		$iAgeDiff = date('Y') - Phpfox::getParam('user.date_of_birth_start');
		for ($i = 0; $i <= Phpfox::getParam('user.date_of_birth_end') - Phpfox::getParam('user.date_of_birth_start'); $i++)
		{
		    $aAge[Phpfox::getParam('user.date_of_birth_end')+$i] = $iAgeDiff-$i;
		}
		asort($aAge);

		// is the user trying to view a campaign?
		if ($iId = $this->request()->get('add'))
		{
		    $aVals = Phpfox::getService('ad')->getSponsor($iId);
		    $sModule = $aVals['module_id'];
	
		    $iSponsorId = $iId;
		    $this->template()->assign(array('isView' => true));
		}
		
		// final fixing
		if (strpos($sModule, '-') !== false)
		{
		    $aModule = explode('-',$sModule);
		    $sModule = $aModule[0];
		    $sFunction = 'getToSponsor' . ucwords($aModule[1]) . 'Info';
		}
		
		// Sponsoring posts in the feed
		$aVals = $this->request()->getArray('val');
		if ($this->request()->get('where') == 'feed')
		{
			// http://www.phpfox.com/tracker/view/15061/
			$this->template()->assign(array('sFormerModule' => $this->request()->get('section')));
			// get "feed" item_id instead of original "module name" item_id
			$aNewItemId = Phpfox::getService('feed')->getForItem($this->request()->get('section'), $this->request()->getInt('item'));
			if(!empty($aNewItemId))
			{
				// correct "feed" item_id
				$aVals['item_id'] = $aNewItemId['feed_id'];
			}
			$aVals['module'] = 'feed'; // assign feed as module instead of original
			// Can sponsor without paying? (note that param is not plural)
			if(Phpfox::getUserParam('feed.can_sponsor_feed'))
			{
				// Payment completed: no payment required
				$sStatus = 'completed';
				// Flag for template to skip payment form
				$this->template()->assign(array('bWithoutPay' => true));
				// add the sponsor
			    $iSponsorId = Phpfox::getService('ad.process')->addSponsor($aVals);
			}
			// END
			
			$sFunction = 'getSponsorPostInfo';
			$sModule = 'feed'; // Easier to get all from one single module
			$iSponsorId = array('iItemId' => $this->request()->getInt('item'), 'sModule' => $this->request()->get('section'));
		}		
		
		if (Phpfox::hasCallback($sModule, $sFunction))
		{	    
		    $aItem = Phpfox::callback($sModule. '.'.$sFunction, $iSponsorId);
		    
		    if (empty($aItem))
		    {
				return Phpfox_Error::display(Phpfox::getPhrase('core.module_is_not_a_valid_module',array('module' => $sModule)));		
		    }
		    
		    /* aItem must be in the format:
		     * array(
		     *	'title' => 'item title',		    <-- required	     
		     *  'link'  => 'makeUrl()'ed link',		    <-- required
		     *  'paypal_msg' => 'message for paypal'	    <-- required
		     *  'item_id' => int			    <-- required
		     *  'user_id'   => owner's user id		    <-- required
		     *	'error' => 'phrase if item doesnt exit'	    <-- optional
		     *	'extra' => 'description'		    <-- optional
		     *	'image' => 'path to an image',		    <-- optional
		     *  'image_dir' => 'photo.url_photo|...	    <-- optional (required if image)
		     * )
		    */
		    if (isset($aItem['error']) && !empty($aItem['error']))
		    {
				
				return Phpfox_Error::display($aItem['error']);
		    }
		    // check that the user viewing is either the owner of the item or an admin	    
		    if (($aItem['user_id'] != Phpfox::getUserId()) && !Phpfox::isAdmin())
		    {	
				
				return Phpfox_Error::display(Phpfox::getPhrase('ad.sponsor_error_owner') );
		    }
		    $aPrices = Phpfox::getUserParam($sModule.'.'.$sModule. (isset($aModule[1]) ? '_'.$aModule[1] : '') .'_sponsor_price');
		    if (Phpfox::getLib('parse.format')->isSerialized($aPrices))
		    {		
				$aPrices = unserialize($aPrices);
				if (!isset($aPrices[Phpfox::getService('core.currency')->getDefault()]))
				{
				    return Phpfox_Error::display(Phpfox::getPhrase('ad.the_default_currency_has_no_price'));
				}
				$aItem['default_cost'] = $aPrices[Phpfox::getService('core.currency')->getDefault()];
                                $aItem['ad_cost'] = $aItem['default_cost'];
		    }
		    else
		    {
				return Phpfox_Error::display(Phpfox::getPhrase('ad.the_currency_for_your_membership_has_no_price'));
		    }
		    
		    if (!isset($aItem['title']))
		    {		
				return Phpfox_Error::display($aItem['error']);		
		    }
		    
		    $aItem['name'] = $aItem['title'];
		    if (isset($aVals) && !empty($aVals))
		    {
				$aItem = array_merge($aItem, $aVals);
				
				$aItem['default_cost'] = isset($aItem['cpm']) ? $aItem['cpm'] : $aItem['ad_cost'];
		    }
		    if ( ($sWhere = $this->request()->get('where')) != '')
		    {
				$aItem['where'] = $sWhere;
			}
			if ( ($iItemId = $this->request()->get('item') ) != '')
			{
				$aItem['item_id'] = $iItemId;
			}
		   
		    $this->template()->assign(array('aForms' => $aItem));		    
		}
		elseif ($this->request()->get('add','') == '' && $this->request()->get('pay','') == '')
		{
		    return Phpfox_Error::display(Phpfox::getPhrase('core.module_is_not_a_valid_module', array('module' => $sModule)));
		}

		$this->template()->assign(array('aAge' => $aAge));	
	
		$iSponsorId = $this->request()->getInt('pay'); // defaults to 0
	
		if (($aVals = $this->request()->getArray('val')) || $iSponsorId > 0)
		{		    
		    if ($iSponsorId > 0)
		    {
				$aVals = Phpfox::getService('ad')->getSponsor($iSponsorId, Phpfox::getUserId());
				$fTotalCost = $aVals['price'];
				$aVals['name'] = $aVals['campaign_name'];
				$aItem = array('item_id' => $aVals['item_id'],'paypal_msg' => $aVals['paypal_msg']);
		    }
		    
		    if (!isset($aVals['total_view']) || ($aVals['total_view'] != 0 && $aVals['total_view'] < 1000))
		    {
				Phpfox_Error::set(Phpfox::getPhrase('ad.impressions_cant_be_less_than_a_thousand'));
		    }
		    
		    if (!isset($aVals['name']) || empty($aVals['name']))
		    {
				Phpfox_Error::set(Phpfox::getPhrase('ad.provide_a_campaign_name'));
		    }
		    
		    if (!isset($fTotalCost))
		    {
				$fTotalCost = round($aVals['total_view'] * $aItem['default_cost'] / 1000 * 100)/100;
		    }
		    
		    if (Phpfox_Error::isPassed())
		    {
				// validator
				$aVals['module'] = $sModule;
				if (isset($aModule[1]))
				{
				    $aVals['section'] = $aModule[1];
				}
				$aVals['item_id'] = $aItem['item_id'];
		
				if ($iSponsorId < 1)
				{
					// http://www.phpfox.com/tracker/view/15061/
					// if sponsor in feeds
					if ($this->request()->get('where') == 'feed')
					{
						// get "feed" item_id instead of original "module name" item_id
						if(!empty($aNewItemId))
						{
							// correct "feed" item_id
							$aVals['item_id'] = $aNewItemId['feed_id'];
						}
					}
					//END
					
				    $iSponsorId = Phpfox::getService('ad.process')->addSponsor($aVals);
				}
				$this->template()->assign(array('iInvoice' => $iSponsorId));
				$this->setParam('gateway_data', array(
						'item_number' => 'ad|'.$iSponsorId.'-sponsor',
						'currency_code' => Phpfox::getService('core.currency')->getDefault(),
						'amount' => $fTotalCost,
						'item_name' => $aItem['paypal_msg'], // this is for paypal
						'return' => $this->url()->makeUrl('ad.invoice'), // dummy page to say it all went fine
						'recurring' => 0,
						'recurring_cost' => '',
						'alternative_cost' => 0,
						'alternative_recurring_cost' => 0,
					)
				);
		    }
		}
		elseif ($this->request()->get('status') == '')
		{
		    $this->template()->setHeader(
			    array(
			   	 'sponsor.js' => 'module_ad',
			  	  '<script type="text/javascript">$Behavior.loadSponsorInfo = function(){$Core.Ad.setPrice(' . $aItem['default_cost'] . ');}</script>'
			    )
			);
		}

		$iId = $this->request()->get('req3');
		if(empty($iId))
		{
			$iId = null;
		}

	    $this->template()->setTitle(Phpfox::getPhrase('ad.creating_an_ad'))	
			->setBreadcrumb(Phpfox::getPhrase('ad.advertise'), $this->url()->makeUrl('ad'))
			->setPhrase(array(
		    	'ad.for_currency_total_cost',
		    	'ad.impressions_cant_be_less_than_a_thousand',
		    	'ad.the_currency_for_your_membership_has_no_price'
	    	)
	    )
		->assign(array(
		    	'sStatus' => $sStatus,
		    	'sModule' => $sModule . (isset($aModule[1]) ? '-'.$aModule[1] : ''),
		    	'iId' => $iId
	    	)
	    );
    }

    /**
     * Garbage collector. Is executed after this class has completed
     * its job and the template has also been displayed.
     */
    public function clean()
    {
		(($sPlugin = Phpfox_Plugin::get('ad.component_controller_sponsor_clean')) ? eval($sPlugin) : false);
    }
}

?>
