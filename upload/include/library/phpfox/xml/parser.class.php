<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * XML Parser
 * Class is used to convert an XML STRING into a ARRAY.
 * 
 * Sample XML code we are working with:
 * <code>
 * <foo var="value">
 * 		<sample extra="info">
 * 			This is some value.
 * 		</sample>
 * </foo>
 * </code>
 * 
 * PHP code to parse XML STRING:
 * <code>
 * $aXmlData = Phpfox::getLib('xml.parser')->parse($sXml);
 * </code>
 * 
 * The variable $aXmlData will output the following array:
 * <code>
 * $aXmlData = array(
 * 		'foo' => array(
 * 			'var' => 'value',
 * 			'sample' => array(
 * 				'extra' => 'info',
 * 				'value' => 'This is some value'
 * 			)
 * 		)
 * );
 * </code>
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: parser.class.php 2525 2011-04-13 18:03:20Z Raymond_Benc $
 */
class Phpfox_Xml_Parser
{
	/**
	 * XML object.
	 *
	 * @see xml_parser_create()
	 * @var object
	 */
	private $_oXml = null;
	
	/**
	 * XML string to parse.
	 *
	 * @var string
	 */
	private $_sXml;
	
	/**
	 * ARRAY of data we picked up and parsed from the XML string.
	 *
	 * @var array
	 */
	private $_aData = array();
	
	/**
	 * Error ID#.
	 *
	 * @var int
	 */
	private $_iError = 0;	
	
	/**
	 * Stack XML.
	 *
	 * @var array
	 */
	private $_aStack = array();
	
	/**
	 * CDATA string.
	 *
	 * @var string
	 */
	private $_sCdata;
	
	/**
	 * Check to include the first tag.
	 *
	 * @var bool
	 */
	private $_bIncludeFirstTag = false;
	
	/**
	 * Total number of tags.
	 *
	 * @var int
	 */
	private $_iTagCnt = 0;
	
	/**
	 * Error code.
	 *
	 * @var int
	 */
	private $_iErrorCode = 0;
	
	/**
	 * Error line.
	 *
	 * @var int
	 */
	private $_iErrorLine = 0;

	/**
	* Class constructor.
	*
	*/
	public function __construct()
	{
	}
	
	/**
	 * Get the XML content.
	 *
	 * @param string $mFile XML data or XML file.
	 * @return string XML data.
	 */
	public function getXml($mFile)
	{		
		if (!preg_match("/<(.*?)>/i", $mFile) && file_exists($mFile))		
		{
			return file_get_contents($mFile);
		}
		
		return $mFile;
	}

	/**
	 * Parse XML code and convert into an ARRAY.
	 *
	 * @param string $mFile XML data or XML file name.
	 * @param string $sEncoding Encoding.
	 * @param bool $bEmptyData TRUE to empty XML data.
	 * @return mixed FALSE if errors were found, ARRAY if no errors and XML was converted into an ARRAY.
	 */
	public function parse($mFile, $sEncoding = 'ISO-8859-1', $bEmptyData = true)
	{
		$this->_sXml = $this->getXml($mFile);
		
		if (empty($this->_sXml) || $this->_iError > 0)
		{			
			return false;
		}

		if (!($this->_oXml = xml_parser_create($sEncoding)))
		{			
			return false;
		}
		
		xml_parser_set_option($this->_oXml, XML_OPTION_SKIP_WHITE, 0);
		xml_parser_set_option($this->_oXml, XML_OPTION_CASE_FOLDING, 0);
		xml_set_character_data_handler($this->_oXml, array(&$this, '_handleCdata'));
		xml_set_element_handler($this->_oXml, array(&$this, '_handleElementStart'), array(&$this, '_handleElementEnd'));		
	
		xml_parse($this->_oXml, $this->_sXml);
		
		$bError = xml_get_error_code($this->_oXml);

		if ($bEmptyData)
		{
			$this->_sXml = '';
			$this->_aStack = array();
			$this->_sCdata = '';
		}

		if ($bError)
		{			
			$this->_iErrorCode = @xml_get_error_code($this->_oXml);
			$this->_iErrorLine = @xml_get_current_line_number($this->_oXml);
			
			xml_parser_free($this->_oXml);

			return Phpfox_Error::trigger($this->errorString(), E_USER_ERROR);
		}

		xml_parser_free($this->_oXml);

		return $this->_aData;
	}
	
	/**
	 * Error phrase.
	 *
	 * @return string
	 */
	public function errorString()
	{		
		if ($sError = xml_error_string($this->_iErrorCode))
		{			
			return $sError;
		}
		else
		{			
			return 'unknown';
		}
	}
	
	/**
	 * Error line.
	 *
	 * @return int
	 */
	public function errorLine()
	{
		if ($this->_iErrorLine)
		{
			return $this->_iErrorLine;
		}
		else
		{
			return 0;
		}
	}

	/**
	 * Error code.
	 *
	 * @return int
	 */
	public function errorCode()
	{
		if ($this->_iErrorCode)
		{
			return $this->_iErrorCode;
		}
		else
		{
			return 0;
		}
	}	

	/**
	 * Handle CDATA by storing it in a variable.
	 *
	 * @param object $oParser Object parser.
	 * @param string $sData CDATA string we parsed.
	 */
	private function _handleCdata(&$oParser, $sData)
	{
		$this->_sCdata .= $sData;
	}

	/**
	 * Handle the start of an element.
	 *
	 * @param object $oParser Object parser.
	 * @param string $sName Name of the element.
	 * @param array $aAttributes List of attributes.
	 */
	private function _handleElementStart(&$oParser, $sName, $aAttributes)
	{
		$this->_sCdata = '';

		foreach ($aAttributes AS $sKey => $sValue)
		{
			if (preg_match('#&[a-z]+;#i', $sValue))
			{
				$aAttributes[$sKey] = Phpfox::getLib('parse.format')->unhtmlspecialchars($sValue);
			}
		}

		array_unshift($this->_aStack, array(
			'name' => $sName, 
			'attributes' => $aAttributes, 
			'tag_count' => ++$this->_iTagCnt
		));
	}

	/**
	 * Handle the end of an element.
	 *
	 * @param unknown_type $oParser Object parser.
	 * @param unknown_type $sName Name of the element.
	 */
	private function _handleElementEnd(&$oParser, $sName)
	{
		$aTag = array_shift($this->_aStack);
		
		if ($aTag['name'] != $sName)
		{
			return;
		}

		$sOutput = $aTag['attributes'];

		if (trim($this->_sCdata) !== '' || $aTag['tag_count'] == $this->_iTagCnt)
		{
			if (sizeof($sOutput) == 0)
			{
				$sOutput = $this->_unescapeCdata($this->_sCdata);
			}
			else
			{
				$this->_addNode($sOutput, 'value', $this->_unescapeCdata($this->_sCdata));
			}
		}

		if (isset($this->_aStack[0]))
		{
			$this->_addNode($this->_aStack[0]['attributes'], $sName, $sOutput);
		}
		else
		{
			if ($this->_bIncludeFirstTag)
			{
				$this->_aData = array($sName => $sOutput);
			}
			else
			{
				$this->_aData = $sOutput;
			}
		}


		$this->_sCdata = '';
	}

	/**
	 * Add children.
	 *
	 * @param array $aChildrens Child ARRAY.
	 * @param string $sName Name of the tag.
	 * @param string $sValue Value of the tag.
	 */
	private function _addNode(&$aChildrens, $sName, $sValue)
	{
		if (!is_array($aChildrens) || !in_array($sName, array_keys($aChildrens)))
		{
			$aChildrens[$sName] = $sValue;
		}
		elseif (is_array($aChildrens[$sName]) && isset($aChildrens[$sName][0]))
		{
			$aChildrens[$sName][] = $sValue;
		}
		else
		{
			$aChildrens[$sName] = array($aChildrens[$sName]);
			$aChildrens[$sName][] = $sValue;
		}
	}

	/**
	 * Unescape CDATA.
	 *
	 * @param string $sXml XML code to parse.
	 * @return string Converted XML unescaped CDATA.
	 */
	private function _unescapeCdata($sXml)
	{
		static $sFind, $sReplace;

		if (!is_array($sFind))
		{
			$sFind = array('�![CDATA[', ']]�', "\r\n", "\n");
			$sReplace = array('<![CDATA[', ']]>', "\n", "\r\n");
		}

		return str_replace($sFind, $sReplace, $sXml);
	}
}

?>