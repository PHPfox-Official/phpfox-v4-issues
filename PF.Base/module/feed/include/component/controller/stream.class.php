<?php

class Feed_Component_Controller_Stream extends Phpfox_Component {
	public function process() {
		define('PHPFOX_FEED_STREAM_MODE', true);

		if (($val = $this->request()->get('val'))) {
			Phpfox::isUser(true);

			// if (isset($aVals['user_status']) && ($iId = Phpfox::getService('user.process')->updateStatus($aVals)))


			$val['user_status'] = $val['content'];
			$id = Phpfox::getService('user.process')->updateStatus($val);

			Feed_Service_Feed::instance()->processAjax($id);

			echo Phpfox_Ajax::instance()->getData();
			exit;
		}

		$aFeedCallback = [];
		if ($module = $this->request()->get('module')) {
			$aFeedCallback = [
				'module' => $this->request()->get('module'),
				'table_prefix' => $this->request()->get('module') . '_',
				'item_id' => $this->request()->get('item_id')
			];
		}

		$aFeed = Feed_Service_Feed::instance()->callback($aFeedCallback)->get(null, $this->request()->get('id'));

		header('Content-type: application/javascript');

		if (!isset($aFeed[0])) {
			echo ';__(' . json_encode([
					'url' => $this->url()->makeUrl('feed.stream', ['id' => $this->request()->get('id')]),
					'content' => false
				]) . ');';
			exit;
		}

		$this->template()->assign('aGlobalUser', (Phpfox::isUser() ? Phpfox::getUserBy(null) : array()));
		$this->template()->assign('aFeed', $aFeed[0]);
		$url = $this->url()->makeUrl('feed.stream', ['id' => $this->request()->get('id')]);
		if ($aFeedCallback) {
			$this->template()->assign('aFeedCallback', $aFeedCallback);
			$url = $this->url()->makeUrl('feed.stream', ['id' => $this->request()->get('id'), 'module' => $this->request()->get('module'), 'item_id' => $this->request()->get('item_id')]);
		}
		$this->template()->getTemplate('feed.block.entry');

		echo ';__(' . json_encode([
				'url' => $url,
				'content' => ob_get_clean()
		]) . ');';
		exit;
	}
}