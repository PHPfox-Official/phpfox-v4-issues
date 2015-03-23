<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Feed
 * @version 		$Id: birth.html.php 5302 2013-02-01 09:39:26Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if $aUser.dob_setting == '3'}
	<div class="message js_no_feed_to_show">{phrase var='feed.there_are_no_new_feeds_to_view_at_this_time'}</div>
{else}
    {if !defined('PHPFOX_IS_PAGES_VIEW')}
        <div class="timeline_holder">    
            <div class="timeline_birth_title">		
                {phrase var='profile.born_on_birthday' birthday=$sBirthDisplay}
            </div>

        </div>
    {/if}
{/if}