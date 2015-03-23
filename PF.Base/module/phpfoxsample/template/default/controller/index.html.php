Hello World!
<br />
<br />
{$sSampleVariable}
<br />
<br />
<ul>
	<li>{$sSampleKey1}</li>
	<li>{$sSampleKey2}</li>
	<li>{$sSampleKey3}</li>
	<li>{$sSampleKey4}</li>
</ul>
<br />
<br />
<a href="#" id="sample_id">Click Me!</a>
<br />
<br />
<b>Members:</b>
<ul class="p_4" style="list-style-type:square; margin:0px 0px 0px 15px;">
{foreach from=$aUsers item=aUser}
	<li>{$aUser.full_name}</li>
{/foreach}
</ul>
{module name='phpfoxsample.display'}