
$Core.event =
{
    sUrl: '',

    url: function(sUrl)
    {
        this.sUrl = sUrl;
    },

    action: function(oObj, sAction)
    {
        aParams = $.getParams(oObj.href);

        $('.dropContent').hide();

        switch (sAction)
        {
            case 'edit':
                window.location.href = this.sUrl + 'add/id_' + aParams['id'] + '/';
                break;
            case 'delete':
                if (confirm(oTranslations['event.are_you_sure_this_will_delete_all_events_that_belong_to_this_category_and_cannot_be_undone']))
                {
                    window.location.href = this.sUrl + 'delete_' + aParams['id'] + '/';
                }
                break;
            default:

                break;
        }

        return false;
    }
}

$(function()
{
    $('.sortable ul').sortable({
            axis: 'y',
            update: function(element, ui)
            {
                var iCnt = 0;
                $('.js_mp_order').each(function()
                {
                    iCnt++;
                    this.value = iCnt;
                });
            },
            opacity: 0.4
        }
    );

    $('.js_drop_down').click(function()
    {
        eleOffset = $(this).offset();

        aParams = $.getParams(this.href);

        $('#js_cache_menu').remove();

        $('body').prepend('<div id="js_cache_menu" style="position:absolute; left:' + eleOffset.left + 'px; top:' + (eleOffset.top + 15) + 'px; z-index:100; background:red;">' + $('#js_menu_drop_down').html() + '</div>');

        $('#js_cache_menu .link_menu li a').each(function()
        {
            this.href = '#?id=' + aParams['id'];
        });

        $('.dropContent').show();

        $('.dropContent').mouseover(function()
        {
            $('.dropContent').show();

            return false;
        });

        $('.dropContent').mouseout(function()
        {
            $('.dropContent').hide();
            $('.sJsDropMenu').removeClass('is_already_open');
        });

        return false;
    });

});