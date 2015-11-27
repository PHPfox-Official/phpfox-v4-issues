<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * WIKI Parser
 * Clones how a common WIKI works and allows the ability for users
 * to use WIKI code to create pages.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: wiki.class.php 1668 2010-07-12 08:54:32Z Raymond_Benc $
 */
class Phpfox_Parse_Wiki 
{	
	/**
	 * Common regex for HTML.
	 *
	 * @var array
	 */
	private $_sLineRegexes = array(
		'preformat' => '^\s(.*?)$',
		'definitionlist' => '^([\;\:])\s*(.*?)$',
		'newline' => '^$',
		'list' => '^([\*\#]+)(.*?)$',
		'sections' => '^(={1,6})(.*?)(={1,6})$',
		'horizontalrule' => '^----$'
	);
		
	/**
	 * Common character regex.
	 *
	 * @var array
	 */
	private	$_sCharRegexes = array(
		'internallink' => '(\[\[(([^\]]*?)\:)?([^\]]*?)(\|([^\]]*?))?\]\]([a-z]+)?)',
		'externallink' => '(\[([^\]]*?)(\s+[^\]]*?)?\])',
		'emphasize' => '(\'{2,5})',
		'eliminate' => '(__TOC__|__NOTOC__|__NOEDITSECTION__)',
		'variable' => '(\{\{([^\}]*?)\}\})'
	);	
		
	/**
	 * Reference within links.
	 *
	 * @var string
	 */
	private $_sReferenceWiki;
	
	/**
	 * Image URI.
	 *
	 * @var string
	 */
	private $_sImageUri;
	
	/**
	 * BOOL to ignore images or not.
	 *
	 * @var bool
	 */
	private $_bIgnoreImages = true;
	
	/**
	 * Redirect links.
	 *
	 * @var bool
	 */
	private $_bRedirect = false;
	
	/**
	 * Format <pre>.
	 *
	 * @var bool
	 */
	private $_bPreformat = false;
	
	/**
	 * ARRAY of emphasis tags.
	 *
	 * @var array
	 */
	private $_aEmphasis = array();
	
	/**
	 * ARRAY of support nowiki tags.
	 *
	 * @var array
	 */
	private $_aNoWikis = array();
	
	/**
	 * <ul> list level types.
	 *
	 * @var array
	 */
	private $_aListLevelTypes = array();
	
	/**
	 * Define how many levels a list has.
	 *
	 * @var int
	 */
	private $_iListLevel = 0;
	
	/**
	 * Support for <dl>.
	 *
	 * @var bool
	 */
	private $_bDefList = false;
	
	/**
	 * Link number.
	 *
	 * @var int
	 */
	private $_iLinkNumber = 0;
	
	/**
	 * Supress link breaks.
	 *
	 * @var bool
	 */
	private $_bSuppressLinebreaks = false;
	
	/**
	 * Create a link break.
	 *
	 * @var bool
	 */
	private $_bStop = false;
	
	/**
	 * Class constructor.
	 *
	 */
	public function __construct()
	{
	}
	
	/**
	 * Parse string and converts WIKI code into HTML.
	 *
	 * @param string $sText Text to parse.
	 * @param string $sTitle Title of this page.
	 * @return string Converted text from WIKI to HTML.
	 */
	public function parse($sText, $sTitle = '') 
	{		
		$sText = preg_replace_callback('/<nowiki>([\s\S]*)<\/nowiki>/i', array(&$this, "_handleSaveNoWiki"), $sText);

		$aLines = explode("\n", $sText);
		
		if (preg_match('/^\#REDIRECT\s+\[\[(.*?)\]\]$/', trim($aLines[0]), $aMatches)) 
		{
			$this->_bRedirect = $aMatches[1];
		}
		
		$sOutput = '';
		foreach ($aLines as $iKey => $sLine) 
		{
			$sOutput .= $this->_parseLine($sLine);
		}

		$sOutput = preg_replace_callback('/<nowiki><\/nowiki>/i', array(&$this, "_handleRestoreNoWiki"), $sOutput);

		return $sOutput;
	}	
	
	/**
	 * Parses each line of the string and creates handles.
	 *
	 * @param string $sLine Line of the string we are parsing.
	 * @return string Returns the parsed line.
	 */
	private function _parseLine($sLine) 
	{				
		$this->_bStop = false;
		$this->_bStopAll = false;

		$aCalled = array();
		
		$sLine = rtrim($sLine);
		
		foreach ($this->_sLineRegexes as $sFunction => $sRegex) 
		{
			if (preg_match("/$sRegex/i", $sLine, $aMatches)) 
			{
				$aCalled[$sFunction] = true;
				$sFunction = '_handle' . $sFunction;
				$sLine = $this->$sFunction($aMatches);
				if ($this->_bStop || $this->_bStopAll)
				{
					break;
				}
			}
		}
		
		if (!$this->_bStopAll) 
		{
			$this->_bStop = false;
			foreach ($this->_sCharRegexes as $sFunction => $sRegex) 
			{
				$sLine = preg_replace_callback("/$sRegex/i", array(&$this, "_handle" . $sFunction), $sLine);
				if ($this->_bStop)
				{
					break;
				}
			}
		}
		
		$isline = (strlen(trim($sLine)) > 0);
		
		if (($this->_iListLevel > 0) && (!isset($aCalled['list'])))
		{
			$sLine = $this->_handleList(false, true) . $sLine;
		}
		
		if ($this->_bDefList && (!isset($aCalled['definitionlist'])))
		{
			$sLine = $this->_handleDefinitionList(false, true) . $sLine;
		}
		
		if ($this->_bPreformat && (!isset($aCalled['preformat'])))
		{
			$sLine = $this->_handlePreFormat(false, true) . $sLine;
		}
		
		if ($isline)
		{
			$this->_bSuppressLinebreaks = ((isset($aCalled['newline']) && $aCalled['newline']) || (isset($aCalled['sections']) && $aCalled['sections']));
		}
		
		return $sLine;
	}	
	
	/**
	 * Handles sections (h1, h2, h3 etc...)
	 *
	 * @param array $aMatches ARRAY matches from regex.
	 * @return string Converted HTML line.
	 */
	private function _handleSections($aMatches) 
	{				
		$iLevel = strlen($aMatches[1]);
		$sContent = $aMatches[2];
		$sContent = trim($sContent);
		$this->_bStop = true;
		
		return $this->emphasize_off() . "\n\n<p><a name=\"" . $this->_cleanTitle($sContent) . "\" id=\"" . $this->_cleanTitle($sContent) . "\"></a></p>\n<h{$iLevel}>{$sContent}</h{$iLevel}>\n\n";
	}
	
	/**
	 * Cleans the title of an item.
	 *
	 * @param string $sTxt Title of the item.
	 * @return string Title all clean.
	 */
	private function _cleanTitle($sTxt)
	{
		$sTxt = preg_replace( '/ +/', '_',preg_replace('/[^0-9a-zA-Z ]+/', '', $sTxt));
		
		return $sTxt;
	}
	
	/**
	 * Handler for new lines (<br />).
	 *
	 * @param array $aMatches ARRAY matches from regex.
	 * @return string Converted HTML.
	 */
	private function _handleNewline($aMatches) 
	{
		if ($this->_bSuppressLinebreaks)
		{
			return $this->emphasize_off();
		}
		
		$this->_bStop = true;

		return $this->emphasize_off() . "<br /><br />";
	}
	
	/**
	 * Handles lists (<ul><li>)
	 *
	 * @param array $aMatches ARRAY matches from regex.
	 * @param bool $bClose TRUE to close the <ul>. FALSE to leave it open.
	 * @return string Converted HTML.
	 */
	private function _handleList($aMatches, $bClose = false) 
	{
		$aListTypes = array(
			'*' => 'ul',
			'#' => 'ol',
		);		
		
		$iNewLevel = (($bClose) ? 0 : strlen($aMatches[1]));
		
		$sOutput = '';
		while ($this->_iListLevel != $iNewLevel) 
		{
			$sListChar = substr($aMatches[1], -1);						
			
			$sListType = (isset($aListTypes[$sListChar]) ? $aListTypes[$sListChar] : '');
			
			if ($this->_iListLevel > $iNewLevel) 
			{
				$sListType = '/' . array_pop($this->_aListLevelTypes);
				$this->_iListLevel--;
			} 
			else 
			{
				$this->_iListLevel++;
				array_push($this->_aListLevelTypes, $sListType);
			}
			$sOutput .= "\n<{$sListType}>\n";
		}
		
		if ($bClose)
		{
			return $sOutput;
		}
		
		$sOutput .= "<li>".$aMatches[2]."</li>\n";
		
		return $sOutput;
	}
	
	/**
	 * Handle <dl>.
	 *
	 * @param array $aMatches ARRAY matches from regex.
	 * @param bool $bClose TRUE to close the <dl>. FALSE to leave it open.
	 * @return string Converted HTML.
	 */
	private function _handleDefinitionList($aMatches, $bClose = false) 
	{		
		if ($bClose) 
		{
			$this->_bDefList = false;
			return "</dl>\n";
		}		
		
		$sOutput = "";
		if (!$this->_bDefList)
		{
			$sOutput .= "<dl>\n";
		}
		$this->_bDefList = true;

		switch($aMatches[1]) 
		{
			case ';':
				$sTerm = $aMatches[2];
				if (strpos($sTerm, ' :') !== false) 
				{
					list($sTerm, $definition) = explode(':', $sTerm);
					$sOutput .= "<dt>{$sTerm}</dt><dd>{$definition}</dd>";
				} 
				else 
				{
					$sOutput .= "<dt>{$sTerm}</dt>";
				}
				break;
			case ':':
				$definition = $aMatches[2];
				$sOutput .= "<dd>{$definition}</dd>\n";
				break;
		}
		
		return $sOutput;
	}
	
	/**
	 * Handle <pre>.
	 *
	 * @param array $aMatches ARRAY matches from regex.
	 * @param bool $bClose TRUE to close the <pre>. FALSE to leave it open.
	 * @return string Converted HTML.
	 */	
	private function _handlePreFormat($aMatches, $bClose = false) 
	{
		if ($bClose) 
		{
			$this->_bPreformat = false;
			return "</pre>\n";
		}
		
		$this->_bStopAll = true;

		$sOutput = "";
		if (!$this->_bPreformat)
		{
			$sOutput .= "<pre>";
		}
		$this->_bPreformat = true;
		
		$sOutput .= $aMatches[1];
		
		return $sOutput."\n";
	}
	
	/**
	 * Handle <hr />
	 *
	 * @param array $aMatches ARRAY matches from regex.
	 * @return string Converted HTML.
	 */
	private function _handleHorizontalRule($aMatches) 
	{
		return "<hr />";
	}
	
	/**
	 * Handle images (<img>).
	 *
	 * @param string $sHref Link
	 * @param string $sTitle Title
	 * @param array $aOptions Extra options for the link.
	 * @return string Converted HTML.
	 */
	private function _handleImage($sHref, $sTitle, $aOptions) 
	{
		if ($this->_bIgnoreImages)
		{
			return '';
		}
		
		if (!$this->_sImageUri)
		{
			return $sTitle;
		}
		
		$sHref = $this->_sImageUri . $sHref;
		
		$sImageTag = sprintf('<img src="%s" alt="%s" />', $sHref, $sTitle);
		foreach ($aOptions as $iKey => $sOption) 
		{
			switch($sOption) 
			{
				case 'frame':
					$sImageTag = sprintf('<div style="float: right; background-color: #F5F5F5; border: 1px solid #D0D0D0; padding: 2px">%s<div>%s</div></div>', $sImageTag, $sTitle);
					break;
				case 'right':
					$sImageTag = sprintf('<div style="float: right">%s</div>', $sImageTag);
					break;
			}
		}
		
		return $sImageTag;
	}
	
	/**
	 * Handles internal links.
	 *
	 * @param array $aMatches ARRAY matches from regex.
	 * @return string Converted HTML.
	 */
	private function _handleInternalLink($aMatches) 
	{
		$bNoLink = false;	
		$sHref = $aMatches[4];
		$sTitle = (isset($aMatches[6]) ? $aMatches[6] : $sHref . (isset($aMatches[7]) ? $aMatches[7] : ''));
		$namespace = (isset($aMatches[3]) ? $aMatches[3] : false);

		if ($namespace == 'Image') 
		{
			$aOptions = explode('|', $sTitle);
			$sTitle = array_pop($aOptions);
			
			return $this->_handleImage($sHref, $sTitle, $aOptions);
		}		
		
		$sTitle = preg_replace('/\(.*?\)/', '', $sTitle);
		$sTitle = preg_replace('/^.*?\:/', '', $sTitle);
		
		if ($this->_sReferenceWiki) 
		{
			$sHref = $this->_sReferenceWiki . ($namespace ? $namespace . ':' : '') . ucfirst(str_replace(' ', '_', $sHref));
		} 
		else 
		{
			$bNoLink = true;
		}

		if ($bNoLink)
		{
			return $sTitle;
		}
		
		$bNewWindow = true;
		
		return sprintf('<a href="%s"%s>%s</a>', $sHref, ($bNewWindow ? ' target="_blank"' : ''), $sTitle);
	}
	
	/**
	 * Handles external links.
	 *
	 * @param array $aMatches ARRAY matches from regex.
	 * @return string Converted HTML.
	 */	
	private function _handleExternalLink($aMatches) 
	{
		$sHref = $aMatches[2];
		$sTitle = (isset($aMatches[3]) ? $aMatches[3] : false);
		if (!$sTitle) 
		{
			$this->_iLinkNumber++;
			$sTitle = "[{$this->_iLinkNumber}]";
		}
		$bNewWindow = true;
		
		return sprintf('<a href="%s"%s>%s</a>', $sHref, ($bNewWindow ? ' target="_blank"' : ''), $sTitle);		
	}
	
	/**
	 * Handles emphasize blocks (em, strong).
	 *
	 * @param int Type of HTML.
	 * @return string Converted HTML.
	 */	
	private function emphasize($iAmount) 
	{
		$aAmounts = array(
			2 => array('<em>','</em>'),
			3 => array('<strong>','</strong>'),
			4 => array('<strong>','</strong>'),
			5 => array('<em><strong>','</strong></em>')
		);
		
		$sOutput = "";
		if ((isset($this->_aEmphasis[$iAmount]) && !$this->_aEmphasis[$iAmount]) && (isset($this->_aEmphasis[$iAmount-1]) && $this->_aEmphasis[$iAmount-1])) 
		{
			$iAmount--;
			$sOutput = "'";
		}

		$sOutput .= $aAmounts[$iAmount][(int) (isset($this->_aEmphasis[$iAmount]) ? $this->_aEmphasis[$iAmount] : 0)];

		$this->_aEmphasis[$iAmount] = (isset($this->_aEmphasis[$iAmount]) ? !$this->_aEmphasis[$iAmount] : true);
		
		return $sOutput;
	}
	
	/**
	 * Handles emphasize blocks (em, strong).
	 *
	 * @param array $aMatches ARRAY matches from regex.
	 * @return string Converted HTML.
	 */		
	private function _handleEmphasize($aMatches) 
	{
		return $this->emphasize(strlen($aMatches[1]));
	}
	
	/**
	 * Checks emphasize diff.
	 *
	 * @return string Converted HTML.
	 */	
	private function emphasize_off() 
	{
		$sOutput = "";
		
		if (!is_array($this->_aEmphasis))
		{
			return $sOutput;
		}
		
		foreach ($this->_aEmphasis as $iAmount => $sState) 
		{
			if ($sState)
			{
				$sOutput .= $this->emphasize($iAmount);
			}
		}
		
		return $sOutput;
	}
	
	/**
	 * Adds empty string.
	 *
	 * @return string Empty string.
	 */		
	private function _handleEliminate($aMatches) 
	{
		return '';
	}
	
	/**
	 * Converts WIKI variables.
	 *
	 * @param array $aMatches ARRAY matches from regex.
	 * @return string Converted HTML.
	 */
	private function _handleVariable($aMatches) 
	{
		switch($aMatches[2]) 
		{
			case 'CURRENTMONTH': return date('m');
			case 'CURRENTMONTHNAMEGEN':
			case 'CURRENTMONTHNAME': return date('F');
			case 'CURRENTDAY': return date('d');
			case 'CURRENTDAYNAME': return date('l');
			case 'CURRENTYEAR': return date('Y');
			case 'CURRENTTIME': return date('H:i');
			case 'NUMBEROFARTICLES': return 0;
			case 'PAGENAME': return '';
			case 'NAMESPACE': return 'None';
			case 'SITENAME': return $_SERVER['HTTP_HOST'];
			default: return '';	
		}
	}
	
	/**
	 * Handles <nowiki>.
	 *
	 * @param array $aMatches ARRAY matches from regex.
	 * @return string Converted HTML.
	 */	
	private function _handleSaveNoWiki($aMatches) 
	{
		array_push($this->_aNoWikis, $aMatches[1]);
		
		return "<nowiki></nowiki>";
	}
	
	/**
	 * Restores wiki.
	 *
	 * @param array $aMatches ARRAY matches from regex.
	 * @return string Converted HTML.
	 */
	private function _handleRestoreNoWiki($aMatches) 
	{
		return array_pop($this->_aNoWikis);
	}
}

?>