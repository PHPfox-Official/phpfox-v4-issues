<?php
/** $Id: install.xml.php 2832 2011-08-15 17:36:44Z Raymond_Benc $ **/
defined('PHPFOX') or exit('NO DICE!');
?>
<phpfox>
	<install>
		$aPhotoCategories = array(
			'Comedy',
			'Digital Art',
			'Photography',
			'Traditional Art',
			'Film &amp; Animation',
			'Designs &amp; Interfaces',
			'Game Development Art',
			'Artisan Crafts',
			'Customization',
			'Fractal Art',
			'Cartoons &amp; Comics',
			'Contests',
			'Resources &amp; Stock Images',
			'Literature',
			'Fan Art',
			'Anthro',
			'Community Projects',
			'People',
			'Pets &amp; Animals',
			'Science &amp; Technology',
			'Sports'
		);		
		sort($aPhotoCategories);
		$iCategoryOrder = 0;
		foreach ($aPhotoCategories as $sCategory)
		{
			$iCategoryOrder++;
			$this->database()->insert(Phpfox::getT('photo_category'), array(					
					'name' => $sCategory,
					'ordering' => $iCategoryOrder			
				)
			);
		}
	</install>
</phpfox>