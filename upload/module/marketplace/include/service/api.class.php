<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox_Service
 * @version 		$Id: api.class.php 5112 2013-01-11 06:56:25Z Raymond_Benc $
 */
class Marketplace_Service_Api extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('marketplace');
		$this->_oApi = Phpfox::getService('api');	
	}
	
	public function categories()
	{
		/*
		@title
		@info Get all categories.
		@method GET
		@extra
		@return category_id=#{Category ID#|int}&name=#{Name of the 
		*/

		$aCategories = Phpfox::getService('marketplace.category')->getForBrowse();

		return $aCategories;
	}
	
	public function add()
	{
		/*
		@title
		@info 
		@method POST
		@extra title=#{Title of the listing|string|yes}&currency_id=#{Currency ID. Use [action]core.getCurrencies[/action] to get a list of valid currencies|string|yes}&price=#{Price|decimal|no}&country_iso=#{Country ISO ID. Use [action]core.getCurrencies[/action]|string|no}&country_child_id=#{State/Province ID#. Use [action]core.getCurrencies[/action]|int|no}&postal_code=#{Postal code|string|no}&city=#{City|string|no}&mini_description=#{Mini description|string|yes}&description=#{Description|string|yes}&category=#{Comma separated category ID#'s. Use [action]marketplace.categories[/action]|string|yes}&images=#{Comma separated URL to images|string|no}  
		@return id=#{Item ID#|int}&title=#{Title of the item|string}&description=#{Description of the item|string}&likes=#{Total number of likes|int}&permalink=#{Link to the item|string}&mini_description=#{Mini description of the listing|string}&currency_id=#{Currency ID|string}&price=#{Price|decimal}&country_iso=#{Country ISO|string}&postal_code=#{Postal code|string}&city=#{City|string}&images=#{Array of images|array}
		*/	
		
		$aCategories = array();	
		if ($this->_oApi->get('category'))
		{
			$aCategories = explode(',', $this->_oApi->get('category'));
		}
		
		$aVals = array(
				'title' => $this->_oApi->get('title'),
				'currency_id' => $this->_oApi->get('currency_id'),
				'price' => $this->_oApi->get('price'),
				'country_iso' => $this->_oApi->get('country_iso'),
				'country_child_id' => $this->_oApi->get('country_child_id'),
				'postal_code' => $this->_oApi->get('postal_code'),
				'city' => $this->_oApi->get('city'),
				'mini_description' => $this->_oApi->get('mini_description'),
				'description' => $this->_oApi->get('description'),
				'category' => (array) $aCategories
				);
		
		if (($iId = Phpfox::getService('marketplace.process')->add($aVals)) !== false)
		{
			if ($this->_oApi->get('images') != '')
			{
				$oImage = Phpfox::getLib('image');
				$oFile = Phpfox::getLib('file');
					
				$aSizes = array(50, 120, 200, 400);
					
				$iFileSizes = 0;
				foreach (explode(',', $this->_oApi->get('images')) as $sImage)
				{		
					$sType = $oFile->getFileExt($sImage);
					$sImageContent = file_get_contents($sImage);
						
					$sImagePath = Phpfox::getParam('marketplace.dir_image') . $iId . '.' . $sType;
							
					$hFile = fopen($sImagePath, 'w');
					fwrite($hFile, $sImageContent);
					fclose($hFile);
						
					$_FILES['photo']['error'] = '';
					$_FILES['photo']['tmp_name'] = $sImagePath;
					$_FILES['photo']['name'] = basename($sImagePath);					
					
						if ($aImage = $oFile->load('photo', array(
								'jpg',
								'gif',
								'png'
						), (Phpfox::getUserParam('marketplace.max_upload_size_listing') === 0 ? null : (Phpfox::getUserParam('marketplace.max_upload_size_listing') / 1024))
						)
						)
						{
							$sFileName = Phpfox::getLib('file')->upload('photo', Phpfox::getParam('marketplace.dir_image'), $iId);
			
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
					
				if ($iFileSizes === 0)
				{
					return false;
				}
					
				$this->database()->update($this->_sTable, array('image_path' => $sFileName, 'server_id' => Phpfox::getLib('request')->getServer('PHPFOX_SERVER_ID')), 'listing_id = ' . $iId);
					
				Phpfox::getService('user.space')->update(Phpfox::getUserId(), 'marketplace', $iFileSizes);
			}			
			
			$aReturn = $this->get($iId);
			
			return $aReturn[0];
		}	
	}
	
	public function get($iLinkId = 0)
	{
		/*
		@title
		@info Get all public videos. If you pass a user ID# it will return just the users listings. If you pass a listing ID# it will just return that listing.
		@method GET
		@extra user_id=#{Pass a user_id if you want to return listings from a specific user.|int|no}&id=#{Pass a listing ID to get a specific video.|int|no}
		@return id=#{Item ID#|int}&title=#{Title of the item|string}&description=#{Description of the item|string}&likes=#{Total number of likes|int}&permalink=#{Link to the item|string}&mini_description=#{Mini description of the listing|string}&currency_id=#{Currency ID|string}&price=#{Price|decimal}&country_iso=#{Country ISO|string}&postal_code=#{Postal code|string}&city=#{City|string}&images=#{Array of images|array}
		*/
		if ((int) $this->_oApi->get('user_id') !== 0)
		{
			$iUserId = $this->_oApi->get('user_id');
		}
		
		if ((int) $this->_oApi->get('id') !== 0)
		{
			$iLinkId = $this->_oApi->get('id');
		}
		
		$iCnt = $this->database()->select('COUNT(*)')
			->from($this->_sTable, 'p')
			->where(($iLinkId > 0 ? 'p.listing_id = ' . (int) $iLinkId : (isset($iUserId) ? 'p.user_id = ' . (int) $iUserId . ' AND ' : '') . ' p.privacy = 0'))
			->execute('getSlaveField');
		
		$this->_oApi->setTotal($iCnt);
		
		$aRows = $this->database()->select('p.*, vt.description_parsed, ' . Phpfox::getUserField())
			->from($this->_sTable, 'p')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = p.user_id')
			->join(Phpfox::getT('marketplace_text'), 'vt', 'vt.listing_id = p.listing_id')
			->where(($iLinkId > 0 ? 'p.listing_id = ' . (int) $iLinkId : (isset($iUserId) ? 'p.user_id = ' . (int) $iUserId . ' AND ' : '') . ' p.privacy = 0'))
			->limit($this->_oApi->get('page'), 10, $iCnt)
			->order('p.time_stamp DESC')
			->execute('getSlaveRows');		
		
		$aSizes = array(50, 120, 200, 400);
		$aReturns = array();
		foreach ($aRows as $aRow)
		{
			$aImages = array();
			$aImageRows = $this->database()->select('*')
				->from(Phpfox::getT('marketplace_image'))
				->where('listing_id = ' . (int) $aRow['listing_id'])				
				->execute('getSlaveRows');
			foreach ($aImageRows as $aImageRow)
			{
				foreach ($aSizes as $iSize)
				{
					$aImages[$iSize . 'px'] = Phpfox::getParam('marketplace.url_image') . sprintf($aImageRow['image_path'], '_' . $iSize);
					$aImages[$iSize . 'px_square'] = Phpfox::getParam('marketplace.url_image') . sprintf($aImageRow['image_path'], '_' . $iSize . '_square');
				}	
			}
			
			$aReturns[] = array(
					'id' => $aRow['listing_id'],
					'title' => $aRow['title'],
					'mini_description' => Phpfox::getLib('parse.output')->parse($aRow['mini_description']),
					'description' => Phpfox::getLib('parse.output')->parse($aRow['description_parsed']),
					'likes' => $aRow['total_like'],
					'permalink' => Phpfox::getLib('url')->permalink('marketplace', $aRow['listing_id'], $aRow['title']),
					'currency_id' => $aRow['currency_id'],
					'price' => $aRow['price'],
					'country_iso' => $aRow['country_iso'],
					'postal_code' => $aRow['postal_code'],
					'city' => $aRow['city'],
					'images' => $aImages
					);
		}
		
		return $aReturns;		
	}
}

?>