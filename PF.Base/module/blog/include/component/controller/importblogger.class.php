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
class Blog_Component_Controller_ImportBlogger extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::getUserParam('blog.can_import_blog',true);  //check if user able to access this page
		Phpfox::isUser(true);
		$bIsEdit = false;
		$bHasForm = true;
		$bCanEditPersonalData = true;
		$aVals = array();
		$sFlag= $this->request()->get('bFlag');  $k=1;
		if($this->request()->get('b_import'))
		{
			$sFile = Phpfox::getService('blog.import')->uploadXML(Phpfox::getUserId());
			if($sFile != "")
			{
				if(isset($_SESSION['NUMBLOGSINSERTED']))
				{
					unset($_SESSION['NUMBLOGSINSERTED']);
				}
					
				$oDoc = new DOMDocument();
				@$oDoc->load($sFile,LIBXML_NOERROR);
				$aTitles = array();
				$aTags = array();
				$aTexts = array();
				$bFlag1 = false;
				$eEntrys = @$oDoc->getElementsByTagName("entry");
					
				$aTimeStamps = array();

				foreach( $eEntrys as $eEntry )
				{
					$bHasForm = false;
					$bFlag1 = true;
					$eCategories = $eEntry->getElementsByTagName("category");
					$eTitles = $eEntry->getElementsByTagName("title");
					$sTitle = $eTitles->item(0)->nodeValue;
					$sTag = '';
					foreach ( $eCategories as $eCategory){
						$sTerm = $eCategory->getAttribute('term');
						if(!strpos($sTerm,'kind#'))
						{
							$sTag.= $eCategory->getAttribute('term').',';
						}
						if(strpos($sTerm,'kind#post'))
						{
							//getcontent
							$eContents = $eEntry->getElementsByTagName("content");
							$sContent = $eContents->item(0)->nodeValue;

						}
					}

					preg_match('/(\d{4})-(\d{1,2})-(\d{1,2}).*?(\d{1,2}):(\d{1,2}):(\d{1,2}).*?/i', $eEntry->getElementsByTagName("published")->item(0)->nodeValue, $matches);
					if(!empty($matches[6]))
					{
						$iTimeStamp = strtotime($matches[1] . '-' . $matches[2] . '-' . $matches[3] . ' ' . $matches[4] . ':' . $matches[5] . ':' . $matches[6]);
					}
					else
					{
						$iTimeStamp = PHPFOX_TIME;
					}
					/*	while(in_array($iTimeStamp, $aTimeStamps))
					 {
					 $iTimeStamp++;
					 }
					 */
					if(isset($sContent) && $sContent != "")
					{
						//get title
						$aTitles[] = $sTitle;
						$aTexts[] = $sContent;
						$aTags[] = $sTag;
						$aTimeStamps[] = $iTimeStamp;
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
						//var_dump(++$k.'. '.date('Y-m-d H:i:s',$aTimeStamps[$i]));
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
			};

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
			$this->url()->send('blog.importblogger', null, Phpfox::getPhrase('blog.there_is_no_any_blog_in_this_file_yet'));


		}
		$this->template()->assign(array('aItems' => $aVals, 'bHasForm' =>$bHasForm));
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
