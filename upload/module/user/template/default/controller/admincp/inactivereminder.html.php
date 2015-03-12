<?php
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_User
 * @version 		$Id: browse.html.php 2137 2010-11-15 13:37:06Z Raymond_Benc $
 * {* *}
 */
defined('PHPFOX') or exit('NO DICE!');
?>
<div class="table_header">
		{phrase var='user.member_search'}
</div>
<div class="table">
	<div class="table_left">
		{phrase var='user.show_users_who_have_not_logged_in_for'}:
	</div>
	<div class="table_right">
		<input type="text" id="inactive_days" size="3" value="1"> {phrase var='user.days'}
	</div>
	<div class="clear"></div>
</div>

<div class="table">
	<div class="table_left">
		{phrase var='user.send_mails_in_batches_of'}
	</div>
	<div class="table_right">
		<input type="text" id="mails_per_batch" size="3" value="0">
		<div class="extra_info">
			{phrase var='user.enter_0_for_all_at_once'}
		</div>
	</div>
	<div class="clear"></div>
</div>

<div class="table">
	<div class="table_left"></div>
	<div class="table_right">
		<div class="extra_info">{phrase var='user.this_feature_uses_the_language'}</div>
	</div>
	<div class="clear"></div>
</div>

<div class="table_clear">
	<input type="submit" value="{phrase var='user.get_members_count'}" class="button" id="btnSearch" />
	<input type="submit" value="{phrase var='user.process_mailing_job'}" class="button" id="btnProcess"/>
	<input type="submit" value="{phrase var='user.stop_mailing_job'}" class="button" id="btnStop" />
</div>

<div id="progress"></div>