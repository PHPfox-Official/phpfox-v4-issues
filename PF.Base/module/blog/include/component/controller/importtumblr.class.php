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
class Blog_Component_Controller_ImportTumblr extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */

	public function process()
	{

		Phpfox::isUser(true);
		Phpfox::getUserParam('blog.can_import_blog',true);  //check if user able to access this page
		$bIsEdit = false;
		$sFlag= $this->request()->get('bFlag');
		$aVals = array();
		$bHasForm = true;
		$bCanEditPersonalData = true;
		$numOfItemProcessing = 100;
		$limit = Phpfox::getUserParam('blog.number_of_import_blogs');
		if($limit <0){
			$limit = 500;   // unlimited posts
		}
		$maximum = 500;   // maximum number blog to import
		if($this->request()->get('b_import'))
		{
			$sUsername = $this->request()->get('username');
			
			if($sUsername != "" )
			{
				if(isset($_SESSION['NUMBLOGSINSERTED'])){
					unset($_SESSION['NUMBLOGSINSERTED']);
				}
				$i = 0;
				$aPosts = array();
				$sFeed = '';
					
				do
				{
					$sUrl = 'http://'.$sUsername.'.tumblr.com/api/read?start='. $i . '&num=50';
					if (strpos($sUsername, ' ')){
						break;
					}
					$file_headers = @get_headers($sUrl);
					if($file_headers[0] == 'HTTP/1.1 404 Not Found'){
						break;
					}
					$oFile = file_get_contents($sUrl);
					if($oFile)
					{
						$sFeed = new SimpleXMLElement($oFile);
						$aPosts = array_merge($aPosts, $sFeed->xpath('posts//post'));
						$i = (int)$sFeed->posts->attributes()->start+50;
						if(($i >= $limit+100) ||($i >= $maximum + 100)){   // for being not able to upload video
							break;
						}
					}
						

				}while($i <= (int)$sFeed->posts["total"]);

				$aTitles = array();
				$aTimeStamps = array();
				$aTexts = array();
				$aTags = array();
				$bFlag1 = false;
				/*
				 * Change code line 85 by remove this character in the end "["
				 */

				$k = 0;
				foreach( $aPosts as $ePost )
				{
					$bHasForm = false;
					$bFlag1 = true;
					$sContent = '';
					$sTitle = '';
					switch($ePost->attributes()->type)
					{
						case "regular":
							$sTitle = htmlspecialchars($ePost->{'regular-title'});
							$sTxt  = $this->formatForPhpFox($ePost->{'regular-body'});
							$sTxt = str_replace(array(
                            '<br/>',
                            '<br>',
                            '<br />'  
                            ),
                            array(
                            '<p ></p>',
                           '<p></p>',
                           '<p></p>' 
                           ), $sTxt);
                           $sContent =  $sTxt;
                           break;
						case "photo":
							$sTitle = "Photos";
							$sContent   = "<img style=\"max-width: 700px\" src=".$ePost->{'photo-url'}." alt=''/><br/><br/>".$this->formatForPhpFox($ePost->{'photo-caption'})."";
							//$aTexts[] = "<img src=".$ePost->{'photo-url'}." alt=''/><br/><br/>".$this->formatForPhpFox($ePost->{'photo-caption'})."]";
							break;
						case "quote":
							$sTitle = htmlspecialchars(strip_tags($ePost->{'quote-text'}));
							$sContent = $ePost->{'quote-text'}."<br/>".$this->formatForPhpFox($ePost->{'quote-source'});
							break;
						case "link":
							$sTitle = htmlspecialchars(strip_tags($ePost->{'link-text'}));
							$sContent = "<a href='". $ePost->{'link-url'}."'>". $ePost->{'link-text'}."</a><br/>".$this->formatForPhpFox($ePost->{'link-description'});
							break;
						case "conversation":
							$sTitle = htmlspecialchars(strip_tags($ePost->{'conversation-title'}));
							$sContent = nl2br($ePost->{'conversation-text'});
							/*
							 $sTemp ='';
							 foreach($ePost->{'conversation-line'} as $line)
							 {
							 $sTemp .= "<strong>".$line->attributes()->label."</strong>".$line."<br/>";
							 }
							 $aTexts[] = $sTemp;
							 */
							break;
						case "video":
							$sTitle = strip_tags(preg_replace('/\(by <a href.*/', '', $ePost->{'video-caption'}));
							$sContent = nl2br($ePost->{'video-player'}[0]);
							break;
						default: break;
					}
					//tags
					$eTags = $ePost->tag ;
					$sTag = '';
					foreach ($eTags as $eTag){
						$sTag.= strval($eTag).', ';
					}

					// end for tags
					$iTimeStamp = strval($ePost->attributes()->{'unix-timestamp'});
					if($sContent != ''){
						$aTitles[]= $sTitle;
						$aTexts[] =$sContent;
						$aTimeStamps[] = $iTimeStamp;
						$aTags[] = $sTag;
						$k++;
					}
					if(($k >= $limit) || ($k >= $maximum )){
						break;
					}
				}

				if($bFlag1 == false){
					Phpfox_Error::set(Phpfox::getPhrase('blog.username_does_not_exist'));

				}
				else{
					$childAvals = array();
					$count = 0;
					if(!count($aTitles)){
						$sFlag = 'noblog';
					}
					for($i = 0; $i < count($aTitles); $i++){
						if(($i>=$limit) || ($i >=$maximum )){
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
						if($count ==$numOfItemProcessing||($i == count($aTitles)-1)){
							$aVals[] = base64_encode(json_encode($childAvals));
							$childAvals = array();
							$count = 0;
						}
						//	$bFlag = true;
					}

				}
			}
			else{
				Phpfox_Error::set(Phpfox::getPhrase('blog.please_enter_a_username'));
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
			$this->url()->send('blog.importtumblr', null, Phpfox::getPhrase('blog.there_is_no_any_blog_in_this_file_yet'));


		}

		$this->template()->assign(array('aItems' => $aVals, 'bHasForm' =>$bHasForm));

	}

	function formatForPhpFox($str)
	{
		$str = $this->formatVideoForPhpFox($this->formatImageForPhpFox($str));
		return $str;
	}

	function formatImageForPhpFox($str)
	{
		if(preg_match_all('/(<p>)?\s*(<img[^>]*\/?>)\s*(<\/p>)?/', $str, $matches))
		{
			for($i=0;$i<sizeof($matches[0]);$i++)
			{
				$str = str_replace($matches[0][$i], str_replace('/>',' alt=""/>', $matches[2][$i]), $str);
			}
		}
		return $str;
	}

	function formatVideoForPhpFox($str)
	{
		if(preg_match_all('/<object[\s\S]*src="([\S\s]*?)&amp;[\s\S]*"[\s\S]*<\/object>/', $str, $matches))
		{
			for($i=0;$i<sizeof($matches);$i++)
			{
				if((strpos($matches[1][$i], 'youtube.com') !== false))
				{
					$str = str_replace($matches[0][$i], '[youtube='.$matches[1][$i].']', $str);
				}
			}
		}
		return $str;
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
