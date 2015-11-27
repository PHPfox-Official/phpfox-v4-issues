<?php
/** $Id: install.xml.php 2831 2011-08-12 19:44:19Z Raymond_Benc $ **/
defined('PHPFOX') or exit('NO DICE!');
?>
<phpfox>
	<install>
		$aCategories = array(
			'Community',
			'Houses',
			'Jobs',
			'Pets',
			'Rentals',
			'Services',
			'Stuff',
			'Tickets',
			'Vehicle'
		);		
		
		$iCategoryOrder = 0;
		foreach ($aCategories as $sCategory)
		{
			$iCategoryOrder++;
			$iCategoryId = $this->database()->insert(Phpfox::getT('marketplace_category'), array(					
					'name' => $sCategory,
					'is_active' => 1,
					'ordering' => $iCategoryOrder			
				)
			);
		}
	</install>
</phpfox>