<?php
    if(Phpfox::isModule('facebook') && Phpfox::getParam('facebook.enable_facebook_connect'))
    {
        echo '<div class="header_login_block">
                    <fb:login-button scope="publish_stream,email,user_birthday" v="2"></fb:login-button>
              </div>';
    }
?>