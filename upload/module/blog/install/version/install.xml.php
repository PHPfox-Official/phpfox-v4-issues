<?php
/** $Id: install.xml.php 2536 2011-04-14 19:37:29Z Raymond_Benc $ **/
defined('PHPFOX') or exit('NO DICE!');
?>
<phpfox>
	<install>
		$aBlogCategories = array(
			'Business' => 'business',
			'Education' => 'education',
			'Entertainment' => 'entertainment',
			'Family &amp; Home' => 'family-home',
			'Health' => 'health',
			'Recreation' => 'recreation',
			'Shopping' => 'shopping',
			'Society' => 'society',
			'Sports' => 'sports',
			'Technology' => 'technology'
		);
		foreach ($aBlogCategories as $sName => $sUrl)
		{
			$this->database()->insert(Phpfox::getT('blog_category'), array(
					'name' => $sName,
					'added' => PHPFOX_TIME
				)
			);
		}
	</install>
</phpfox>