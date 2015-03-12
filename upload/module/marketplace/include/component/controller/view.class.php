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
 * @version 		$Id: view.class.php 5844 2013-05-09 08:00:59Z Raymond_Benc $
 */
class Marketplace_Component_Controller_View extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if ($this->request()->get('req2') == 'view' && ($sLegacyTitle = $this->request()->get('req3')) && !empty($sLegacyTitle))
		{			
			Phpfox::getService('core')->getLegacyItem(array(
					'field' => array('listing_id', 'title'),
					'table' => 'marketplace',		
					'redirect' => 'marketplace',
					'title' => $sLegacyTitle
				)
			);
		}		
		
		Phpfox::getUserParam('marketplace.can_access_marketplace', true);
		
		if (!($iListingId = $this->request()->get('req2')))
		{
			$this->url()->send('marketplace');
		}
		
		if (!($aListing = Phpfox::getService('marketplace')->getListing($iListingId)))
		{
			return Phpfox_Error::display(Phpfox::getPhrase('marketplace.the_listing_you_are_looking_for_either_does_not_exist_or_has_been_removed'));	
		}			
		
		$this->setParam('aListing', $aListing);	
		
		if (Phpfox::isUser() && $aListing['invite_id'] && !$aListing['visited_id'] && $aListing['user_id'] != Phpfox::getUserId())
		{
			Phpfox::getService('marketplace.process')->setVisit($aListing['listing_id'], Phpfox::getUserId());
		}		
		
		if (Phpfox::isUser() && Phpfox::isModule('notification'))
		{
			Phpfox::getService('notification.process')->delete('comment_marketplace', $this->request()->getInt('req2'), Phpfox::getUserId());
			Phpfox::getService('notification.process')->delete('marketplace_like', $this->request()->getInt('req2'), Phpfox::getUserId());
		}
		
		if (Phpfox::isModule('notification') && $aListing['user_id'] == Phpfox::getUserId())
		{
			Phpfox::getService('notification.process')->delete('marketplace_approved', $aListing['listing_id'], Phpfox::getUserId());
		}		
		
		Phpfox::getService('core.redirect')->check($aListing['title']);
		if (Phpfox::isModule('privacy'))
		{
			Phpfox::getService('privacy')->check('marketplace', $aListing['listing_id'], $aListing['user_id'], $aListing['privacy'], $aListing['is_friend']);		
		}

		$this->setParam('aRatingCallback', array(
				'type' => 'user',
				'default_rating' => $aListing['total_score'],
				'item_id' => $aListing['user_id'],
				'stars' => range(1, 10)
			)
		);			
		
		$this->setParam('aFeed', array(				
				'comment_type_id' => 'marketplace',
				'privacy' => $aListing['privacy'],
				'comment_privacy' => $aListing['privacy_comment'],
				'like_type_id' => 'marketplace',
				'feed_is_liked' => $aListing['is_liked'],
				'feed_is_friend' => $aListing['is_friend'],
				'item_id' => $aListing['listing_id'],
				'user_id' => $aListing['user_id'],
				'total_comment' => $aListing['total_comment'],
				'total_like' => $aListing['total_like'],
				'feed_link' => $this->url()->permalink('marketplace', $aListing['listing_id'], $aListing['title']),
				'feed_title' => $aListing['title'],
				'feed_display' => 'view',
				'feed_total_like' => $aListing['total_like'],
				'report_module' => 'marketplace',
				'report_phrase' => Phpfox::getPhrase('marketplace.report_this_listing_lowercase')
			)
		);			
		
		$this->template()->setTitle($aListing['title'] . ($aListing['view_id'] == '2' ? ' (' . Phpfox::getPhrase('marketplace.sold') . ')' : ''))
			->setBreadcrumb(Phpfox::getPhrase('marketplace.marketplace'), $this->url()->makeUrl('marketplace'))
			->setMeta('description', $aListing['description'])
			->setMeta('keywords', $this->template()->getKeywords($aListing['title'] . $aListing['description']))
			->setMeta('og:image', Phpfox::getLib('image.helper')->display(array(
						'server_id' => $aListing['listing_id'],
						'path' => 'marketplace.url_image',
						'file' => $aListing['image_path'],
						'suffix' => '_400',
						'return_url' => true
					)
				)
			)			
			->setBreadcrumb($aListing['title'] . ($aListing['view_id'] == '2' ? ' (' . Phpfox::getPhrase('marketplace.sold') . ')' : ''), $this->url()->permalink('marketplace', $aListing['listing_id'], $aListing['title']), true)
			->setHeader('cache', array(
					'jquery/plugin/star/jquery.rating.js' => 'static_script',
					'jquery.rating.css' => 'style_css',	
					'jquery/plugin/jquery.highlightFade.js' => 'static_script',
					'jquery/plugin/jquery.scrollTo.js' => 'static_script',
					'quick_edit.js' => 'static_script',
					'comment.css' => 'style_css',
					'pager.css' => 'style_css',
					'switch_legend.js' => 'static_script',
					'switch_menu.js' => 'static_script',
					'view.js' => 'module_marketplace',
					'view.css' => 'module_marketplace',
					'pager.css' => 'style_css',
					'feed.js' => 'module_feed'
				)
			)			
			
			->setEditor(array(
					'load' => 'simple'
				)
			)
			->assign(array(
					'aListing' => $aListing,
					'sMicroPropType' => 'Product'
				)
			);
		if (Phpfox::isModule('rate'))
		{
			$this->template()
				->setPhrase(array(
					'rate.thanks_for_rating'
					)
				)
				->setHeader(array(
					'rate.js' => 'module_rate',
					'<script type="text/javascript">$Behavior.rateMarketplaceUser = function() { $Core.rate.init({display: false}); }</script>',		
				)		
			);
		}
		(($sPlugin = Phpfox_Plugin::get('marketplace.component_controller_view_process_end')) ? eval($sPlugin) : false);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('marketplace.component_controller_view_clean')) ? eval($sPlugin) : false);
	}
}

?>