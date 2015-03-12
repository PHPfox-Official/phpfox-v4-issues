<?php

class Phpfoxsample_Component_Controller_Index extends Phpfox_Component
{
	public function process()
	{		
		$this->template()->setTitle('My Sample Title');
		$this->template()->setBreadcrumb('My Sample Breadcrumb');
		$this->template()->setMeta('keywords', 'phrase1, phrase2, phrase3');
		$this->template()->setMeta('description', 'This is a sample page.');
		$this->template()->assign('sSampleVariable', 'Hello, I am an assigned variable.');
		$this->template()->assign(array(
				'sSampleKey1' => 'Sample Value 1',
				'sSampleKey2' => 'Sample Value 2',
				'sSampleKey3' => 'Sample Value 3',
				'sSampleKey4' => 'Sample Value 4'
			)
		);
		$this->template()->setHeader(array(
				'sample.css' => 'module_phpfoxsample',
				'sample.js' => 'module_phpfoxsample'
			)
		);
		$this->template()->setHeader('<!-- Add me in the header -->');
		$aUsers = Phpfox::getService('phpfoxsample')->getUsers(10);
		$this->template()->assign('aUsers', $aUsers);		
	}
}

?>