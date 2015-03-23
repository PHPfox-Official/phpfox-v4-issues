if (typeof $Core.AdminCP == 'undefined') $Core.AdminCP = {};

$Core.AdminCP.Rewrite = 
{
	aRecords: [],
	aDeleted: [],
	nTemplate : '',
	
	/** Loads records and caches the template for new records */
	init : function(jRecords)
	{
		this.nTemplate = $('#templateEntry');
		var oRecords = JSON.parse(jRecords);
		for (var i in oRecords) this.aRecords.push( oRecords[i] );
		if (this.aRecords.length > 0) this.displayRecords();
	},
	
	/** Removes a <tr> from DOM */
	remove: function(oObj)
	{
		if (confirm('are you sure?'))
		{
			this.aDeleted.push({
				rewrite_id: $(oObj).parents('tr').attr('id'),
				remove: true
			});
			$(oObj).parents('tr').remove();
            $.ajaxCall('core.removeRewrite', 'id=' + $(oObj).parents('tr').attr('id'), 'GET');
		}
	},
	
	displayRecords : function()
	{
		if (this.aRecords.length < 1 )
		{
			return;
		}
		var sNew;
		for (var i in this.aRecords)
		{
			sNew = this.nTemplate.clone().html();
			sNew = sNew
					.replace(oTranslations['core.original_url'], this.aRecords[i]['url'])
					.replace(oTranslations['core.replacement_url'], this.aRecords[i]['replacement'] )
					.replace('_ID_', this.aRecords[i]['rewrite_id']);
						
			sNew = '<tr id="' + this.aRecords[i]['rewrite_id'] + '" class="rewriteEntry' + ($('tr').length % 2 == 0 ? ' tr' : '') + '">' + sNew + '</tr>';
			$('#tblHeader').after( sNew );
		}
	},
	
	/** Adds one entry to the table so the user can enter the new url and replacement */
	addNew : function()
	{
		var oTemp = $(this.nTemplate).clone();
        var sHtml = oTemp.html();

        var sNew = sHtml.replace(oTranslations['core.original_url'], '').replace(oTranslations['core.replacement_url'], '');

		/* It is easier to understand that it is a new rule if we add an id */
		$('#trAddNew').before('<tr class="rewriteEntry' + ($('tr').length % 2 == 0 ? ' tr' : '') + '" id="newRule' + ( ((1 + Math.random()) * 0x1000) | 0).toString(16) + '">' + sNew + '</tr>');
	},
	
	save: function()
	{
		var bAlert = false
		$('.sOriginal').each(function(){
			if ($(this).val().indexOf('_') > (-1))
			{
				bAlert = true;
				return false;
			}
		});
		if (bAlert)
		{
			alert('The original URL may not contain under scores');
			return;
		}
		
		
		// build the array
		var aRewrites = [];
		$('tr.rewriteEntry').each(function(){
			if ( $(this).find('.sOriginal').length < 1 ) return true;
			if ( $(this).find('.sOriginal').val().indexOf(' ') > 0)
			{
				$(this).hide(400, function(){ $(this).remove(); });
				return true;
			}
			aRewrites.push({
				rewrite_id : $(this).attr('id'),
				original_url : $(this).find('.sOriginal').val(),
				replacement_url : $(this).find('.sReplacement').val()
			});
		});
		aRewrites = aRewrites.concat( this.aDeleted );
		$('#processing').show();
		$('#message').html('');
		$.ajaxCall('core.updateRewrites', 'aRewrites=' + JSON.stringify(aRewrites), 'POST');
	},
	
	/** Triggered from the ajax response */
	saveSuccessful : function()
	{
		$('#processing').hide();		
	},
	
	checkOriginal : function(oObj)
	{
		if ($(oObj).val().indexOf('_') > (-1))
		{
			$(oObj).siblings('span').show();
		}
		else
		{
			$(oObj).siblings('span').hide();
		}
		$(oObj).val($(oObj).val().replace(oParams['sJsHome'], '').replace('index.php?do=',''));
	},
	
	checkReplacement: function(oObj)
	{
		$(oObj).val($(oObj).val().replace(oParams['sJsHome'], '').replace('index.php?do=',''));
	}
};
