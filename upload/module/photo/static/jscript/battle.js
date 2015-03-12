

$Core.photoBattle = 
{
	aPhotos: {},
	aParams: {},
	iCount: 0,
	bInit: false,
	mCategory: '',
	
	set: function (mCategory)
	{
		this.mCategory = mCategory;
	},
	
	init: function(aParams)
	{
		this.bInit = true;
		this.aPhotos = aParams;
		this.iCount = 0;
		
		var aPhotos = new Image();
		for (i in aParams)
		{			
			aMatches = aParams[i][0]['destination'].match(/<img src="(.*?)"(.*?)/i);		 				
			aPhotos.src = aMatches[1];			
			
			aMatches = aParams[i][1]['destination'].match(/<img src="(.*?)"(.*?)/i);		 				
			aPhotos.src = aMatches[1];			
		}		
	},
	
	populate: function(aParams)
	{
		this.init(aParams);
		
		this.display(0);
	},
	
	display: function(iId)
	{		
		if (this.bInit === false)
		{
			return false;
		}
		
		$('#js_no_photos').hide();
		$('#js_photo_battle_holder').show();
		
		if (!isset(this.aPhotos[iId]))
		{
			sParams = '';
			for (iKey in this.aParams)
			{
				sParams += '&photo_id[' + iKey + ']=' + this.aParams[iKey] + '';
			}
			
			if (empty(sParams))
			{
				return false;
			}
			
			$.ajaxCall('photo.battle', sParams + '&category=' + this.mCategory);			
			
			return false;
		}
		
		this.iCount = iId;
		
		$('#js_photo_1').html(this.getImage(iId, 0));
		$('#js_photo_2').html(this.getImage(iId, 1));
	},
	
	getImage: function(iId, iCnt)
	{
		var sHtml = '';
		
		sHtml += '<a href="#?id=' + this.aPhotos[iId][iCnt]['photo_id'] + '&amp;match=' + this.aPhotos[iId][(iCnt == 1 ? 0 : 1)]['photo_id'] + '" onclick="$Core.photoBattle.process(this.href); return false;">';
		sHtml += this.aPhotos[iId][iCnt]['destination'];
		sHtml += '</a>';
		sHtml += '<div class="extra_info">' + oTranslations['photo.added_on_time_stamp_by_full_name'].replace('{time_stamp}', this.aPhotos[iId][iCnt]['time_stamp']).replace('{full_name}', this.aPhotos[iId][iCnt]['full_name']) + '</div>';
		
		return sHtml;
	},
	
	process: function(sHref)
	{
		aParams = $.getParams(sHref);
		
		this.aParams[aParams['id']] = aParams['match'];
		
		window.location = '#id_' + aParams['id'] + '/match_' + aParams['match'] + '/';		
			
		this.display((this.iCount + 1));
	}
}

$Behavior.loadPhotoBatle = function()
{
	// $Core.photoBattle.display(0);
	/*
	$('.js_photo_category').each(function()
	{
		this.href = this.href.replace('photo/', 'photo/battle/');
	});	
	*/
}