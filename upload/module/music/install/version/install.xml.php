<?php
/** $Id: install.xml.php 2832 2011-08-15 17:36:44Z Raymond_Benc $ **/
defined('PHPFOX') or exit('NO DICE!');

?>
<phpfox>
	<install>		
		$aGenres = array(
			'Hip Hop',
			'Rock',
			'Pop',
			'Alternative',
			'Country',
			'Indie',
			'Rap',
			'R&amp;B',
			'Metal',
			'Punk',
			'Hardcore',
			'House',
			'Electronica',
			'Techno',
			'Reggae',
			'Latin',
			'Jazz',
			'Classic Rock',
			'Blues',
			'Folk',
			'Progressive',
		);
		
		foreach ($aGenres as $sName)
		{
			$this->database()->insert(Phpfox::getT('music_genre'), array('name' => $sName));
		}		
	</install>
</phpfox>