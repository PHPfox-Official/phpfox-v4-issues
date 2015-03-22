<?php
/** $Id: install.xml.php 402 2009-04-13 08:33:48Z Raymond_Benc $ **/
defined('PHPFOX') or exit('NO DICE!');
?>
<phpfox>
	<install>
		$aCategories = array(
			'Category 1' => array(
				'url' => 'category-1',				
				'sub_categories' => array(
					'Category 1.1' => 'category-1-1',
					'Category 1.2' => 'category-1-2'
				)
			),
			'Category 2' => array(
				'url' => 'category-2',				
				'sub_categories' => array(
					'Category 2.1' => 'category-2-1',
					'Category 2.2' => 'category-2-2'
				)
			)			
		);		
		
		$iCategoryOrder = 0;
		foreach ($aCategories as $sCategory => $aCategory)
		{
			$iCategoryOrder++;
			$iCategoryId = $this->database()->insert(Phpfox::getT('group_category'), array(					
					'name' => $sCategory,
					'name_url' => $aCategory['url'],
					'is_active' => 1,
					'ordering' => $iCategoryOrder			
				)
			);
			
			$iSubCategoryOrder = 0;
			foreach ($aCategory['sub_categories'] as $sName => $sUrl)
			{
				$iSubCategoryOrder++;
				$this->database()->insert(Phpfox::getT('group_category'), array(
						'parent_id' => $iCategoryId,						
						'name' => $sName,
						'name_url' => $sUrl,
						'is_active' => 1,
						'ordering' => $iSubCategoryOrder			
					)
				);			
			}
			
		}
	</install>
</phpfox>