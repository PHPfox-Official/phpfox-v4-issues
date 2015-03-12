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
 * @package  		Module_Blog
 * @version 		$Id: add.class.php 1522 2010-03-11 17:56:49Z Miguel_Espinoza $
 */
class Blog_Component_Controller_Admincp_Add extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		$aValidation = array(
			'name' => Phpfox::getPhrase('blog.provide_blog_category')
		);		
		
		$oValid = Phpfox::getLib('validator')->set(array('sFormName' => 'js_form', 'aParams' => $aValidation));	

		if ($aVals = $this->request()->getArray('val'))
		{			
			if ($oValid->isValid($aVals))
			{
				if (Phpfox::getService('blog.category.process')->add($aVals['name'], '0'))
				{
					$this->url()->send('admincp.blog.add', null, Phpfox::getPhrase('blog.category_successfully_added'));
				}
			}
		}		
		
		$this->template()->setTitle(Phpfox::getPhrase('blog.add_category'))
			->setBreadCrumb(Phpfox::getPhrase('blog.add_category'), $this->url()->makeUrl('admincp.blog'))
			->assign(array(			
				'sCreateJs' => $oValid->createJS(),
				'sGetJsForm' => $oValid->getJsForm()
			)
		);		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('blog.component_controller_admincp_add_clean')) ? eval($sPlugin) : false);
	}
}

?>