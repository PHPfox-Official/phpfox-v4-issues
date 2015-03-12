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
 * @package  		Module_Admincp
 * @version 		$Id: index.class.php 2831 2011-08-12 19:44:19Z Raymond_Benc $
 */
class Admincp_Component_Controller_Checksum_Unknown extends Phpfox_Component {

	public function process() {

		$check = array();
		$lines = file(PHPFOX_DIR_INCLUDE . 'checksum/md5');
		foreach ($lines as $line) {
			$line = trim($line);
			$parts = explode(' ', $line);
			$check[trim($parts[1])] = true;
		}

		$unknown = array();
		$files = Phpfox::getLib('file')->getAllFiles(PHPFOX_DIR);
		foreach ($files as $file) {
			$file = str_replace(PHPFOX_DIR, '', $file);

			if (substr($file, -15) == 'server.sett.php'
				|| substr($file, 0, 5) == 'file/'
				|| substr($file, 0, 8) == 'install/'
				|| $file == '.DS_Store'
				|| $file == '.htaccess'
			) {
				continue;
			}

			if (!isset($check[$file])) {
				$unknown[] = $file;
			}
			// $check[str_replace(PHPFOX_DIR, '', $file)] = md5(file_get_contents($file));
			// echo $hash . " " . $file . "\n";
		}

		$this->template()->setTitle('Checking Unknown Files')
			->setBreadcrumb('Checking Unknown Files')
			->assign(array(
				'unknown' => $unknown,
				'total' => count($unknown)
			));
	}

}

?>