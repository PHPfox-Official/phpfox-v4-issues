<?php 
class Blog_Component_Controller_Processimport extends Phpfox_Component{

	public function process(){
	 	$count = 0;
		if($aVals = $this->request()->get('aVals')){
			$aItems = json_decode((base64_decode($aVals)));
			foreach ($aItems as $oItem){
				if(Phpfox::getService('blog.import')->addImporter((array)$oItem)){
					 $count++	;
				}
			}
		}	
		if(!isset($_SESSION['NUMBLOGSINSERTED'])){
			$_SESSION['NUMBLOGSINSERTED'] = $count;
		}
		else{
			$_SESSION['NUMBLOGSINSERTED'] += $count;
		}
		
	} 
}
?>