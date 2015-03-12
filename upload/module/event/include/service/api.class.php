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
 * @version 		$Id: api.class.php 6187 2013-06-29 08:31:02Z Raymond_Benc $
 */
class Event_Service_Api extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */
	public function __construct()
	{
		$this->_sTable = Phpfox::getT('event');
		$this->_oApi = Phpfox::getService('api');
	}
	
	public function add()
	{		
		/*
		@title 
		@info Post an event.
		@method POST
		@extra title=#{Title of the event|string|yes}&venue=#{Venue of where the event will take place|string|yes}&description=#{Information about the event|string|yes}&country_iso=#{Country ISO ID. Use [action]core.getCountries[/action]|string|no}&country_child_id=#{State/Province ID#. Use [action]core.getCountries[/action] to get the correct ID#|int|no}&postal_code=#{Postal code|int|no}&city=#{City|string|no}&address=#{Address|string|no}&start_hour=#{24-hour format of an hour of when the event starts with leading zeros|int|yes}&start_minute=#{Minutes with leading zeros of when the event starts|int|yes}&start_day=#{Day of the month of when the event starts, 2 digits with leading zeros|int|yes}&start_month=#{A full numeric representation of a month of when the event starts, 2 digits|int|yes}&start_year=#{A full numeric representation of a year of when the event starts, 4 digits|int|yes}&end_hour=#{24-hour format of an hour of when the event ends with leading zeros|int|yes}&end_minute=#{Minutes with leading zeros of when the event ends|int|yes}&end_day=#{Day of the month of when the event ends, 2 digits with leading zeros|int|yes}&end_month=#{A full numeric representation of the month when the event ends, 2 digits|int|yes}&end_year=#{A full numeric representation of a year of when the event ends, 4 digits|int|yes}
		*/
	
		if ($this->_oApi->isAllowed('event.add_event') == false)
		{
			return $this->_oApi->error('event.add_event', 'Unable to add an event for this user.');
		}
	
		$aInsert = array(
				'title' => $this->_oApi->get('title'),
				'location' => $this->_oApi->get('venue'),
				'country_iso' => $this->_oApi->get('country_iso'),
				'country_child_id' => $this->_oApi->get('country_child_id'),
				'postal_code' => $this->_oApi->get('postal_code'),
				'city' => $this->_oApi->get('city'),
				'address' => $this->_oApi->get('address'),
				'description' => $this->_oApi->get('description'),
				
				'start_hour' => $this->_oApi->get('start_hour'),
				'start_minute' => $this->_oApi->get('start_minute'),
				'start_month' => $this->_oApi->get('start_month'),
				'start_day' => $this->_oApi->get('start_day'),
				'start_year' => $this->_oApi->get('start_year'),
				
				'end_hour' => $this->_oApi->get('end_hour'),
				'end_minute' => $this->_oApi->get('end_minute'),
				'end_month' => $this->_oApi->get('end_month'),
				'end_day' => $this->_oApi->get('end_day'),
				'end_year' => $this->_oApi->get('end_year')				
		);
	
		$iId = Phpfox::getService('event.process')->add($aInsert);
		if (!$iId)
		{
			return $this->_oApi->error('event.unable_to_add_blog', implode('', Phpfox_Error::get()));
		}
	
		$aRows = $this->get($iId);
	
		return $aRows[0];
	}	

	public function get($iId = 0)
	{
		/*
		@title
		@info Get a list of all public events. If you pass a user ID# it will return a list of the users events. If you pass a ID# it will return just that event.
		@method GET
		@extra user_id=#{User ID#|int|no}&id=#{Event ID#|int|no}
		@return event_id=#{Event ID#|int}&title=#{Title of the event|string}&likes=#{Total number of likes|int}&permalink=#{Link to the event|string}&info=#{Information about the event|string}&created_by=#{Person who created the event|string}&created_by_url=#{Link to creators profile|string}&photo_200px=#{Default photo for the event. Max 200px|string}
		*/
	
		$iUserId = $this->_oApi->get('user_id');
		if ((int) $this->_oApi->get('id') !== 0)
		{
			$iId = $this->_oApi->get('id');
		}
	
		$iTimeDisplay = Phpfox::getLib('date')->mktime(0, 0, 0, Phpfox::getTime('m'), Phpfox::getTime('d'), Phpfox::getTime('Y'));
		
		$iCnt = $this->database()->select('COUNT(*)')
			->from($this->_sTable, 'b')
			->where((empty($iId) ? 'b.view_id = 0 AND b.privacy = 0 AND b.item_id = 0 AND ' . (empty($iUserId) ? '' : 'b.user_id = ' . (int) $iUserId . ' AND ') . ' b.start_time >= \'' . Phpfox::getLib('date')->convertToGmt($iTimeDisplay) . '\'' : 'b.event_id = ' . (int) $iId))
			->execute('getSlaveField');
	
		$this->_oApi->setTotal($iCnt);
	
		$aRows = $this->database()->select('b.*, bt.description_parsed, ' . Phpfox::getUserField())
			->from($this->_sTable, 'b')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = b.user_id')
			->join(Phpfox::getT('event_text'), 'bt', 'bt.event_id = b.event_id')
			->where((empty($iId) ? 'b.view_id = 0 AND b.privacy = 0 AND b.item_id = 0 AND ' . (empty($iUserId) ? '' : 'b.user_id = ' . (int) $iUserId . ' AND ') . ' b.start_time >= \'' . Phpfox::getLib('date')->convertToGmt($iTimeDisplay) . '\'' : 'b.event_id = ' . (int) $iId))
			->limit($this->_oApi->get('page'), 10, $iCnt)
			->order('b.time_stamp DESC')
			->execute('getSlaveRows');
	
		$aReturn = array();
		foreach ($aRows as $iKey => $aRow)
		{
			$aReturn[$iKey] = array(
					'event_id' => $aRow['event_id'],
					'title' => $aRow['title'],
					'likes' => $aRow['total_like'],
					'permalink' => Phpfox::permalink('event', $aRow['event_id'], $aRow['title']),
					'info' => Phpfox::getLib('parse.output')->parse($aRow['description_parsed']),
					'created_by' => $aRow['full_name'],
					'created_by_url' => Phpfox::getLib('url')->makeUrl($aRow['user_name'])
				);
			
			$aReturn[$iKey]['photo_200px'] = Phpfox::getLib('image.helper')->display(array(
					'path' => 'event.url_image',
					'server_id' => $aRow['server_id'],
					'file' => $aRow['image_path'],
					'suffix' => '_200',
					'return_url' => true
				)
			);	
		}
	
		return $aReturn;
	}
}

?>