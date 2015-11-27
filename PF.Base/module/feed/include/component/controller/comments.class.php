<?php

class Feed_Component_Controller_Comments extends Phpfox_Component {
	public function process() {
		$feed = Feed_Service_Feed::instance()->getForItem($this->request()->get('type'), $this->request()->get('id'));
		$aFeed = Feed_Service_Feed::instance()->get(null, $feed['feed_id']);

		$this->setParam('aFeed', array_merge($aFeed[0], ['feed_display' => 'view']));
		$this->template()->assign('showOnlyComments', true);
		$this->template()->assign('nextIteration', ((int) $this->request()->get('page') + 1));
		Phpfox::getBlock('feed.comment');

		$out = "var comment = " . json_encode(['html' => ob_get_contents()]) . "; ";
		$out .= "$('#js_feed_comment_pager_{$feed['type_id']}{$feed['item_id']}').prepend(comment.html); \$Core.loadInit();";
		$out .= "obj.remove();";
		ob_clean();

		header('Content-type: application/json');
		echo json_encode(['run' => $out]);
		exit;
	}
}