<?php
if (Phpfox::getParam('facebook.enable_facebook_connect'))
{
	if (!empty($_REQUEST['facebook-process-login']))
	{	
		if (!empty($_REQUEST['code']))
		{
			switch ($_REQUEST['facebook-process-login'])
			{
				case 'sync-email':
					if ($oObject = Phpfox::getService('facebook')->get('me', Phpfox::getParam('core.path') . 'index.php?facebook-process-login=sync-email'))
					{
						if (isset($oObject->id))
						{
							Phpfox::getService('facebook.process')->syncAccounts($oObject->email, $oObject->id);
							
							$aUserCache = Phpfox::getService('facebook')->checkEmail($oObject->email);
							
							list($bIsLoggedIn, $aPostUserInfo) = Phpfox::getService('user.auth')->login($aUserCache['user_name'], null, false, 'user_name', true);
							
							if ($bIsLoggedIn)
							{
								Phpfox::getLib('url')->send(Phpfox::getParam('user.redirect_after_login'));	
							}
							else 
							{
								Phpfox::getLib('url')->send('facebook.account', array('type' => 'no-login'));
							}
						}
						else 
						{
							Phpfox::getLib('url')->send('facebook.account', array('type' => 'no-account'));
						}
					}					
					break;
				default:							
					if (!($oObject = Phpfox::getService('facebook')->get('me', Phpfox::getParam('core.path') . 'index.php?facebook-process-login=true')))
					{
						Phpfox::getLib('url')->send('facebook.account', array('type' => 'no-account'));	
					}
		
					if (isset($oObject->id))
					{
						$aUser = Phpfox::getService('facebook')->getUser($oObject->id);
						if (!isset($aUser['user_id']) && isset($oObject->email))
						{
							if ($aUserCache = Phpfox::getService('facebook')->checkEmail($oObject->email))
							{						
								if (isset($aUserCache['user_id']) && empty($aUserCache['fb_user_id']))
								{
									Phpfox::getLib('database')->insert(Phpfox::getT('fbconnect'), array('user_id' => $aUserCache['user_id'], 'fb_user_id' => (int) $oObject->id));
								}
								else
								{
									Phpfox::getLib('database')->update(Phpfox::getT('fbconnect'), array('is_unlinked' => 0), 'user_id = ' . (int) $aUserCache['user_id']);
								}
								
								list($bIsLoggedIn, $aPostUserInfo) = Phpfox::getService('user.auth')->login($aUserCache['user_name'], null, false, 'user_name', true);
								if ($bIsLoggedIn)
								{							
									Phpfox::getLib('url')->send(Phpfox::getParam('user.redirect_after_login'));	
								}																	
							}
						}
						
						if (isset($aUser['user_id']))
						{
							Phpfox::getLib('database')->update(Phpfox::getT('fbconnect'), array('is_unlinked' => 0), 'user_id = ' . (int) $aUser['user_id']);
							
							list($bIsLoggedIn, $aPostUserInfo) = Phpfox::getService('user.auth')->login($aUser['user_name'], null, false, 'user_name', true);
							if ($bIsLoggedIn)
							{						
								Phpfox::getLib('url')->send(Phpfox::getParam('user.redirect_after_login'));	
							}							
						}
						
						$aUserInfo = (array) $oObject;
				
						if (is_array($aUserInfo))
						{
							$aVals['full_name'] = $aUserInfo['name'];

							if (isset($aUserInfo['first_name']))
							{
								$aVals['first_name'] = $aUserInfo['first_name'];
							}
							if (isset($aUserInfo['last_name']))
							{
								$aVals['last_name'] = $aUserInfo['last_name'];
							}
							
							if (empty($aVals['full_name']))
							{
								Phpfox::getLib('url')->send('facebook.account', array('type' => 'full-name'));
							}					
							
							if (!empty($aUserInfo['link']))
							{
								if (preg_match('/http:\/\/(.*?)\.facebook\.com\/(.*)/i', $aUserInfo['link'], $aMatches) && isset($aMatches[2]))
								{
									$aVals['user_name'] = (substr($aMatches[2], 0, 11) == 'profile.php' ? $aUserInfo['id'] : $aMatches[2]);
								}			
							}							

							if (empty($aVals['user_name']))
							{
								$aVals['user_name'] = $aUserInfo['name'];
							}
							
							Phpfox::getService('user.validate')->email($aUserInfo['email']);					
							if (Phpfox_Error::get())
							{
								Phpfox::getLib('url')->send('facebook.account', array('type' => 'email'));
							}
							
							$aVals['user_name'] = Phpfox::getLib('parse.input')->prepareTitle('user', $aVals['user_name'], 'user_name', null, Phpfox::getT('user'));
							$aVals['email'] = $aUserInfo['email'];
							$aVals['password'] = md5($aUserInfo['id']);
							$aVals['gender'] = ($aUserInfo['gender'] == 'female' ? '2' : '1');
							$aVals['country_iso'] = null;	
							
							if (empty($aUserInfo['birthday']))
							{
								$aVals['day'] = '1';
								$aVals['month'] = '1';
								$aVals['year'] = '1982';
							}
							else 
							{
								$aParts = explode('/', $aUserInfo['birthday']);		
								$aVals['day'] = (isset($aParts[1]) ? $aParts[1] : '1');
								$aVals['month'] = (isset($aParts[0]) ? $aParts[0] : '1');
								$aVals['year'] = (isset($aParts[2]) ? $aParts[2] : '1982');
							}	
							
							if (!defined('PHPFOX_SKIP_EMAIL_INSERT'))
							{
								define('PHPFOX_SKIP_EMAIL_INSERT', true);
							}
							if (!defined('PHPFOX_IS_FB_USER'))
							{
								define('PHPFOX_IS_FB_USER', true);
							}						
							
							$iUserId = Phpfox::getService('user.process')->add($aVals);
							
							if ($iUserId === false)
							{
								Phpfox::getLib('url')->send('facebook.account', array('type' => 'no-account', 'error' => serialize(Phpfox_Error::get())));
							}
							else 
							{
								Phpfox::getService('facebook.process')->addUser($iUserId, $aUserInfo['id']);					
								
								$sImage = 'https://graph.facebook.com/me/picture?type=large&access_token=' . Phpfox::getService('facebook')->getToken();
								Phpfox::getLib('file')->writeToCache('fb_' . $iUserId . '_' . md5($sImage), file_get_contents($sImage));							
								$sNewImage = 'fb_' . $iUserId . '_' . md5($sImage) . '%s.jpg';
								copy(PHPFOX_DIR_CACHE . 'fb_' . $iUserId . '_' . md5($sImage), Phpfox::getParam('core.dir_user') . sprintf($sNewImage, ''));
								foreach(Phpfox::getParam('user.user_pic_sizes') as $iSize)
								{
									Phpfox::getLib('image')->createThumbnail(Phpfox::getParam('core.dir_user') . sprintf($sNewImage, ''), Phpfox::getParam('core.dir_user') . sprintf($sNewImage, '_' . $iSize), $iSize, $iSize);
									Phpfox::getLib('image')->createThumbnail(Phpfox::getParam('core.dir_user') . sprintf($sNewImage, ''), Phpfox::getParam('core.dir_user') . sprintf($sNewImage, '_' . $iSize . '_square'), $iSize, $iSize, false);
								}	
								unlink(PHPFOX_DIR_CACHE . 'fb_' . $iUserId . '_' . md5($sImage));
									
								$iServerId = 0;
								if (Phpfox::getParam('core.allow_cdn'))
								{
									$iServerId = Phpfox::getLib('cdn')->getServerId();
								}

								Phpfox::getLib('database')->update(Phpfox::getT('user'), array('user_image' => $sNewImage, 'server_id' => $iServerId), 'user_id = ' . (int) $iUserId);
								
								if (Phpfox::getService('user.auth')->login($aVals['user_name'], null, false, 'user_name', true))
								{
									Phpfox::getLib('url')->send('');	
								}
								else 
								{
									Phpfox::getLib('url')->send('facebook.account', array('type' => 'no-login'));
								}								
							}
						}
					}		
					
					exit;
					break;
			}
		}
	}
}
?>
