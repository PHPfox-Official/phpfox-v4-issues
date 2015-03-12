$Core.Like = {
    /* This is the container of the like, we will add like and unlike here, usually a class e.g. .js_like*/
    sLikeId: undefined,
    /* This is the container of the like, we will add dislike and undislike here, usually a class e.g. .js_dislike*/
    sDislikeId: undefined,
    /* Phrase for the like */
    sPhraseLike: undefined,
    /* Phrase for unlike*/
    sPhraseUnlike: undefined,
    /* Phrase for dislike */
    sPhraseDislike: undefined,
    /* Phrase for undislike*/
    sCounterId: undefined,
    
    init: function(sType, aObj)
    {
	for(var i in aObj)
	{
	    /* When the phrase is clicked we trigger an event */
	    $('.' + aObj[i]['holder_add']).each(function(){
		if (!empty($(this).attr('id')))
		{
		    console.log('Not empty');
		    var sId = 'domark' + Math.random().toString(32).substring(2, 15);
		    $(this).on('click', function(){
			$.ajaxCall('like.doMark', 'type=' + sType + '&item_id=' + $(this).attr('id') + '&action=' + aObj[i]['action'] + '&counterId=' + sId);
		    });
		    $(this).parent().parent().find('.' + aObj[i]['counter']).attr('id', sId );
		}
		else
		{
		    console.log('Empty');
		}
	    });
	}
    },
    
    displayIncrease: function(itemId)
    {
	
    }
}

