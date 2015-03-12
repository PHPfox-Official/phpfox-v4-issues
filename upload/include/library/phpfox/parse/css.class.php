<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * CSS Code Parser
 * Parses CSS code passed on by end-users and make sure the data being passed is valid.
 * Class is connected with the profile designer, which allows end-users the ability to 
 * create custom profiles based on CSS we allow within this class.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: css.class.php 5086 2013-01-05 13:23:21Z Miguel_Espinoza $
 */
class Phpfox_Parse_Css
{
	/**
	 * Fonts (font-family)
	 *
	 * @var array
	 */
	private $_aFonts = array(
		'Microsoft Sans Serif',
		'Verdana',
		'Arial Black',
		'Arial',
		'Courier New',
		'Palatino Linotype',
		'Tahoma',
		'Franklin Gothic Medium',
		'Lucida Console'
	);
	
	/**
	 * Positions (position)
	 *
	 * @var array
	 */
	private $_aPositions = array(
		'top left',
		'top center',
		'top right',
		'center left',
		'center center',
		'center right',
		'bottom left',
		'bottom center',
		'bottom right'
	);
	
	/**
	 * Background Repaat (background-repeat)
	 *
	 * @var array
	 */
	private $_aRepeat = array(
		'no-repeat',
		'repeat-x',
		'repeat-y',
		'repeat'
	);
	
	/**
	 * Background Attachment (background-attachment)
	 *
	 * @var array
	 */
	private $_aAttachment = array(
		'scroll',
		'fixed'
	);
	
	/**
	 * Font Sizes (font-size)
	 *
	 * @var array
	 */
	private $_aFontSizes = array(
		'8px',
		'9px',
		'10px',
		'11px',
		'12px',
		'14px',
		'16px'
	);
	
	/**
	 * Border Widths (border-width)
	 *
	 * @var array
	 */
	private $_aBorderWidths = array(
		'0px',
		'1px',
		'2px',
		'3px',
		'4px',
		'5px',
		'6px',
		'7px',
		'8px'
	);
	
	/**
	 * Border Styles (border-style)
	 *
	 * @var array
	 */
	private $_aBorderStyles = array(
		'none',
		'dotted',
		'dashed',
		'solid',
		'double',
		'groove',
		'ridge',
		'inset',
		'outset',
		'inherit'
	);
	
	/**
	 * Padding (padding)
	 *
	 * @var array
	 */
	private $_aPaddingSizes = array(
		'0px',
		'1px',
		'2px',
		'3px',
		'4px',
		'5px',
		'6px',
		'7px',
		'8px'	
	);
	
	/**
	 * Font Styles (font-style)
	 *
	 * @var array
	 */
	private $_aFontStyles = array(
		'normal',
		'italic',
		'oblique'
	);
	
	/**
	 * Font Weight (font-weight)
	 *
	 * @var array
	 */
	private $_aFontWeights = array(
		'normal',
		'bold',
		'bolder',
		'lighter'
	);
	
	/**
	 * Text Transforms (text-transform)
	 *
	 * @var array
	 */
	private $_aTextTransforms = array(
		'none',
		'capitalize',
		'uppercase',
		'lowercase'
	);
	
	/**
	 * Text Decoration (text-decoration)
	 *
	 * @var array
	 */
	private $_aTextDecorations = array(
		'none',
		'underline',
		'overline',
		'line-through'		
	);
	
	/**
	 * Regex for CSS hex and image links.
	 *
	 * @var array
	 */
	private $_aRegex = array(
		'hex' => '/^#([a-fA-F0-9]){6}$/',
		'link' => '/^(?:(ftp|http|https):)?(?:\/\/(?:((?:%[0-9a-f]{2}|[\-a-z0-9_.!~*\'\(\);:&=\+\$,])+)@)?(?:((?:[a-z0-9](?:[\-a-z0-9]*[a-z0-9])?\.)*[a-z](?:[\-a-z0-9]*[a-z0-9])?)|([0-9]{1,3}(?:\.[0-9]{1,3}){3}))(?::([0-9]*))?)?((?:\/(?:%[0-9a-f]{2}|[\-a-z0-9_.!~*\'\(\):@&=\+\$,;])+)+)?\/?(?:\?.*)?$/i'
	);		
	
	/**
	 * ARRAY of CSS code to parse.
	 *
	 * @var array
	 */
	private $_aCss = '';
	
	/**
	 * Evil CSS properties we need to remove.
	 *
	 * @var array
	 */
	private $_aRemoveProperties = array(
		'-moz-binding'
	);
	
	/**
	 * Class constructor.
	 *
	 */
	public function __construct()
	{		
	}
	
	/**
	 * Convert the ARRAY of CSS into CSS code.
	 *
	 * @return string CSS code.
	 */
  	public function getCss() 
  	{
    	$sResult = '';    
    	if (is_array($this->_aCss))
    	{
	    	foreach($this->_aCss as $sSelector => $aValues) 
	    	{    		
	    		$sSelector = trim($sSelector);
	    
	    		$sResult .= $sSelector . " {\n";
	      		foreach($aValues as $sProperty => $sValue) 
	      		{        	
	      			if (in_array($sProperty, $this->_aRemoveProperties))
	        		{
	        			continue;
	        		}
	      		
	        		if (preg_match('/expression/i', $sValue))
	        		{
	        			continue;
	        		}
	        		
	      			$sResult .= $sProperty . ": {$sValue};\n";
	      		}
	      		$sResult .= "}\n\n";
	    	}
    	}
    	
    	return $sResult;
  	}	
	
  	/**
  	 * Check if a color is a valid HEX.
  	 *
  	 * @param string $sHex HEX Color.
  	 * @return  bool TRUE on success, FALSE on failure.
  	 */
	public function isHex($sHex)
	{
		return ($sHex == 'transparent' ? true : preg_match($this->_aRegex['hex'], $sHex));
	}
	
	/**
	 * Make sure images added to CSS are really images.
	 *
	 * @param string $sHex Image path.
	 * @return bool TRUE on success, FALSE on failure.
	 */
	public function isImageLink($sHex)
	{
		return preg_match($this->_aRegex['link'], $sHex);
	}

	/**
	 * Clean out the css by running the method parseCss().
	 *
	 * @see self::parseCSs()
	 * @param string $sCss CSS code to parse.
	 * @return string Parsed CSS code that is valid and ready for output.
	 */
	public function cleanCss($sCss)
	{
		$this->parseCss($sCss);
		
		return $this->getCss();
	}
	
	/**
	 * Adds a CSS property and value to the global CSS ARRAY that will later
	 * be converted into CSS code.
	 *
	 * @param string $sKey CSS property.
	 * @param string $sCodeStr CSS value.
	 */
  	public function addCss($sKey, $sCodeStr) 
  	{
	    $sKey = strtolower($sKey);
    	$sCodeStr = strtolower($sCodeStr);
    	if(!isset($this->_aCss[$sKey])) 
    	{
      		$this->_aCss[$sKey] = array();
    	}
    
    	$aCodes = explode(';', $sCodeStr);
    	if(count($aCodes) > 0) 
    	{
      		foreach($aCodes as $sCode) 
      		{
        		$sCode = trim($sCode);        
        		if (empty($sCode))
        		{
        			continue;
        		}
        		list($sCodekey, $sCodevalue) = explode(':', $sCode, 2);
        
        		if(strlen($sCodekey) > 0) 
        		{
        			$sCodekey = trim($sCodekey);
        			$sCodevalue = trim($sCodevalue);
        			if (
        				$sCodekey == 'visibility'
        				|| $sCodekey == 'display'
        			)
          			{
          				continue;
          			}
        			
        			$this->_aCss[$sKey][trim($sCodekey)] = trim($sCodevalue);
        		}
      		}
    	}
  	} 	
	
  	/**
  	 * Parse CSS code and remove evil tags, comments.
  	 *
  	 * @param string $sCss CSS Code we need to parse.
  	 */
 	public function parseCss($sCss) 
 	{    
    	$sCss = preg_replace('/<(.*?)>(.*?)<\/(.*?)>/i', '', $sCss);
    	$sCss = strip_tags($sCss);
    	$sCss = preg_replace("/\/\*(.*)?\*\//Usi", "", $sCss);

    	$aParts = explode("}",$sCss);
    	if(count($aParts) > 0) 
    	{
      		foreach($aParts as $sPart) 
      		{
      			$sPart = trim($sPart);
      			if (empty($sPart))
      			{
      				continue;
      			}
        		
      			list($aKeystr, $sCodeStr) = explode('{',$sPart);
        		$aKeystr = trim($aKeystr);
        		if (empty($aKeystr))
        		{
        			continue;
        		}
        		
        		$aKeys = explode(',', $aKeystr);
        		if(count($aKeys) > 0) 
        		{
          			foreach($aKeys as $sKey) 
          			{
            			if(strlen($sKey) > 0) 
            			{
              				$sKey = str_replace("\n", "", $sKey);
              				$sKey = str_replace("\\", "", $sKey);
              				
              				$this->addCss($sKey, trim($sCodeStr));
            			}
          			}
        		}
      		}
    	}    
  	}	
	
  	/**
  	 * Run sanity checks on a CSS property and value to make sure they are valid.
  	 *
  	 * @param string $sProperty CSS property to check.
  	 * @param string $sValue CSS property value to check.
  	 * @return bool TRUE if value is valid, FALSE if value is invalid.
  	 */
	public function process($sProperty, $sValue)
	{		
		(($sCmd = Phpfox::getLib('template')->getXml('design_css')) ? eval($sCmd) : null);
		
		$aWidths = array();
		foreach ($aAdvanced as $aCss)
		{
			if (isset($aCss['design']['width']) && isset($aCss['id']) && $aCss['id'] = 'page_width')
			{
				$aWidths = array_values($aCss['design']['width']);
				
				break;
			}
		}		
		
		switch ($sProperty)
		{
			case 'width':
				if (in_array($sValue, $aWidths))
				{
					return true;
				}			
				break;			
			case 'font-family':
				if (in_array($sValue, $this->getFonts()))
				{
					return true;
				}
				break;	
			case 'background':
				if ($sValue == 'none')
				{
					return true;
				}
				break;
			case 'font-size':	
				if (in_array($sValue, $this->getFontSizes()))
				{					
					return true;
				}
				break;
			case 'font-style':	
				if (in_array($sValue, $this->getFontStyles()))
				{					
					return true;
				}
				break;
			case 'font-weight':	
				if (in_array($sValue, $this->getFontWeights()))
				{					
					return true;
				}
				break;
			case 'font-color':
				if ($this->isHex($sValue))
				{
					return true;
				}
				break;		
			case 'background-color':
				if ($this->isHex($sValue))
				{
					return true;
				}
				break;		
			case 'background-image':
				if (preg_match('/url\(\'(.*?)\'\)/i', $sValue, $aMatches))
				{
					$sValue = $aMatches[1];					
				}
				if ($this->isImageLink($sValue))
				{
					return true;
				}
				break;											
			case 'background-position':
				if (in_array($sValue, $this->getPositions()))
				{
					return true;
				}
				break;	
			case 'background-attachment':
				if (in_array($sValue, $this->_aAttachment))
				{
					return true;
				}
				break;	
			case 'background-repeat':
				if (in_array($sValue, $this->_aRepeat))
				{
					return true;
				}
				break;	
			case 'text-align':
				if (in_array($sValue, $this->getTextAlign()))
				{
					return true;
				}
				break;		
			case 'text-transform':
				if (in_array($sValue, $this->getTextTransforms()))
				{
					return true;
				}
				break;	
			case 'text-decoration':
				if (in_array($sValue, $this->getTextDecorations()))
				{
					return true;
				}
				break;				
			default:				
				if (substr($sProperty, 0, 7) == 'border-')
				{					
					foreach ($this->getBorders() as $sBorder)
					{
						if ($sProperty == $sBorder . 'style')
						{
							if (in_array($sValue, $this->getBorderStyles()))
							{
								return true;
							}
						}
						elseif ($sProperty == $sBorder . 'width')
						{
							if (in_array($sValue, $this->getBorderWidths()))
							{
								return true;
							}
						}
						elseif ($sProperty == $sBorder . 'color')
						{
							if ($this->isHex($sValue))
							{
								return true;
							}
						}						
					}					
				}
				elseif (substr($sProperty, 0, 8) == 'padding-')
				{
					foreach ($this->getPaddings() as $sPadding)
					{
						if (in_array($sValue, $this->getPaddingSizes()))
						{
							return true;
						}
					}
				}
				break;			
		}
		
		return false;
	}
	
	/**
	 * Get all positions.
	 *
	 * @see self::_aPositions
	 * @return array
	 */
	public function getPositions()
	{
		return $this->_aPositions;	
	}

	/**
	 * Get all fonts.
	 *
	 * @see self::_aFonts
	 * @return array
	 */	
	public function getFonts()
	{
		return $this->_aFonts;
	}
	
	/**
	 * Get all border widths.
	 *
	 * @see self::_aBorderWidths
	 * @return array
	 */	
	public function getBorderWidths()
	{
		return $this->_aBorderWidths;
	}
	
	/**
	 * Get all font sizes.
	 *
	 * @see self::_aFontSizes
	 * @return array
	 */	
	public function getFontSizes()
	{
		return $this->_aFontSizes;
	}
	
	/**
	 * Get all font weights.
	 *
	 * @see self::_aFontWeights
	 * @return array
	 */	
	public function getFontWeights()
	{
		return $this->_aFontWeights;
	}

	/**
	 * Get all font styles.
	 *
	 * @see self::_aFontStyles
	 * @return array
	 */	
	public function getFontStyles()
	{
		return $this->_aFontStyles;
	}	
	
	/**
	 * Get all padding sizes.
	 *
	 * @see self::_aPaddingSizes
	 * @return array
	 */	
	public function getPaddingSizes()
	{
		return $this->_aPaddingSizes;
	}
	
	/**
	 * Get all borders.
	 *
	 * @return array
	 */
	public function getBorders()
	{
		return array(
			'border-top-',
			'border-right-',
			'border-bottom-',
			'border-left-'
		);
	}
	
	/**
	 * Get all paddings.
	 *
	 * @return array
	 */
	public function getPaddings()
	{
		return array(
			'padding-top',
			'padding-right',
			'padding-bottom',
			'padding-left'
		);
	}	
	
	/**
	 * Get all border styles.
	 *
	 * @see self::_aBorderStyles
	 * @return array
	 */		
	public function getBorderStyles()
	{
		return $this->_aBorderStyles;
	}
	
	/**
	 * Get all text allignments.
	 *
	 * @return array
	 */
	public function getTextAlign()
	{
		return array(
			'left',
			'right',
			'center',
			'justify'
		);
	}	
	
	/**
	 * Get all text transformations.
	 *
	 * @see self::_aTextTransforms
	 * @return array
	 */		
	public function getTextTransforms()
	{
		return $this->_aTextTransforms;
	}
	
	/**
	 * Get all text decorations.
	 *
	 * @see self::_aTextDecorations
	 * @return array
	 */		
	public function getTextDecorations()
	{
		return $this->_aTextDecorations;
	}
	
	/**
	 * Get JavaScript code used to verify the validity of a CSS property value.
	 *
	 * @return string JavaScript code used to validate CSS property values.
	 */
	public function getJavaScript()
	{
		$sJs = '<script type="text/javascript">';
		$sJs .= 'var oValidateCss = {';
		
		(($sCmd = Phpfox::getLib('template')->getXml('design_css')) ? eval($sCmd) : null);
		
		$aWidths = array();
		if (isset($aAdvanced))
		{
		    foreach ($aAdvanced as $aCss)
		    {
			    if (isset($aCss['design']['width']) && isset($aCss['id']) && $aCss['id'] = 'page_width')
			    {
				    $aWidths = array_values($aCss['design']['width']);

				    break;
			    }
		    }
		}		
				
		$sJs .= '\'width\': ' . $this->_build($aWidths) . ',';
		$sJs .= '\'font-family\': ' . $this->_build($this->getFonts()) . ',';
		$sJs .= '\'font-size\': ' . $this->_build($this->getFontSizes()) . ',';
		$sJs .= '\'font-style\': ' . $this->_build($this->getFontStyles()) . ',';
		$sJs .= '\'font-weight\': ' . $this->_build($this->getFontWeights()) . ',';
		$sJs .= '\'text-align\': ' . $this->_build($this->getTextAlign()) . ',';
		$sJs .= '\'text-transform\': ' . $this->_build($this->getTextTransforms()) . ',';
		$sJs .= '\'text-decoration\': ' . $this->_build($this->getTextDecorations()) . ',';
		$sJs .= '\'background-position\': ' . $this->_build($this->getPositions()) . ',';
		$sJs .= '\'background-attachment\': ' . $this->_build($this->_aAttachment) . ',';
		$sJs .= '\'background-repeat\': ' . $this->_build($this->_aRepeat) . ',';
		foreach ($this->getBorders() as $sBorder)
		{
			$sJs .= '\'' . $sBorder . 'style\': ' . $this->_build($this->getBorderStyles()) . ',';	
			$sJs .= '\'' . $sBorder . 'width\': ' . $this->_build($this->getBorderWidths()) . ',';	
		}
		foreach ($this->getPaddings() as $sPadding)
		{
			$sJs .= '\'' . $sPadding . '\': ' . $this->_build($this->getPaddingSizes()) . ',';				
		}		
		$sJs .= 'isHex: function(sHex) { if (sHex == \'#transparent\') { return true; } if (sHex.search(' . $this->_aRegex['hex'] . ') == -1) { return false; } return true;},';
		$sJs .= 'isImageLink: function(sLink) { if (sLink.search(' . $this->_aRegex['link'] . ') == -1) { return false; } return true;}';
		
		$sJs .= '};';
		$sJs .= '</script>';
		
		return $sJs;
	}
	
	/**
	 * Build javascript code.
	 *
	 * @see self::getJavaScript()
	 * @param array $aBuild ARRAY of CSS properties and values to build.
	 * @return string JavaScript code.
	 */
	private function _build($aBuild)
	{
		$sJs = '';
		foreach ($aBuild as $sKey)
		{
			$sJs .= '\'' . $sKey . '\': true,';
		}

		return '{' . rtrim($sJs, ',') . '}';	
	}
}

?>