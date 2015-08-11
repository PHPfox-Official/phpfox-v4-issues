{if $hasRewrite}
<div class="message">
	Short URLs are up and running. Good job!
</div>
{else}

<div class="message">
	{if $hasHtaccess}
	Add the following at the start of your <strong>/.htaccess</strong> file:
	{else}
	Create a new file called <strong>/.htaccess</strong> and add the following:
	{/if}
</div>
<pre style="margin-bottom:30px; background:#0c0c0c; text-indent:0px; color:#fff; padding:10px; font-family:monospace; font-size:13px;">
# START PHPfox Rewrite
&lt;IfModule mod_rewrite.c&gt;
	RewriteEngine On
	RewriteBase {param var='core.folder_original'}
	{literal}
	RewriteCond %{REQUEST_FILENAME} !-f
	{/literal}
    RewriteRule ^(file)/(.*) PF.Base/$1/$2

    RewriteRule ^static/ajax.php index.php
	RewriteRule ^themes/default/(.*) PF.Base/theme/default/$1
	RewriteRule ^(static|theme|module)/(.*) PF.Base/$1/$2
	RewriteRule ^(Apps|themes)/(.*) PF.Site/$1/$2

	{literal}
	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteCond %{REQUEST_FILENAME} !-d
	{/literal}
	RewriteRule ^(.*) index.php/$1
&lt;/IfModule&gt;
# END PHPfox Rewrite
</pre>

<form method="post" action="#" class="ajax_post">
	<div class="message">
		Continue below if your <strong>.htaccess</strong> file is ready.
	</div>
	<div class="table_clear">
		<input type="submit" class="button" value="Enable Short URLs">
	</div>
</form>

{/if}