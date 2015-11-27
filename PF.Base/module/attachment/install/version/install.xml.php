<?php
/** $Id: install.xml.php 882 2009-08-21 09:04:36Z Raymond_Benc $ **/
defined('PHPFOX') or exit('NO DICE!');
?>
<phpfox>
	<install>
		$aExtensions = array(
			array(
				'extension' => 'jpg',
				'mime_type' => 'image/jpeg',
				'is_active' => '1',
				'is_image' => '1',
				'added' => '1208637306'
			),
			array(
				'extension' => 'jpeg',
				'mime_type' => 'image/jpeg',
				'is_active' => '1',
				'is_image' => '1',
				'added' => '1208637306'
			),
			array(
				'extension' => 'gif',
				'mime_type' => 'image/gif',
				'is_active' => '1',
				'is_image' => '1',
				'added' => '1208637335'
			),
			array(
				'extension' => 'png',
				'mime_type' => 'image/png',
				'is_active' => '1',
				'is_image' => '1',
				'added' => '1212577320'
			),			
			array(
				'extension' => 'zip',
				'mime_type' => 'image/zip',
				'is_active' => '1',
				'is_image' => '1',
				'added' => '1212577320'
			)			
		);
		foreach ($aExtensions as $aExtension)
		{
			$this->database()->insert(Phpfox::getT('attachment_type'), array(
					'extension' => $aExtension['extension'],
					'mime_type' => $aExtension['mime_type'],
					'is_active' => $aExtension['is_active'],
					'is_image' => $aExtension['is_image'],
					'added' => $aExtension['added']
				)
			);
		}
	</install>
</phpfox>