<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox_Component
 * @version 		$Id: backup.class.php 1268 2009-11-23 20:45:36Z Raymond_Benc $
 */
class Admincp_Component_Controller_Sql_Backup extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
        $bCanBackup = Phpfox::getLib('database')->canBackup();    
        $sDefaultPath = PHPFOX_DIR_FILE . 'log' . PHPFOX_DS;   
        
        if (($sPath = $this->request()->get('path')) && $bCanBackup)
        {
        	if (($sBackupPath = Phpfox::getLib('database')->backup($sPath)))
        	{
        		$this->url()->send('admincp.sql.backup', null, Phpfox::getPhrase('admincp.sql_backup_successfully_created_and_can_be_downloaded_here_path', array('path' => $sBackupPath)));	
        	}
        }
		
		$this->template()->setTitle(Phpfox::getPhrase('admincp.sql_maintenance_title'))
        	->setBreadcrumb(Phpfox::getPhrase('admincp.sql_maintenance_title'), $this->url()->makeUrl('admincp.sql'))
        	->setBreadcrumb(Phpfox::getPhrase('admincp.backup'), null, true)
        	->assign(array(
        		'bCanBackup' => $bCanBackup,
        		'sDefaultPath' => $sDefaultPath
        	)
        );		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('admincp.component_controller_sql_backup_clean')) ? eval($sPlugin) : false);
	}
}

?>