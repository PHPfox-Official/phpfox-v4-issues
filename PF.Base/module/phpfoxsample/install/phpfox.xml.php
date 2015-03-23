<?php
/** $Id: phpfox.xml.php 46 2009-01-14 14:07:11Z Raymond_Benc $ **/
defined('PHPFOX') or exit('NO DICE!');
?>
<phpfox version="22">
	<module>
		<module_id>phpfoxsample</module_id>
		<product_id>phpfox_sample</product_id>
		<is_core>0</is_core>
		<is_active>1</is_active>
		<is_menu>1</is_menu>
		<menu>a:2:{s:30:"phpfoxsample.admin_menu_menu_1";a:1:{s:3:"url";a:1:{i:0;s:12:"phpfoxsample";}}s:30:"phpfoxsample.admin_menu_menu_2";a:1:{s:3:"url";a:2:{i:0;s:12:"phpfoxsample";i:1;s:3:"new";}}}</menu>
		<phrase_var_name>module_phpfoxsample</phrase_var_name>
	</module>
<phrases>
	<phrase module_id="phpfoxsample" version_id="22" var_name="admin_menu_menu_1" added="1231879395">Menu 1</phrase>
	<phrase module_id="phpfoxsample" version_id="22" var_name="admin_menu_menu_2" added="1231879395">Menu 2</phrase>
	<phrase module_id="phpfoxsample" version_id="22" var_name="module_phpfoxsample" added="1231879395">This is a sample module.</phrase>
</phrases>
</phpfox>