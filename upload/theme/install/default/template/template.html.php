<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: template.html.php 5861 2013-05-10 08:36:45Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="{$sLocaleDirection}" lang="{$sLocaleCode}">
	<head>
		<title>{title}</title>	
		{header}
		{loadjs}
	{literal}
		<script type="text/javascript">
		$Core.installer =
		{
			resize: function()
			{
				var iTop = (($(window).height() - $('#container').height()) / 2);
				var iLeft = (($(window).width() - $('#container').width()) / 2);
				
				if (iTop > 0)
				{
					$('#container').css('top', iTop);
				
					// alert((($(window).height() - $('#container').height()) / 2));
				}
				
				if (iLeft > 0)
				{
					$('#container').css('left', iLeft);
				}
				
				$('#container').show();			
			}
		}
		
		$(document).ready(function()
		{
			$('#install_form').submit(function()
			{
				$('#button').attr('disabled', true);
				$('#button').val('Processing...');
				
				return true;
			});			
			/*
			$(window).bind('resize', function() 
			{
				$Core.installer.resize();	
			});
			
			$Core.installer.resize();
			*/
		});		
		</script>
	{/literal}
	</head>
	<body>
		<div id="container">				
			<div id="main">
				<div class="left">
					<div class="logo">
						<a href="http://www.phpfox.com/" target="_blank">{img theme='layout/phpfox-logo-dark.png' alt=''}</a>
					</div>				
					<ul class="step">
						{foreach from=$aSteps item=aStep}
						<li{if $aStep.is_active} class="active"{/if}>{$aStep.count}. {$aStep.name}</li>
						{/foreach}
					</ul>
				</div>
				<div class="right">
				{if $sPublicMessage}
				<div class="public_message" id="public_message">
					{$sPublicMessage}
				</div>
				<script type="text/javascript">
					$Behavior.theme_install_template = function()
					{l}
						$('#public_message').show('slow');
					{r};
				</script>
				{/if}
				<div id="core_js_messages">
				{if count($aErrors)}
				{foreach from=$aErrors item=sErrorMessage}
					<div class="error_message">{$sErrorMessage}</div>
				{/foreach}
				{unset var=$sErrorMessage }
				{/if}
				</div>
				{layout file=$sTemplate}
				</div>
				<div class="clear"></div>
			</div>
			<div id="copyright">
				 {img theme='layout/phpfox-emblem.png' style='vertical-align:middle;'} {product_branding}
			</div>
		</div>
		<script type="text/javascript">
			$Core.init();
		</script>
	</body>
</html>