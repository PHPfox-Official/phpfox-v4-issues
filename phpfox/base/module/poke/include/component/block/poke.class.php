<?php

defined('PHPFOX') or exit('No dice!');

class Poke_Component_Block_Poke extends Phpfox_Component
{
	public function process()
	{
		$aArr= array();
		$aUser = Phpfox::getService('user')->getUserFields(false, $aArr, null, $this->request()->get('user_id'));
		
		$this->template()->assign(array(
			'aUser' => $aUser,
			'bCanPoke' => Phpfox::getService('poke')->canSendPoke($this->request()->get('user_id'))
			));
		return 'block';
	}
}
?>
