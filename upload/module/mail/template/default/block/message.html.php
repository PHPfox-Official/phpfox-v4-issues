<?php
/**
 * [PHPFOX_HEADER]
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel_Espinoza
 * @package  		Module_Mail
 * @version 		$Id: folder.html.php 629 2009-06-02 15:01:42Z Miguel_Espinoza $
 */

defined('PHPFOX') or exit('NO DICE!');

?>
{if !Phpfox::getParam('mail.threaded_mail_conversation')}
{$aMessage.text|parse}
{else}
{foreach from=$aMessage name=messages item=aMail}
{template file='mail.block.entry'}
{/foreach}
{/if}