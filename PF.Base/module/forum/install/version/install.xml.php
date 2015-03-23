<?php
/** $Id: install.xml.php 2831 2011-08-12 19:44:19Z Raymond_Benc $ **/
defined('PHPFOX') or exit('NO DICE!');
?>
<phpfox>
	<install>
		$aForumCategories = array(
			'Discussions' => array(
				'url' => 'discussions',				
				'sub_forums' => array(
					'General' => 'general',
					'Movies' => 'movies',
					'Music' => 'music'
				)
			),
			'Computers &amp; Technology' => array(
				'url' => 'computers-technology',				
				'sub_forums' => array(
					'Computers' => 'computers',
					'Electronics' => 'electronics',
					'Gadgets' => 'gadgets',
					'General' => 'general'
				)
			)
		);		
		
		$iCategoryOrder = 0;
		foreach ($aForumCategories as $sCategory => $aForum)
		{
			$iCategoryOrder++;
			$iForumId = $this->database()->insert(Phpfox::getT('forum'), array(
					'is_category' => 1,
					'name' => $sCategory,
					'name_url' => $aForum['url'],
					'ordering' => $iCategoryOrder			
				)
			);
			
			$iForumOrder = 0;
			foreach ($aForum['sub_forums'] as $sName => $sUrl)
			{
				$iForumOrder++;
				$this->database()->insert(Phpfox::getT('forum'), array(
						'parent_id' => $iForumId,						
						'name' => $sName,
						'name_url' => $sUrl,
						'ordering' => $iForumOrder			
					)
				);			
			}
			
		}
	</install>
</phpfox>