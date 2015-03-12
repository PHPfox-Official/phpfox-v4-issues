<?php

defined('PHPFOX') or exit('No dice!');

/**
 * Displays all the pokes this user has received so they can poke back
 */
class Poke_Component_Block_Display extends Phpfox_Component
{
	public function process()
	{
		list($iTotalPokes, $aPokes) = Phpfox::getService('poke')->getPokesForUser(Phpfox::getUserId(), true);
		if (!$iTotalPokes)
		{
			return false;
		}
		
		$this->template()->assign(array(
				'aPokes' => $aPokes,
				'sHeader' => Phpfox::getPhrase('poke.pokes'),
				'iTotalPokes' => $iTotalPokes
			)
		);
		
		if (!PHPFOX_IS_AJAX)
		{
			return 'block';
		}
	}
}
?>
