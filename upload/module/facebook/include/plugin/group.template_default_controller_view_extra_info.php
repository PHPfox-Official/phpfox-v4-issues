<?php
if (Phpfox::getParam('facebook.facebook_like_group'))
{
	echo '<div class="p_4">
	<iframe src="http://www.facebook.com/plugins/like.php?href=' . $this->_aVars['aGroup']['bookmark_url'] . '&amp;layout=button_count&amp;show_faces=true&amp;width=200&amp;action=like&amp;font&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:400px; height:21px;" allowTransparency="true"></iframe></div>';
}
?>