<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * XML Builder
 * Class is used to create and build XML files.
 * 
 * PHP usage:
 * <code>
 * $oXml = Phpfox::getLib('xml.builder');
 * $oXml->addGroup('foo', array('bar' => 'value'));
 * $oXml->addTag('sample', 'This is some value.', array('extra' => 'info'));
 * $oXml->closeGroup();
 * </code>
 * 
 * XML output of the PHP code:
 * <code>
 * <foo var="value">
 * 		<sample extra="info">
 * 			This is some value.
 * 		</sample>
 * </foo>
 * </code>
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: builder.class.php 1668 2010-07-12 08:54:32Z Raymond_Benc $
 */
class Phpfox_Xml_Builder
{
	/**
	 * History of open tags.
	 *
	 * @var array
	 */
	private $_aOpenTags = array();
	
	/**
	 * Current tab.
	 *
	 * @var string
	 */
	private $_sTabs;	
	
	/**
	 * XML code we are building.
	 *
	 * @var strig
	 */
	private $_sDoc;
	
	/**
	 * XML settings.
	 *
	 * @var array
	 */
	private $_aXml = array();
	
	/**
	 * Class constructor.
	 *
	 */
	public function __construct()
	{
	}
	
	/**
	 * Set XML settings.
	 *
	 * @param array $aParams ARRAY of XML settings.
	 */
	public function setXml($aParams)
	{
		$this->_aXml = $aParams;
	}
	
	/**
	 * Creates an XML group.
	 *
	 * @param string $sTag Group name.
	 * @param array $aAttr Optional ARRAY of attributes.
	 */
	public function addGroup($sTag, $aAttr = array())
	{
		$this->_aOpenTags[] = $sTag;
		$this->_sDoc .= $this->_sTabs . $this->_buildTag($sTag, $aAttr) . "\n";
		$this->_sTabs .= "\t";
	}

	/**
	 * Close an open XML group.
	 *
	 */
	public function closeGroup()
	{
		$sTag = array_pop($this->_aOpenTags);
		$this->_sTabs = substr($this->_sTabs, 0, -1);
		$this->_sDoc .= $this->_sTabs . "</$sTag>\n";
	}

	/**
	 * Create an XML tag.
	 *
	 * @param string $sTag Name of the tag.
	 * @param string $sContent Tag inner content.
	 * @param array $aAttr Optional ARRAY of attributes.
	 * @param bool $bCdata TRUE to force CDATA.
	 * @param bool $bHtmlSpecialChars TRUE to convert HTML characters.
	 * @return object Return self.
	 */
	public function addTag($sTag, $sContent = '', $aAttr = array(), $bCdata = false, $bHtmlSpecialChars = false)
	{
		$this->_sDoc .= $this->_sTabs . $this->_buildTag($sTag, $aAttr, ($sContent === ''));
		if ($sContent !== '')
		{
			if ($bHtmlSpecialChars)
			{
				$this->_sDoc .= $this->_htmlSpecialcharsUni($sContent);
			}
			elseif ($bCdata || preg_match('/[\<\>\&\'\"\[\]]/', $sContent))
			{
				$this->_sDoc .= '<![CDATA[' . $this->_escapeCdata($sContent) . ']]>';
			}
			else
			{
				$this->_sDoc .= $sContent;
			}
			$this->_sDoc .= "</$sTag>\n";
		}
		
		return $this;
	}
	
	/**
	 * Return XML data we have built so far.
	 *
	 * @return string
	 */
	public function output()
	{
		if (!empty($this->_aOpenTags))
		{
			return Phpfox_Error::trigger('Certain tags are still open.', E_USER_ERROR);
		}
		
		if (ob_get_length() > 0) 
		{
			ob_clean();
		}
		
		$sDoc = (count($this->_aXml) ? '<?xml version="' . $this->_aXml['version'] . '" encoding="' . $this->_aXml['encoding'] . '"?>' . "\n" : (defined('PHPFOX_XML_SKIP_STAMP') ? "" : "<?php\n/** \$Id: \$ **/\ndefined('PHPFOX') or exit('NO DICE!');\n?>\n"));		
		$sDoc .= rtrim($this->_sDoc);		
		
		$this->_aOpenTags = array();
		$this->_sTabs = '';
		$this->_sDoc = '';
		
		return $sDoc;
	}	

	/**
	 * Build an XML tag.
	 *
	 * @param string $sTag XML tag name.
	 * @param array $aAttr ARRAY of tag attributes.
	 * @param bool $closing TRUE to close the tag.
	 * @return string XML tag code.
	 */
	private function _buildTag($sTag, $aAttr, $closing = false)
	{
		$tmp = "<$sTag";
		if (!empty($aAttr))
		{
			foreach ($aAttr as $aAttr_name => $aAttr_key)
			{
				if (strpos($aAttr_key, '"') !== false)
				{
					$aAttr_key = $this->_htmlSpecialcharsUni($aAttr_key);
				}
				$tmp .= " $aAttr_name=\"$aAttr_key\"";
			}
		}
		$tmp .= ($closing ? " />\n" : '>');
		return $tmp;
	}

	/**
	 * Escapes CDATA.
	 *
	 * @param string $sXml XML data to parse.
	 * @return string Parsed and escaped CDATA.
	 */
	private function _escapeCdata($sXml)
	{
		$sXml = preg_replace('#[\\x00-\\x08\\x0B\\x0C\\x0E-\\x1F]#', '', $sXml);

		return str_replace(array('<![CDATA[', ']]>'), array('�![CDATA[', ']]�'), $sXml);
	}

	/**
	 * Convert HTML characters.
	 *
	 * @param string $sText XML string to convert.
	 * @param bool $bEntities TRUE to convert entities.
	 * @return string Return converted XML data.
	 */
	private function _htmlSpecialcharsUni($sText, $bEntities = true)
	{
		return str_replace(array('<', '>', '"'), array('&lt;', '&gt;', '&quot;'), preg_replace('/&(?!' . ($bEntities ? '#[0-9]+|shy' : '(#[0-9]+|[a-z]+)') . ';)/si', '&amp;', $sText));
	}	
}

?>