<?php

class Phpfoxsample_Service_Phpfoxsample extends Phpfox_Service 
{
	public function getUsers($iTotal)
	{
		return $this->database()->select('u.full_name')
			->from(Phpfox::getT('user'), 'u')
			->limit($iTotal)
			->execute('getRows');
	}
}

?>