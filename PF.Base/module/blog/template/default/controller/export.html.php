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
   
   <p>{phrase var='blog.blog_import_instruction'}</p> 
   <div style="padding: 10px;">
   <table style="background-color:#FFFFFF;border-color:#DFDFDF;-moz-border-radius:4px 4px 4px 4px; border-spacing:0;border-style:solid;border-width:1px;clear:both;margin:0;width:100%;" cellspacing='0'  >
  	 <tbody>
   		<tr style="background-color:#F9F9F9;">
   			<td style="padding:6px 15px;font-size:12px !important; font-weight:bold;  border-color:#DFDFDF;border-bottom-style:solid; border-bottom-width:1px;">
 	 	 		<a title="Create an XML file cointaing your posts to save or import into another Wordpress blog" href="javascript:void(0);" onclick="window.location.href = '{url link='blog.export' option='wordpresstemplate'}';return false;">{phrase var='blog.wordpress'}</a>
   			</td>
   			<td style="padding:6px 15px;border-color:#DFDFDF;border-bottom-style:solid; border-bottom-width:1px;">{phrase var='blog.create_an_xml_file_wordpress_export'}.</td>
   		</tr>
   <tr style="background-color:#F9F9F9;">
   <td style="padding:6px 15px;font-size:12px !important; font-weight:bold;  border-color:#DFDFDF;border-bottom-style:solid; border-bottom-width:1px;">
   <a title="Create an XML file cointaing your posts to save or import into another Blogger blog" href="javascript:void(0);" onclick="window.location.href = '{url link='blog.export' option='bloggertemplate'}';return false">{phrase var='blog.blogger'}</a>
   </td>
   <td style="padding:6px 15px;border-color:#DFDFDF;border-bottom-style:solid; border-bottom-width:1px;">{phrase var='blog.create_an_xml_file_blogger_export'}.</td>
   </tr>
   <tr style="background-color:#F9F9F9;">
   <td style="padding:6px 15px;font-size:12px !important; font-weight:bold;  border-color:#DFDFDF;border-bottom-style:solid; border-bottom-width:1px;">
   <a title="Create an XML file cointaing your posts to save or import into another Tumblr blog." href="javascript:void(0);" onclick="window.location.href = '{url link='blog.export' option='tumblrtemplate'}';return false">{phrase var='blog.tumblr'}</a>
   </td>
   <td style="padding:6px 15px;border-color:#DFDFDF;border-bottom-style:solid; border-bottom-width:1px;">{phrase var='blog.create_an_xml_file_tumblr_export'}.</td>
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
 

