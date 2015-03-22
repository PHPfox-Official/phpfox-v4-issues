<?php
if (isset($this->_aVars['aFeed']) && isset($this->_aVars['aFeed']['comment_type_id']) && $this->_aVars['aFeed']['comment_type_id'] == 'photo' && isset($this->_aVars['aFeed']['feed_display']) && $this->_aVars['aFeed']['feed_display'] == 'view')
{
	if (isset($this->_aVars['aForms']) && $this->_aVars['aForms']['allow_download'] == '1')
	{
		echo '<li><span>&middot;</span></li>';
		echo '<li><a href="' . Phpfox::permalink(array('photo', 'download'), $this->_aVars['aForms']['photo_id'], $this->_aVars['aForms']['title']) . '" class="no_ajax_link">' . Phpfox::getPhrase('photo.download') . '</a></li>';		
	}	
	if (isset($this->_aVars['aForms']) && Phpfox::getUserParam('photo.can_view_all_photo_sizes') && !Phpfox::isMobile())
	{
		echo '<li><span>&middot;</span></li>';
		// echo '<li><a href="#" onclick="js_box_remove(this); $Core.box(\'photo.viewAllSizes\', \'full\', \'id=' . $this->_aVars['aForms']['photo_id'] . '\'); return false;">View All Sizes</a></li>';
		echo '<li><a href="' . Phpfox::permalink(array('photo', 'all'), $this->_aVars['aForms']['photo_id'], $this->_aVars['aForms']['title']) . '" class="no_ajax_link">' . Phpfox::getPhrase('photo.view_all_sizes') . '</a></li>';
	}
}
?>