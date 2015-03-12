<?php
/** $Id: install.xml.php 41 2009-02-04 11:04:59Z Miguel_Espinoza $ **/
defined('PHPFOX') or exit('NO DICE!');
?>
<phpfox>
	<install>
		$aContactCategories = array(
			'Sales' => '0',	
			'Support' => '1',			
			'Suggestions' => '2'
		);
		foreach ($aContactCategories as $sTitle => $iOrdering)
		{
			$this->database()->insert(Phpfox::getT('contact_category'), array(
					'title' => $sTitle,
					'ordering' => $iOrdering
				)
			);
		}
	</install>
</phpfox>