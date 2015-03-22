<?php
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: validator.sett.php 5840 2013-05-09 06:14:35Z Raymond_Benc $
 */

defined('PHPFOX') or exit('NO DICE!');

$this->_aDefaults = array(
	'username' => array(
		'pattern' => '/^[a-zA-Z0-9\- ]{' . Phpfox::getParam('user.min_length_for_username') . ',' . Phpfox::getParam('user.max_length_for_username') . '}$/',
		'title' => (defined('PHPFOX_INSTALLER') ? '' : Phpfox::getPhrase('user.provide_a_valid_user_name', array('min' => Phpfox::getParam('user.min_length_for_username'), 'max' => Phpfox::getParam('user.max_length_for_username'))))
		
	),
    'email' => array(
        'pattern' => '/^[0-9a-zA-Z]([\-+.\w]*[0-9a-zA-Z]?)*@([0-9a-zA-Z\-.\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,}$/',
        'maxlen' => 100,
        'title' => (defined('PHPFOX_INSTALLER') ? '' : Phpfox::getPhrase('user.provide_a_valid_email_address'))
    ),    
    'password' => array(
    	'minlen' => 4,
    	'maxlen' => 30,
    	'title' => (defined('PHPFOX_INSTALLER') ? '' : Phpfox::getPhrase('core.not_a_valid_password'))
    ),
    'url' => array(
       'pattern' => '/^(?:(ftp|http|https):)?(?:\/\/(?:((?:%[0-9a-f]{2}|[\-a-z0-9_.!~*\'\(\);:&=\+\$,])+)@)?(?:((?:[a-z0-9](?:[\-a-z0-9]*[a-z0-9])?\.)*[a-z](?:[\-a-z0-9]*[a-z0-9])?)|([0-9]{1,3}(?:\.[0-9]{1,3}){3}))(?::([0-9]*))?)?((?:\/(?:%[0-9a-f]{2}|[\-a-z0-9_.!~*\'\(\):@&=\+\$,;])+)+)?\/?(?:\?.*)?$/i',
       'maxlen'=> 255,
       'minlen'=> 11,
       'title' => (defined('PHPFOX_INSTALLER') ? '' : Phpfox::getPhrase('core.invalid_url'))
    ),
	'int' => array(
       'pattern' => '/^[0-9]$/',
       'title' => (defined('PHPFOX_INSTALLER') ? '' : Phpfox::getPhrase('core.provide_a_numerical_value'))
    ),
    'money' => array(
        'pattern'=>'/[0-9.,]$/',
        'title' => (defined('PHPFOX_INSTALLER') ? '' : Phpfox::getPhrase('core.provide_a_valid_price'))
    ),
    'year' => array(
    	'pattern' => '/^[0-9]{4}$/',
    	'title' => (defined('PHPFOX_INSTALLER') ? '' : Phpfox::getPhrase('core.provide_a_valid_year_eg_1982'))
    ),
    'zip'  => array(
        'pattern'=>'/^[a-zA-Z\d\-\s]{0,20}$/'
    )
);

?>
