<?php

class Forum_Component_Block_Forums extends Phpfox_Component {
	public function process() {
		$this->template()->assign([
			'aForums' => Phpfox::getService('forum')->live()->getForums()
		]);
	}
}