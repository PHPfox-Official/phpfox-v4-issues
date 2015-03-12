<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: foxporter.class.php 5074 2012-12-06 10:37:26Z Raymond_Benc $
 */
class FoxporterModule_Ning extends Foxporter_Abstract
{	
	protected $_aDetails = array(
		'name' => 'Ning',
		'description' => 'Module that will import all your Ning users via a CSV file. Emails will be sent out to users with their new passwords once completed.',
		'link' => 'http://www.ning.com/'
	);
	
	protected $_aSteps = array(
		'setup' => array(
			'phrase' => 'System Check',
			'method' => 'check'
		),
		'import-users' => array(
			'phrase' => 'Users',
			'method' => 'importUsers'
		),
		'completed' => array(
			'phrase' => 'Completed',
			'method' => 'completed'
		)				
	);	
	
	public function check()
	{
		$sCsvFile = PHPFOX_DIR_LIB . 'foxporter' . PHPFOX_DS . 'module' . PHPFOX_DS . 'ning' . PHPFOX_DS . 'memberdata.csv';
		if (!file_exists($sCsvFile))
		{
			return array(
				'phrase' => '<div class="error_message">We are missing the Ning CSV export of your members.</div> Make sure this file ends up here: <br /> ' . $sCsvFile,
				'next' => false
			);			
		}
		else 
		{
			return array(
				'phrase' => 'Checking for CSV file... Done!',
				'next' => 'import-users'
			);
		}
	}
	
	public function importUsers()
	{
		$sCsvFile = PHPFOX_DIR_LIB . 'foxporter' . PHPFOX_DS . 'module' . PHPFOX_DS . 'ning' . PHPFOX_DS . 'memberdata.csv';	
		$iCnt = 0;
		$hFile = fopen($sCsvFile, 'r');
		while ($aData = fgetcsv($hFile))
		{
			$iCnt++;
			if ($iCnt == 1)
			{
				continue;
			}
			// d($aData);
			
			$aBirthdates = explode('-', $aData[8]);
			
			$aInsert = array(
				'full_name' => $aData[0],
				'email' => $aData[2]
			);
			
			if (!empty($aData[8]))
			{
				$aBirthdates = explode('-', $aData[8]);
				
				$aInsert['birth_year'] = $aBirthdates[0];
				$aInsert['birth_month'] = $aBirthdates[1];
				$aInsert['birth_day'] = $aBirthdates[2];
			}
			
			if (!empty($aData[3]))
			{
				$aInsert['gender'] = $aData[3];
			}			
			
			if (!empty($aData[5]))
			{
				$aInsert['country'] = $aData[5];
			}
			
			if (!empty($aData[4]))
			{
				$aLocationParts = explode(',', $aData[4]);
				$aInsert['city'] = trim($aLocationParts[0]);
				if (isset($aLocationParts[1]))
				{
					$aInsert['state'] = trim($aLocationParts[1]);
				}
			}
			
			if (!empty($aData[9]))
			{
				$aSignUp = explode('-', $aData[9]);		
				$aInsert['joined'] = mktime(0, 0, 0, $aSignUp[2], $aSignUp[2], $aSignUp[0]);
			}
			
			$aUser = $this->addUser($aInsert);
			if (is_array($aUser))
			{
				Phpfox::getLib('mail')->to($aData[2])
					->messageHeader(false)
					->subject('Commmunity Update')
					->message("We have updated our community at: <a href=\"" . Phpfox::getLib('url')->makeUrl('') . "\">" . Phpfox::getLib('url')->makeUrl('') . "</a>\n\nNote we have provided your new login details below...\n#######\n\n\n\n\nEmail: " . $aData[2] . "\nPassword: " . $aUser['password'] . "\n")
					->send();						
			}
		}
		fclose($hFile);
		
		return array(
			'phrase' => 'Importing users... Done!',
			'next' => 'completed'
		);		
	}
	
	public function completed()
	{
		return array(
			'phrase' => 'Import of your Ning users has successfully been completed.',
			'completed' => true
		);			
	}
}

?>