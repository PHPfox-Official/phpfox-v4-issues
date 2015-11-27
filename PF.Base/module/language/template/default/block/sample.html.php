<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: sample.html.php 1297 2009-12-04 23:18:17Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="p_4">
	<div class="p_4">	
		<div class="go_left t_right" style="width:150px;"><b>{phrase var='language.php'}</b>:</div>
		<div><input type="text" name="php" value="Phpfox::getPhrase('{$sCachePhrase}')" size="40" onclick="this.select();" /></div>
		<div class="clear"></div>
	</div>
	<div class="p_4">	
		<div class="go_left t_right" style="width:150px;"><b>{phrase var='language.php_single_quoted'}</b>:</div>
		<div><input type="text" name="php" value="' . Phpfox::getPhrase('{$sCachePhrase}') . '" size="40" onclick="this.select();" /></div>
		<div class="clear"></div>
	</div>	
	<div class="p_4">	
		<div class="go_left t_right" style="width:150px;"><b>{phrase var='language.php_double_quoted'}</b>:</div>
		<div><input type="text" name="php" value="&quot; . Phpfox::getPhrase('{$sCachePhrase}') . &quot;" size="40" onclick="this.select();" /></div>
		<div class="clear"></div>
	</div>		
	<div class="p_4">
		<div class="go_left t_right" style="width:150px;"><b>{phrase var='language.html'}</b>:</div>
		<div><input type="text" name="html" value="{literal}{{/literal}phrase var='{$sCachePhrase}'{literal}}{/literal}" size="40" onclick="this.select();" /></div>
		<div class="clear"></div>
	</div>
	<div class="p_4">
		<div class="go_left t_right" style="width:150px;"><b>{phrase var='language.js'}</b>:</div>
		<div><input type="text" name="html" value="oTranslations['{$sCachePhrase}']" size="40" onclick="this.select();" /></div>
		<div class="clear"></div>
	</div>	
	<div class="p_4">
		<div class="go_left t_right" style="width:150px;"><b>{phrase var='language.text'}</b>:</div>
		<div><input type="text" name="html" value="{$sCachePhrase}" size="40" onclick="this.select();" /></div>
		<div class="clear"></div>
	</div>		
</div>