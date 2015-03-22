<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: template-footer.html.php 6519 2013-08-28 12:16:06Z Fern $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
		{if !defined('PHPFOX_SKIP_IM')}
                <div id="js_im_player"></div>
		{module name='im.footer'}
		{$sDebugInfo}
		{/if}
		{loadjs}
        {plugin call='theme_template_body__end'}
        