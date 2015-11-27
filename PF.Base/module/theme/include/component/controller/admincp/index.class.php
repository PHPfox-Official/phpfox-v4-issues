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
 * @package  		Module_Theme
 * @version 		$Id: index.class.php 1179 2009-10-12 13:56:40Z Raymond_Benc $
 */
class Theme_Component_Controller_Admincp_Index extends Phpfox_Component {
	public function process()
	{
		if (($iDeleteId = $this->request()->getInt('delete')))
		{
			if (Phpfox::getService('theme.process')->delete($iDeleteId))
			{
				$this->url()->send('admincp.theme', null, Phpfox::getPhrase('theme.theme_successfully_deleted'));
			}
		}

		$themes = [];
		$default = [];
		$rows = $this->template()->theme()->all();
		foreach ($rows as $row) {
			if ($row->is_default) {
				$default = $row;

				continue;
			}

			$themes[] = $row;
		}

		if ($default) {
			$themes = array_merge([$default], $themes);
		}

		$Home = new Core\Home(PHPFOX_LICENSE_ID, PHPFOX_LICENSE_KEY);
		$products = $Home->downloads(['type' => 2]);
		$newInstalls = [];
		if (is_object($products)) {
			foreach ($products as $product) {
				foreach ($themes as $theme) {
					if (isset($theme->internal_id) && isset($product->id) && $theme->internal_id == $product->id) {
						continue 2;
					}
				}

				$newInstalls[] = (array) $product;
			}
		}

		$this->template()->setTitle(Phpfox::getPhrase('theme.themes'))
			->setSectionTitle('Themes')
			->setActionMenu([
				'New Theme' => [
						'url' => $this->url()->makeUrl('admincp.theme.add'),
						'class' => 'popup light'
					],
				'Find More Themes' => [
					'url' => $this->url()->makeUrl('admincp.store', ['load' => 'themes']),
					'class' => ''
				]
			])
			->setBreadcrumb(Phpfox::getPhrase('theme.themes'), $this->url()->makeUrl('admincp.theme'))
			->assign(array(
					'newInstalls' => $newInstalls,
					'themes' => $themes
				)
			);
	}
}