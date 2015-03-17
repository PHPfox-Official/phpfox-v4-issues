<?php

class Feed_Component_Controller_Stream extends Phpfox_Component {
	public function process() {
		if (($val = $this->request()->get('val'))) {
			Phpfox::isUser(true);

			// if (isset($aVals['user_status']) && ($iId = Phpfox::getService('user.process')->updateStatus($aVals)))


			$val['user_status'] = $val['content'];
			$id = Phpfox::getService('user.process')->updateStatus($val);

			Phpfox::getService('feed')->processAjax($id);

			echo Phpfox::getLib('ajax')->getData();
			exit;
		}

		$aFeed = Phpfox::getService('feed')->get(null, $this->request()->get('id'));

		$this->template()->assign('aGlobalUser', (Phpfox::isUser() ? Phpfox::getUserBy(null) : array()));
		// $aFeed[0]['feed_view_comment'] = true;

		// $this->setParam('aFeed', array_merge(array('feed_display' => 'view', 'total_like' => $aFeed[0]['feed_total_like']), $aFeed[0]));
		$this->template()->assign('aFeed', $aFeed[0]);
		$this->template()->getTemplate('feed.block.entry');

		header('Content-type: application/javascript');
		echo ';__(' . json_encode([
				'url' => $this->url()->makeUrl('feed.stream', ['id' => $this->request()->get('id')]),
				'content' => ob_get_clean()
		]) . ');';
		exit;
	}
}