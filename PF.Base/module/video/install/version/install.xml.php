<?php
/** $Id: install.xml.php 402 2009-04-13 08:33:48Z Raymond_Benc $ **/
defined('PHPFOX') or exit('NO DICE!');
?>
<phpfox>
	<install>
		$aCategories = array(
			'Autos &amp; Vehicles',
			'Comedy',
			'Education',
			'Entertainment',
			'Film &amp; Animation',
			'Gaming',
			'Howto &amp; Style',
			'News &amp; Politics',
			'Nonprofits &amp; Activism',
			'People &amp; Blogs',
			'Pets &amp; Animals',
			'Science &amp; Technology',
			'Sports',
			'Travel &amp; Events'
		);		
		
		$iCategoryOrder = 0;
		foreach ($aCategories as $sCategory)
		{
			$iCategoryOrder++;
			$iCategoryId = $this->database()->insert(Phpfox::getT('video_category'), array(					
					'name' => $sCategory,
					'is_active' => 1,
					'ordering' => $iCategoryOrder			
				)
			);			
		}		
	</install>
</phpfox>