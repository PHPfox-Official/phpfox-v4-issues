<?php
/** $Id: install.xml.php 4278 2012-06-14 08:33:35Z Raymond_Benc $ **/
defined('PHPFOX') or exit('NO DICE!');
?>
<phpfox>
	<install>
	<![CDATA[
		$aRows = array(
			  0 => 
			  array (
			    'type_id' => 'post',
			    'title' => 'Facebook',
			    'icon' => 'facebook.gif',
			    'is_active' => '1',
			    'ordering' => '1',
			    'url' => 'http://www.facebook.com/share.php?u={URL}',
			  ),
			  1 => 
			  array (
			    'type_id' => 'bookmark',
			    'title' => 'Newsvine',
			    'icon' => 'newsvine.png',
			    'is_active' => '1',
			    'ordering' => '2',
			    'url' => 'http://www.newsvine.com/_wine/save?u={URL}&h={TITLE}',
			  ),
			  3 => 
			  array (
			    'type_id' => 'post',
			    'title' => 'Twitter',
			    'icon' => 'twitter.png',
			    'is_active' => '1',
			    'ordering' => '4',
			    'url' => 'http://twitter.com/home?status={TITLE} {URL}',
			  ),
			  4 => 
			  array (
			    'type_id' => 'bookmark',
			    'title' => 'Reddit',
			    'icon' => 'reddit.png',
			    'is_active' => '1',
			    'ordering' => '5',
			    'url' => 'http://www.reddit.com/submit?url={URL}&title={TITLE}',
			  ),
			  5 => 
			  array (
			    'type_id' => 'post',
			    'title' => 'Myspace',
			    'icon' => 'myspace.png',
			    'is_active' => '1',
			    'ordering' => '6',
			    'url' => 'http://www.myspace.com/Modules/PostTo/Pages/?l=3&u={URL}&t={TITLE}&c=',
			  ),
			  6 => 
			  array (
			    'type_id' => 'bookmark',
			    'title' => 'Technorati',
			    'icon' => 'technorati.png',
			    'is_active' => '1',
			    'ordering' => '7',
			    'url' => 'http://www.technorati.com/faves?add={URL}',
			  ),
			  7 => 
			  array (
			    'type_id' => 'post',
			    'title' => 'Friend Feed',
			    'icon' => 'friend_feed.png',
			    'is_active' => '1',
			    'ordering' => '8',
			    'url' => 'http://friendfeed.com/share?url={URL}',
			  ),
			  8 => 
			  array (
			    'type_id' => 'bookmark',
			    'title' => 'Digg',
			    'icon' => 'digg.gif',
			    'is_active' => '1',
			    'ordering' => '9',
			    'url' => 'http://digg.com/submit?phase=2&url={URL}&title={TITLE}',
			  ),
			  9 => 
			  array (
			    'type_id' => 'bookmark',
			    'title' => 'del.icio.us',
			    'icon' => 'delicious.gif',
			    'is_active' => '1',
			    'ordering' => '10',
			    'url' => 'http://del.icio.us/post?url={URL}&title={TITLE}',
			  ),
			  10 => 
			  array (
			    'type_id' => 'bookmark',
			    'title' => 'Google',
			    'icon' => 'google.gif',
			    'is_active' => '1',
			    'ordering' => '11',
			    'url' => 'http://www.google.com/bookmarks/mark?op=edit&output=popup&bkmk={URL}&title={TITLE}',
			  ),
			  11 => 
			  array (
			    'type_id' => 'bookmark',
			    'title' => 'StumbleUpon',
			    'icon' => 'stumbleupon.gif',
			    'is_active' => '1',
			    'ordering' => '12',
			    'url' => 'http://www.stumbleupon.com/submit?url={URL}&title={TITLE}',
			  ),
			);		
		foreach ($aRows as $aRow)
		{
			$aInsert = array();
			foreach ($aRow as $sKey => $sValue)
			{
				$aInsert[$sKey] = $sValue;
			}
			$this->database()->insert(Phpfox::getT('share_bookmark'), $aInsert);
		}	
	]]>
	</install>
</phpfox>