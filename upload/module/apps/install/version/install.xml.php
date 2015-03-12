<?php
/** $Id: install.xml.php 2832 2011-08-15 17:36:44Z Raymond_Benc $ **/
defined('PHPFOX') or exit('NO DICE!');
?>
<phpfox>
	<install>
		$aAppCategories = array(
			'Just for Fun',			
			'Gaming',
			'Sports',
			'Utility',
			'Education',
			'Dating',
			'Messaging',
			'Chat',
			'Music',
			'Events',
			'Alerts',
			'Photo',
			'Business',
			'Video',
			'Politics',
			'Fashion',
			'Food and Drink',
			'Travel',
			'Money',
			'Mobile',
			'Classified',
			'File Sharing'
		);		
		sort($aAppCategories);
		$iCategoryOrder = 0;
		foreach ($aAppCategories as $sCategory)
		{
			$iCategoryOrder++;
			$this->database()->insert(Phpfox::getT('app_category'), array(					
					'name' => $sCategory					
				)
			);
		}
	</install>
</phpfox>