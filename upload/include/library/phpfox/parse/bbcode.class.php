<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * BBCode Parser
 * This class parses common BBCode into HTML. This class is fully part of the parsing
 * system we have in place when parsing incoming data before entering it into the database.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: bbcode.class.php 7298 2014-05-06 15:35:55Z Fern $
 */
class Phpfox_Parse_Bbcode
{	
	/**
	 * List of parsing rules to convert BBCOde into HTML.
	 *
	 * @var array
	 */
	private $_aDefault = array(
		'b' => array(			
			'prefix' => '<b>',			
			'suffix' => '</b>'
		),
		'i' => array(			
			'prefix' => '<i>',			
			'suffix' => '</i>'
		),
		'link' => array(
			'prefix' => '<a href="{option}" target="_blank" rel="nofollow">',
			'suffix' => '</a>'
		),
		'strong' => array(
			'prefix' => '<strong>',			
			'suffix' => '</strong>'			
		),
		'u' => array(
			'prefix' => '<u>',			
			'suffix' => '</u>'			
		),
		'color' => array(
			'prefix' => '<span style="color:{option};">',			
			'suffix' => '</span>'			
		),
		'em' => array(
			'prefix' => '<em>',			
			'suffix' => '</em>'			
		),
		'email' => array(
			'prefix' => '<a href="mailto:{option}">',			
			'suffix' => '</a>'			
		),
		'size' => array(
			'prefix' => '<font size="{option}">',			
			'suffix' => '</font>'			
		),	
		'center' => array(
			'prefix' => '<div style="text-align:center;">',			
			'suffix' => '</div>'			
		),	
		'align' => array(
			'prefix' => '<div style="text-align:{option};">',			
			'suffix' => '</div>'			
		),	
		'left' => array(
			'prefix' => '<div style="text-align:left;">',			
			'suffix' => '</div>'			
		),
		'right' => array(
			'prefix' => '<div style="text-align:right;">',			
			'suffix' => '</div>'			
		),
		'ul' => array(
			'prefix' => '<ul>',			
			'suffix' => '</ul>'			
		),		
		'ol' => array(
			'prefix' => '<ol>',			
			'suffix' => '</ol>'			
		),	
		'li' => array(
			'prefix' => '<li>',			
			'suffix' => '</li>'			
		),	
		'br' => array(
			'prefix' => '<br />',			
			'suffix' => ''			
		),			
		'hr' => array(
			'prefix' => '<hr />',			
			'suffix' => ''			
		)
	);
	
	/**
	 * Holds an ARRAY of CODE. (eg. [php], [html], [code])
	 *
	 * @var array
	 */
	private $_aCodes = array();
	
	/**
	 * Array of attachments we are going to pull from the db a little later.
	 * Reason we place this into an array is so we don't run a query for each attachment.
	 *
	 * @var array Array of attachments
	 */
	private $_aAttachments = array();
	
	/**
	 * ARRAY of all the video BBCode calls.
	 *
	 * @var array
	 */
	private $_aVideos = array();
	
	/**
	 * ARRAY of all the user BBCode calls.
	 *
	 * @var array
	 */
	private $_aUsers = array();
	
	/**
	 * Identify if we should use the videos image instead of loading the actual video
	 * when replacing the video BBCode.
	 *
	 * @var bool
	 */
	private $_bUseVideoImage = false;
	
	/**
	 * ARRAY of the strings height in pixels.
	 *
	 * @var array
	 */
	private $_aBlockHeight = array();
	
	/**
	 * Class constructor is used to load any hooks developers have
	 * in case they want to extend BBCode support.
	 *
	 */	
	public function __construct()
	{		
		(($sPlugin = Phpfox_Plugin::get('parse_bbcode_construct')) ? eval($sPlugin) : false);
	}
	
	/**
	 * Run the first round of parsing of CODE related BBCode since we need to save them in memory.
	 *
	 * @param string $sTxt String we need to parse.
	 * @return string Parsed string.
	 */
	public function preParse($sTxt)
	{		
		$sTxt = preg_replace("/\[php\](.*?)\[\/php\]/ise","''.stripslashes(\$this->_code('$1', 'php')).''", $sTxt);
		$sTxt = preg_replace("/\[code\](.*?)\[\/code\]/ise","''.stripslashes(\$this->_code('$1', 'code')).''", $sTxt);
		$sTxt = preg_replace("/\[html\](.*?)\[\/html\]/ise","''.stripslashes(\$this->_code('$1', 'html')).''", $sTxt);	
		
		(($sPlugin = Phpfox_Plugin::get('parse_bbcode_preparse_end')) ? eval($sPlugin) : false);	
		
		return $sTxt;
	}	
	
	/**
	 * Identify if we should use the videos image instead of loading the actual video
	 * when replacing the video BBCode.
	 *
	 * @param bool Set to TRUE if we should use the videos image instead of loading the actual video when replacing the video BBCode.
	 * @return object Return this class.
	 */	
	public function useVideoImage($bUseVideoImage)
	{
		$this->_bUseVideoImage = $bUseVideoImage;
		
		return $this;
	}	
	
	/**
	* Removes text used for tags: [x=32]Name Lastname[/x]
	*/
	public function removeTagText($sTxt)
	{		
		preg_match_all('/(\[x=[0-9]*\])(.+?)(\[\/x\])/is', $sTxt, $aMatches);
		
		foreach ($aMatches[0] as $iKey => $sOriginalMatch)
		{
			$sTxt = str_replace($sOriginalMatch, $aMatches[2][$iKey], $sTxt);
		}
		
		return $sTxt;
	}
	
	/**
	 * 2nd run to parse BBCode into HTML. This is the final run and after this all BBCode will
	 * have been converted into HTML.
	 *
	 * @param string $sTxt String to parse.
	 * @return string Fully parsed string and we know have the final HTML output.
	 */
	public function parse($sTxt)
	{
		foreach ($this->_aDefault as $sBbcode => $mValue)
		{		
			$sTxt = preg_replace("/\[" . $sBbcode . "\]/ise", "''.\$this->_replaceBbCode('' . \$sBbcode . '').''", $sTxt);
			$sTxt = preg_replace("/\[\/" . $sBbcode . "\]/ise", "''.\$this->_replaceBbCode('' . \$sBbcode . '', 'suffix').''", $sTxt);
			$sTxt = preg_replace("/\[" . $sBbcode . "=(.*?)\]/ise", "''.\$this->_replaceBbCode('' . \$sBbcode . '', 'prefix', true, '$1').''", $sTxt);
		}
		
		$sTxt = preg_replace("/\[table=(.*?)\](.*?)\[\/table\]/ise", "''.\$this->_parseTable('$1','$2').''", $sTxt);
		$sTxt = preg_replace("/\[user\](.+?)\[\/user\]/ise", "''.stripslashes(\$this->_parseMember('user', '$1')).''", $sTxt);
		$sTxt = preg_replace("/\[profile\](.+?)\[\/profile\]/ise", "''.stripslashes(\$this->_parseMember('profile', '$1')).''", $sTxt);
		
		if (preg_match_all("/\[quote(.*?)\]/i", $sTxt, $aSample) && isset($aSample[0]))
		{		
			for ($i = 0; $i < count($aSample[0]); $i++)
			{		
				$sTxt = preg_replace("/\[quote(.*?)\](.*?)\[\/quote\]/ise","''.stripslashes(\$this->_quote('$1','$2')).''", $sTxt);				
			}
		}
		
		$sTxt = preg_replace("/\[img\](.*?)\[\/img\]/ise","''.stripslashes(\$this->_image('$1')).''", $sTxt);
		
		$sTxt = $this->preParse($sTxt);
		
		// Attachments
		$sTxt = preg_replace("/\[attachment(.*?)\](.*?)\[\/attachment\]/ise","''.stripslashes(\$this->_attachment('$1', '$2')).''", $sTxt);
		// $sTxt = preg_replace("/<a href=\"(.*?)\" attachment=\"(.*?)\">/ise","'<a href=\"' . preg_replace('/(_thumb|_view)/i', '', '$1') . '\" '.stripslashes(\$this->_attachment('$2')).'>'", $sTxt);			
		if (count($this->_aAttachments))
		{
			$this->_aAttachments = Phpfox::getService('attachment')->verify(implode(',', $this->_aAttachments));			
		}		
		$sTxt = preg_replace("/\[attachment(.*?)\](.*?)\[\/attachment\]/ise","''.stripslashes(\$this->_parseAttachment('$1', '$2')).''", $sTxt);	
	//	$sTxt = preg_replace("/<a href=\"(.*?)\" attachment=\"(.*?)\">/ise","'<a href=\"\\1\" '.stripslashes(\$this->_parseAttachment('$2')).'>'", $sTxt);				
		$this->_aAttachments = array();
		
		$sTxt = preg_replace("/\[video\](.*?)\[\/video\]/ise","''.stripslashes(\$this->_video('$1')).''", $sTxt);
		if (count($this->_aVideos))
		{
			$this->_aVideos = Phpfox::getService('video')->verify(implode(',', $this->_aVideos), $this->_bUseVideoImage);
		}		
		$sTxt = preg_replace("/\[video\](.*?)\[\/video\]/ise","''.stripslashes(\$this->_parseVideo('$1')).''", $sTxt);
		$this->_aVideos = array();	
		
		if (count($this->_aUsers))
		{
			$oDb = Phpfox::getLib('database');			
			$sUsers = '';
			foreach ($this->_aUsers as $sMember => $sType)
			{
				$sUsers .= '\'' . $oDb->escape($sMember) . '\',';
			}
			$sUsers = rtrim($sUsers, ',');
			
			if (!empty($sUsers))
			{
				$aUsers = array();
				$aRows = $oDb->select(Phpfox::getUserField())->from(Phpfox::getT('user'), 'u')->where('u.user_name IN(' . $sUsers . ')')->execute('getSlaveRows');
				foreach ($aRows as $aRow)
				{
					$aUsers[$aRow['user_name']] = $aRow;
				}				
				
				if (count($aUsers))
				{
					foreach ($this->_aUsers as $sUser => $sType)
					{
						if (!isset($aUsers[$sUser]))
						{
							unset($this->_aUsers[$sUser]);
							
							continue;
						}		
						
						$this->_aUsers[$aUsers[$sUser]['user_name']] = $aUsers[$sUser];		
					}					
				}
			}			
		}
		
		$sTxt = preg_replace("/\[user\](.+?)\[\/user\]/ise", "''.stripslashes(\$this->_parseUser('user', '$1')).''", $sTxt);
		$sTxt = preg_replace("/\[profile\](.+?)\[\/profile\]/ise", "''.stripslashes(\$this->_parseUser('profile', '$1')).''", $sTxt);
		
		(($sPlugin = Phpfox_Plugin::get('parse_bbcode_parse_end')) ? eval($sPlugin) : false);
		
		return $sTxt;
	}
	
	/**
	 * Remove BBCode from a block of text.
	 *
	 * @param string $sText Text to parse.
	 * @return string Returns text with any BBCode calls.
	 */
	public function cleanCode($sText)
	{
		return preg_replace("/\[(.*?)\]/i", "", $sText);
	}

	/**
	 * Removes any BBCode and any content found within a BBCode call.
	 *
	 * @param string $sText String to parse and remove all BBCode.
	 * @param string $mCode String found within the BBCode.
	 * @return string Fully parsed text removing all BBCode.
	 */
	public function stripCode($sText, $mCode = null)
	{
		if ($mCode === null)
		{
			$mCode = array_merge(array_keys($this->_aDefault), array('quote', 'code', 'php', 'html', 'user', 'profile', 'video', 'attachment'));			
		}
		
		if (is_array($mCode))
		{
			foreach ($mCode as $sCode)
			{
				$sText = $this->stripCode($sText, $sCode);
			}
			
			return $sText;
		}
		
		$iLength = strlen($mCode);				
		
		$sLowerText = strtolower($sText);
		$aStartPos = array();
		$iCurPos = 0;
		do
		{
			$sPos = strpos($sLowerText, '[' . $mCode . '', $iCurPos);
			if ($sPos !== false && ($sLowerText[($sPos + $iLength + 1)] == '=' || $sLowerText[($sPos + $iLength + 1)] == ']'))
			{
				$aStartPos[$sPos] = 'start';
			}
	
			$iCurPos = ($sPos + $iLength + 1);
		}
		while ($sPos !== false);
	
		if (sizeof($aStartPos) == 0)
		{
			return $sText;
		}
	
		$aEndPos = array();
		$iCurPos = 0;
		do
		{
			$sPos = strpos($sLowerText, '[/' . $mCode . ']', $iCurPos);
			if ($sPos !== false)
			{
				$aEndPos[$sPos] = 'end';
				$iCurPos = ($sPos + $iLength + 3);
			}
		}
		while ($sPos !== false);
	
		if (sizeof($aEndPos) == 0)
		{
			return $sText;
		}
	
		$aPosList = $aStartPos + $aEndPos;
		ksort($aPosList);
	
		do
		{
			$aStack = array();
			$sNewText = '';
			$iSubstrPos = 0;
			foreach ($aPosList AS $sPos => $sType)
			{
				$aStacksize = sizeof($aStack);
				if ($sType == 'start')
				{
					if ($aStacksize == 0)
					{
						$sNewText .= substr($sText, $iSubstrPos, $sPos - $iSubstrPos);
					}
					array_push($aStack, $sPos);
				}
				else
				{
					if ($aStacksize)
					{
						array_pop($aStack);
						$iSubstrPos = ($sPos + $iLength + 3);
					}
				}
			}
	
			$sNewText .= substr($sText, $iSubstrPos);
	
			if ($aStack)
			{
				foreach ($aStack AS $sPos)
				{
					unset($aPosList[$sPos]);
				}
			}
		}
		while ($aStack);
	
		$sNewText = str_replace("\n\r", "", $sNewText);
		
		return $sNewText;
	}	
	
	/**
	 * Parse BBCode attachments.
	 *
	 * @param string $iId Unique ID identifying the attachment call.
	 * @param string $sText String of text to parse.
	 * @return string Parsed text.
	 */
	private function _parseAttachment($iId, $sText = null)
	{		
		$iOriginalId = stripslashes($iId);
		$iId = (int) preg_replace("/\W/", "", $iOriginalId);				
		if (isset($this->_aAttachments[$iId]))
		{
			if ($sText === null)
			{				
				return 'class="thickbox"';
			}

			if ($this->_aAttachments[$iId]['is_image'])
			{
				$sImageSize = '';
				$bIsView = false;
				$sOriginal = preg_replace("/[^a-z0-9:]/", "", $iOriginalId);
				if (strpos($sOriginal, ':'))
				{
					$aParts = explode(':', $sOriginal);
					if (isset($aParts[1]) && ($aParts[1] == 'thumb' || $aParts[1] == 'view'))
					{
						$sImageSize = '_' . $aParts[1];
						if ($aParts[1])
						{
							$bIsView = true;
						}
					}
				}			
				
				$sStr = Phpfox::getLib('image.helper')->display(array(
							'server_id' => $this->_aAttachments[$iId]['server_id'], 
							'path' => 'core.url_attachment',
							'file' => $this->_aAttachments[$iId]['destination'], 
							'suffix' => $sImageSize,
							'max_width' => Phpfox::getParam(($bIsView ? 'attachment.attachment_max_medium' : 'attachment.attachment_max_thumbnail')), 
							'max_height' => Phpfox::getParam(($bIsView ? 'attachment.attachment_max_medium' : 'attachment.attachment_max_thumbnail')),
							'thickbox' => true,
							'class' => 'parsed_image',
							'title' => Phpfox::getLib('parse.output')->htmlspecialchars(stripslashes($sText))
					)
				) . "\n";				
			}	
			elseif ($this->_aAttachments[$iId]['is_video'])
			{
				$sText = stripslashes($sText);
				$aAttachment = $this->_aAttachments[$iId];
				$sStr = '<span id="js_attachment_id_' . $iId . '">'; 
				$sStr .= '<a href="#" class="play_link" onclick="$.ajaxCall(\'attachment.playVideo\', \'attachment_id=' . $iId . '\', \'GET\'); return false;">';
				$sStr .= '<span class="play_link_img">Play</span>';
				$sStr .= Phpfox::getLib('image.helper')->display(array('server_id' => $aAttachment['server_id'], 'title' => $sText, 'path' => 'core.url_attachment', 'file' => $aAttachment['video_image_destination'], 'suffix' => '_120', 'max_width' => 'attachment.attachment_max_thumbnail', 'max_height' => 'attachment.attachment_max_thumbnail'));
				$sStr .= '</a></span>';
			}	
			else 
			{				
				$sText = stripslashes($sText);
				$sStr = '<a href="' . Phpfox::getLib('url')->makeUrl('attachment', array('download', 'id' => $iId)) . '" ';
				$sStr .= 'class="targetBlank parsed_image">' . "\n";
				$sStr .= Phpfox::getLib('parse.input')->jsClean($sText) . "</a>\n";
			}			
			
			return $sStr;
		}
				
		return '';
	}
	
	/**
	 * Parse attachments and create the new ID.
	 *
	 * @param string $iId Attachment ID.
	 * @param string $sText Text to parse.
	 * @return string Full parse text.
	 */
	private function _attachment($iId, $sText = null)
	{
		$iOriginalId = stripslashes($iId);
		$iId = (int) preg_replace("/\W/", "", $iOriginalId);		
		
		if ($iId > 0)
		{
			$this->_aAttachments[] = $iId;
			if ($sText === null)
			{
				return 'attachment="' . $iId . '"';	
			}
			else 
			{
				$sText = stripslashes($sText);
				return '[attachment=' . $iOriginalId . ']' . $sText . '[/attachment]';
			}
		}

		return '';		
	}
	
	/**
	 * Parse videos.
	 *
	 * @param int $iId Unique ID of the video.
	 * @return string Parse video.
	 */
	private function _parseVideo($iId)
	{
		$iId = (int) $iId;
		
		if (isset($this->_aVideos[$iId]))
		{			
			return $this->_aVideos[$iId];
		}
		
		return '';
	}
	
	/**
	 * Create an ID and store the parsed video ID in memory.
	 *
	 * @param int $iId ID of the video.
	 * @return string BBCode of the parsed video.
	 */
	private function _video($iId)
	{
		$iOriginalId = stripslashes($iId);
		$iId = (int) preg_replace("/\W/", "", $iOriginalId);		
		
		if ($iId > 0)
		{
			$this->_aVideos[] = $iId;
			
			return '[video]' . $iId . '[/video]';
		}

		return '';
	}	
	
	/**
	 * Parse code blocks (eg. code, html, php)
	 *
	 * @param string $sTxt Text to parse.
	 * @param string $sType Type of code block.
	 * @return string Fully parsed code blocks.
	 */
	private function _code($sTxt, $sType)
	{
		$sTxt = stripslashes($sTxt);	
		$sType = strtolower($sType);
				
		(($sPlugin = Phpfox_Plugin::get('parse_bbcode__code1')) ? eval($sPlugin) : false);
		if (!isset($this->_aCodes[$sTxt]))
		{
			switch($sType)
			{
				case 'code':
				case 'html':	
				case 'php':			
					$sTxt = trim($sTxt);
					$this->_aBlockHeight[md5($sTxt)] = $this->_getBlockHeight($sTxt);
					$sNewTxt = htmlspecialchars($sTxt);							
					// $sNewTxt = str_replace("\n", "<br />", $sNewTxt);			
					$sNewTxt = preg_replace('#&lt;((?>[^&"\']+?|&quot;.*&quot;|&(?!gt;)|"[^"]*"|\'[^\']*\')+)&gt;#esiU', "\$this->_htmlTags('\\1')", $sNewTxt);
					// $this->_aBlockHeight[md5($sTxt)] = $this->_getBlockHeight($sNewTxt);
					break;
				case 'phpold':
					
					
					$aCodeFind = array(
						'&gt;',		// &gt; to >
						'&lt;',		// &lt; to <
						'&quot;',	// &quot; to ",
						'&amp;',	// &amp; to &
						'&#91;',    // &#91; to [
						'&#93;',    // &#93; to ]
						'<br />',
						'<br>'
					);
					
					$aCodeReplace = array(
						'>',
						'<',
						'"',
						'&',
						'[',
						']',
						'',
						''
					);
		
					$sTxt = str_replace($aCodeFind, $aCodeReplace, $sTxt);		
					$sTxt = trim($sTxt);		
					
					// do we have an opening <? tag?
					if (!preg_match('#<\?#si', $sTxt))
					{
						// if not, replace leading newlines and stuff in a <?php tag and a closing tag at the end
						$sTxt = "<?php BEGIN__PHPFOX__CODE__SNIPPET $sTxt END__PHPFOX__CODE__SNIPPET ?>";
						$bAddedTags = true;
					}
					else
					{
						$bAddedTags = false;
					}								
					
					if (empty($sTxt))
					{
						return '';
					}					

					$this->_aBlockHeight[md5($sTxt)] = $this->_getBlockHeight($sTxt);
					
					$sNewTxt = highlight_string($sTxt, true);											
										
					(($sPlugin = Phpfox_Plugin::get('parse_bbcode__code2')) ? eval($sPlugin) : false);
					// if we added tags above, now get rid of them from the resulting string
					if ($bAddedTags)
					{
						$aSearch = array(
							'#&lt;\?php( |&nbsp;)BEGIN__PHPFOX__CODE__SNIPPET( |&nbsp;)#siU',
							'#(<(span|font)[^>]*>)&lt;\?(</\\2>(<\\2[^>]*>))php( |&nbsp;)BEGIN__PHPFOX__CODE__SNIPPET( |&nbsp;)#siU',
							'#END__PHPFOX__CODE__SNIPPET( |&nbsp;)\?(>|&gt;)#siU'
						);
						$aReplace = array(
							'',
							'\\4',
							''
						);
			
						$sNewTxt = preg_replace($aSearch, $aReplace, $sNewTxt);						
					}					
					
					$sNewTxt = preg_replace('/&amp;#([0-9]+);/', '&#$1;', $sNewTxt);
					$sNewTxt = str_replace(array('[', ']'), array('&#91;', '&#93;'), $sNewTxt);
					$sNewTxt = preg_replace("/<span style=(.*?)>(.*)<\/span>/ise", "'' . \$this->_cleanSpan('$1', '$2') . ''", $sNewTxt);					
					
					break;
				default:
					$sTxt = trim($sTxt);
					$sNewTxt = htmlspecialchars($sTxt);	
					// $this->_aBlockHeight[md5($sTxt)] = $this->_getBlockHeight($sNewTxt);
					break;
			}
			
			$this->_aCodes[md5($sTxt)] = $sNewTxt;
			
			return '[' . $sType . ']' . md5($sTxt) . '[/' . $sType . ']';
		}

		$sNewTxt = $this->_aCodes[$sTxt];	

		$sPrefix = '';	
		$sSuffix = '';
		if ($sType != 'php')
		{
			$sPrefix = '<pre>';	
			$sSuffix = '</pre>';
		}
		
		$sTitle = '';
		if ($sType == 'php')
		{
			$sTitle = 'PHP ';
		}
		elseif ($sType == 'html')
		{
			$sTitle = 'HTML ';	
		}		
		elseif ($sType == 'css')
		{
			$sTitle = 'CSS ';	
		}			
		
		$sNewTxt = trim($sNewTxt);
		if (substr($sNewTxt, 0, 12) == '<br /><br />')
		{
			$sNewTxt = substr_replace($sNewTxt, '', 0, 12);
		}		
		if (substr($sNewTxt, 0, 6) == '<br />')
		{
			$sNewTxt = substr_replace($sNewTxt, '', 0, 6);
		}
		
		if (substr($sNewTxt, -12) == '<br /><br />')
		{
			$sNewTxt = substr_replace($sNewTxt, '<br />', -12);
		}			
		
		if (!isset($this->_aBlockHeight[$sTxt]))
		{
			$this->_aBlockHeight[$sTxt] = $this->_getBlockHeight($sNewTxt);
		}
		
		$bNoTitle = false;
		if ($sType == 'code')
		{
			$bNoTitle = true;
		}
		
		$sTxt = '<div class="quote">' . ($bNoTitle ? '' : '<div class="quote_title">' . trim($sTitle) . ':</div>') . '<div class="quote_body" style="overflow:auto;' . ($this->_aBlockHeight[$sTxt] >= 540 ? ' height:' . $this->_aBlockHeight[$sTxt] . 'px;' : '') . '">' . $sPrefix . $sNewTxt . $sSuffix . '</div></div>';
		
		(($sPlugin = Phpfox_Plugin::get('parse_bbcode__code3')) ? eval($sPlugin) : false);
		return $sTxt;
	}
	
	/**
	 * Parse user BBCode that creates a link to their profile.
	 *
	 * @param string $sType Type of connection to the profile.
	 * @param string $sMember Name of the member.
	 * @return string Parsed string.
	 */
	private function _parseUser($sType, $sMember)
	{
		if (!isset($this->_aUsers[$sMember]))
		{
			return '';
		}
		
		$sTxt = '';
		switch ($sType)
		{
			case 'user':
				$sTxt = '<a href="' . Phpfox::getLib('url')->makeUrl($sMember) . '">' . $sMember . '</a>';
				break;
			case 'profile':
				$sTxt = Phpfox::getLib('image.helper')->display(array(
							'user' => $this->_aUsers[$sMember],
							'title' => $this->_aUsers[$sMember]['full_name'],
							'path' => 'core.url_user',
							'file' => $this->_aUsers[$sMember]['user_image'],
							'suffix' => '_50',
							'max_width' => 75,
							'max_height' => 75										
						)
					);								
				break;
			default:
				
				break;
		}
		
		return $sTxt;
	}
	
	/**
	 * Holds in memory all the memers we need to parse.
	 *
	 * @param string $sType Type of method to parse.
	 * @param string $sMember Name of the member.
	 * @return string Parsed text.
	 */
	private function _parseMember($sType, $sMember)
	{
		$this->_aUsers[$sMember] = $sType;
		
		return '[' . $sType . ']' . $sMember . '[/' . $sType . ']';
	}
	
	/**
	 * Parse BBCode [table][/table]
	 *
	 * @param int $i Size of the table.
	 * @param string $sStr String to parse.
	 * @return string Parsed text.
	 */
    private function _parseTable($i, $sStr)
    {
    	$sStr = str_replace("[br]", "", $sStr);

    	if ($i > 100)
    	{
    		$i = 100;
    	}

    	$sStr = '<table style="width:'.$i.'%"><tr>'.$sStr.'</tr></table>';
    	$sStr = preg_replace("/\[td\](.*?)\[\/td\]/si","<td>\\1</td>",$sStr);
    	
    	return $sStr;
    }	
	
    /**
     * Parse a specific BBCode.
     *
     * @param array $aMatches ARRAY of matches for this bbcode.
     * @return string Converted BBCode into HTML.
     */
	private function _parseBbCodeSingle($aMatches)
	{
		if (substr($aMatches[1], 0, 1) == '/')
		{
			if (!isset($this->_aDefault[substr_replace($aMatches[1], '', 0, 1)]))
			{
				return $aMatches[0];
			}		
			
			return '/' . $this->_aDefault[substr_replace($aMatches[1], '', 0, 1)];			
		}
		
		if (!isset($this->_aDefault[$aMatches[1]]))
		{
			return $aMatches[0];
		}		
		
		return $this->_aDefault[$aMatches[1]];
	}
	
	/**
	 * Parse BBCode with contents within it.
	 *
	 * @param string $sBbcode BBCode to parse.
	 * @param string $sTxt Text to parse.
	 * @return string Converted BBCode.
	 */
	private function _parseBbCode($sBbcode, $sTxt)
	{		
		if (!isset($this->_aDefault[$sBbcode]))
		{
			return $sTxt;
		}
		
		$sTxt = str_replace(array('{value}'), array($sTxt), $this->_aDefault[$sBbcode]);		
		
		/*
		foreach ($this->_aDefault as $sBbcode => $mValue)
		{		
			$sTxt = preg_replace("/\[" . $sBbcode . "\](.*)\[\/" . $sBbcode . "\]/ise", "''.\$this->_parseBbCode('' . \$sBbcode . '', '$1').''", $sTxt);
			$sTxt = preg_replace("/\[" . $sBbcode . "=(.*?)\](.*?)\[\/" . $sBbcode . "\]/ise", "''.\$this->_parseBbCodeOption('' . \$sBbcode . '', '$1','$2').''", $sTxt);				
		}
		$sTxt = preg_replace_callback("/\[(.*?)\]/is", array(&$this, '_parseBbCodeSingle'), $sTxt);				
		*/
		
		$sTxt = preg_replace('/<(.*?)>/ise', "'<'.Phpfox::getLib('parse.input')->removeEvilAttributes('\\1').'>'", $sTxt);
		
		return $sTxt;
	}
	
	/**
	 * Parse BBCode with options.
	 *
	 * @param string $sBbCode BBCode to parse.
	 * @param string $sOption Option part of the BBCode.
	 * @param string $sTxt Text to parse.
	 * @return string Converted text from BBCode to HTML.
	 */
	private function _parseBbCodeOption($sBbCode, $sOption, $sTxt)
	{		
		if (!isset($this->_aDefault[$sBbCode]))
		{
			return $sTxt;
		}
	
		$sTxt = str_replace(array('{option}', '{value}'), array(trim(trim(stripslashes(stripslashes($sOption)), '"'), "'"), $sTxt), $this->_aDefault[$sBbCode]);
		
		/*
		foreach ($this->_aDefault as $sBbcode => $mValue)
		{		
			$sTxt = preg_replace("/\[" . $sBbcode . "\](.*)\[\/" . $sBbcode . "\]/ise", "''.\$this->_parseBbCode('' . \$sBbcode . '', '$1').''", $sTxt);
			$sTxt = preg_replace("/\[" . $sBbcode . "=(.*?)\](.*?)\[\/" . $sBbcode . "\]/ise", "''.\$this->_parseBbCodeOption('' . \$sBbcode . '', '$1','$2').''", $sTxt);				
		}
		$sTxt = preg_replace_callback("/\[(.*?)\]/is", array(&$this, '_parseBbCodeSingle'), $sTxt);
		*/
		
		$sTxt = preg_replace('/<(.*?)>/ise', "'<'.Phpfox::getLib('parse.input')->removeEvilAttributes('\\1').'>'", $sTxt);
		
		return $sTxt;
	}	
	
	/**
	 * Clean html <span>.
	 *
	 * @param string $sStyle Custom CSS for this span.
	 * @param string $sTxt Text to parse.
	 * @return string Cleaned span.
	 */
	private function _cleanSpan($sStyle, $sTxt)
	{
		if (empty($sTxt))
		{
			return '';
		}
		return  '<span style=' . stripslashes($sStyle) . '>'. stripslashes($sTxt) . '</span>';
	}
	
	/**
	* Block height.
	*
	* @param	string	Block of text to find the height of
	* @return	int		Height of block in pixels
	*/
	private function _getBlockHeight($sTxt)
	{
		$iNumLines = max(substr_count($sTxt, "\n"), substr_count($sTxt, "<br />")) + 1;

		if ($iNumLines > 30)
		{
			$iNumLines = 30;
		}
		elseif ($iNumLines <= 1)
		{
			$iNumLines = 1;
		}
		/*
		if ($iNumLines === 1)
		{
			$iNumLines = 3;
		}		
		*/
		/*
		d((($iNumLines) * 18), true);
		p(htmlspecialchars($sTxt));		
		*/
		// return ($iNumLines) * 16 + 18;
		return (($iNumLines) * 18);
	}	

	/**
	* Handles an individual HTML tag in a [html] tag.
	*
	* @param	string	The body of the tag.
	* @return	string	Syntax highlighted, displayable HTML tag.
	*/
	private function _htmlTags($sTag)
	{
		static $aHtmlColors = array();

		if (!$aHtmlColors)
		{
			$aHtmlColors = $this->_getHtmlColors();
		}

		// change any embedded URLs so they don't cause any problems
		$sTag = preg_replace('#\[(email|url)=&quot;(.*)&quot;\]#siU', '[$1="$2"]', $sTag);

		// find if the tag has attributes
		$iSpacepos = strpos($sTag, ' ');
		if ($iSpacepos != false)
		{
			// tag has attributes - get the tag name and parse the attributes
			$sTagname = substr($sTag, 0, $iSpacepos);
			$sTag = preg_replace('# (\w+)=&quot;(.*)&quot;#siU', ' \1=<span style="color:' . $aHtmlColors['attribs'] . '">&quot;\2&quot;</span>', $sTag);
		}
		else
		{
			// no attributes found
			$sTagname = $sTag;
		}
		// remove leading slash if there is one
		if ($sTag{0} == '/')
		{
			$sTagname = substr($sTagname, 1);
		}
		// convert tag name to lower case
		$sTagname = strtolower($sTagname);

		// get highlight colour based on tag type
		switch($sTagname)
		{
			// table tags
			case 'table':
			case 'tr':
			case 'td':
			case 'th':
			case 'tbody':
			case 'thead':
				$sTagcolor = $aHtmlColors['table'];
				break;
			// form tags
			//NOTE: Supposed to be a semi colon here ?
			case 'form';
			case 'input':
			case 'select':
			case 'option':
			case 'textarea':
			case 'label':
			case 'fieldset':
			case 'legend':
				$sTagcolor = $aHtmlColors['form'];
				break;
			// script tags
			case 'script':
				$sTagcolor = $aHtmlColors['script'];
				break;
			// style tags
			case 'style':
				$sTagcolor = $aHtmlColors['style'];
				break;
			// anchor tags
			case 'a':
				$sTagcolor = $aHtmlColors['a'];
				break;
			// img tags
			case 'img':
				$sTagcolor = $aHtmlColors['img'];
				break;
			// all other tags
			default:
				$sTagcolor = $aHtmlColors['default'];
				break;
		}

		$sTag = '<span style="color:' . $sTagcolor . '">&lt;' . str_replace('\\"', '"', $sTag) . '&gt;</span>';
		
		return $sTag;
	}
	
	/**
	* Color code.
	*
	* @return	array	array of type (key) to color (value)
	*/
	private function _getHtmlColors()
	{
		return array(
			'attribs'	=> '#0000FF',
			'table'		=> '#008080',
			'form'		=> '#FF8000',
			'script'	=> '#800000',
			'style'		=> '#800080',
			'a'			=> '#008000',
			'img'		=> '#800080',
			'if'		=> '#FF0000',
			'default'	=> '#000080'
		);
	}	
	
	/**
	 * Parse images from BBCode [image]
	 *
	 * @param string $sTxt Text to parse.
	 * @return string Converted BBCode.
	 */
	private function _image($sTxt)
	{
		$sRealImage = '';
		if (strpos($sTxt, 'attachment') && strpos($sTxt, 'thumb'))
		{
			$sRealImage = str_replace('thumb/', '', $sTxt);
		}
		
		(($sPlugin = Phpfox_Plugin::get('parse_bbcode__image')) ? eval($sPlugin) : false);
		
		$sTxt = ($sRealImage ? '<a href="' . $sRealImage . '" class="thickbox">' : '') . '<img src="' . $sTxt . '" alt="" class="parsed_image" />' . ($sRealImage ? '</a>' : '');
		return $sTxt;	
	}
	
	/**
	 * Parse and convert [quote][/quote] BBCode.
	 *
	 * @param string $sDetail Details identifying the quote message.
	 * @param string $sTxt Text to parse.
	 * @return string Converted BBCode.
	 */
	private function _quote($sDetail, $sTxt)
	{
		$bData = false;
		$bLink = true;
		
		if (!empty($sDetail))
		{
			$bData = true;
			$sDetail = substr_replace($sDetail, '', 0, 1);			
			$sDetail = Phpfox::getLib('parse.input')->jsClean($this->_trim($sDetail));
			
			$aUser = Phpfox::getService('user')->getUser($sDetail,'u.user_id, u.user_name, u.full_name');
				
			if (empty($aUser))
			{
				$bLink = false;					
			}
		}		
		
		$sTxt = stripslashes($sTxt);
		// $sTxt = Phpfox::getLib('parse.input')->prepare($sTxt);
		
		(($sPlugin = Phpfox_Plugin::get('parse_bbcode_quote_start')) ? eval($sPlugin) : false);
		
		$sTxt = '<div class="new_quote">' . ($bData ? '<div class="new_quote_header">' . ($bLink ? '<a href="' . Phpfox::getLib('url')->makeUrl('profile', $aUser['user_name']) . '">' : '') . ($bLink ? $aUser['full_name'] : $sDetail) . ($bLink ? '</a>' : '') . ' [PHPFOX_PHRASE]core.said[/PHPFOX_PHRASE]</div>' : '') . '<div class="new_quote_content_holder"><div class="new_quote_content">' . $sTxt . '</div></div></div>';
		
		(($sPlugin = Phpfox_Plugin::get('parse_bbcode_quote_end')) ? eval($sPlugin) : false);
		
		return $sTxt;
	}
		
	/**
	 * Clean BBCode option.
	 *
	 * @param string $sTxt String to parse.
	 * @return string Clean value of the 1st argument.
	 */
	private function _parseOption($sTxt)
	{
		return Phpfox::getLib('parse.input')->jsClean($this->_trim(stripslashes($sTxt)));		
	}
	
	/**
	 * Clean BBCode value.
	 *
	 * @param string $sTxt String to parse.
	 * @return string Clean value of the 1st argument.
	 */	
	private function _parseValue($sTxt)
	{
		foreach ($this->_aDefault as $sKey => $sValue)
		{
			$sTxt = preg_replace("/\[{$sKey}(.*?)\](.*?)\[\/{$sKey}\]/ise", "'' . str_replace(array('{option}', '{value}'), array(\$this->_parseOption('$1'), \$this->_parseValue('$2')), '$sValue') . ''", $sTxt);
		}
		
		return Phpfox::getLib('parse.input')->jsClean(stripslashes($this->_trim($sTxt)));
	}
	
	/**
	 * Trim BBCode.
	 *
	 * @param string $sTxt Text to parse.
	 * @return string Trimmed text.
	 */
	private function _trim($sTxt)
	{		
		$sTxt = stripslashes($sTxt);
		$sTxt = trim($sTxt);
		$sTxt = ltrim($sTxt, '=');		
		$sTxt = trim($sTxt, '"');
		$sTxt = trim($sTxt, "'");		

		return $sTxt;
	}
	
	/**
	 * Replace default BBCode with HTML.
	 *
	 * @param string $sBbCode BBCode to parse.
	 * @param string $sType Type of BBCode.
	 * @param bool $bOption TRUE if option is allowed, FALSE if not.
	 * @param string $sOption If argument 3 is TRUE then you can pass a valid STRING option here.
	 * @return string Converted BBCode string.
	 */
	private function _replaceBbCode($sBbCode, $sType = 'prefix', $bOption = false, $sOption = null)
	{
		// http://www.phpfox.com/tracker/view/15240/
		if(Phpfox::getParam('core.enable_html_purifier') && $sBbCode == 'i')
		{
			$sBbCode = 'em';
		}
		
		if ($bOption === true)
		{
			if (!isset($this->_aDefault[$sBbCode][$sType]))
			{
				return '[' . ($sType == 'suffix' ? '/' : '') . $sBbCode . '=' . stripslashes($sOption) . ']';
			}			
 
			return str_replace('{option}', trim(trim(stripslashes($sOption), '"'), "'"), $this->_aDefault[$sBbCode][$sType]);	
		}
		
		if (!isset($this->_aDefault[$sBbCode][$sType]))
		{
			return '[' . ($sType == 'suffix' ? '/' : '') . $sBbCode . ']';
		}		
		
		return $this->_aDefault[$sBbCode][$sType];
	}
}

?>
