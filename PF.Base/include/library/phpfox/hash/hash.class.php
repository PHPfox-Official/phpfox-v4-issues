<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Random Hash Creator
 * Creates a random hash for passwords as well as create a random hash for cookies were X will
 * always have a different hash value due to a random prefix.
 * 
 * Example to create a hashed password:
 * <code>
 * Phpfox::getLib('hash')->setHash('password', 'salt');
 * </code>
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: hash.class.php 6599 2013-09-06 08:18:37Z Miguel_Espinoza $
 */
class Phpfox_Hash
{
	/**
	 * Class constructor
	 *
	 */
	public function __construct()
	{			
	}
	
	/**
	 * Creates an MD5 hash with the password itself wrapped in MD5 as
	 * well as support for a random salt that is also wrapped in MD5
	 *
	 * @see md5()
	 * @param string $sPassword Password to create a hash for
	 * @param string $sSalt Optional random salt to make the hash unique
	 * @return string Returns a 32 character MD5 string
	 */
	public function setHash($sPassword, $sSalt = '')
	{
		if (!$sSalt)
		{
			$sSalt = Phpfox::getParam('core.salt');
		}
		if ($sPlugin = Phpfox_Plugin::get('hash_sethash__end')){eval($sPlugin);}

		return md5(md5($sPassword) . md5($sSalt));
	}
	
	/**
	 * Creates a random hash for a password that needs to be set in a public state, usually a session
	 * or a cookie
	 *
	 * @see sha1()
	 * @see md5()
	 * @param string $sPassword Password or information we need to create a hash for
	 * @return string Returns a sha1 string
	 */
	public function setRandomHash($sPassword)
	{
		if (Phpfox::getParam('core.use_custom_hash_salt'))
		{
			$sPassword = $sPassword . Phpfox::getParam('core.custom_hash_salt');
		}

	   	$sSeed = '';
		for ($i = 1; $i <= 10; $i++)
	   	{
	    	$sSeed .= substr('0123456789abcdef', rand(0, 15), 1);
		}

		return sha1($sSeed . md5($sPassword) . $sSeed) . $sSeed;
	}
	
	/**
	 * Verifies if the hash we created earlier with the method setRandomHash() matches.
	 *
	 * @see self::setRandomHash()
	 * @param string $sPassword Password or information we need to check with our stored hash
	 * @param string $sStoredValue Stored sha1 hash. Usually a cookie or session
	 * @return bool TRUE on success, FALSE on failure
	 */
	public function getRandomHash($sPassword, $sStoredValue)
	{
		if (Phpfox::getParam('core.use_custom_hash_salt'))
		{
			$sCustomSalt = Phpfox::getParam('core.custom_hash_salt');
			if (defined('PHPFOX_IS_FLASH_UPLOADER'))
			{
				$sCustomSalt = str_replace('Shockwave Flash', $_SERVER['HTTP_USER_AGENT'], $sCustomSalt);
			}
			$sPassword = $sPassword . $sCustomSalt;
		}

		if (strlen($sStoredValue) != 50)
		{
			return false;
		}

		$sStoredSeed = substr($sStoredValue, 40, 10);	   	
		
	   	if (sha1($sStoredSeed . md5($sPassword) . $sStoredSeed) . $sStoredSeed == $sStoredValue)
	   	{
	   		return true;
	   	}
	   	else
	   	{
			return false;
	   	}
	}	
}

?>
