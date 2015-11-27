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

<div id="loading" style="display: none; margin-left: 200px; text-align: center; width: 320px; height: 320px; padding-top: 3 0px;">
	<div id="inserting" style="display: none"></div>
	<img alt="" src="{param var='core.url_module'}blog/static/image/ajax-loader.gif">
	<div id="process" style="text-align: center;">{phrase var='blog.load_and_reading_file'}</div>
</div>
 <script type="text/javascript">
     $Behavior.importWordPressBlog = function(){l}
$(document).ready(function()
{l}	 
	 {if count($aItems)}
		 var iNumMax = 0;var iStep = 0;
		{foreach from=$aItems name=blog key=key item=aItem}
			$.ajax
			({l}
				type: "POST",
				//async:true,
				url : "{url link='blog.processimport'}",
				data: {l}"aVals":"{$aItem}","key":"{$key}"{r},
				success: function(msg)
				{l}
					iStep++; 
					if(iStep == iNumMax )
					{l}	
				     	window.location = "{url link='current'}bFlag_success";
				 	{r}
				{r}
			{r});	
			iNumMax++;
			{/foreach}
		$("#process").text("{phrase var='blog.importing_records'}");
		sending_request();
	{/if}
{r});

function sending_request()
 {l} 
	$("#import_form").css("display","none");
	$("#loading").css("display","block"); 
	
 {r}
 {r}
 </script>
 {if $bHasForm}
<div id="import_form">
	<form onsubmit="sending_request();" enctype="multipart/form-data"
		class="global_form" action="{url link='current'}" method="post">
		<h1>{phrase var='blog.import_wordpress'}</h1>
		<h3 style="border-bottom: 0 solid #758AB7;">{phrase var='blog.have_a_wordpress_export_file'}</h3>
		<div style="padding: 10px;">
		{phrase var='blog.choose_a_file_from_your_computer'}: ({phrase var='blog.maximum_size'})&nbsp;
				<input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
				<input id="import_blog" type="file" name="import_blog" />
							
		</div>
	
	<div class="table_clear">
		<ul class="table_clear_button">
                        <li>
                            <input type="submit" value="Upload file and import" class="button" name="b_import" />
                        </form>
                        </li>
			<li><input style="margin-top: 3px;" type="button" class="button"
				value="Back"
				onclick="window.location.href = '{url link='blog.import'}';">
			</li>
                     
		</ul>
		<div class="clear"></div>
	</div>
</div>
{/if}
