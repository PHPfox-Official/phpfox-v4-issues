<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Display the image details when viewing an image.
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package  		Module_Friend
 * @version 		$Id: detail.class.php 254 2009-02-23 12:36:20Z Miguel_Espinoza $
 */
class Friend_Component_Block_Birthday extends Phpfox_Component
{
	public function process()
	{
		if (!Phpfox::getParam('friend.enable_birthday_notices'))
		{
			return false;
		}
		
		if (!Phpfox::isUser())
		{
			return false;
		}

		$aBirthdays = Phpfox::getService('friend')->getBirthdays(Phpfox::getuserId());

		$bIsEventSection = (Phpfox::getLib('module')->getFullControllerName() == 'event.index' ? true : false);
		if (!Phpfox::isModule('event'))
		{
			$bIsEventSection = true;
		}
		
		if ($bIsEventSection && empty($aBirthdays) && (Phpfox::getParam('friend.show_empty_birthdays') == false))
		{
			return false;
		}
		
		$aUpcomingEvents = array();
		if (!$bIsEventSection)
		{
			if (Phpfox::isUser())
			{
				$sEventCacheId = Phpfox::getLib('cache')->set(array('events', Phpfox::getUserId()));
				if (!($aUpcomingEvents = Phpfox::getLib('cache')->get($sEventCacheId, (Phpfox::getParam('event.cache_upcoming_events_info') * 60))))
				{
					$this->search()->set(array(				
							'type' => 'event',
							'field' => 'm.event_id',				
							'search_tool' => array(
								'default_when' => 'upcoming',
								'when_field' => 'start_time',
								'when_upcoming' => true,
								'table_alias' => 'm',	
								'sort' => array(
									'latest' => array('m.start_time', 'Latest', 'ASC')						
								),
								'show' => array(5)
							)
						)
					);			
					
					$aBrowseParams = array(
						'module_id' => 'event',
						'alias' => 'm',
						'field' => 'event_id',
						'table' => Phpfox::getT('event'),
						'hide_view' => array('pending', 'my')
					);			
					
					$this->search()->setCondition('AND m.view_id = 0 AND m.privacy IN(%PRIVACY%)');
					$this->search()->browse()->params($aBrowseParams)->execute();

					$aUpcomingEvents = $this->search()->browse()->getRows();
					
					// http://www.phpfox.com/tracker/view/14796/
					// iterate among dates
					foreach($aUpcomingEvents as $sUpcomingDate => $aEvents)
					{
						// iterate among events
						foreach($aEvents as $iKey => $aUpcomingEvent)
						{
							// if the event is in a page
							if(Phpfox::isModule('pages') && $aUpcomingEvent['module_id'] == 'pages')
							{
								// if current user is not member or admin, remove the event from the upcoming block
								if(!Phpfox::getService('pages')->isMember($aUpcomingEvent['profile_page_id']) && !Phpfox::getService('pages')->isAdmin($aUpcomingEvent['profile_page_id']))
								{
									// if only one event in the date, erase the date
									if(count($aUpcomingEvents[$sUpcomingDate]) == 1)
									{
										unset($aUpcomingEvents[$sUpcomingDate]);
									}
									// If there are more events, delete only the event
									else
									{
										unset($aUpcomingEvents[$sUpcomingDate][$iKey]);
									}
								}
							}
						}
					}
					
					Phpfox::getLib('cache')->save($sEventCacheId, $aUpcomingEvents);
				}
			}
		}

		$this->template()->assign(array(
				'aSearchTool' => '',
				'aUpcomingEvents' => (is_bool($aUpcomingEvents) ? array() : $aUpcomingEvents),
				'aBirthdays' => $aBirthdays,
				'bIsEventSection' => $bIsEventSection,
				'sHeader' => ($bIsEventSection ? Phpfox::getPhrase('friend.birthdays') : Phpfox::getPhrase('event.upcoming_events'))
			)
		);

		return 'block';
	}
}
?>
