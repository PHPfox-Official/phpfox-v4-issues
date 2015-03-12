<?php
if (Phpfox::getParam('janrain.enable_janrain_login'))
{
	echo "


<script type=\"text/javascript\">
(function() {
    if (typeof window.janrain !== 'object') window.janrain = {};
    if (typeof window.janrain.settings !== 'object') window.janrain.settings = {};
    
    janrain.settings.tokenUrl = '" . Phpfox::getLib('url')->makeUrl('janrain.rpx') . "';

    function isReady() { janrain.ready = true; };
    if (document.addEventListener) {
      document.addEventListener(\"DOMContentLoaded\", isReady, false);
    } else {
      window.attachEvent('onload', isReady);
    }

    var e = document.createElement('script');
    e.type = 'text/javascript';
    e.id = 'janrainAuthWidget';

    if (document.location.protocol === 'https:') {
      e.src = 'https://rpxnow.com/js/lib/" . Phpfox::getService('janrain')->getName() . "/engage.js';
    } else {
      e.src = 'http://widget-cdn.rpxnow.com/js/lib/" . Phpfox::getService('janrain')->getName() . "/engage.js';
    }

    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(e, s);
})();
</script>

			
			
			";
}
?>