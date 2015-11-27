<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

Phpfox::getLibClass('phpfox.image.interface');

/**
 * Abstract Layer for Image Libraries
 * Common methods that can be used on all the image libraries are packed into this class.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: abstract.class.php 5357 2013-02-14 07:09:29Z Raymond_Benc $
 * @abstract 
 */
abstract class Phpfox_Image_Abstract implements Phpfox_Image_Interface
{
    /**
     * Holds an ARRAY of meta information about an image
     *
     * @var arrat
     */
	protected $_aInfo = array();
    
	/**
	 * Supported file types
	 *
	 * @var array
	 */
    protected $_aTypes = array('', 'gif', 'jpg', 'png');    
	
    /**
     * Class constructor
     *
     */
	public function __construct()
    {    	
    }
    
    /**
     * Verification to check if an image is well an image when it is first being uploaded
     *
     * @param string $sPath Full path to where the image is located
     * @return bool TRUE if it is an image and FALSE if it isn't
     */
    public function isImage($sPath)
    {
    	if (($aInfo = @getImageSize($sPath)) && isset($this->_aTypes[$aInfo[2]]))
    	{    		    		
    		return true;
    	}
    	
    	return false;
    }    
    
    /**
     * Check to make sure the image being uploaded is a valid image extension that we support
     *
     * @param string $sExt File extension
     * @return bool TRUE is a valid file extension, FALSE if it isn't
     */
    public function isImageExtension($sExt)
    {
    	foreach ($this->_aTypes as $sType)
    	{
    		if (empty($sType))
    		{
    			continue;
    		}
    		
    		if ($sType == strtolower($sExt))
    		{
    			return true;
    		}
    	}
    	
    	return false;
    }
	
    /**
     * Load an image and attempt to get as much meta information about the image
     *
     * @param string $sPath Full path to where the image is located
     * @return bool TRUE on success, FALSE on failure
     */
	protected function _load($sPath)
    {                
        if (Phpfox::getParam(array('balancer', 'enabled')) && !file_exists($sPath))
        {
			preg_match('/(.*)\/(.*)-(.*)-(.*)_(.*?)/i', $sPath, $aLbMatches);
			$aServers = Phpfox::getParam(array('balancer', 'servers'));
			foreach ($aServers as $iIp => $aServer)
			{
				if ($aServer['id'] == $aLbMatches[4])
				{
					$sPath = str_replace(PHPFOX_DIR, $aServer['url'], $sPath);
					
					break;
				}				
			}		
		}
		
		if (defined('PHPFOX_IS_HOSTED_SCRIPT'))
		{
			$sPath = str_replace(PHPFOX_DIR, rtrim(Phpfox::getParam('core.rackspace_url'), '/') . '/', $sPath);
		}
		
		$this->sPath = $sPath;
    	
    	if ($this->_aInfo = @getImageSize($sPath))
        {            
            if (!isset($this->_aTypes[$this->_aInfo[2]]))
            {
            	return false;
            }
        	
        	$this->nW = $this->_aInfo[0];
            $this->nH = $this->_aInfo[1];
            $this->sType = $this->_aTypes[$this->_aInfo[2]];
            $this->sMimeType = $this->_aInfo['mime'];
            
            return true;
        }
        
        return false;
    }
    
    /**
     * Destory all the variables associated with the current image in preperation to manipulate another image.
     *
     */
    protected function _destroy()
    {
    	$this->sPath = null;
    	$this->_aInfo = array();
    	$this->nW = null;
    	$this->nH = null;
    	$this->sType = null;
    	$this->sMimeType = null;
    }
    
    /**
     * Transform a HEX to RGB
     *
     * @param string $sHex HEX string
     * @return array ARRAY of an RGB array(red, blue, green)
     */
    protected function _hex2rgb($sHex)
    {
        $iRed = substr($sHex, 0, 2);
        $iGreen = substr($sHex, 2, 2);
        $iBlue = substr($sHex, 4, 2);
        $iRed = hexdec($iRed);
        $iGreen = hexdec($iGreen);
        $iBlue = hexdec($iBlue);
        
        return array($iRed, $iBlue, $iGreen);
    }    
    	
    /** 
     * Calculates size for resizing.
     * 
     * @param int $nMaxW  maximum width
     * @param int $nMaxH  maximum height
     * @return array new size (width, height)
     */
    protected function _calcSize($nMaxW, $nMaxH)
    {
        $w  = $nMaxW;
        $h  = $nMaxH;

        if ($this->nW > $nMaxW)
        {
            $w  = $nMaxW;
            $h  = floor($this->nH * $nMaxW/$this->nW);
            if ($h > $nMaxH)
            {
              $h  = $nMaxH;
              $w  = floor($this->nW * $nMaxH/$this->nH);
            }
        }
        elseif ($this->nH > $nMaxH)
        {
            $h  = $nMaxH;
            $w  = floor($this->nW * $nMaxH/$this->nH);
        }

        return array($w, $h);
    } 
}

?>
