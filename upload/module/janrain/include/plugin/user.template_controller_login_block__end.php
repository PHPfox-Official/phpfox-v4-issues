<?php 
    if (Phpfox::isModule('janrain') && Phpfox::getParam('janrain.enable_janrain_login')) 
    { 
        echo     '<div class="header_login_block"> 
                <a class="rpxnow" onclick="return false;" href="' 
                . Phpfox::getService('janrain')->getUrl() . '">'  
                . Phpfox::getLib('phpfox.image.helper')->display(array('theme' => 'layout/janrain-icons.png')) 
                . '</a> 
            </div>'; 
    } 
?>