<?php

class Mail_Component_Controller_Panel extends Phpfox_Component {
	public function process() {
		Phpfox::isUser(true);

		$iPageSize = 30;
		$this->search()->set(array(
				'type' => 'mail',
				'field' => 'mail.mail_id',
				'search_tool' => array(
					'table_alias' => 'm',
					'search' => array(
						'action' => $this->url()->makeUrl('mail', array('view' => $this->request()->get('view'), 'id' => $this->request()->get('id'))),
						'default_value' => Phpfox::getPhrase('mail.search_messages'),
						'name' => 'search',
						'field' => array('m.subject', 'm.preview')
					),
					'sort' => array(
						'latest' => array('m.time_stamp', Phpfox::getPhrase('mail.latest')),
						'most-viewed' => array('m.viewer_is_new', Phpfox::getPhrase('mail.unread_first'))
					),
					'show' => array(30)
				)
			)
		);
		$this->search()->setCondition('AND m.viewer_user_id = ' . Phpfox::getUserId() . ' AND m.is_archive = 0');

		list($iCnt, $aMessages, $aInputs) = Mail_Service_Mail::instance()->get($this->search()->getConditions(), $this->search()->getSort(), $this->search()->getPage(), $iPageSize);

		$this->template()->assign(array(
				'aMessages' => $aMessages
			)
		);
	}
}