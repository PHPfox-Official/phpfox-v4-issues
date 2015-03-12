
$Core.PhotoRate = 
{
	iImage: 0,
	iPhotoId: 0,
	oRatings: {},
	iRatingCount: 0,
	oPhotos: {},
	iCnt: 0,
	
	init: function (aParams)
	{
		this.oPhotos = aParams;		
	},
	
	populate: function(aVars)
	{
		this.iImage = 0;
		this.oRatings = {};		
		this.oPhotos = aVars;		
		
		this.preload();
		
		$('#js_photo_rate_image').html(this.getImage(0));		
	},
	
	preload: function()
	{
		var aPhotos = new Image();	
		
		for (i in this.oPhotos)
		{			
			aMatches = this.oPhotos[i]['destination'].match(/<img src="(.*?)"(.*?)/i);		 	
			aPhotos.src = aMatches[1];			
		}
	},
	
	getImage: function(iCnt)
	{
		if (!isset(this.oPhotos[iCnt]))
		{
			this.processRatings();
			
			return false;
		}		
		
		this.iImage++;		
		this.iCnt = iCnt;
		this.iPhotoId = this.oPhotos[iCnt]['photo_id'];		
		
		var sHtml = '';						
		sHtml += this.oPhotos[iCnt]['destination'];	
		sHtml += '<div class="extra_info">' + oTranslations['photo.added_on_time_stamp_by_full_name'].replace('{time_stamp}', this.oPhotos[iCnt]['time_stamp']).replace('{full_name}', this.oPhotos[iCnt]['full_name']) + '</div>';
		
		var sStat = '';
		if (this.oPhotos[iCnt]['total_rating'] == '0.00')
		{
			sStat += '<div style="font-size:28pt; font-weight:bold;" class="t_center">0</div>';
		}
		else
		{
			sStat += '<div style="font-size:28pt; font-weight:bold;" class="t_center">' + Math.round(this.oPhotos[iCnt]['total_rating']) + '</div>';
			sStat += '<div class="extra_info t_center">' + oTranslations['photo.with_a_total_of_total_vote_votes'].replace('{total_vote}', this.oPhotos[iCnt]['total_vote']) + '</div>';
		}
		
		$('#js_photo_average_rating').html(sStat);
		
		return sHtml;
	},
	
	getNextImage: function(iRating)
	{
		if (iRating !== false)
		{
			debug('Photo: ' + this.iPhotoId);		
				
			this.oRatings[this.iRatingCount] = {
				photo_id: this.iPhotoId,
				rating: iRating
			};			
			
			this.iRatingCount++;
		}		
		
		mData = this.getImage(this.iImage);
		
		if (mData === false)
		{
			
		}
		else		
		{
			$('#js_photo_rate_image').html(mData);
			
			this.prepareBar();
		}
	},
	
	processRatings: function()
	{
		sParams = '';
		for (i in this.oRatings)
		{
			sParams += '&photo_id[' + this.oRatings[i]['photo_id'] + ']=' + this.oRatings[i]['rating'] + '';
		}
		
		if (empty(sParams))
		{
			$('#js_block_border_average_rating').hide();
			
			return false;
		}
		
		$.ajaxCall('photo.getPhotosForRating', sParams + $Core.parseUrlString(window.location.hash));
	},
	
	prepareBar: function()
	{		
		$('.js_rating_bar').each(function()
		{			
			if (isset($Core.PhotoRate.oPhotos[$Core.PhotoRate.iCnt]))
			{			
				this.href = this.href.replace(/id_(.*?)\//i, '');			
				this.href = this.href + 'id_' + $Core.PhotoRate.oPhotos[$Core.PhotoRate.iCnt]['photo_id'] + '/';
			}
		});		
	}
}

$Behavior.photoRating = function()
{
	 window.onbeforeunload = function()
	 {
	 	$Core.PhotoRate.processRatings();
	 }
	
	$Core.PhotoRate.preload();
	
	$('#js_photo_rate_image').html($Core.PhotoRate.getImage(0));	
	
	$('.js_rating_bar').click(function()
	{
		aParams = $Core.getParams(this.href);		
		
		$Core.PhotoRate.getNextImage(aParams['rating']);
		
		window.location = '#' + $Core.getRequests(this.href, true);
		
		return false;
	});
	
	$Core.PhotoRate.prepareBar();
	
	$('.js_photo_category').each(function()
	{
		this.href = this.href.replace('photo/', 'photo/rate/');
	});
}