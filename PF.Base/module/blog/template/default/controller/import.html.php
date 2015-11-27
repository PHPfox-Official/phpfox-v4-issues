<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Blog
 * @version 		$Id: add.html.php 1298 2009-12-05 16:19:23Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 
?>
   {*<h1>Import</h1>*}
   <p>{phrase var='blog.blog_import_instruction'}</p>
   <div style="padding: 10px;">
   <table style="background-color:#FFFFFF;border-color:#DFDFDF;-moz-border-radius:4px 4px 4px 4px; border-spacing:0;border-style:solid;border-width:1px;clear:both;margin:0;width:100%;" cellspacing='0'  >
   <tbody>
   <tr style="background-color:#F9F9F9;">
   <td style="padding:6px 15px;font-size:12px !important; font-weight:bold;  border-color:#DFDFDF;border-bottom-style:solid; border-bottom-width:1px;">
   <a title="Import posts from a WordPress export file." href="{url link='blog.importwordpress'}">{phrase var='blog.wordpress'}</a>
   </td>
   <td style="padding:6px 15px;border-color:#DFDFDF;border-bottom-style:solid; border-bottom-width:1px;">{phrase var='blog.import_post_s_from_a_wordpress_export_file'}</td>
   </tr>
   <tr>
   <td style="padding:6px 15px;font-size:12px !important; font-weight:bold;  border-color:#DFDFDF;border-bottom-style:solid; border-bottom-width:1px;">
   <a title="Import posts from a Blogger export file." href="{url link='blog.importblogger'}">{phrase var='blog.blogger'}</a>
   </td>
   <td style="padding:6px 15px;border-color:#DFDFDF;border-bottom-style:solid; border-bottom-width:1px;">{phrase var='blog.import_post_s_from_a_blogger_export_file'}</td>
   </tr>
   <tr style="background-color:#F9F9F9;">
   <td style="padding:6px 15px;font-size:12px !important; font-weight:bold;  border-color:#DFDFDF;border-bottom-style:solid; border-bottom-width:1px;">
   <a title="Import posts from a Tumblr Username." href="{url link='blog.importtumblr'}">{phrase var='blog.tumblr'}</a>
   </td>
   <td style="padding:6px 15px;border-color:#DFDFDF;border-bottom-style:solid; border-bottom-width:1px;">{phrase var='blog.import_post_s_from_a_tumblr_username'}</td>
   </tr>
   </tbody>
   </table>
    <div class="table_clear">
  	<ul class="table_clear_button">
   		<li>
   			<input style="margin-top:10px;" type="button" class="button" value="Back" onclick="window.location.href = '{url link='blog'}';">
   		</li>
   	</ul>
   	<div class="clear"></div>
 </div>
   </div>

