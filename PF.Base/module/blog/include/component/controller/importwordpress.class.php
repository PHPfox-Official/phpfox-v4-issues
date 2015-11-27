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
 * @version 		$Id: add.class.php 1601 2010-05-30 05:20:59Z Raymond_Benc $
 */
class Blog_Component_Controller_ImportWordPress extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('blog.can_import_blog',true);  //check if user able to access this page
		$bIsEdit = false;
		$bHasForm = true;
		$bCanEditPersonalData = true;
		$aVals = array();
		$sFlag= $this->request()->get('bFlag');
		//{
		//	$bFlag =$this->request()->get('bFlag'); var_dump($bFlag);
		//}
		if($this->request()->get('b_import')){
				
			$sFile = Phpfox::getService('blog.import')->uploadXML(Phpfox::getUserId());
			if($sFile != ""){
				if(isset($_SESSION['NUMBLOGSINSERTED'])){
					unset($_SESSION['NUMBLOGSINSERTED']);
				}
				$oDoc = new DOMDocument();
				@$oDoc->load($sFile,LIBXML_NOERROR);
				$eChanels = @$oDoc->getElementsByTagName("channel");
				$aTimeStamps = array();
				$aTitles = array();
				$aTexts = array();
				$aTags = array();
					
				$bFlag1 = false;
				$num = $eChanels->length;
				if($num>0)
				foreach( $eChanels as $eChannel ){
					
					
					$eItemss = $eChannel->getElementsByTagName( "item" );
					$num = $eItemss->length;
					// var_dump($eItemss, $num);exit;
					if($num>0) {
						foreach( $eItemss as $eItems ){
							$bFlag1 = true;
							$bHasForm =false;
							//getcontent
							$eContents = $eItems->getElementsByTagName("encoded");
							$sContent = $eContents->item(0)->nodeValue;
							$eTags = $eItems->getElementsByTagName("category");

							$sTag = '';
							$num = $eTags->length;
							if($num>0)
							foreach ($eTags as $eTag){
								if($eTag->getAttribute('domain') == 'post_tag'){
									$sTag.= ','.$eTag->nodeValue;
								}

							}
							if($sContent != ""){
								//get title
								$eTitles = $eItems->getElementsByTagName("title");
								$sTitle = $eTitles->item(0)->nodeValue;
								$iTimeStamp = strtotime($eItems->getElementsByTagName("pubDate")->item(0)->nodeValue);

								$aTitles[] = $sTitle;
								$aTexts[] = $sContent;
								$aTimeStamps[] = $iTimeStamp;
								$aTags[] = $sTag;

							}

							//	while(in_array($iTimeStamp, $aTimeStamps)){   not understand this one
							//	$iTimeStamp++;
							//	}

						}
					}
				}
				if($bFlag1 == false){
					Phpfox_Error::set( Phpfox::getPhrase('blog.invalid_file'));
				}
				else{
					$childAvals = array();
					$count = 0;
					$numOfItemProcessing = 200;
					$limit = Phpfox::getUserParam('blog.number_of_import_blogs');
					if(!count($aTitles)){
						$sFlag = 'noblog';
					}
					for($i = 0; $i < count($aTitles); $i++){
						if(($limit>=0) &&($i>=$limit)){
							$aVals[] = base64_encode(json_encode($childAvals));
							break;
						}
						$aVal['title'] = $aTitles[$i];
						$aVal['text'] = $aTexts[$i];
						$aVal['time_stamp'] = $aTimeStamps[$i];
						$aVal['tag_list'] = $aTags[$i];
						$childAvals[] = $aVal;
						//	Phpfox::getService('blog.import')->addImporter($aVal);
						$count++;
						if($count ==$numOfItemProcessing||($i==count($aTitles)-1)){
							$aVals[] = base64_encode(json_encode($childAvals));
							$childAvals = array();
							$count = 0;
						}
						//	$bFlag = true;
					}
			}
		}
	}

	if(($sFlag == "success")){
		$aRow = Phpfox::getLib('phpfox.database')->select('user_name')
		->from(Phpfox::getT('user'))
		->where('user_id = '.Phpfox::getUserId())
		->execute('getRow');
		$sUserName = $aRow['user_name'];

		if(isset($_SESSION['NUMBLOGSINSERTED'])	){
			$iNum = (int)$_SESSION['NUMBLOGSINSERTED'];

			$sMessage = '';
			if($iNum <= 1){
				$sMessage = $iNum.' '.Phpfox::getPhrase('blog.blog_has_been_inserted');
			}
			else{
				$sMessage = $iNum.' '.Phpfox::getPhrase('blog.blog_s_have_been_inserted');
			}
			$this->url()->send($sUserName.'.blog', null, Phpfox::getPhrase('blog.import_sucessfully').$sMessage);
		}
		else{
			Phpfox_Error::set('Error found');
		}
	}
	else if($sFlag == "noblog"){
		$this->url()->send('blog.importwordpress', null, Phpfox::getPhrase('blog.there_is_no_any_blog_in_this_file_yet'));
	}

	$this->template()->assign(array('aItems' => $aVals, 'bHasForm' =>$bHasForm));
}

public function prepareSql($sql, $aVal){
	if($sql == ""){
		$sql = "INSERT INTO `phpfox_blog` (`blog_id`, `user_id`, `title`, `time_stamp`, `time_update`, `is_approved`, `privacy`, `privacy_comment`, `post_status`, `total_comment`, `total_attachment`, `total_view`, `total_like`) VALUES";
	}
	if(empty($aVal)){
		return $sql;
	}




}

/**
 * Garbage collector. Is executed after this class has completed
 * its job and the template has also been displayed.
 */
public function clean()
{
	(($sPlugin = Phpfox_Plugin::get('blog.component_controller_import_clean')) ? eval($sPlugin) : false);
}
}

?>
