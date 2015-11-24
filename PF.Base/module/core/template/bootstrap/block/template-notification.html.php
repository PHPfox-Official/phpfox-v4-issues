<?php
/**
 * [PHPFOX_HEADER]
 *
 * @copyright        [PHPFOX_COPYRIGHT]
 * @author           Raymond_Benc
 * @package          Phpfox
 * @version          $Id: template-notification.html.php 2838 2011-08-16 19:09:21Z Raymond_Benc $
 */

defined('PHPFOX') or exit('NO DICE!');

?>
{if Phpfox::isUser()}
<nav class="pull-right">
    <ul class="list-inline header-right-menu">
        <li>
            {img user=$aGlobalUser suffix='_50_square'}
        </li>
        <li class="hidden-xs hidden-sm">
            <a href="{url link='profile'}" class="header-topbar-profile-link">
                {$aGlobalUser|user}
            </a>
        </li>
        <li>
            <a role="button"
               data-toggle="dropdown"
               data-panel="#request-panel-body"
               data-url="{url link='friend.panel'}">
                <i class="fa fa-user-plus"></i>
                <span id="js_total_new_friend_requests"></span>
            </a>
            <div class="dropdown-panel">
                <div class="dropdown-panel-body" id="request-panel-body"></div>
            </div>
        </li>
        <li>
            <a role="button"
               data-panel="#notification-panel-body"
               data-toggle="dropdown"
               data-url="{url link='notification.panel'}">
                <i class="fa fa-bell"></i>
                <span id="js_total_new_notifications"></span>
            </a>
            <div class="dropdown-panel">
                <div class="dropdown-panel-body" id="notification-panel-body"></div>
            </div>
        </li>
        <li>
            <a role="button"
               data-toggle="dropdown"
               data-panel="#message-panel-body"
               data-url="{url link='mail.panel'}">
                <i class="fa fa-envelope"></i>
                <span id="js_total_new_messages"></span>
            </a>
            <div class="dropdown-panel">
                <div class="dropdown-panel-body" id="message-panel-body"></div>
            </div>
        </li>
        <li>
            <a href="#"
               data-toggle="dropdown"
               class="dropdown-toggle"
               type="button"
               aria-haspopup="true"
               aria-expanded="false">
                <span class="fa fa-cog"></span>
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-right dont-unbind">
                <li role="presentation">
                    <a href="{url link='user.setting'}" class="no_ajax">
                        <i class="fa fa-cog"></i>
                        Account Settings
                    </a>
                </li>
                <li role="presentation">
                    <a href="{url link='user.profile'}" class="no_ajax">
                        <i class="fa fa-edit"></i>
                        Edit Profile
                    </a>
                </li>
                <li role="presentation">
                    <a href="{url link='friend'}" class="no_ajax">
                        <i class="fa fa-group"></i>
                        Manage Friends
                    </a>
                </li>
                <li role="presentation">
                    <a href="{url link='user.privacy'}" class="no_ajax">
                        <i class="fa fa-shield"></i>
                        Privacy Settings
                    </a>
                </li>
                {if Phpfox::isAdmin() }
                <li class="divider"></li>
                <li role="presentation">
                    <a href="{url link='admincp'}" class="no_ajax">
                        <i class="fa fa-diamond"></i>
                        AdminCP
                    </a>
                </li>
                {/if}
                <li class="divider"></li>
                <li role="presentation">
                    <a href="{url link='user.logout'}" class="no_ajax logout">
                        <i class="fa fa-toggle-off"></i>
                        Logout
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>
{else}
<div class="guest_login header-login-form hidden-xs pull-right">
    <form method="post" action="{url link='user.login'}" class="form-inline text-left">
        <div class="form-group">
            <label>Email</label>
            <input style="width: 180px"
                placeholder="{if Phpfox::getParam('user.login_type') == 'user_name'}{phrase var='user.user_name'}{elseif Phpfox::getParam('user.login_type') == 'email'}{phrase var='user.email'}{else}{phrase var='user.login'}{/if}"
                type="text" name="val[login]" id="js_email" value="" size="30" class="form-control" tabindex="1"/>
            <div>
                <a class="forgot_password" tabindex="-1" href="{url link='user.password.request'}">{phrase var='user.forgot_your_password'}</a>
            </div>

        </div>
        <div class="form-group">
            <label>Password</label>
            <input style="width: 180px" placeholder="{phrase var='user.password'}" type="password" name="val[password]" id="js_password"
                   value="" size="30" class="form-control" tabindex="2"/>
            <div class="">
                <label><input type="checkbox" name="val[remember_me]" value="" checked="checked" tabindex="3" /> {phrase var='user.keep_me_logged_in'}</label>
            </div>
        </div>
        <button class="btn btn-danger btn-sm" type="submit" tabindex="4"><i class="fa fa-sign-in"></i></button>
    </form>
</div>
<div class="visible-xs text-right">
    <a class="btn btn-sm btn-danger" role="link" href="{url link='login'}">
        <i class="fa fa-sign-in"></i> Login
    </a>
    <a class="btn btn-sm btn-info" role="link" href="{url link='user.register'}">
        Register
    </a>
</div>
{/if}