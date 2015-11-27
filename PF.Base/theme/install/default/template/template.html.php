<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="{$sLocaleDirection}" lang="{$sLocaleCode}">
	<head>
		<title>{title}</title>
		{header}
	</head>
	<body>
		{if (isset($bIsUprade) && $bIsUprade)}
		<div id="is-upgrade"></div>
		{/if}
		<div id="header">
			PHPfox <span>{$sCurrentVersion}</span>
		</div>
		<div id="installer">
			{if isset($requirementErrors)}
			<form method="post" action="#start">
				<div id="errors">
					{foreach from=$requirementErrors item=error}
					<div class="error">
						{$error}
					</div>
					{/foreach}
				</div>
				<div class="table_clear">
					<input type="submit" value="Try Again" class="button" />
				</div>
			</form>
			{else}
			<div class="process">Loading installer<i class="fa fa-spin fa-circle-o-notch"></i></div>
			{/if}
		</div>
		{loadjs}
	</body>
</html>