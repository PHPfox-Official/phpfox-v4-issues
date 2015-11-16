<?php
class Blog_Component_Controller_Admincp_Installer extends Phpfox_Component{

	public function process(){

		$sAction = $this->request()->get('req4');
		$sFlag = $this->request()->get('flag');
		if ($sFlag == ''){
			if($sAction == 'install'){
				$oInstaller =Phpfox::getService('blog.import');
				if ($oInstaller->uninstall() && $oInstaller->install()){
					$this->clearCache("file/cache");
					$this->clearCache("file/gzip");
					$this->url()->send('admincp.blog.installer.install'.'/flag_success1');
				}
				else{
					Phpfox_Error::set('The module blog importer cannot installed, please try again');
				}
			}
			elseif ($sAction == 'uninstall2'){
				if (Phpfox::getService('blog.import')->uninstall()){
					$this->clearCache("file/cache");
					$this->clearCache("file/gzip");
					$this->url()->send('admincp.blog.installer.uninstall'.'/flag_success2');
				}
				else{
					Phpfox_Error::set('The module blog importer cannot uninstalled, please try again');
				}
			}
			elseif ($sAction == 'uninstall'){
				
			}
			else{
				$this->url()->send('subcribe');
			}
		}
		elseif($sFlag =='success1'){
			$this->url()->send('admincp.blog.installer.install'.'/flag_success',null,'Congratulation ! The module blog importer v3.02p2 has been installed successfully');
		}
		elseif($sFlag =='success2'){
			$this->url()->send('admincp.blog.installer.uninstall'.'/flag_success',null,'Uninstall blog importer v3.02p3 done !');
				
		}
	
		$this->template()->assign(array('sAction' => $sAction, 'sFlag' => $sFlag ))
			 ->setBreadCrumb(Phpfox::getPhrase('blog.blog'), $this->url()->makeUrl('admincp.blog'));


	}

	function clearCache($dir) {
		return phpfox::getLib('cache')->remove();
		//echo sprintf("%s<br/>\n", $dir);
		if (is_dir($dir)) {
			$objects = scandir($dir);
			foreach ($objects as $object) {
				if ($object != "." && $object != "..") {
					if (filetype($dir."/".$object) == "dir")
					$this->clearCache($dir."/".$object);
					else
					unlink($dir."/".$object);
				}
			}
			reset($objects);
			rmdir($dir);
		}
	}


}
?>