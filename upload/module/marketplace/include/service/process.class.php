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
 * @package 		Phpfox_Service
 * @version 		$Id: process.class.php 6277 2013-07-16 12:59:34Z Raymond_Benc $
 */
class Marketplace_Service_Process extends Phpfox_Service 
{
	private $_bHasImage = false;
	
	private $_aCategories = array();
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('marketplace');
	}
	
	public function add($aVals)
	{
		// Plugin call
		if ($sPlugin = Phpfox_Plugin::get('marketplace.service_process_add__start'))
		{
			eval($sPlugin);
		}
		
		if (!$this->_verify($aVals))
		{
			return false;
		}
		
		if (!isset($aVals['privacy']))
		{
			$aVals['privacy'] = 0;
		}
		Phpfox::getService('ban')->checkAutomaticBan($aVals);
		
		$oParseInput = Phpfox::getLib('parse.input');
		
		$aSql = array(
			'view_id' => (Phpfox::getUserParam('marketplace.listing_approve') ? '1' : '0'),
			'privacy' => (isset($aVals['privacy']) ? $aVals['privacy'] : '0'),
			'privacy_comment' => (isset($aVals['privacy_comment']) ? $aVals['privacy_comment'] : '0'),			
			'group_id' => 0,
			'user_id' => Phpfox::getUserId(),
			'title' => $oParseInput->clean($aVals['title'], 255),
			'currency_id' => $aVals['currency_id'],
			'price' => $this->_price($aVals['price']),
			'country_iso' => $aVals['country_iso'],
			'country_child_id' => (isset($aVals['country_child_id']) ? (int) $aVals['country_child_id'] : 0),
			'postal_code' => (empty($aVals['postal_code']) ? null : Phpfox::getLib('parse.input')->clean($aVals['postal_code'], 20)),
			'city' => (empty($aVals['city']) ? null : $oParseInput->clean($aVals['city'], 255)),
			'time_stamp' => PHPFOX_TIME,
			'is_sell' => (isset($aVals['is_sell']) ? (int) $aVals['is_sell'] : 0),
			'auto_sell' => (isset($aVals['auto_sell']) ? (int) $aVals['auto_sell'] : 0),
			'mini_description' => (empty($aVals['mini_description']) ? null : $oParseInput->clean($aVals['mini_description'], 255))
		);
		
		$iId = $this->database()->insert($this->_sTable, $aSql);
		
		if (Phpfox::isModule('input'))
		{
			// This is how we add the values to the Inputs
			Phpfox::getService('input.process')->addValue(array(
				'module' => 'marketplace',
				'action' => 'add-listing',
				'item_id' => $iId,
				'aVals' => $aVals
			));
		}		
		
		(($sPlugin = Phpfox_Plugin::get('marketplace.service_process_add')) ? eval($sPlugin) : false);
		
		if (!$iId)
		{
			return false;
		}
		
		$this->database()->insert(Phpfox::getT('marketplace_text'), array(
				'listing_id' => $iId,
				'description' => (empty($aVals['description']) ? null : $oParseInput->clean($aVals['description'])),
				'description_parsed' => (empty($aVals['description']) ? null : $oParseInput->prepare($aVals['description']))
			)
		);		
		
		foreach ($this->_aCategories as $iCategoryId)
		{
			$this->database()->insert(Phpfox::getT('marketplace_category_data'), array('listing_id' => $iId, 'category_id' => $iCategoryId));
		}
		
		if (!Phpfox::getUserParam('marketplace.listing_approve'))
		{
			(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->add('marketplace', $iId, $aVals['privacy'], (isset($aVals['privacy_comment']) ? (int) $aVals['privacy_comment'] : 0)) : null);
			
			Phpfox::getService('user.activity')->update(Phpfox::getUserId(), 'marketplace');
		}
		
		if ($aVals['privacy'] == '4')
		{
			Phpfox::getService('privacy.process')->add('marketplace', $iId, (isset($aVals['privacy_list']) ? $aVals['privacy_list'] : array()));			
		}

		if (Phpfox::isModule('tag') && Phpfox::getParam('tag.enable_hashtag_support'))
		{
			Phpfox::getService('tag.process')->add('marketplace', $iId, Phpfox::getUserId(), $aVals['description'], true);
		}

		//Plugin call
		if ($sPlugin = Phpfox_Plugin::get('marketplace.service_process_add__end'))
		{
			eval($sPlugin);
		}
		
		return $iId;
	}
	
	public function update($iId, $aVals)
	{
		if (!$this->_verify($aVals))
		{
			return false;
		}		
		
		$oParseInput = Phpfox::getLib('parse.input');
		Phpfox::getService('ban')->checkAutomaticBan($aVals['title'] . ' ' . $aVals['description']);
		
		if (empty($aVals['privacy']))
		{
			$aVals['privacy'] = 0;
		}
		if (empty($aVals['privacy_comment']))
		{
			$aVals['privacy_comment'] = 0;
		}			
		
		$aSql = array(
			'privacy' => (isset($aVals['privacy']) ? $aVals['privacy'] : '0'),
			'privacy_comment' => (isset($aVals['privacy_comment']) ? $aVals['privacy_comment'] : '0'),		
			'title' => $oParseInput->clean($aVals['title'], 255),			
			'currency_id' => $aVals['currency_id'],
			'price' => $this->_price($aVals['price']),
			'country_iso' => $aVals['country_iso'],
			'country_child_id' => (isset($aVals['country_child_id']) ? (int) $aVals['country_child_id'] : 0),
			'postal_code' => (empty($aVals['postal_code']) ? null : Phpfox::getLib('parse.input')->clean($aVals['postal_code'], 20)),
			'city' => (empty($aVals['city']) ? null : $oParseInput->clean($aVals['city'], 255)),
			'is_sell' => (isset($aVals['is_sell']) ? (int) $aVals['is_sell'] : 0),
			'auto_sell' => (isset($aVals['auto_sell']) ? (int) $aVals['auto_sell'] : 0),
			'mini_description' => (empty($aVals['mini_description']) ? null : $oParseInput->clean($aVals['mini_description'], 255))
		);
		
		if (isset($aVals['view_id']) && ($aVals['view_id'] == '0' || $aVals['view_id'] == '2'))
		{
			$aSql['view_id'] = $aVals['view_id'];	
		}		
		
		$this->database()->update($this->_sTable, $aSql, 'listing_id = ' . (int) $iId);

		if (Phpfox::isModule('input'))
		{
			$bAdded = Phpfox::getService('input.process')->addValue(array(
				'item_id' => $iId, // marketplace_id
				'module' => 'marketplace', 
				'action' => 'add-listing', 
				'aVals' => $aVals
			));
			
		}
		
		$this->database()->update(Phpfox::getT('marketplace_text'), array(				
				'description' => (empty($aVals['description']) ? null : $oParseInput->clean($aVals['description'])),
				'description_parsed' => (empty($aVals['description']) ? null : $oParseInput->prepare($aVals['description']))
			), 'listing_id = ' . (int) $iId
		);		
		
		(($sPlugin = Phpfox_Plugin::get('marketplace.service_process_update')) ? eval($sPlugin) : false);
		
		$this->database()->delete(Phpfox::getT('marketplace_category_data'), 'listing_id = ' . (int) $iId);
		foreach ($this->_aCategories as $iCategoryId)
		{
			$this->database()->insert(Phpfox::getT('marketplace_category_data'), array('listing_id' => $iId, 'category_id' => $iCategoryId));
		}
		
		$aListing = $this->database()->select('*')
			->from($this->_sTable)
			->where('listing_id = ' . (int) $iId)
			->execute('getSlaveRow');		
		
		if ($this->_bHasImage)
		{			
			$oImage = Phpfox::getLib('image');
			$oFile = Phpfox::getLib('file');
			
			$aSizes = array(50, 120, 200, 400);
			
			$iFileSizes = 0;
			foreach ($_FILES['image']['error'] as $iKey => $sError)
			{
				if ($sError == UPLOAD_ERR_OK) 
				{			
					if ($aImage = $oFile->load('image[' . $iKey . ']', array(
								'jpg',
								'gif',
								'png'
							), (Phpfox::getUserParam('marketplace.max_upload_size_listing') === 0 ? null : (Phpfox::getUserParam('marketplace.max_upload_size_listing') / 1024))
						)
					)
					{					
						$sFileName = Phpfox::getLib('file')->upload('image[' . $iKey . ']', Phpfox::getParam('marketplace.dir_image'), $iId);
						
						$iFileSizes += filesize(Phpfox::getParam('marketplace.dir_image') . sprintf($sFileName, ''));
						
						$this->database()->insert(Phpfox::getT('marketplace_image'), array('listing_id' => $iId, 'image_path' => $sFileName, 'server_id' => Phpfox::getLib('request')->getServer('PHPFOX_SERVER_ID')));		
			
						foreach ($aSizes as $iSize)
						{						
							$oImage->createThumbnail(Phpfox::getParam('marketplace.dir_image') . sprintf($sFileName, ''), Phpfox::getParam('marketplace.dir_image') . sprintf($sFileName, '_' . $iSize), $iSize, $iSize);	
							$oImage->createThumbnail(Phpfox::getParam('marketplace.dir_image') . sprintf($sFileName, ''), Phpfox::getParam('marketplace.dir_image') . sprintf($sFileName, '_' . $iSize . '_square'), $iSize, $iSize, false);						
							
							$iFileSizes += filesize(Phpfox::getParam('marketplace.dir_image') . sprintf($sFileName, '_' . $iSize));			
						}					
					}
				}
			}
			
			if ($iFileSizes === 0)
			{
				return false;
			}
			
			$this->database()->update($this->_sTable, array('image_path' => $sFileName, 'server_id' => Phpfox::getLib('request')->getServer('PHPFOX_SERVER_ID')), 'listing_id = ' . $iId);
			
			(($sPlugin = Phpfox_Plugin::get('marketplace.service_process_update__1')) ? eval($sPlugin) : false);
			
			// Update user space usage
			Phpfox::getService('user.space')->update(Phpfox::getUserId(), 'marketplace', $iFileSizes);			
		}
		
		if (isset($aVals['emails']) || isset($aVals['invite']))
		{
			$aInvites = $this->database()->select('invited_user_id, invited_email')
				->from(Phpfox::getT('marketplace_invite'))
				->where('listing_id = ' . (int) $iId)
				->execute('getRows');
			$aInvited = array();
			foreach ($aInvites as $aInvite)
			{
				$aInvited[(empty($aInvite['invited_email']) ? 'user' : 'email')][(empty($aInvite['invited_email']) ? $aInvite['invited_user_id'] : $aInvite['invited_email'])] = true;
			}			
		}

		
		if (isset($aVals['emails']))
		{

			// if (strpos($aVals['emails'], ','))
			{
				$aEmails = explode(',', $aVals['emails']);
				$aCachedEmails = array();
				
				foreach ($aEmails as $sEmail)
				{
					$sEmail = trim($sEmail);
					if (!Phpfox::getLib('mail')->checkEmail($sEmail))
					{
						continue;
					}
					
					if (isset($aInvited['email'][$sEmail]))
					{
						continue;
					}
					
					$sLink = Phpfox::getLib('url')->permalink('marketplace', $aListing['listing_id'], $aListing['title']);
					$sMessage = Phpfox::getPhrase('marketplace.full_name_invited_you_to_view_the_marketplace_listing_title', array(
							'full_name' => Phpfox::getUserBy('full_name'),
							'title' => $oParseInput->clean($aVals['title'], 255),
							'link' => $sLink
						)
					);
					if (!empty($aVals['personal_message']))
					{
						$sMessage .= "\n\n" . Phpfox::getPhrase('marketplace.full_name_added_the_following_personal_message', array('full_name' => Phpfox::getUserBy('full_name'))) . ":\n";
						$sMessage .= $aVals['personal_message'];
					}

					$oMail = Phpfox::getLib('mail');
					if (isset($aVals['invite_from']) && $aVals['invite_from'] == 1)
					{
						$oMail->fromEmail(Phpfox::getUserBy('email'))
								->fromName(Phpfox::getUserBy('full_name'));
					}
					$bSent = $oMail->to($sEmail)
						->subject(array('marketplace.full_name_invited_you_to_view_the_listing_title', array('full_name' => Phpfox::getUserBy('full_name'), 'title' => $oParseInput->clean($aVals['title'], 255))))
						->message($sMessage)
						->send();
						
					if ($bSent)
					{
						$this->_aInvited[] = array('email' => $sEmail);
						
						$aCachedEmails[$sEmail] = true;
						
						$this->database()->insert(Phpfox::getT('marketplace_invite'), array(
								'listing_id' => $iId,
								'type_id' => 1,
								'user_id' => Phpfox::getUserId(),
								'invited_email' => $sEmail,
								'time_stamp' => PHPFOX_TIME
							)
						);
					}
				}
			}
		}
		if (isset($aVals['invite']) && is_array($aVals['invite']))
		{
			$sUserIds = '';
			foreach ($aVals['invite'] as $iUserId)
			{
				if (!is_numeric($iUserId))
				{
					continue;
				}
				$sUserIds .= $iUserId . ',';
			}
			$sUserIds = rtrim($sUserIds, ',');
			
			$aUsers = $this->database()->select('user_id, email, language_id, full_name')
				->from(Phpfox::getT('user'))
				->where('user_id IN(' . $sUserIds . ')')
				->execute('getSlaveRows');
				
			foreach ($aUsers as $aUser)
			{
				if (isset($aCachedEmails[$aUser['email']]))
				{
					continue;
				}	
				
				if (isset($aInvited['user'][$aUser['user_id']]))
				{
					continue;
				}
				
				$sLink = Phpfox::getLib('url')->permalink('marketplace', $aListing['listing_id'], $aListing['title']);
				$sMessage = Phpfox::getPhrase('marketplace.full_name_invited_you_to_view_the_marketplace_listing_title', array(
						'full_name' => Phpfox::getUserBy('full_name'),
						'title' => $oParseInput->clean($aVals['title'], 255),
						'link' => $sLink
					), false, null, $aUser['language_id']
				);
				if (!empty($aVals['personal_message']))
				{
					$sMessage .= "\n\n" . Phpfox::getPhrase('marketplace.full_name_added_the_following_personal_message', array('full_name' => Phpfox::getUserBy('full_name')), false, null, $aUser['language_id']);
					$sMessage .= $aVals['personal_message'];
				}
				
				$bSent = Phpfox::getLib('mail')->to($aUser['user_id'])						
					->subject(array('marketplace.full_name_invited_you_to_view_the_listing_title', array('full_name' => Phpfox::getUserBy('full_name'), 'title' => $oParseInput->clean($aVals['title'], 255))))
					->message($sMessage)
					->notification('marketplace.new_invite')
					->send();
						
				if ($bSent)
				{
					$this->_aInvited[] = array('user' => $aUser['full_name']);	
					
					$this->database()->insert(Phpfox::getT('marketplace_invite'), array(
							'listing_id' => $iId,								
							'user_id' => Phpfox::getUserId(),
							'invited_user_id' => $aUser['user_id'],
							'time_stamp' => PHPFOX_TIME
						)
					);
					
					(Phpfox::isModule('request') ? Phpfox::getService('request.process')->add('marketplace_invite', $iId, $aUser['user_id']) : null);
				}
			}
		}		
		
		(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->update('marketplace', $iId, $aVals['privacy'], $aVals['privacy_comment'], 0, $aListing['user_id']) : null);
		
		if (Phpfox::isModule('privacy'))
		{
			if ($aVals['privacy'] == '4')
			{
				Phpfox::getService('privacy.process')->update('marketplace', $iId, (isset($aVals['privacy_list']) ? $aVals['privacy_list'] : array()));
			}
			else 
			{
				Phpfox::getService('privacy.process')->delete('marketplace', $iId);
			}		
		}

		if (Phpfox::isModule('tag') && Phpfox::getParam('tag.enable_hashtag_support'))
		{
			Phpfox::getService('tag.process')->update('marketplace', $iId, Phpfox::getUserId(), $aVals['description'], true);
		}
		
		return true;
	}	
	
	public function delete($iId, &$aListing = null)
	{
		if ($aListing === null)
		{
			$aListing = $this->database()->select('user_id, image_path')
				->from($this->_sTable)
				->where('listing_id = ' . (int) $iId)
				->execute('getRow');
				
			if (!isset($aListing['user_id']))
			{
				return Phpfox_Error::set(Phpfox::getPhrase('marketplace.unable_to_find_the_listing_you_want_to_delete'));
			}
			
			if (!Phpfox::getService('user.auth')->hasAccess('listing', 'listing_id', $iId, 'marketplace.can_delete_own_listing', 'marketplace.can_delete_other_listings', $aListing['user_id']))
			{
				return Phpfox_Error::set(Phpfox::getPhrase('marketplace.you_do_not_have_sufficient_permission_to_delete_this_listing'));
			}
		}
		
		$iFileSizes = 0;
		$aImages = $this->database()->select('image_id, image_path, server_id')
			->from(Phpfox::getT('marketplace_image'))
			->where('listing_id = ' . $iId)
			->execute('getRows');
		foreach ($aImages as $aImage)
		{			
			$aSizes = array('', 50, 120, 200, 400);
			foreach ($aSizes as $iSize)
			{
				$sImage = Phpfox::getParam('marketplace.dir_image') . sprintf($aListing['image_path'], (empty($iSize) ? '' : '_' ) . $iSize);
				if (file_exists($sImage))
				{
					$iFileSizes += filesize($sImage);
					
					Phpfox::getLib('file')->unlink($sImage);
				}
				
				if(Phpfox::getParam('core.allow_cdn') && $aImage['server_id'] > 0)
				{
					// Get the file size stored when the photo was uploaded
					$sTempUrl = Phpfox::getLib('cdn')->getUrl(str_replace(Phpfox::getParam('marketplace.dir_image'), Phpfox::getParam('marketplace.url_image'), $sImage));
					
					$aHeaders = get_headers($sTempUrl, true);
					if(preg_match('/200 OK/i', $aHeaders[0]))
					{
						$iFileSizes += (int) $aHeaders["Content-Length"];
					}
					
					Phpfox::getLib('cdn')->remove($sImage);
				}
			}
			
			$this->database()->delete(Phpfox::getT('marketplace_image'), 'image_id = ' . $aImage['image_id']);
		}
		
		if ($iFileSizes > 0)
		{
			Phpfox::getService('user.space')->update($aListing['user_id'], 'marketplace', $iFileSizes, '-');
		}			
		
		(Phpfox::isModule('comment') ? Phpfox::getService('comment.process')->deleteForItem(null, $iId, 'marketplace') : null);		
		(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->delete('marketplace', $iId) : null);
		(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->delete('comment_marketplace', $iId) : null);
		
		$this->database()->delete($this->_sTable, 'listing_id = ' . (int) $iId);
		$this->database()->delete(Phpfox::getT('marketplace_text'), 'listing_id = ' . (int) $iId);
		$this->database()->delete(Phpfox::getT('marketplace_category_data'), 'listing_id = ' . (int) $iId);
		
		Phpfox::getService('user.activity')->update($aListing['user_id'], 'marketplace', '-');
		
		$this->cache()->remove('marketplace_sponsored');
		Phpfox::massCallback('deleteItem', array(
			'sModule' => 'marketplace',
			'sTable' => Phpfox::getT('marketplace'),
			'iItemId' => $iId
		));

		$this->cache()->remove('marketplace_featured');
		$this->cache()->remove('marketplace_sponsored');
		
		(($sPlugin = Phpfox_Plugin::get('marketplace.service_process_delete__1')) ? eval($sPlugin) : false);
		return true;
	}
	
	public function setDefault($iImageId)
	{
		$aListing = $this->database()->select('mi.image_path, mi.server_id, m.user_id, m.listing_id')
			->from(Phpfox::getT('marketplace_image'), 'mi')
			->join($this->_sTable, 'm', 'm.listing_id = mi.listing_id')
			->where('mi.image_id = ' . (int) $iImageId)
			->execute('getSlaveRow');
			
		if (!isset($aListing['user_id']))
		{
			return Phpfox_Error::set('Unable to find the image.');
		}	

		if (!Phpfox::getService('user.auth')->hasAccess('listing', 'listing_id', $aListing['listing_id'], 'marketplace.can_delete_own_listing', 'marketplace.can_delete_other_listings', $aListing['user_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('marketplace.you_do_not_have_sufficient_permission_to_modify_this_listing'));
		}
		
		$this->database()->update($this->_sTable, array('image_path' => $aListing['image_path'], 'server_id' => $aListing['server_id']), 'listing_id = ' . $aListing['listing_id']);
		
		(($sPlugin = Phpfox_Plugin::get('marketplace.service_process_setdefault__1')) ? eval($sPlugin) : false);
		
		return true;
	}
	
	public function deleteImage($iImageId)
	{
		$aListing = $this->database()->select('mi.image_id, mi.image_path, mi.server_id, m.user_id, m.listing_id, m.image_path AS default_image_path')
			->from(Phpfox::getT('marketplace_image'), 'mi')
			->join($this->_sTable, 'm', 'm.listing_id = mi.listing_id')
			->where('mi.image_id = ' . (int) $iImageId)
			->execute('getSlaveRow');
			
		if (!isset($aListing['user_id']))
		{
			return Phpfox_Error::set('Unable to find the image.');
		}	

		if (!Phpfox::getService('user.auth')->hasAccess('listing', 'listing_id', $aListing['listing_id'], 'marketplace.can_delete_own_listing', 'marketplace.can_delete_other_listings', $aListing['user_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('marketplace.you_do_not_have_sufficient_permission_to_modify_this_listing'));
		}			
		
		if ($aListing['default_image_path'] == $aListing['image_path'])
		{
			$aImage = $this->database()->select('image_path, server_id')
				->from(Phpfox::getT('marketplace_image'))
				->where('listing_id = ' . $aListing['listing_id'])
				->execute('getSlaveRow');
			
			$this->database()->update($this->_sTable, array('image_path' => (isset($aImage['image_path']) ? $aImage['image_path'] : null), 'server_id' => (isset($aImage['server_id']) ? $aImage['server_id'] : null)), 'listing_id = ' . $aListing['listing_id']);			
		}
		
		$iFileSizes = 0;
		$aSizes = array('', 50, 120, 200, 400);
		foreach ($aSizes as $iSize)
		{
			$sImage = Phpfox::getParam('marketplace.dir_image') . sprintf($aListing['image_path'], (empty($iSize) ? '' : '_' ) . $iSize);
			$sImageSquare = Phpfox::getParam('marketplace.dir_image') . sprintf($aListing['image_path'], (empty($iSize) ? '' : '_' ) . $iSize . '_square');
			if (file_exists($sImage))
			{
				$iFileSizes += filesize($sImage);
				
				Phpfox::getLib('file')->unlink($sImage);
				
			}
			if (file_exists($sImageSquare))
			{
				Phpfox::getLib('file')->unlink($sImageSquare);
			}
			
			if(Phpfox::getParam('core.allow_cdn') && $aListing['server_id'] > 0)
			{				
				$aFilesToDelete = array($sImage, $sImageSquare);
				foreach($aFilesToDelete as $sFilePath)
				{
					// Get the file size stored when the photo was uploaded
					$sTempUrl = Phpfox::getLib('cdn')->getUrl(str_replace(Phpfox::getParam('marketplace.dir_image'), Phpfox::getParam('marketplace.url_image'), $sFilePath));
					
					$aHeaders = get_headers($sTempUrl, true);
					if(preg_match('/200 OK/i', $aHeaders[0]))
					{
						$iFileSizes += (int) $aHeaders["Content-Length"];
					}
					
					Phpfox::getLib('cdn')->remove($sFilePath);
				}
			}
		}
		
		if ($iFileSizes > 0)
		{
			Phpfox::getService('user.space')->update($aListing['user_id'], 'marketplace', $iFileSizes, '-');
		}		
		
		$this->database()->delete(Phpfox::getT('marketplace_image'), 'image_id = ' . $aListing['image_id']);
		
		(($sPlugin = Phpfox_Plugin::get('marketplace.service_process_deleteimage__1')) ? eval($sPlugin) : false);
		
		return true;
	}

	public function setVisit($iId, $iUserId)
	{
		$this->database()->update(Phpfox::getT('marketplace_invite'), array('visited_id' => 1), 'listing_id = ' . (int) $iId . ' AND invited_user_id = ' . (int) $iUserId);
		
		(Phpfox::isModule('request') ? Phpfox::getService('request.process')->delete('marketplace_invite', $iId, $iUserId) : null);
	}
	
	public function feature($iId, $iType)
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('marketplace.can_feature_listings', true);
		
		$this->database()->update($this->_sTable, array('is_featured' => ($iType ? '1' : '0')), 'listing_id = ' . (int) $iId);
		
		$this->cache()->remove('marketplace_featured');
		
		return true;
	}	

	public function sponsor($iId, $iType)
	{
	    if (!Phpfox::getUserParam('marketplace.can_sponsor_marketplace') && !Phpfox::getUserParam('marketplace.can_purchase_sponsor') && !defined('PHPFOX_API_CALLBACK'))
	    {
			return Phpfox_Error::set('Hack attempt?');
	    }
	    $iType = (int)$iType;
	    $iId = (int)$iId;
	    if ($iType != 0 && $iType != 1)
	    {
			return false;
	    }
	    $this->database()->update($this->_sTable, array('is_featured' => 0, 'is_sponsor' => $iType),
		    'listing_id = ' . $iId
	    );

	    if ($sPlugin = Phpfox_Plugin::get('marketplace.service_sponsor__end')){eval($sPlugin);}
	    $this->cache()->remove('marketplace_sponsored');
	    return true;
	}

	public function approve($iId)
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('marketplace.can_approve_listings', true);
		
		$aListing = $this->database()->select('v.*, ' . Phpfox::getUserField())
			->from($this->_sTable, 'v')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = v.user_id')
			->where('v.listing_id = ' . (int) $iId)
			->execute('getRow');
			
		if (!isset($aListing['listing_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('marketplace.unable_to_find_the_listing_you_want_to_approve'));
		}
		
		$this->database()->update($this->_sTable, array('view_id' => '0', 'time_stamp' => PHPFOX_TIME), 'listing_id = ' . $aListing['listing_id']);
		
		if (Phpfox::isModule('notification'))
		{
			Phpfox::getService('notification.process')->add('marketplace_approved', $aListing['listing_id'], $aListing['user_id']);
		}
		
		// Send the user an email
		$sLink = Phpfox::getLib('url')->permalink('marketplace' , $aListing['listing_id'], $aListing['title']);
		
		$bAddFeed = true;
		
		(($sPlugin = Phpfox_Plugin::get('marketplace.service_process_approve__1')) ? eval($sPlugin) : false);
		
		Phpfox::getLib('mail')->to($aListing['user_id'])
			->subject(array('marketplace.your_listing_has_been_approved_on_site_title', array('site_title' => Phpfox::getParam('core.site_title'))))
			->message(array('marketplace.your_listing_has_been_approved_on_site_title_message', array('site_title' => Phpfox::getParam('core.site_title'), 'link' => $sLink)))
			->notification('marketplace.listing_is_approved')
			->send();		
			
		(Phpfox::isModule('feed') && $bAddFeed ? Phpfox::getService('feed.process')->add('marketplace', $iId, $aListing['privacy'], (isset($aListing['privacy_comment']) ? (int) $aListing['privacy_comment'] : 0), 0, $aListing['user_id']) : null);				

		return true;	
	}
	
	public function addInvoice($iId, $sCurrency, $sCost)
	{
		$iInvoiceId = $this->database()->insert(Phpfox::getT('marketplace_invoice'), array(
				'listing_id' => $iId,
				'user_id' => Phpfox::getUserId(),
				'currency_id' => $sCurrency,
				'price' => $sCost,
				'time_stamp' => PHPFOX_TIME
			)
		);

		return $iInvoiceId;	
	}
		
		
	public function sendExpireNotifications()
	{
		if (Phpfox::getParam('marketplace.days_to_expire_listing') < 1 || Phpfox::getParam('marketplace.days_to_notify_expire') < 1)
		{
			return true;
		}
		
		// Lets use caching to make sure we dont check too often
		$sCacheId = $this->cache()->set('marketplace_notify_expired');
		if (!($bCheck = $this->cache()->get($sCacheId, 86400)))
		{
			$iDaysToExpireSinceAdded = (Phpfox::getParam('marketplace.days_to_expire_listing') * 86400);
			$iExpireDaysInSeconds = (Phpfox::getParam('marketplace.days_to_notify_expire') * 86400);
			$iAddedAt = 'm.time_stamp';
			/* We should notify them when it is 
			 * 
			 * I added the listing today at 13:00 and I set it to expire in 2 days and to notify in 1 day.
			 * Right now it is 13:05, it should not send a notification
			 * Right now it is 1 day and 2 minutes, it has not sent a notification, it should send a notification
			 * */
			// Get the listings to notify
			$aNotify = $this->database()->select('m.listing_id, m.title, u.full_name, u.email, m.user_id')
				->from(Phpfox::getT('marketplace'), 'm')
				->join(Phpfox::getT('user'), 'u', 'u.user_id = m.user_id')
				->where('(m.is_notified = 0) AND ((m.time_stamp + ' . $iExpireDaysInSeconds .') < ' . PHPFOX_TIME .') AND ((m.time_stamp + ' . $iDaysToExpireSinceAdded. ') <= ' . PHPFOX_TIME . ')')
				->execute('getSlaveRows');
			
			if (!empty($aNotify))
			{
				$aUpdate = array();
				foreach ($aNotify as $aRow)
				{
					Phpfox::getLib('mail')
						->to($aRow['user_id'])
						->sendToSelf(true)
						->subject(array('marketplace.listing_expiring_subject', array(
							'title' => $aRow['title'],
							'site_title' => Phpfox::getParam('core.site_title'),
							'days' => (Phpfox::getParam('marketplace.days_to_expire_listing') - Phpfox::getParam('marketplace.days_to_notify_expire'))
							)))
						->message(array('marketplace.listing_expiring_message', array(
							'site_name' => Phpfox::getParam('core.site_title'),
							'title' => $aRow['title'],
							'site_title' => Phpfox::getParam('core.site_title'),
							'link' => Phpfox::getLib('url')->permalink('marketplace', $aRow['listing_id'], $aRow['title']),
							'days' => (Phpfox::getParam('marketplace.days_to_expire_listing') - Phpfox::getParam('marketplace.days_to_notify_expire'))
							)))
						->send();	
						
					$aUpdate[] = $aRow['listing_id'];
				}
				
				$this->database()->update(Phpfox::getT('marketplace'), array('is_notified' => 1), 'listing_id IN ('. implode(',', $aUpdate).')');	
			}					
		}
		
	}
	/**
	 * If a call is made to an unknown method attempt to connect
	 * it to a specific plug-in with the same name thus allowing 
	 * plug-in developers the ability to extend classes.
	 *
	 * @param string $sMethod is the name of the method
	 * @param array $aArguments is the array of arguments of being passed
	 */
	public function __call($sMethod, $aArguments)
	{
		/**
		 * Check if such a plug-in exists and if it does call it.
		 */
		if ($sPlugin = Phpfox_Plugin::get('marketplace.service_process__call'))
		{
			return eval($sPlugin);
		}
			
		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}
	
	private function _price($sPrice)
	{
		if (empty($sPrice))
		{
			return '0.00';
		}
		
		$sPrice = str_replace(array(' ', ','), '', $sPrice);
		$aParts = explode('.', $sPrice);		
		if (count($aParts) > 2)
		{
			$iCnt = 0;
			$sPrice = '';
			foreach ($aParts as $sPart)
			{
				$iCnt++;
				$sPrice .= (count($aParts) == $iCnt ? '.' : '') . $sPart;
			}
		}		
		
		return $sPrice;
	}

	private function _verify(&$aVals)
	{
		if (!isset($aVals['category']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('marketplace.provide_a_category_this_listing_will_belong_to'));
		}
		
		foreach ($aVals['category'] as $iCategory)
		{		
			$iCategory = trim($iCategory);
			
			if (empty($iCategory))
			{
				continue;
			}
			
			if (!is_numeric($iCategory))
			{
				continue;
			}			
			
			$this->_aCategories[] = $iCategory;
		}
		
		if (!count($this->_aCategories))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('marketplace.provide_a_category_this_listing_will_belong_to'));
		}	
				
		if (isset($_FILES['image']))
		{
			foreach ($_FILES['image']['error'] as $iKey => $sError)
			{
				if ($sError == UPLOAD_ERR_OK) 
				{			
					$aImage = Phpfox::getLib('file')->load('image[' . $iKey . ']', array(
							'jpg',
							'gif',
							'png'
						)
					);
					
					if ($aImage === false)
					{
						continue;
					}
					
					$this->_bHasImage = true;
				}
			}
		}	

		return true;	
	}
}

?>
