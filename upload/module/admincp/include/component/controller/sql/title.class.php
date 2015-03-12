<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox_Component
 * @version 		$Id: title.class.php 4520 2012-07-18 14:08:39Z Miguel_Espinoza $
 */
class Admincp_Component_Controller_Sql_Title extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if ($this->request()->get('update'))
		{
			$aModules = Phpfox::massCallback('getSqlTitleField');
			$aParseTables = array();
			if (is_array($aModules) && count($aModules))
			{
				foreach ($aModules as $aModule)
				{
					if (isset($aModule['table']))
					{
						$aModule = array($aModule);	
					}
					
					foreach ($aModule as $aInfo)
					{
						$aParseTables[] = $aInfo;	
					}
				}
			}
			$oDb = Phpfox::getLib('database');
			foreach ($aParseTables as $aParseTable)
			{				
				if (isset($aParseTable['has_index']))
				{
					$aIndexes = Phpfox::getLib('database.support')->getIndexes(Phpfox::getT($aParseTable['table']), null, $oDb, true);
					
					foreach ($aIndexes as $aIndex)
					{
						if ($aIndex['Column_name'] == $aParseTable['has_index'])
						{
							$oDb->query('ALTER TABLE ' . Phpfox::getT($aParseTable['table']) .' DROP INDEX ' . $aIndex['Key_name']);
						}
					}
				}
				
				Phpfox::getLib('database')->query('ALTER TABLE ' . Phpfox::getT($aParseTable['table']) . ' CHANGE ' . $aParseTable['field'] . ' ' . $aParseTable['field'] . ' text');				
			}
			
			$this->url()->send('admincp.sql.title', null, Phpfox::getPhrase('admincp.database_tables_updated'));
		}
		
		$this->template()->setTitle(Phpfox::getPhrase('admincp.alter_title_fields'))
			->setBreadcrumb(Phpfox::getPhrase('admincp.alter_title_fields'))
			->assign(array(
					
				)
			);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('admincp.component_controller_sql_title_clean')) ? eval($sPlugin) : false);
	}
}

?>