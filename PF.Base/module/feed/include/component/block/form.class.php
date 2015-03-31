<?php

class Feed_Component_Block_Form extends Phpfox_Component {
	public function process() {
		$bLoadCheckIn = false;
		if (!defined('PHPFOX_IS_PAGES_VIEW') && Phpfox::getParam('feed.enable_check_in') && (Phpfox::getParam('core.ip_infodb_api_key') || Phpfox::getParam('core.google_api_key') ) )
		{
			$bLoadCheckIn = true;
		}
		$this->template()->assign([
			'aFeedStatusLinks' => Feed_Service_Feed::instance()->getShareLinks(),
			'bLoadCheckIn' => $bLoadCheckIn
		]);
	}
}