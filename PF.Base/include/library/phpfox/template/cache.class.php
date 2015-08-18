<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Template Cache
 * Class handles the caching of a template file and converts any
 * custom code into PHP code. Class is only loaded if the template
 * cache file does not exist.
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @subpackage 		Template
 * @version 		$Id: cache.class.php 6361 2013-07-25 08:37:06Z Raymond_Benc $
 */
class Phpfox_Template_Cache extends Phpfox_Template
{
	/**
	 * Foreach stack.
	 * 
	 * @var array
	 */
	private $_aForeachElseStack = array();
	
	/**
	 * Require stack.
	 * 
	 * @var array
	 */
	private $_aRequireStack = array();
	
	/**
	 * PHP blocks. {php}{/php}
	 * 
	 * @var array
	 */
	private $_aPhpBlocks = array();
	
	/**
	 * Section blocks. {section}{/section}
	 * 
	 * @var array
	 */
	private $_aSectionelseStack = array();
	
	/**
	 * Module blocks.
	 * 
	 * @var array
	 */
	private $_aModuleBlocks = array();
	
	/**
	 * Literal blocks. {literal}{/literal}
	 * 
	 * @var array
	 */
	private $_aLiterals = array();

	/**
	 * String regex.
	 * 
	 * @var string
	 */
	private $_sDbQstrRegexp = '"[^"\\\\]*(?:\\\\.[^"\\\\]*)*"';
	
	/**
	 * String regex.
	 * 
	 * @var string
	 */	
	private $_sSiQstrRegexp = '\'[^\'\\\\]*(?:\\\\.[^\'\\\\]*)*\'';
	
	/**
	 * Bracket regex.
	 * 
	 * @var string
	 */	
	private $_sVarBracketRegexp = '\[[\$|\#]?\w+\#?\]';
	
	/**
	 * Variable regex.
	 * 
	 * @var string
	 */	
	private $_sSvarRegexp = '\%\w+\.\w+\%';
	
	/**
	 * Function regex.
	 * 
	 * @var string
	 */	
	private $_sFuncRegexp = '[a-zA-Z_]+';

	private $_aBlocklets = [];

	private $_sCurrentFile = '';
	
	/**
	 * Class constructor. Build all the regex we will be using
	 * with this class.
	 */
	public function __construct()
	{
		$this->_sQstrRegexp = '(?:' . $this->_sDbQstrRegexp . '|' . $this->_sSiQstrRegexp . ')';

		$this->_sDvarRegexp = '\$[a-zA-Z0-9_]{1,}(?:' . $this->_sVarBracketRegexp . ')*(?:\.\$?\w+(?:' . $this->_sVarBracketRegexp . ')*)*';

		$this->_sCvarRegexp = '\#[a-zA-Z0-9_]{1,}(?:' . $this->_sVarBracketRegexp . ')*(?:' . $this->_sVarBracketRegexp . ')*\#';

		$this->_sVarRegexp = '(?:(?:' . $this->_sDvarRegexp . '|' . $this->_sCvarRegexp . ')|' . $this->_sQstrRegexp . ')';

		$this->_sModRegexp = '(?:\|@?[0-9a-zA-Z_]+(?::(?>-?\w+|' . $this->_sDvarRegexp . '|' . $this->_sQstrRegexp .'))*)';		
	}

	/**
	 * Compile a template file and cache it to a PHP flat file.
	 * 
	 * @param string $sName Name of the template.
	 * @param string $sData Contents of the template.
	 * @param bool $bRemoveHeader TRUE to remove the time stamp we added to the header of each cache file.
	 * @param bool $bSkipDbCheck TRUE to skip checks on the database to see if the cache file exists there as well.
	 * @return mixed We only return the templates content if the installer does not have a writable directory.
	 */
	public function compile($sName, $sData = null, $bRemoveHeader = false, $bSkipDbCheck = false)
	{
		/*
		if (!defined('PHPFOX_INSTALLER') && !defined('PHPFOX_LIVE_TEMPLATES'))
		{						
			$sNewName = str_replace('_ajax.php', '.php', $sName);
			if (preg_match("/(.*?)template_(.*?)_(.*?)_template_(.*?)\.php$/i", str_replace('template/', 'template_', $sNewName), $aMatches) && isset($aMatches) && $aMatches[2] == 'frontend')
			{			
				$oDb = Phpfox_Database::instance();
				$aTemplate = $oDb->select('html_data')
					->from(Phpfox::getT('theme_template'))
					->where("folder = '" . parent::$_sStaticThemeFolder . "' AND type_id = 'layout' AND name = '" . $oDb->escape($aMatches[4]) . "'")
					->execute('getSlaveRow');				
			}
			elseif ($bSkipDbCheck === false && preg_match("/(.*?)template_(.*?)_template_(.*?)_(.*?)_(.*?)\.php$/i", str_replace('template/', 'template_', $sNewName), $aMatches) && isset($aMatches[5]) && !preg_match("/admincp_(.*?)/", $aMatches[4]))
			{
				$oDb = Phpfox_Database::instance();

				$aTemplate = $oDb->select('html_data')
					->from(Phpfox::getT('theme_template'))
					->where("folder = '" . parent::$_sStaticThemeFolder . "' AND type_id = '" . $oDb->escape($aMatches[4]) . "' AND module_id = '" . $oDb->escape($aMatches[2]) . "' AND name = '" . $oDb->escape(str_replace('_', '/', $aMatches[5])) . "'")
					->execute('getSlaveRow');				
			}
		}
		*/
		
		$this->_sCurrentFile = $sName;

		$sData = $this->_parse((isset($aTemplate['html_data']) ? $aTemplate['html_data'] : $sData), $bRemoveHeader);

		if (defined('PHPFOX_INSTALLER_NO_TMP'))
		{
			return $sData;
		}

		$sContent = '';
		$aLines = explode("\n", $sData);

		foreach ($aLines as $sLine)
		{
			if (preg_match("/<\?php(.*?)\?>/i", $sLine))
			{
				if (substr(trim($sLine), 0, 5) == '<?php')
				{
					$sContent .= trim($sLine) . "\n";
				}
				else
				{
					$sContent .= $sLine . "\n";
				}
			}
			else
			{
				$sContent .= $sLine . "\n";
			}
		}

		$sContent = preg_replace("/defined\('PHPFOX'\) or exit\('NO DICE!'\);/is", "", $sContent);
		$sContent = "<?php defined('PHPFOX') or exit('NO DICE!'); ?>\n" . $sContent;
		$sContent = str_replace('<body>', '<body id="page_<?php echo Phpfox::getLib(\'module\')->getPageId(); ?>">', $sContent);

        if ($sPlugin = Phpfox_Plugin::get('library_template_cache_compile__1')){eval($sPlugin);if (isset($aPluginReturn)){return $aPluginReturn;}}

		/*
		if (count($this->_aBlocklets)) {
			if ($sLocation) {
				if (!is_dir(PHPFOX_DIR_CACHE . 'blocklet/')) {
					mkdir(PHPFOX_DIR_CACHE . 'blocklet/');
				}
				$sNewName = PHPFOX_DIR_CACHE . 'blocklet/' . Phpfox_Module::instance()->getFullControllerName() . '.blocklets.php';
				// d(Phpfox_Module::instance()->getFullControllerName());
				// d($this->_aBlocklets[1]);
				$locations = [];
				foreach ($this->_aBlocklets[1] as $key => $data) {
					$locations[$key] = $data;
				}

				$sBlocks = "<?php class blocklet_" . md5($sNewName) . " { \n";
				$sBlocks .= "private \$_object;\n";
				$sBlocks .= "public function __construct() {
					\$this->_object = Phpfox_Template::instance();

				}

				public function __get(\$name) {
					return \$this->_object->getVar();
				}

				";
				foreach ($this->_aBlocklets[2] as $key => $block) {

					$sBlocks .= "public function location_{$locations[$key]}() { ?>\n";
					$sBlocks .= $this->_parse($block);
					$sBlocks .= "\n<?php }\n";
				}
				$sBlocks .= " }";

				file_put_contents($sNewName, $sBlocks);
			}
		}
		*/

		if (defined('PHPFOX_IS_HOSTED_SCRIPT'))
		{
			$oCache = Phpfox::getLib('cache');
			$sId = $oCache->set(md5($sName));
			$oCache->save($sId, $sContent);
			
			return;
		}
		if ($rFile = @fopen($sName, 'w+'))
		{
			fwrite($rFile, $sContent);
			fclose($rFile);

			if (!defined('PHPFOX_INSTALLER'))
			{
				Phpfox::getLib('cache')->saveInfo($sName, 'template', $sContent, filesize($sName));
			}
		}
		else
		{
			return Phpfox_Error::trigger('Unable to cache template file: ' . $sName, E_USER_NOTICE);
		}
	}

	/**
	 * Get all the template files that have been cached.
	 *
	 * @return array List of cached files.
	 */
	public function getAll()
	{
		if ($hDir = @opendir(PHPFOX_DIR_CACHE))
		{
			$aFiles = array();
			while ($sFile = readdir($hDir))
			{
				if (substr($sFile, 0, 9) != 'template_')
				{
					continue;
				}

				$aFiles[] = array(
					'id' => md5($sFile),
					'name' => $sFile,
					'size' => filesize(PHPFOX_DIR_CACHE . $sFile),
					'date' => filemtime((PHPFOX_DIR_CACHE . $sFile)),
					'type' => 'Template'
				);
			}
			closedir($hDir);

			return $aFiles;
		}

		return array();
	}

	/**
	 * Remove a cache file or the entire directory.
	 *
	 * @param mixed $sName Pass nothing to remove all cached files, or the STRING name of the file to just remove that file.
	 * @return bool TRUE if removed, FALSE if not.
	 */
	public function remove($sName = null)
	{
		if ($sName === null)
		{
			foreach ($this->getAll() as $aFile)
			{
				@unlink(PHPFOX_DIR_CACHE . $aFile['name']);
			}
			return true;
		}

		if (file_exists(PHPFOX_DIR_CACHE . $sName))
		{
			@unlink(PHPFOX_DIR_CACHE . $sName);
			return true;
		}

		return false;
	}

	/**
	 * Parse a templates content and convert it into PHP.
	 *
	 * @see self::_parse()
	 * @param string $sData Content of the template.
	 * @param bool $bRemoveHeader TRUE to remove cache headers in the template.
	 * @return string Parsed and converted content.
	 */
	public function parse($sData, $bRemoveHeader = false)
	{
		$sData = $this->_parse($sData, $bRemoveHeader);

		return $sData;
	}

	/**
	 * Parse a templates content and convert it into PHP.
	 *
	 * @param string $sData Content of the template.
	 * @param bool $bRemoveHeader TRUE to remove cache headers in the template.
	 * @return string Parsed and converted content.
	 */
	private function _parse($sData, $bRemoveHeader = false)
	{
        if ($sPlugin = Phpfox_Plugin::get('library_template_cache_parse__1')){eval($sPlugin);if (isset($aPluginReturn)){return $aPluginReturn;}}
        
		$sLdq = preg_quote($this->sLeftDelim);
		$sRdq = preg_quote($this->sRightDelim);
		$aText = array();
		$sCompiledText = '';

		// Remove phpFox SVN headers
		$sData = preg_replace("/\<\!phpfox(.*?)\>/is", "", $sData);

		// Add a security token in a form
		// $sData = preg_replace("/<form(.*?)>(.*?)<\/form>/ise", "'' . \$this->_parseForm('$1', '$2') .''", $sData);
		$sData = preg_replace_callback("/<form(.*?)>(.*?)<\/form>/is", array($this, '_parseForm'), $sData);

		// remove all comments
		$sData = preg_replace("/{$sLdq}\*(.*?)\*{$sRdq}/s", "", $sData);

		// remove literal blocks
		preg_match_all("!{$sLdq}\s*literal\s*{$sRdq}(.*?){$sLdq}\s*/literal\s*{$sRdq}!s", $sData, $aMatches);
		$this->_aLiterals = $aMatches[1];
		$sData = preg_replace("!{$sLdq}\s*literal\s*{$sRdq}(.*?){$sLdq}\s*/literal\s*{$sRdq}!s", stripslashes($sLdq . "literal" . $sRdq), $sData);

		// remove php blocks
		preg_match_all("!{$sLdq}\s*php\s*{$sRdq}(.*?){$sLdq}\s*/php\s*{$sRdq}!s", $sData, $aMatches);
		$this->_aPhpBlocks = $aMatches[1];
		$sData = preg_replace("!{$sLdq}\s*php\s*{$sRdq}(.*?){$sLdq}\s*/php\s*{$sRdq}!s", stripslashes($sLdq . "php" . $sRdq), $sData);

		// remove blocklets
		preg_match_all("!{$sLdq}\s*blocklet location=([0-9]+){$sRdq}(.*?){$sLdq}\s*/blocklet\s*{$sRdq}!s", $sData, $aMatches);
		$this->_aBlocklets = $aMatches;
		$sData = preg_replace("!{$sLdq}\s*blocklet location=([0-9]+){$sRdq}(.*?){$sLdq}\s*/blocklet\s*{$sRdq}!s", stripslashes($sLdq . "blocklet" . $sRdq), $sData);

		$aText = preg_split("!{$sLdq}.*?{$sRdq}!s", $sData);

		preg_match_all("!{$sLdq}\s*(.*?)\s*{$sRdq}!s", $sData, $aMatches);
		$aTags = $aMatches[1];

		$aCompiledTags = array();
		$iCompiledTags = count($aTags);
		for ($i = 0, $iForMax = $iCompiledTags; $i < $iForMax; $i++)
		{
			$aCompiledTags[] = $this->_compileTag($aTags[$i]);
		}

		$iCountCompiledTags = count($aCompiledTags);
		for ($i = 0, $iForMax = $iCountCompiledTags; $i < $iForMax; $i++)
		{
			if ($aCompiledTags[$i] == '')
			{
				$aText[$i+1] = preg_replace('~^(\r\n|\r|\n)~', '', $aText[$i+1]);
			}
			$sCompiledText .= $aText[$i].$aCompiledTags[$i];
		}
		$sCompiledText .= $aText[$i];

		foreach ($this->_aRequireStack as $mKey => $mValue)
		{
			$sCompiledText = '<?php require_once(\''. PHPFOX_DIR_TPL_PLUGIN . $mKey . '\'); $this->_register("' . $mValue[0] . '", "' . $mValue[1] . '", "' . $mValue[2] . '"); ?>' . $sCompiledText;
		}

		$sCompiledText = preg_replace('!\?>\n?<\?php!', '', $sCompiledText);

		$sCompiledText = '<?php /* Cached: ' . date("F j, Y, g:i a", time()) . ' */ ?>' . "\n" . $sCompiledText;

		return $sCompiledText;
	}

	/**
	 * Parse HTML forms. This is where we automatically add our security token.
	 *
	 * @param string $aMatches ARRAY of regex matches
	 * @return string Converted form.
	 */
	private function _parseForm($aMatches)
	{
		$sForm = $aMatches[1];
		$sData = $aMatches[2];
		
		$sForm = '<form' . stripslashes($sForm) . ">";
		if (strpos($sData, '{token}') === false)
		{
			/*$sForm .= "\n" . '<?php echo \'<div><input type="hidden" name="\' . Phpfox::getTokenName() . \'[security_token]" value="\' . Phpfox::getService(\'log.session\')->getToken() . \'" /></div>\'; ?>';*/
		}
		$sForm .= stripslashes($sData) . "\n";
		$sForm .= '</form>' . "\n";

		return $sForm;
	}

	/**
	 * Compile custom tags. (eg. {literal})
	 *
	 * @param string $sTag Name of the tag to parse.
	 * @return string Converted block of code based on the tag.
	 */
	private function _compileTag($sTag)
	{
		preg_match_all('/(?:(' . $this->_sVarRegexp . '|' . $this->_sSvarRegexp . '|\/?' . $this->_sFuncRegexp . ')(' . $this->_sModRegexp . '*)(?:\s*[,\.]\s*)?)(?:\s+(.*))?/xs', $sTag, $aMatches);

		if ($aMatches[1][0]{0} == '$' || $aMatches[1][0]{0} == "'" || $aMatches[1][0]{0} == '"')
		{
			return "<?php echo " . $this->_parseVariables($aMatches[1], $aMatches[2]) . "; ?>";
		}

		$sTagCommand = $aMatches[1][0];
		$sTagModifiers = !empty($aMatches[2][0]) ? $aMatches[2][0] : null;
		$sTagArguments = !empty($aMatches[3][0]) ? $aMatches[3][0] : null;

		return $this->_parseFunction($sTagCommand, $sTagModifiers, $sTagArguments);
	}

	/**
	 * Parse all the custom tags used within templates. In templates we
	 * do not use conventional PHP code as we seperate PHP logic from the
	 * template. The tags we use work similar to that off SMARTY.
	 *
	 * @param string $sFunction Name of the function.
	 * @param string $sModifiers Modifiers.
	 * @param string $sArguments Any arguments we are passing.
	 * @return string Converted PHP value of the function.
	 */
	private function _parseFunction($sFunction, $sModifiers, $sArguments)
	{
		switch ($sFunction)
		{
			/**
			 * SMARTY
			 */
			case 'ldelim':
				return $this->sLeftDelim;
				break;
			case 'rdelim':
				return $this->sRightDelim;
				break;	
			case 'php':
				if (!Phpfox::getParam('core.is_auto_hosted'))
				{
					list (,$sPhpBlock) = each($this->_aPhpBlocks);
					return '<?php ' . $sPhpBlock . ' ?>';
				}
				else
				{
					return '';
				}		
				break;
			case 'iterate':
				$aArgs = $this->_parseArgs($sArguments);
				return '<?php ' . $aArgs['int'] . '++; ?>';
				break;
			case 'for':
				// $sArguments = preg_replace("/\\$([A-Za-z0-9]+)/is", "'' . \$this->_parseVariable('\$$1') . ''", $sArguments);
				$sArguments = preg_replace_callback("/\\$([A-Za-z0-9]+)/is", function($matches) {
					return $this->_parseVariable($matches[0]);
				}, $sArguments);

				return '<?php for (' . $sArguments . '): ?>';
				break;
			case '/for':
				return "<?php endfor; ?>";
				break;
			case 'left_curly':
				return '{';
				break;
			case 'right_curly':
				return '}';
				break;
			case 'l':
				return '{';
				break;
			case 'r':
				return '}';
				break;
			case 'assign':
				$aArgs = $this->_parseArgs($sArguments);
				if (!isset($aArgs['var']))
				{
					return '';
				}
				if (!isset($aArgs['value']))
				{
					return '';
				}
				return '<?php $this->assign(\'' . $this->_removeQuote($aArgs['var']) . '\', ' . $aArgs['value'] . '); ?>';
				break;
			case 'blocklet':

				return '';
				break;
			case 'literal':
				list (,$sLiteral) = each($this->_aLiterals);
				return "<?php echo '" . str_replace("'", "\'", $sLiteral) . "'; ?>\n";
				break;
			case 'foreach':
				array_push($this->_aForeachElseStack, false);
				$aArgs = $this->_parseArgs($sArguments);
				if (!isset($aArgs['from']))
				{
					return '';
				}
				if (!isset($aArgs['value']) && !isset($aArgs['item']))
				{
					return '';
				}
				if (isset($aArgs['value']))
				{
					$aArgs['value'] = $this->_removeQuote($aArgs['value']);
				}
				elseif (isset($aArgs['item']))
				{
					$aArgs['value'] = $this->_removeQuote($aArgs['item']);
				}

				(isset($aArgs['key']) ? $aArgs['key'] = "\$this->_aVars['".$this->_removeQuote($aArgs['key'])."'] => " : $aArgs['key'] = '');

				$bIteration = (isset($aArgs['name']) ? true : false);

				$sResult = '<?php if (count((array)' . $aArgs['from'] . ')): ?>' . "\n";
				if ($bIteration)
				{
					$sResult .= '<?php $this->_aPhpfoxVars[\'iteration\'][\'' . $aArgs['name'] . '\'] = 0; ?>' . "\n";
				}
				$sResult .= '<?php foreach ((array) ' . $aArgs['from'] . ' as ' . $aArgs['key'] . '$this->_aVars[\'' . $aArgs['value'] . '\']): ?>';
				if ($bIteration)
				{
					$sResult .= '<?php $this->_aPhpfoxVars[\'iteration\'][\'' . $aArgs['name'] . '\']++; ?>' . "\n";
				}
				return $sResult;
				break;
			case 'foreachelse':
				$this->_aForeachElseStack[count($this->_aForeachElseStack)-1] = true;
				return "<?php endforeach; else: ?>";
				break;
			case '/foreach':
				if (array_pop($this->_aForeachElseStack))
				{
					return "<?php endif; ?>";
				}
				else
				{
					return "<?php endforeach; endif; ?>";
				}
				break;
			case 'if':
				return $this->_compileIf($sArguments);
				break;
			case 'else':
				return "<?php else: ?>";
				break;
			case 'elseif':
				return $this->_compileIf($sArguments, true);
				break;
			case '/if':
				return "<?php endif; ?>";
				break;
			case 'section':
				array_push($this->_aSectionelseStack, false);
				return $this->_compileSectionStart($sArguments);
				break;
			case 'sectionelse':
				$this->_aSectionelseStack[count($this->_aSectionelseStack)-1] = true;
				return "<?php endfor; else: ?>";
				break;
			case '/section':
				if (array_pop($this->_aSectionelseStack))
				{
					return "<?php endif; ?>";
				}
				else
				{
					return "<?php endfor; endif; ?>";
				}
				break;
			/**
			 * phpFox
			 */
			case 'title':
				return '<?php echo $this->getTitle(); ?>';
				break;
			case 'header':
				return '<?php echo $this->getHeader(); ?>';
				break;
			case 'loadjs':
				return '<?php echo $this->_sFooter; ?>';
				break;
			case 'block':
				$aArgs = $this->_parseArgs($sArguments);

				$sContent = '';
				$sContent .= '<?php if (!Phpfox::isAdminPanel()): ?>';
				$sContent .= '<div class="_block" data-location="' . $this->_removeQuote($aArgs['location']) . '">';
				$sContent .= '<?php endif; ?>';

				$sContent .= '<?php if ($this->bIsSample): ?>';
				$sContent .= '<?php if (defined(\'PHPFOX_NO_WINDOW_CLICK\')): ?>';
				$sContent .= '<?php if (defined(\'PHPFOX_IS_AD_SAMPLE\')): Phpfox::getBlock(\'ad.sample\', array(\'block_id\' => ' . $this->_removeQuote($aArgs['location']) . ')); endif; ?>';
				$sContent .= '<?php else: ?>';
				$sContent .= '<div class="sample"<?php echo (!defined(\'PHPFOX_NO_WINDOW_CLICK\') ? " onclick=\"window.parent.$(\'#location\').val(' . $aArgs['location'] . '); window.parent.tb_remove();\"" : \' style="cursor:default;"\'); ?>><?php echo Phpfox::getPhrase(\'core.block\') ; ?> ' . $this->_removeQuote($aArgs['location']) . '<?php if (defined(\'PHPFOX_IS_AD_SAMPLE\')): echo Phpfox::getService(\'ad\')->getSizeForBlock("' . $this->_removeQuote($aArgs['location']) . '"); endif; ?>';
				$sContent .= '<?php if (defined(\'PHPFOX_IS_AD_SAMPLE\')): Phpfox::getBlock(\'ad.sample\', array(\'block_id\' => ' . $this->_removeQuote($aArgs['location']) . ')); endif; ?>';
				$sContent .= '</div>';
				$sContent .= '<?php endif; ?>';
				$sContent .= '<?php else: ?>';
				
				
				$sContent .= '<?php $aBlocks = Phpfox::getLib(\'phpfox.module\')->getModuleBlocks(' . $aArgs['location'] . '); ?>';
				
				/* if user is designing the profile or the dashboard showing the block containers is needed */				
				$sContent .= '<?php $aUrl = Phpfox::getLib(\'url\')->getParams(); ?>';
				$sContent .= '<?php $bDesigning = Phpfox::getService("theme")->isInDnDMode(); ?>';				
				
				$sContent .= '<?php if (!Phpfox::isAdminPanel() && ( (defined(\'PHPFOX_DESIGN_DND\') && PHPFOX_DESIGN_DND) || $bDesigning || (defined("PHPFOX_IN_DESIGN_MODE") && PHPFOX_IN_DESIGN_MODE && in_array(' . $aArgs['location'] . ', array(1, 2, 3))))):?> <div class="js_can_move_blocks js_sortable_empty" id="js_can_move_blocks_'. str_replace("'",'',$aArgs['location']).'"> <div class="block js_sortable dnd_block_info">Position '. $aArgs['location'] .'</div></div><?php endif; ?>' . "\n";
				$sContent .= '<?php foreach ((array)$aBlocks as $sBlock): ?>' . "\n";
				
				$sContent .= '<?php if (!Phpfox::isAdminPanel() && ( (defined(\'PHPFOX_DESIGN_DND\') && PHPFOX_DESIGN_DND) || $bDesigning || (defined("PHPFOX_IN_DESIGN_MODE") && PHPFOX_IN_DESIGN_MODE && in_array(' . $aArgs['location'] . ', array(1, 2, 3))))):?>' . "\n";
				$sContent .= '<div class="js_can_move_blocks" id="js_can_move_blocks_'. str_replace("'",'',$aArgs['location']).'">' . "\n";
				$sContent .= '<?php endif; ?>' . "\n";	
				
				$sContent .= '<?php if (is_array($sBlock) && (!defined(\'PHPFOX_CAN_MOVE_BLOCKS\') || !in_array(' . $aArgs['location'] . ', array(1, 2, 3, 4)))): ?>' . "\n";
				$sContent .= '<?php eval(\' ?>\' . $sBlock[0] . \'<?php \'); ?>' . "\n";
				$sContent .= '<?php else: ?>' . "\n";
					// Load blocks after onLoad
					/*//$sContent .= '<?php if (in_array('. $aArgs['location'] . ', array(2)) && Phpfox::getParam(\'feed.force_ajax_on_load\')): ?>'. "\n";
					//	$sContent .= '<div id="delayed_block_'. str_replace("'",'',$aArgs['location']) . '"><script type="text/javascript">if (typeof $Core.delayedBlocks == \'undefined\') $Core.delayedBlocks = [];$Core.delayedBlocks.push(' . str_replace("'", '',$aArgs['location']) . ');</script></div>'. "\n";
					//$sContent .= '<?php else: ?>'. "\n";*/
						$sContent .= '<?php Phpfox::getBlock($sBlock, array(\'location\' => ' . $aArgs['location'] . ')); ?>'. "\n";
					/*$sContent .= '<?php endif; ?>'. "\n";*/
				$sContent .= '<?php endif; ?>' . "\n";	
				
				$sContent .= '<?php if (!Phpfox::isAdminPanel() && ( (defined(\'PHPFOX_DESIGN_DND\') && PHPFOX_DESIGN_DND) || $bDesigning || (defined("PHPFOX_IN_DESIGN_MODE") && PHPFOX_IN_DESIGN_MODE && in_array(' . $aArgs['location'] . ', array(1, 2, 3))))):?>';				
				$sContent .= '</div>';		
				$sContent .= '<?php endif; ?>' . "\n";	
				
				$sContent .= '<?php endforeach; ?>';
				/*
				$sContent .= '<?php if (!Phpfox::isAdminPanel()): ?>';
				$sContent .= '<?php Phpfox::getBlock(\'ad.display\', array(\'block_id\' => ' . $this->_removeQuote($aArgs['location']) . ')); ?>';
				$sContent .= '<?php endif; ?>';
				*/
				
				$sContent .= '<?php endif; ?>';

				$sContent .= '<?php if (!Phpfox::isAdminPanel()): ?>';
				$sContent .= '</div>';
				$sContent .= '<?php endif; ?>';

				return $sContent;
				break;
			case 'branding':
				$sContent = '
				<?php if (!Phpfox::getParam(\'core.branding\')): ?>
					<?php echo PhpFox::link(true, false); ?>
				<?php endif; ?>
				';
				return $sContent;
				break;
			case 'product_branding':
				$sContent = '<?php echo \' &middot; \' . PhpFox::link(); ?>';
				return $sContent;
				break;				
			case 'image_path':
				return '<?php echo $this->getStyle(\'image\'); ?>';
				break;
			case 'module_path':
				return '<?php echo Phpfox::getParam(\'core.url_module\'); ?>';
				break;
			case 'permalink':
				$aArgs = $this->_parseArgs($sArguments);
				$aExtra = $aArgs;
				unset($aExtra['module'], $aExtra['id'], $aExtra['title']);				

				return '<?php echo Phpfox::permalink(' . $aArgs['module'] . ', ' . $this->_removeQuote($aArgs['id']) . '' . (empty($aArgs['title']) ? ', null' : ', ' . $this->_removeQuote($aArgs['title'])) . ', false, null, (array) ' . var_export($aExtra, true) . '); ?>';
				break;
			case 'url':
				$aArgs = $this->_parseArgs($sArguments);
				if (!isset($aArgs['link']))
				{
					return '';
				}
				$sLink = $aArgs['link'];
				unset($aArgs['link']);
				$sArray = '';
				if (count($aArgs))
				{
					$sArray = ', array(';
					foreach ($aArgs as $sKey => $sValue)
					{
						$sArray .= '\'' . $sKey . '\' => ' . $sValue . ',';
					}
					$sArray = rtrim($sArray, ',') . ')';
				}
				return '<?php echo Phpfox::getLib(\'phpfox.url\')->makeUrl(' . $sLink . $sArray . '); ?>';
				break;
			case 'phrase':
				$aArgs = $this->_parseArgs($sArguments);
				if (!isset($aArgs['var']))
				{
					return '';
				}
				$sVar = $aArgs['var'];
				unset($aArgs['var']);
				$sArray = '';
				$sLanguage = '';
				if (count($aArgs))
				{
					$sArray = ', array(';
					foreach ($aArgs as $sKey => $sValue)
					{
						if ($sKey == 'language')
						{
							$sLanguage = $sValue;
						}
						$sArray .= '\'' . $sKey . '\' => ' . $sValue . ',';
					}
					$sArray = rtrim($sArray, ',') . ')';
				}
				return '<?php echo Phpfox::getPhrase(' . $sVar . '' . $sArray . ($sLanguage != '' ? ',false,null,'.$sLanguage : '') .'); ?>';
				break;
			case 'error':
				$sContent = '<?php if (!$this->bIsSample): ?>';
				$sContent .= '<?php $this->getLayout(\'error\'); ?>';
				$sContent .= '<?php endif; ?>';
				return $sContent;
				break;
			case 'breadcrumb':
				$sContent = '<div class="_block_breadcrumb"><?php if (!$this->bIsSample): ?>';
				$sContent .= '<?php $this->getLayout(\'breadcrumb\'); ?>';
				$sContent .= '<?php endif; ?></div>';
				return $sContent;
				break;
			case 'search':
				$sContent = '<div class="_block_search"><?php if (!$this->bIsSample): ?>';
				$sContent .= '<?php $this->getLayout(\'search\'); ?>';
				$sContent .= '<?php endif; ?></div>';
				return $sContent;
				break;
			case 'content':
				$sContent = '<?php if (!$this->bIsSample): ?><div id="site_content">';
				$sContent .= '<?php if (isset($this->_aVars[\'bSearchFailed\'])): ?>';
				$sContent .= '<div class="message">Unable to find anything with your search criteria.</div>';
				$sContent .= '<?php else: ?>';
					// Dont do this for profiles/pages or core.index-member because those load the feed and there is a separate routine for this block
					$sContent .= '<?php $sController = "'. Phpfox_Module::instance()->getFullControllerName() .'"; ?>';
					$sContent .= '<?php if ( Phpfox::getLib("template")->shouldLoadDelayed("'. Phpfox_Module::instance()->getFullControllerName() .'") == true ): ?>'. "\n";
					$sContent .= '<div id="delayed_block_image" style="text-align:center; padding-top:20px;"><img src="' . Phpfox_Template::instance()->getStyle('image', 'ajax/add.gif') . '" alt="" /></div>'."\n";
					$sContent .= '<div id="delayed_block" style="display:none;"><?php echo Phpfox::getLib(\'phpfox.module\')->getFullControllerName(); ?></div>'."\n";
					$sContent .= '<?php else: ?>'. "\n";
						$sContent .= '<?php Phpfox::getLib(\'phpfox.module\')->getControllerTemplate(); ?>';
					$sContent .= '<?php endif; ?>';
				$sContent .= '<?php endif; ?></div>';
				$sContent .= '<?php endif; ?>';
				return $sContent;
				break;
			case 'layout':
				$aArgs = $this->_parseArgs($sArguments);
				return '<?php $this->getLayout(' . $aArgs['file'] . '); ?>';
				return $sContent;
				break;
			case 'pager':
				$sReturn = '<?php if (!isset($this->_aVars[\'aPager\'])): Phpfox::getLib(\'pager\')->set(array(\'page\' => Phpfox::getLib(\'request\')->getInt(\'page\'), \'size\' => Phpfox::getLib(\'search\')->getDisplay(), \'count\' => Phpfox::getLib(\'search\')->getCount())); endif; ?>';
				$sReturn .= '<?php $this->getLayout(\'pager\'); ?>';				
				return $sReturn;
				break;
			case 'unset':
				$aArgs = $this->_parseArgs($sArguments);
				return '<?php unset(' . implode(', ', $aArgs) . '); ?>';
				break;
			case 'token':
				return '';
				return '<?php echo \'<div><input type="hidden" name="\' . Phpfox::getTokenName() . \'[security_token]" value="\' . Phpfox::getService(\'log.session\')->getToken() . \'" /></div>\'; ?>';
				break;
			case 'img':
				$aArgs = $this->_parseArgs($sArguments);
				$sArray = '';
				foreach ($aArgs as $sKey => $sValue)
				{
					$sArray .= '\'' . $sKey . '\' => ' . $sValue . ',';
				}
				return '<?php echo Phpfox::getLib(\'phpfox.image.helper\')->display(array(' . rtrim($sArray, ',') . ')); ?>';
				break;
			case 'plugin':
				$aArgs = $this->_parseArgs($sArguments);
				if (!isset($aArgs['call']))
				{
					return '';
				}
				return '<?php (($sPlugin = Phpfox_Plugin::get(\'' . $this->_removeQuote($aArgs['call']) . '\')) ? eval($sPlugin) : false); ?>';
				break;
			case 'template':
				$aArgs = $this->_parseArgs($sArguments);
				$sFile = $this->_removeQuote($aArgs['file']);
				return '<?php
						Phpfox::getLib(\'template\')->getBuiltFile(\'' . $sFile . '\');						
						?>';
				/*
				$aArgs = $this->_parseArgs($sArguments);				
				$mContent = Phpfox_Template::instance()->getTemplateFile($this->_removeQuote($aArgs['file']), true);
				if (is_array($mContent))
				{
					$mContent = $mContent[0];
				}
				else
				{
					$mContent = file_get_contents($mContent);
				}
				$mContent = $this->_parse($mContent, true);

				if (count($aArgs) > 1)
				{
					$sAssign = 'array(';
					$sClear = 'array(';
					foreach ($aArgs as $sKey => $mValue)
					{
						if ($sKey == 'file')
						{
							continue;
						}
						$sAssign .= '\'' . $sKey . '\' => ' . $mValue . ',';
						$sClear .= '\'' . $sKey . '\',';
					}
					$sAssign = rtrim($sAssign, ',');
					$sAssign .= ')';
					$sClear = rtrim($sClear, ',');
					$sClear .= ')';

					return '<?php $this->assign(' . $sAssign . '); ?>' . $mContent . '<?php $this->clean(' . $sClear . '); ?>';
				}
				else
				{
					return $mContent;
				}
				*/
				break;
			case 'parse_image':
				$aArgs = $this->_parseArgs($sArguments);
				$sArray = '';
				foreach ($aArgs as $sKey => $sValue)
				{
					$sArray .= '\'' . $sKey . '\' => ' . $sValue . ',';
				}
				return '<?php Phpfox::getLib(\'parse.output\')->setImageParser(array(' . rtrim($sArray, ',') . ')); ?>';
				break;
			case 'module':
				$aArgs = $this->_parseArgs($sArguments);
				$sModule = $aArgs['name'];
				unset($aArgs['name']);
				$sArray = '';
				
				/*if (strpos($sModule,'feed.comment') !== false)
				{
					$aArgs['delay']
					//return '<?php echo "<div class=\'load_delayed\'>feed.comment<span class=\'load_delayed_param\'>feed: ".print_r($this->_aVars, true) . $this->_aVars[\'aItem\'][\'aFeed\'][\'feed_id\']. "</span></div>"; ?>';
				}*/
				
				foreach ($aArgs as $sKey => $sValue)
				{
					if (substr($sValue, 0, 1) != '$' && $sValue !== 'true' && $sValue !== 'false')
					{
						$sValue = '\'' . $this->_removeQuote($sValue) . '\'';
					}
					$sArray .= '\'' . $sKey . '\' => ' . $sValue . ',';
				}
				
				return '<?php Phpfox::getBlock(' . $sModule . ', array(' . rtrim($sArray, ',') . ')); ?>';
				break;
			case 'editor':
				$aArgs = $this->_parseArgs($sArguments);
				$aParams = array();
				foreach ($aArgs as $sKey => $mParam)
				{
					$aParams[$sKey] = $this->_removeQuote($mParam);
				}

				$sReturn = '<div class="editor_holder">';
				$sReturn .= '<?php echo Phpfox::getLib(\'phpfox.editor\')->get(' . $aArgs['id'] . ', ' . var_export($aParams, true) . '); ?>';
				$sReturn .= '<?php Phpfox::getBlock(\'attachment.share\'); ?>';
				$sReturn .= '</div>';
				
				return $sReturn;
				break;
			case 'nomoreie':
				return '<!--[if lt IE 7]><div style="border: 1px solid #F7941D; background: #FEEFDA; text-align: center; clear: both; height: 75px; position: relative; margin:0px 10px 10px 10px;">
			    <div style="width: 640px; margin: 0 auto; text-align: left; padding: 0; overflow: hidden; color: black;">
			      <div style="width: 75px; float: left;"><img src="http://www.ie6nomore.com/files/theme/ie6nomore-warning.jpg" alt="' . Phpfox::getPhrase('core.warning') . '" /></div>
			      <div style="width: 275px; float: left; font-family: Arial, sans-serif;">
			        <div style="font-size: 14px; font-weight: bold; margin-top: 12px;">' . Phpfox::getPhrase('core.you_are_using_an_outdated_browser') . '</div>
			        <div style="font-size: 12px; margin-top: 6px; line-height: 12px;">' . Phpfox::getPhrase('core.for_a_better_experience_using_this_site_please_upgrade_to_a_modern_web_browser') . '</div>
			      </div>
			      <div style="width: 75px; float: left;"><a href="http://www.firefox.com" target="_blank"><img src="http://www.ie6nomore.com/files/theme/ie6nomore-firefox.jpg" style="border: none;" alt="' . Phpfox::getPhrase('core.get_firefox') . '"/></a></div>
			      <div style="width: 75px; float: left;"><a href="http://www.browserforthebetter.com/download.html" target="_blank"><img src="http://www.ie6nomore.com/files/theme/ie6nomore-ie8.jpg" style="border: none;" alt="' . Phpfox::getPhrase('core.get_internet_explorer') . '" /></a></div>
			      <div style="width: 73px; float: left;"><a href="http://www.apple.com/safari/download/" target="_blank"><img src="http://www.ie6nomore.com/files/theme/ie6nomore-safari.jpg" style="border: none;" alt="' . Phpfox::getPhrase('core.get_safari') . '" /></a></div>
			      <div style="float: left;"><a href="http://www.google.com/chrome" target="_blank"><img src="http://www.ie6nomore.com/files/theme/ie6nomore-chrome.jpg" style="border: none;" alt="' . Phpfox::getPhrase('core.get_google_chrome') . '" /></a></div>
			    </div>
			  </div><![endif]-->';
				break;
			case 'value':
				$aArgs = $this->_parseArgs($sArguments);
				$aArgs = array_map(array($this, '_removeQuote'), $aArgs);
				// Accept variables in ids
				if (substr($aArgs['id'], 0, 14) == '$this->_aVars[')
				{
					$aArgs['id'] = '\'.' . $aArgs['id'] .'.\'';
				}
				
				switch($aArgs['type'])
				{
					case 'input':
						$sContent = '<?php $aParams = (isset($aParams) ? $aParams : Phpfox::getLib(\'phpfox.request\')->getArray(\'val\')); echo (isset($aParams[\'' . $aArgs['id'] . '\']) ? Phpfox::getLib(\'phpfox.parse.output\')->clean($aParams[\'' . $aArgs['id'] . '\']) : (isset($this->_aVars[\'aForms\'][\'' . $aArgs['id'] . '\']) ? Phpfox::getLib(\'phpfox.parse.output\')->clean($this->_aVars[\'aForms\'][\'' . $aArgs['id'] . '\']) : ' . (isset($aArgs['default']) ? '\'' . $aArgs['default'] . '\'' : '\'\'' ) . ')); ?>' . "\n";
						break;
					case 'radio':
						$sContent = '<?php $aParams = (isset($aParams) ? $aParams : Phpfox::getLib(\'phpfox.request\')->getArray(\'val\'));';
						$sContent .= "\n".'if (isset($this->_aVars[\'aForms\']) && is_numeric(\''.$aArgs["id"].'\') && in_array(\''.$aArgs["id"].'\', $this->_aVars[\'aForms\']) ){echo \' checked="checked"\';}';
						$sContent .= "\n".'if ((isset($aParams[\'' . $aArgs['id'] . '\']) && $aParams[\'' . $aArgs['id'] . '\'] == \'' . $aArgs['default'] . '\'))';
						$sContent .= "\n".'{echo \' checked="checked" \';}';
						$sContent .= "\n".'else';
						$sContent .= "\n".'{';
						$sContent .= "\n".' if (isset($this->_aVars[\'aForms\']) && isset($this->_aVars[\'aForms\'][\'' . $aArgs['id'] . '\']) && !isset($aParams[\'' . $aArgs['id'] . '\']) && $this->_aVars[\'aForms\'][\'' . $aArgs['id'] . '\'] == \'' . $aArgs['default'] . '\')';
						$sContent .= "\n".' {';
						$sContent .= "\n".'    echo \' checked="checked" \';}';
						$sContent .= "\n".' else';
						$sContent .= "\n".' {';
						if (isset($aArgs['selected']))
						{
							$sContent .= "\n".' if (!isset($this->_aVars[\'aForms\']) || ((isset($this->_aVars[\'aForms\']) && !isset($this->_aVars[\'aForms\'][\'' . $aArgs['id'] . '\']) && !isset($aParams[\'' . $aArgs['id'] . '\']))))';
							$sContent .= "\n".'{';
							$sContent .= "\n".' echo \' checked="checked"\';';
							$sContent .= "\n".'}';
						}

						$sContent .= "\n".' }';
						$sContent .= "\n".'}';
						$sContent .= "\n".'?>' . " \n";
						break;
					case 'checkbox':					
					case 'multiselect':
					case 'select':						
						$bIsCheckbox = ($aArgs['type'] == 'checkbox' ? 'checked="checked"' : 'selected="selected"');
						$aArgs['default'] = $this->_removeQuote($aArgs['default']);
						if (substr($aArgs['default'], 0, 1) == '$')
						{
							$sDefault = $aArgs['default'];
						}
						elseif (substr($aArgs['default'], 0, 2) == ".\$")
						{
							$sDefault = trim($aArgs['default'], '.');
						}
						else
						{
							$sDefault = "'{$aArgs['default']}'";
						}

						$sContent = '<?php $aParams = (isset($aParams) ? $aParams : Phpfox::getLib(\'phpfox.request\')->getArray(\'val\'));'.
							"\n" . '';
						$sContent .= "\n\n".'if (isset($this->_aVars[\'aField\']) && isset($this->_aVars[\'aForms\'][$this->_aVars[\'aField\'][\'field_id\']]) && !is_array($this->_aVars[\'aForms\'][$this->_aVars[\'aField\'][\'field_id\']]))
							{
								$this->_aVars[\'aForms\'][$this->_aVars[\'aField\'][\'field_id\']] = array($this->_aVars[\'aForms\'][$this->_aVars[\'aField\'][\'field_id\']]);
							}';
						$sContent .= "\n\n".'if (isset($this->_aVars[\'aForms\']'. (isset($aArgs['parent']) ? '[\''.$aArgs["parent"].'\']' : '') .')';
						$sContent .= "\n".' && is_numeric(\''.$aArgs["id"].'\') && in_array(\''.$aArgs["id"].'\', $this->_aVars[\'aForms\']'. (isset($aArgs['parent']) ? '[\''.$aArgs["parent"].'\']' : '') .'))
							'."\n".'{
								echo \' ' . $bIsCheckbox . ' \';
							}'."\n".'
							if (isset($aParams[\'' . $aArgs['id'] . '\'])
								&& $aParams[\'' . $aArgs['id'] . '\'] == ' . $sDefault . ')'."\n".'
							{'."\n".'
								echo \' ' . $bIsCheckbox . ' \';'."\n".'
							}'."\n".'
							else'."\n".'
							{'."\n".'
								if (isset($this->_aVars[\'aForms\'][\'' . $aArgs['id'] . '\'])
									&& !isset($aParams[\'' . $aArgs['id'] . '\'])
									&& $this->_aVars[\'aForms\'][\'' . $aArgs['id'] . '\'] == ' . $sDefault . ')
								{
								 echo \' ' . $bIsCheckbox . ' \';
								}
								else
								{
									echo ' . (isset($aArgs['selected']) ? '" ' . str_replace('"', '\"', $bIsCheckbox) . '"' : '""') . ';
								}
							}
							?>' . "\n";
						break;
					case 'wysiwyg':
					case 'textarea':
						$sContent = '<?php $aParams = (isset($aParams) ? $aParams : Phpfox::getLib(\'phpfox.request\')->getArray(\'val\')); echo (isset($aParams[\'' . $aArgs['id'] . '\']) ? Phpfox::getLib(\'phpfox.parse.output\')->clean($aParams[\'' . $aArgs['id'] . '\']) : (isset($this->_aVars[\'aForms\'][\'' . $aArgs['id'] . '\']) ? Phpfox::getLib(\'phpfox.parse.output\')->clean($this->_aVars[\'aForms\'][\'' . $aArgs['id'] . '\']) : \'\')); ?>' . "\n";
						break;
				}
				return $sContent;
				break;
			case 'translate':
				$aArgs = $this->_parseArgs($sArguments);
				$sPrefix = (isset($aArgs['prefix']) ? ', ' . $aArgs['prefix'] : '');
				return '<?php echo Phpfox::getLib(\'phpfox.locale\')->translate(' . $aArgs['var'] . $sPrefix . '); ?>';
				break;
			case 'help':
				$aArgs = $this->_parseArgs($sArguments);
				return '<?php Phpfox::getBlock(\'help.popup\', array(\'phrase\' => ' . $aArgs['var'] . ')); ?>';
				break;
			case 'param':
				$aArgs = $this->_parseArgs($sArguments);
				return '<?php echo Phpfox::getParam(\'' . $this->_removeQuote($aArgs['var']) . '\'); ?>';
				break;
			case 'request':
				$aArgs = $this->_parseArgs($sArguments);
				return '<?php echo urlencode(Phpfox::getLib(\'request\')->get(\'' . $this->_removeQuote($aArgs['var']) . '\')); ?>';
				break;				
			case 'required':
				return '<?php if (Phpfox::getParam(\'core.display_required\')): ?><span class="required"><?php echo Phpfox::getParam(\'core.required_symbol\'); ?></span><?php endif; ?>';
				break;				
			case 'select_date':
				/*
				 * @param string $aArgs['time_separator'] the variable for the language phrase
				 */
				$aArgs = $this->_parseArgs($sArguments);

				$sPrefix = '';
				if (isset($aArgs['prefix']))
				{
					$sPrefix = $this->_removeQuote($aArgs['prefix']);
				}
				
				$bUseJquery = Phpfox::getParam('core.use_jquery_datepicker');
				if (isset($aArgs['bUseDatepicker']) && $aArgs['bUseDatepicker'] == 'false')
				{
					$bUseJquery = false;
				}
				
				$sMonth = '<select name="val[' . $sPrefix . 'month]" id="' . $sPrefix . 'month" class="js_datepicker_month">' . "\n";
				if (!isset($aArgs['default_all']))
				{
					$sMonth .= "\t\t" . '<option value=""><?php echo Phpfox::getPhrase(\'core.month\'); ?>:</option>'  . "\n";
				}

				$aMonths = array(
					'January',
					'February',
					'March',
					'April',
					'May',
					'June',
					'July',
					'August',
					'September',
					'October',
					'November',
					'December'
				);
				$i = 0;
				foreach ($aMonths as $sNewMonth)
				{
					$i++;
					$sMonth .= "\t\t\t" . '<option value="' . $i . '"' . $this->_parseFunction('value', '', "type='select' id='{$sPrefix}month' default='{$i}'") . (isset($aArgs['default_all']) ? '<?php echo (!isset($this->_aVars[\'aForms\'][\'' . $sPrefix . 'month\']) ? (\'' . $i . '\' == Phpfox::getTime(\'n\') ? \' selected="selected"\' : \'\') : \'\'); ?>' : '') . '><?php echo (defined(\'PHPFOX_INSTALLER\') ? \'' . str_replace("'", "\'", $sNewMonth) . '\' : Phpfox::getPhrase(\'core.' . strtolower($sNewMonth) . '\')); ?></option>' . "\n";
				}
				$sMonth .= "\t\t" . '</select>' . "\n";

				$sDay = "\t\t" . '<select name="val[' . $sPrefix . 'day]" id="' . $sPrefix . 'day" class="js_datepicker_day">' . "\n";
				if (!isset($aArgs['default_all']))
				{
					$sDay .= "\t\t" . '<option value=""><?php echo Phpfox::getPhrase(\'core.day\'); ?>:</option>' . "\n";
				}

				for ($i = 1; $i <= 31; $i++)
				{
					$sDay .= "\t\t\t" . '<option value="' . $i . '"' . $this->_parseFunction('value', '', "type='select' id='{$sPrefix}day' default='{$i}'") . (isset($aArgs['default_all']) ? '<?php echo (!isset($this->_aVars[\'aForms\'][\'' . $sPrefix . 'day\']) ? (\'' . $i . '\' == ' . (isset($aArgs['start_hour']) ? '((Phpfox::getTime(\'H\') == 23 && (Phpfox::getTime(\'H\') + ' . $aArgs['start_hour'] . ') >= 00) ? (Phpfox::getTime(\'j\') + 1) : Phpfox::getTime(\'j\'))' : 'Phpfox::getTime(\'j\')') . ' ? \' selected="selected"\' : \'\') : \'\'); ?>' : '') . '>' . $i . '</option>'  . "\n";
				}
				$sDay .= "\t\t" . '</select>' . "\n";

				if ($this->_removeQuote($aArgs['start_year']) == 'current_year')
				{
					$aArgs['start_year'] = date('Y');
				}
				else if (preg_match('/[a-z]+\.{1}[a-z0-9\_]+/', $this->_removeQuote($aArgs['start_year']), $aMatch) > 0)
				{
					$aArgs['start_year'] = Phpfox::getParam($aMatch[0]);
				}

				if (substr($this->_removeQuote($aArgs['end_year']), 0, 1) == '+')
				{
					$aArgs['end_year'] = (date('Y') + substr_replace($this->_removeQuote($aArgs['end_year']), '', 0, 1));
				}
				else if (preg_match('/[a-z]+\.{1}[a-z0-9\_]+/', $this->_removeQuote($aArgs['end_year']), $aMatch) > 0)
				{
					$aArgs['end_year'] = Phpfox::getParam($aMatch[0]);
				}
				
				if (isset($aArgs['sort_years']) && $aArgs['sort_years'] == '\'DESC\'')
				{
					$sTemp = $aArgs['start_year'];
					$aArgs['start_year'] = $aArgs['end_year'];
					$aArgs['end_year'] = $sTemp;
				}

				$sYear = '<?php $aYears = range(' . $aArgs['start_year'] . ', ' . $aArgs['end_year'] . ');  ?>';
				$sYear .= '<?php $aParams = (isset($aParams) ? $aParams : Phpfox::getLib(\'phpfox.request\')->getArray(\'val\')); ?>';
				$sYear .= "\t\t" . '<select name="val[' . $sPrefix . 'year]" id="' . $sPrefix . 'year" class="js_datepicker_year">' . "\n";
				if (!isset($aArgs['default_all']))
				{
					$sYear .= "\t\t" . '<option value=""><?php echo Phpfox::getPhrase(\'core.year\'); ?>:</option>' . "\n";
				}
				$sYear .= '<?php foreach ($aYears as $iYear): ?>';
				$sYear .= "\t\t\t" . '<option value="<?php echo $iYear; ?>"<?php echo ((isset($aParams[\'' . $sPrefix . 'year\']) && $aParams[\'' . $sPrefix . 'year\'] == $iYear) ? \' selected="selected"\' : (!isset($this->_aVars[\'aForms\'][\'' . $sPrefix . 'year\']) ? ($iYear == Phpfox::getTime(\'Y\') ? \' selected="selected"\' : \'\') : ($this->_aVars[\'aForms\'][\'' . $sPrefix . 'year\'] == $iYear ? \' selected="selected"\' : \'\'))); ?>><?php echo $iYear; ?></option>'  . "\n";
				$sYear .= '<?php endforeach; ?>';
				$sYear .= "\t\t" . '</select>' . "\n";

				$aSep = '<span class="field_separator">' . $this->_removeQuote($aArgs['field_separator']) . '</span>';

				$sReturn = '';
				switch (Phpfox::getParam('core.date_field_order'))
				{
					case 'DMY':
						$sReturn = $sDay . $aSep . $sMonth . $aSep . $sYear;
						break;
					case 'YMD':
						$sReturn = $sYear . $aSep . $sMonth . $aSep . $sDay;
						break;
					// MDY
					default:
						$sReturn = $sMonth . $aSep . $sDay . $aSep . $sYear;
						break;
				}

				if ($bUseJquery)
				{
					$sValue = '';
					$sValue .= '<?php if (isset($aParams[\'' . $sPrefix . 'month\'])): ?>';
					$sValue .= '<?php echo $aParams[\'' . $sPrefix . 'month\'] . \'/\'; ?>';
					$sValue .= '<?php echo $aParams[\'' . $sPrefix . 'day\'] . \'/\'; ?>';
					$sValue .= '<?php echo $aParams[\'' . $sPrefix . 'year\']; ?>';
					$sValue .= '<?php elseif (isset($this->_aVars[\'aForms\'])): ?>';
					$sValue .= '<?php if (isset($this->_aVars[\'aForms\'][\'' . $sPrefix . 'month\'])): ?>';

					$sValue .= '<?php switch(Phpfox::getParam("core.date_field_order")){ ?>';
					$sValue .= '<?php case "DMY": ?>';
					$sValue .= '<?php echo $this->_aVars[\'aForms\'][\'' . $sPrefix . 'day\'] . \'/\'; ?>';
					$sValue .= '<?php echo $this->_aVars[\'aForms\'][\'' . $sPrefix . 'month\'] . \'/\'; ?>';					
					$sValue .= '<?php echo $this->_aVars[\'aForms\'][\'' . $sPrefix . 'year\']; ?>';
					$sValue .= '<?php break; ?>';
					$sValue .= '<?php case "MDY": ?>';
					$sValue .= '<?php echo $this->_aVars[\'aForms\'][\'' . $sPrefix . 'month\'] . \'/\'; ?>';
					$sValue .= '<?php echo $this->_aVars[\'aForms\'][\'' . $sPrefix . 'day\'] . \'/\'; ?>';
					$sValue .= '<?php echo $this->_aVars[\'aForms\'][\'' . $sPrefix . 'year\']; ?>';
					$sValue .= '<?php break; ?>';
					$sValue .= '<?php case "YMD": ?>';
					$sValue .= '<?php echo $this->_aVars[\'aForms\'][\'' . $sPrefix . 'year\'] . \'/\'; ?>';
					$sValue .= '<?php echo $this->_aVars[\'aForms\'][\'' . $sPrefix . 'month\'] . \'/\'; ?>';
					$sValue .= '<?php echo $this->_aVars[\'aForms\'][\'' . $sPrefix . 'day\']; ?>';					
					$sValue .= '<?php break; ?>';
					$sValue .= '<?php } ?>';									
					
					$sValue .= '<?php endif; ?>';
					$sValue .= '<?php else: ?>';	
					$sValue .= '<?php switch(Phpfox::getParam("core.date_field_order")){';
					$sValue .= '	case "DMY": echo Phpfox::getTime(\'j\') . \'/\' . Phpfox::getTime(\'n\') . \'/\' . Phpfox::getTime(\'Y\'); break;';
					$sValue .= '	case "MDY": echo Phpfox::getTime(\'n\') . \'/\' . Phpfox::getTime(\'j\') . \'/\' . Phpfox::getTime(\'Y\'); break;';
					$sValue .= '	case "YMD": echo Phpfox::getTime(\'Y\') . \'/\' . Phpfox::getTime(\'n\') . \'/\' . Phpfox::getTime(\'j\'); break;';
					$sValue .= '}?>';
					/*$sValue .= '<?php echo Phpfox::getTime(\'n\') . \'/\'; ?>';
					$sValue .= '<?php echo Phpfox::getTime(\'j\') . \'/\'; ?>';
					$sValue .= '<?php echo Phpfox::getTime(\'Y\'); ?>';		*/		
					$sValue .= '<?php endif; ?>';
					
					$sReturn = '<div class="js_datepicker_core'. (isset($aArgs['id']) ? str_replace(array('"',"'"),'',$aArgs['id']) : '')  .'"><div class="js_datepicker_image"></div><span class="js_datepicker_holder"><div style="display:none;">' . $sReturn . '</div><input type="text" name="js_' . $sPrefix . '_datepicker" value="' . $sValue . '" class="js_date_picker" /></span> ';
				}
				
				if (isset($aArgs['add_time']))
				{
					$sCustomPhrase = $this->_removeQuote($aArgs['time_separator']);
					$aCustomPhraseParts = explode('.', $sCustomPhrase);					
					if (Phpfox::isModule($aCustomPhraseParts[0]))
					{
						$sReturn .= Phpfox::getPhrase($sCustomPhrase);
					}
					$aHours = range(0, 23);
					$sReturn .= "\t\t" . '<select name="val[' . $sPrefix . 'hour]" id="' . $sPrefix . 'hour">' . "\n";
					foreach ($aHours as $iHour)
					{
						if (isset($aArgs['start_hour']))
						{
							if (substr($this->_removeQuote($aArgs['start_hour']), 0, 1) == '+')
							{
								$aArgs['start_hour'] = substr_replace($this->_removeQuote($aArgs['start_hour']), '', 0, 1);
							}
						}

						if (strlen($iHour) < 2)
						{
							$iHour = '0' . $iHour;
						}

						$sReturn .= "\t\t\t" . '<option value="' . $iHour . '"' . $this->_parseFunction('value', '', "type='select' id='{$sPrefix}hour' default='{$iHour}'") . (isset($aArgs['default_all']) ? '<?php echo (!isset($this->_aVars[\'aForms\'][\'' . $sPrefix . 'hour\']) ? (\'' . $iHour . '\' == ' . (isset($aArgs['start_hour']) ? '(Phpfox::getLib(\'date\')->modifyHours(\'+' . $aArgs['start_hour'] . '\'))' : 'Phpfox::getTime(\'H\')') . ' ? \' selected="selected"\' : \'\') : \'\'); ?>' : '') . '>' . $iHour . '</option>'  . "\n";
					}
					$sReturn .= "\t\t" . '</select>&nbsp;&nbsp;:&nbsp;&nbsp;' . "\n";

					$aMinutes = range(0, 59);
					$sReturn .= "\t\t" . '<select name="val[' . $sPrefix . 'minute]" id="' . $sPrefix . 'minute">' . "\n";
					foreach ($aMinutes as $iMinute)
					{
						if (strlen($iMinute) < 2)
						{
							$iMinute = '0' . $iMinute;
						}
						$sReturn .= "\t\t\t" . '<option value="' . $iMinute . '"' . $this->_parseFunction('value', '', "type='select' id='{$sPrefix}minute' default='{$iMinute}'") . (isset($aArgs['default_all']) ? '<?php echo (!isset($this->_aVars[\'aForms\'][\'' . $sPrefix . 'minute\']) ? (\'' . $iMinute . '\' == Phpfox::getTime(\'i\') ? \' selected="selected"\' : \'\') : \'\'); ?>' : '') . '>' . $iMinute . '</option>'  . "\n";
					}
					$sReturn .= "\t\t" . '</select>' . "\n";	
				}	
				
				if ($bUseJquery)
				{
					$sReturn .= '</div>';
				}

				return $sReturn;

				break;
			case 'select_location':
				$aArgs = $this->_parseArgs($sArguments);
				if (isset($aArgs['value_title']) && strpos($aArgs['value_title'], 'phrase var=') !== false)
				{
					$aArgs['value_title'] = Phpfox::getPhrase(str_replace(array('phrase var=','"',"'"),'',$aArgs['value_title']));
				}
				$bIsMultiple = isset($aArgs['multiple']) && !empty($aArgs['multiple']);
				
				$sCountries = '<select '. ( $bIsMultiple ? 'multiple="multiple" ' : '') .'name="val[' . (isset($aArgs['name']) ? $this->_removeQuote($aArgs['name']) : 'country_iso') . ']'. ($bIsMultiple ? '[]':'') .'" id="' . (isset($aArgs['name']) ? $this->_removeQuote($aArgs['name']) : 'country_iso') . '"' . (isset($aArgs['style']) ? ' style=' . $aArgs['style'] . '' : '') . '>' . "\n";
				$sCountries .= "\t\t" . '<option value="">' . (isset($aArgs['value_title']) ? $this->_removeQuote($aArgs['value_title']) : '<?php echo Phpfox::getPhrase(\'core.select\'); ?>:') . '</option>' . "\n";
				foreach (Phpfox::getService('core.country')->get() as $sIso => $sCountry)
				{
					/*
                    $sCountries .= "\t\t\t" . '<option class="js_country_option" id="js_country_iso_option_' . $sIso . '" value="' . $sIso . '"' . $this->_parseFunction('value', '', "type='select' id='" . (isset($aArgs['name']) ? $this->_removeQuote($aArgs['name']) : 'country_iso') . "' default='{$sIso}'") . '><?php echo (Phpfox::getLib(\'locale\')->isPhrase(\'core.translate_country_iso_' . strtolower($sIso) . '\') ? Phpfox::getPhrase(\'core.translate_country_iso_' . strtolower($sIso) . '\') : \'' . str_replace("'", "\'", $sCountry) . '\'); ?></option>' . "\n";
                     */
                    $sCountries .= "\t\t\t" . '<option class="js_country_option" id="js_country_iso_option_'. $sIso . '" value="' . $sIso . '"'. '><?php echo (Phpfox::getLib(\'locale\')->isPhrase(\'core.translate_country_iso_' . strtolower($sIso) . '\') ? Phpfox::getPhrase(\'core.translate_country_iso_' . strtolower($sIso) . '\') : \'' . str_replace("'", "\'", $sCountry) . '\'); ?></option>' . "\n";
				}
				$sCountries .= "\t\t" . '</select>';
                $sCountries .= "\n" . '<?php if (isset($this->_aVars[\'aForms\'][\'country_iso\']))';
                $sCountries .= "\n" .'{ ';
                $sCountries .= "\n" . 'echo \'<script type="text/javascript"> $Behavior.setCountry = function() {';
                $sCountries .= '$("#js_country_iso_option_\' . $this->_aVars[\'aForms\'][\'country_iso\'] . \'").attr("selected","selected"); } </script>\';  }';
                $sCountries .= "\n" . '?>';
				return $sCountries;
				break;
			case 'select_gender':
				$aArgs = $this->_parseArgs($sArguments);
				if (isset($aArgs['value_title']) && strpos($aArgs['value_title'], 'phrase var=') !== false)
				{
					$aArgs['value_title'] = Phpfox::getPhrase(str_replace(array('phrase var=','"',"'"),'',$aArgs['value_title']));
				}
				$sGenders = '<select name="val[gender]" id="gender">' . "\n";
				$sGenders .= "\t\t" . '<option value="">' . (isset($aArgs['value_title']) ? $this->_removeQuote($aArgs['value_title']) : '<?php echo Phpfox::getPhrase(\'core.select\'); ?>:') . '</option>' . "\n";
				foreach (Phpfox::getService('core')->getGenders(true) as $iKey => $sGender)
				{
					$sGenders .= "\t\t\t" . '<option value="' . $iKey . '"' . $this->_parseFunction('value', '', "type='select' id='gender' default='{$iKey}'") . '><?php echo Phpfox::getPhrase(\'' . $sGender . '\'); ?></option>' . "\n";
				}
				$sGenders .= "\t\t" . '</select>';
				return $sGenders;
				break;
			case 'inline_search':
				$aArgs = $this->_parseArgs($sArguments);
				$aParams = array();
				foreach ($aArgs as $sKey => $mParam)
				{
					$aParams[$sKey] = $this->_removeQuote($mParam);
				}
				return '<?php echo Phpfox::getLib(\'phpfox.search.inline\')->get(' . var_export($aParams, true) . '); ?>';
				break;
			case 'application':
				$aArgs = $this->_parseArgs($sArguments);
				return '<?php echo Phpfox::getService(\'application\')->getForProfile(' . $aArgs['user_id'] . ', ' . $aArgs['location'] . '); ?>';
				break;
			case 'filter':
				$aArgs = $this->_parseArgs($sArguments);
				return '<?php echo $this->_aVars[\'aFilters\'][' . $aArgs['key'] . ']; ?>';
				break;
			case 'jscript':
				$aArgs = $this->_parseArgs($sArguments);
				return '<?php echo $this->getStyle(\'static_script\', ' . $aArgs['file'] . '' . (isset($aArgs['module']) ? ', ' . $aArgs['module'] . '' : '') . '); ?>';
				break;
			case 'css':
				$aArgs = $this->_parseArgs($sArguments);
				return '<?php echo $this->getStyle(\'css\', ' . $aArgs['file'] . '' . (isset($aArgs['module']) ? ', ' . $aArgs['module'] . '' : '') . '); ?>';
				break;
			case 'moderation':
				return '<?php Phpfox::getBlock(\'core.moderation\'); ?>';
				break;
			case 'section_menu_js':
				return '<?php echo Phpfox::getLib(\'template\')->getSectionMenuJavaScript(); ?>';
				break;	
			case 'body':
				return '<?php Phpfox::getBlock(\'core.template-body\'); ?>';
				break;
			case 'notification':
				return '<?php Phpfox::getBlock(\'core.template-notification\'); ?>';
				break;
			/*
			case 'menu_account':
				return '<?php Phpfox::getBlock(\'core.template-menuaccount\'); ?>';
				break;
			*/
			case 'menu':
				return '<?php Phpfox::getBlock(\'core.template-menu\'); ?>';
				break;	
			case 'menu_sub':
				return '<div class="_block_menu_sub"><?php Phpfox::getBlock(\'core.template-menusub\'); ?></div>';
				break;	
			case 'menu_footer':
				return '<?php Phpfox::getBlock(\'core.template-menufooter\'); ?>';
				break;	
			case 'copyright':
				return '<?php Phpfox::getBlock(\'core.template-copyright\'); ?>';
				break;		
			case 'footer':
				return '<?php Phpfox::getBlock(\'core.template-footer\'); ?>';
				break;
			case 'holder_name':
				return '<?php Phpfox::getBlock(\'core.template-holdername\'); ?>';
				break;	
			case 'logo':
				return '<?php Phpfox::getBlock(\'core.template-logo\'); ?>';
				break;		
			case 'breadcrumb_list':
				return '<?php Phpfox::getBlock(\'core.template-breadcrumblist\'); ?>';
				break;	
			case 'breadcrumb_menu':
				return '<?php Phpfox::getBlock(\'core.template-breadcrumbmenu\'); ?>';
				break;	
			case 'content_class':
				return '<?php Phpfox::getBlock(\'core.template-contentclass\'); ?>';
				break;				
			case 'is_page_view':
				return '<?php echo (defined(\'PHPFOX_IS_PAGES_VIEW\') ? \'id="js_is_page"\' : \'\'); ?>';
				break;
			case 'item':
				$aArgs = $this->_parseArgs($sArguments);
				return '<article itemscope itemtype="http://schema.org/' . $this->_removeQuote($aArgs['name']) . '">';
				break;
			case '/item':			
				return '</article>';
				break;				
			default:				
				if ($this->_compileCustomFunction($sFunction, $sModifiers, $sArguments, $sResult))
				{
					return $sResult;
				}
				else
				{
					Phpfox_Error::trigger('Invalid function: ' . $sFunction);
				}
				return $sResult;
		}
	}

	/**
	 * Parse arguments. (eg. {for bar1=sample1 bar2=sample2}
	 *
	 * @param string $sArguments Arguments to parse.
	 * @return array ARRAY of all the arguments.
	 */
	private function _parseArgs($sArguments)
	{
		$aResult	= array();
		preg_match_all('/(?:' . $this->_sQstrRegexp . ' | (?>[^"\'=\s]+))+|[=]/x', $sArguments, $aMatches);

		$iState = 0;
		foreach($aMatches[0] as $mValue)
		{
			switch($iState)
			{
				case 0:
					if (is_string($mValue))
					{
						$sName = $mValue;
						$iState = 1;
					}
					else
					{
						Phpfox_Error::trigger("Invalid Attribute Name", E_USER_ERROR);
					}
					break;
				case 1:
					if ($mValue == '=')
					{
						$iState = 2;
					}
					else
					{
						 Phpfox_Error::trigger("Expecting '=' After '{$sLastValue}'", E_USER_ERROR);
					}
					break;
				case 2:
					if ($mValue != '=')
					{
						if(!preg_match_all('/(?:(' . $this->_sVarRegexp . '|' . $this->_sSvarRegexp . ')(' . $this->_sModRegexp . '*))(?:\s+(.*))?/xs', $mValue, $aVariables))
						{
							$aResult[$sName] = $mValue;
						}
						else
						{
							$aResult[$sName] = $this->_parseVariables($aVariables[1], $aVariables[2]);
						}
						$iState = 0;
					}
					else
					{
						Phpfox_Error::trigger("'=' cannot be an attribute value", E_USER_ERROR);
					}
					break;
			}
			$sLastValue = $mValue;
		}

		if($iState != 0)
		{
			if($iState == 1)
			{
				Phpfox_Error::trigger("expecting '=' after attribute name '{$sLastValue}'", E_USER_ERROR);
			}
			else
			{
				Phpfox_Error::trigger("missing attribute value", E_USER_ERROR);
			}
		}

		return $aResult;
	}

	/**
	 * Parse variables.
	 *
	 * @param array $aVariables ARRAY of variables.
	 * @param array $aModifiers ARRAY of modifiers.
	 * @return string Converted variable.
	 */
	private function _parseVariables($aVariables, $aModifiers)
	{
		$sResult = "";
		foreach($aVariables as $mKey => $mValue)
		{
			if (empty($aModifiers[$mKey]))
			{
				$sResult .= $this->_parseVariable(trim($aVariables[$mKey])).'.';
			}
			else
			{
				$sResult .= $this->_parseModifier($this->_parseVariable(trim($aVariables[$mKey])), $aModifiers[$mKey]).'.';
			}
		}
		return substr($sResult, 0, -1);
	}

	/**
	 * Parse a specific variable.
	 *
	 * @param string $sVariable Name of the variable we are parsing.
	 * @return string Converted variable.
	 */
	private function _parseVariable($sVariable)
	{
		if ($sVariable{0} == "\$")
		{
			return $this->_compileVariable($sVariable);
		}
		else
		{
			return $sVariable;
		}
	}

	/**
	 * Compile all variables.
	 *
	 * @param string $sVariable Variable name.
	 * @return string Converted variable.
	 */
	private function _compileVariable($sVariable)
	{
		$sResult = '';
		$sVariable = substr($sVariable, 1);

		preg_match_all('!(?:^\w+)|(?:' . $this->_sVarBracketRegexp . ')|\.\$?\w+|\S+!', $sVariable, $aMatches);
		$aVariables = $aMatches[0];
		$sVarName = array_shift($aVariables);

		if ($sVarName == $this->sReservedVarname)
		{
			if ($aVariables[0]{0} == '[' || $aVariables[0]{0} == '.')
			{
				$aFind = array("[", "]", ".");
				switch(strtoupper(str_replace($aFind, "", $aVariables[0])))
				{
					case 'GET':
						$sResult = "\$_GET";
						break;
					case 'POST':
						$sResult = "\$_POST";
						break;
					case 'COOKIE':
						$sResult = "\$_COOKIE";
						break;
					case 'ENV':
						$sResult = "\$_ENV";
						break;
					case 'SERVER':
						$sResult = "\$_SERVER";
						break;
					case 'SESSION':
						$sResult = "\$_SESSION";
						break;
					default:
						$sVar = str_replace($aFind, "", $aVariables[0]);
						$sResult = "\$this->_aPhpfoxVars['$sVar']";
						break;
				}
				array_shift($aVariables);
			}
			else
			{
				Phpfox_Error::trigger('$' . $sVarName.implode('', $aVariables) . ' is an invalid $phpfox reference', E_USER_ERROR);
			}
		}
		else
		{
			$sResult = "\$this->_aVars['$sVarName']";
			// $sResult = "\$this->getVar('$sVarName')";
		}

		foreach ($aVariables as $sVar)
		{
			if ($sVar{0} == '[')
			{
				$sVar = substr($sVar, 1, -1);
				if (is_numeric($sVar))
				{
					$sResult .= "[$sVar]";
				}
				elseif ($sVar{0} == '$')
				{
					$sResult .= "[" . $this->_compileVariable($sVar) . "]";
				}
				else
				{
					$parts = explode('.', $sVar);
					$section = $parts[0];
					$section_prop = isset($parts[1]) ? $parts[1] : 'index';
					$sResult .= "[\$this->_aSections['$section']['$section_prop']]";
				}
			}
			elseif ($sVar{0} == '.')
			{
   				$sResult .= "['" . substr($sVar, 1) . "']";
			}
			elseif (substr($sVar,0,2) == '->')
			{
				Phpfox_Error::trigger('Call to object members is not allowed', E_USER_ERROR);
			}
			else
			{
				Phpfox_Error::trigger('$' . $sVarName.implode('', $aVariables) . ' is an invalid reference', E_USER_ERROR);
			}
		}
		return $sResult;
	}

	/**
	 * Parse modifiers.
	 *
	 * @param string $sVariable Variable name.
	 * @param string $sModifiers Modifiers.
	 * @return string Converted modifier.
	 */
	private function _parseModifier($sVariable, $sModifiers)
	{
		$aMods = array();
		$aArgs = array();

		$aMods = explode('|', $sModifiers);
		unset($aMods[0]);
		foreach ($aMods as $sMod)
		{
			$aArgs = array();
			if (strpos($sMod, ':'))
			{
				$aParts = explode(':', $sMod);
				$iCnt = 0;

				foreach ($aParts as $iKey => $sPart)
				{
					if ($iKey == 0)
					{
						continue;
					}

					if ($iKey > 1)
					{
						$iCnt++;
					}

					$aArgs[$iCnt] = $this->_parseVariable($sPart);
				}

				$sMod = $aParts[0];
			}

			if ($sMod{0} == '@')
			{
				$sMod = substr($sMod, 1);
				$bMapArray = false;
			}
			else
			{
				$bMapArray = true;
			}

			$sArg = ((count($aArgs) > 0) ? ', '.implode(', ', $aArgs) : '');

			if ($this->_plugin($sMod, 'modifier'))
			{
				$sVariable = "\$this->_runModifier($sVariable, '$sMod', 'plugin', $sArg)";
			}
			else
			{
				switch ($sMod)
				{
					case 'htmlspecialchars':
						$sVariable = "Phpfox::getLib('parse.output')->htmlspecialchars({$sVariable})";
						break;
					case 'filesize':
						$sVariable = 'Phpfox::getLib(\'phpfox.file\')->filesize(' . $sVariable . ')';
						break;
					case 'clean':
						if (isset($aArgs[0]) )
						{
							$sVariable = 'Phpfox::getLib(\'phpfox.parse.output\')->clean(' . $sVariable . ',' . $aArgs[0].')';
						}
						else
						{
							$sVariable = 'Phpfox::getLib(\'phpfox.parse.output\')->clean(' . $sVariable . ')';
						}
						break;
					case 'clean_phrase':
						$sVariable = 'md5('.$sVariable . ')';
						break;
					case 'parse':
						$sVariable = 'Phpfox::getLib(\'phpfox.parse.output\')->parse(' . $sVariable . ')';
						break;
					case 'sprintf':
						$sVariable = 'sprintf(' . $sVariable . '' . $sArg . ')';
						break;
					case 'date':
						$sVariable = 'Phpfox::getTime(Phpfox::getParam(\'' . (empty($aArgs[0]) ? 'core.global_update_time' : $this->_removeQuote($aArgs[0])) . '\'), ' . $sVariable . ')';
						break;
					case 'highlight':
						$sVariable = 'Phpfox::getLib(\'phpfox.search\')->highlight(' . $aArgs[0] . ', ' . $sVariable . ')';
						break;
					case 'feed_strip':
						$sVariable = 'Phpfox::getLib(\'parse.output\')->feedStrip(' . $sVariable . ')';
						break;	
					case 'max_line':
						$sVariable = 'Phpfox::getLib(\'parse.output\')->maxLine(' . $sVariable . ')';
						break;
					case 'translate':
						$sPrefix = (isset($aArgs[0]) ? ', ' . $aArgs[0] : '');
						$sVariable = 'Phpfox::getLib(\'phpfox.locale\')->translate(' . $sVariable . $sPrefix . ')';
						break;
					case 'eval':
						$sVariable = 'eval(\' ?>\' . ' . $sVariable . ' . \'<?php \')';
						break;
					case 'tag_search':
						$sVariable = 'str_replace(' . $aArgs[0] . ', \'<u>\' . ' . $aArgs[0] . ' . \'</u>\', ' . $sVariable . ')';
						break;
					case 'shorten':
						if (!empty($aArgs[0]) && is_string($aArgs[0]) && preg_match('/[a-z]+\.{1}[a-z\_]+/', $aArgs[0], $aMatches) > 0)
						{							
							$sArg = $this->_removeQuote(trim(ltrim($aArgs[0], ', ')));
							$sArg = ',' . Phpfox::getParam($sArg);
						}
						$sVariable = 'Phpfox::getLib(\'phpfox.parse.output\')->shorten(' . $sVariable  . $sArg . ')';
						break;
					case 'split':
						$sVariable = 'Phpfox::getLib(\'phpfox.parse.output\')->split(' . $sVariable . ', ' . $aArgs[0] . ')';
						break;
					case 'first_name':
						$sVariable = 'Phpfox::getService(\'user\')->getFirstname(' . $sVariable . ')';
						break;
					case 'location':
						$sVariable = 'Phpfox::getService(\'core.country\')->getCountry(' . $sVariable . ')';
						break;
					case 'location_child':
						$sVariable = 'Phpfox::getService(\'core.country\')->getChild(' . $sVariable . ')';
						break;
					case 'stripbb':
						$sVariable = 'Phpfox::getLib(\'phpfox.parse.bbcode\')->stripCode(' . $sVariable . ')';
						break;
					case 'cleanbb':
						$sVariable = 'Phpfox::getLib(\'phpfox.parse.bbcode\')->cleanCode(' . $sVariable . ')';
						break;
					case 'convert_time':
						$sVariable = 'Phpfox::getLib(\'date\')->convertTime(' . $sVariable . '' . $sArg . ')';
						break;
					case 'micro_time':
						$sVariable = 'date(\'Y-d-m\', ' . $sVariable . ')';
						break;						
					case 'convert':
						$sVariable = 'Phpfox::getLib(\'locale\')->convert(' . $sVariable . ')';
						break;
					case 'user':
						$sSuffix = '';
						$sExtra = '';

						if (count($aArgs))
						{
							if (!empty($aArgs[0]))
							{
								$sSuffix = $this->_removeQuote($aArgs[0]);
							}
						}

						$bAuthor = false;
						$sValue = '\' . Phpfox::getLib(\'phpfox.parse.output\')->shorten(Phpfox::getService(\'user\')->getCurrentName(' . $sVariable . '[\'' . $sSuffix . 'user_id\'], ' . $sVariable . '[\'' . $sSuffix . 'full_name\']), Phpfox::getParam(\'user.maximum_length_for_full_name\')) . \'';
						if (count($aArgs))
						{
							if (!empty($aArgs[1]))
							{
								$sExtra .= $this->_removeQuote($aArgs[1]);
							}

							if (!empty($aArgs[2]))
							{
								if (preg_match('/[a-z]+\.{1}[a-z\_]+/', $aArgs[2], $aMatches) > 0)
								{
									$aArgs[2] = Phpfox::getParam($this->_removeQuote($aArgs[2]));
								}
								$sValue = '\' . Phpfox::getLib(\'phpfox.parse.output\')->shorten(Phpfox::getService(\'user\')->getCurrentName(' . $sVariable . '[\'' . $sSuffix . 'user_id\'], ' . $sVariable . '[\'' . $sSuffix . 'full_name\']), ' . $this->_removeQuote($aArgs[2]) . ', \'...\') . \'';
							}

							if (isset($aArgs[3]))
							{
								$aArgs[3] = $this->_removeQuote($aArgs[3]);
							}
							if (!empty($aArgs[3]))
							{
								$sValue = '\' . Phpfox::getLib(\'phpfox.parse.output\')->shorten(Phpfox::getLib(\'phpfox.parse.output\')->split(Phpfox::getService(\'user\')->getCurrentName(' . $sVariable . '[\'' . $sSuffix . 'user_id\'], ' . $sVariable . '[\'' . $sSuffix . 'full_name\']), ' . $this->_removeQuote($aArgs[3]) . '' . (empty($aArgs[3]) ? '' : ', true') . '), Phpfox::getParam(\'user.maximum_length_for_full_name\')) . \'';
							}
							
							if (isset($aArgs[4]))
							{
								$aArgs[4] = $this->_removeQuote($aArgs[4]);
								if (!empty($aArgs[4]))
								{
									$bAuthor = true;
									$sExtra .= ' rel="author" ';
								}
							}							
						}
						$sVariable = '\'<span class="user_profile_link_span" id="js_user_name_link_\' . ' . $sVariable . '[\'' . $sSuffix . 'user_name\'] . \'"' . ($bAuthor ? ' itemprop="author"' : '') . '><a href="\' . Phpfox::getLib(\'phpfox.url\')->makeUrl(\'profile\', array(' . $sVariable . '[\'' . $sSuffix . 'user_name\'], ((empty(' . $sVariable . '[\'' . $sSuffix . 'user_name\']) && isset(' . $sVariable . '[\'' . $sSuffix . 'profile_page_id\'])) ? ' . $sVariable . '[\'' . $sSuffix . 'profile_page_id\'] : null))) . \'"' . $sExtra . '>' . $sValue . '</a></span>\'';
						break;
					case 'gender':
						$sVariable = 'Phpfox::getService(\'user\')->gender(' . $sVariable . $sArg . ')';
						break;
					case 'age':
						$sVariable = 'Phpfox::getService(\'user\')->age(' . $sVariable . ')';
						break;
					case 'currency_symbol':
						$sVariable = 'Phpfox::getService(\'core.currency\')->getSymbol(' . $sVariable . ')';
						break;
					case 'currency':
						$sVariable = 'Phpfox::getService(\'core.currency\')->getCurrency(' . $sVariable . $sArg . ')';
						break;
					case 'hide_email':
						$sVariable = 'Phpfox::getLib(\'phpfox.parse.format\')->hideEmail(' . $sVariable . ')';
						break;
					case 'privacy_phrase':
						$sVariable = 'Phpfox::getService(\'privacy\')->getPhrase(' . $sVariable . ')';
						break;
					case 'category_display':
						$sVariable = 'Phpfox::getService(\'core.category\')->displayView(' . $sVariable . $sArg . ')';
						break;
					case 'emoticon':
						$sVariable = '(Phpfox::isModule(\'emoticon\') ? Phpfox::getService(\'emoticon\')->parse(' . $sVariable . ') : ' . $sVariable . ')';
						break;					
					default:
						if (function_exists($sMod))
						{
							$sVariable = '' . $sMod . '(' . $sVariable . $sArg . ')';
						}
						else
						{
							$sVariable = "Phpfox_Error::trigger(\"'" . $sMod . "' modifier does not exist\", E_USER_ERROR)";
						}
				}
			}
		}

		return $sVariable;
	}

	/**
	 * Load custom plug-ins.
	 * NOTE: This is not in use yet.
	 *
	 * @param string $sFunction Custom function name.
	 * @param string $sType Type of function.
	 * @return string Returns function to load.
	 */
	private function _plugin($sFunction, $sType)
	{
		if (isset($this->_aPlugins[$sType][$sFunction]) && is_array($this->_aPlugins[$sType][$sFunction]) && is_object($this->_aPlugins[$sType][$sFunction][0]) && method_exists($this->_aPlugins[$sType][$sFunction][0], $this->_aPlugins[$sType][$sFunction][1]))
		{
			return '$this->_aPlugins[\'' . $sType . '\'][\'' . $sFunction . '\'][0]->' . $this->_aPlugins[$sType][$sFunction][1];
		}

		if (isset($this->_aPlugins[$sType][$sFunction]) && function_exists($this->_aPlugins[$sType][$sFunction]))
		{
			return $this->_aPlugins[$sType][$sFunction];
		}

		if (function_exists('phpfox_' . $sType . '_' . $sFunction))
		{
			$this->_aRequireStack[$sType . '.' . $sFunction . '.php'] = array($sType, $sFunction, 'phpfox_' . $sType . '_' . $sFunction);

			return 'phpfox_' . $sType . '_' . $sFunction;
		}

		if (file_exists(PHPFOX_DIR_TPL_PLUGIN . $sType . '.' . $sFunction . '.php'))
		{
			require_once(PHPFOX_DIR_TPL_PLUGIN . $sType . '.' . $sFunction . '.php');

			if (function_exists('phpfox_' . $sType . '_' . $sFunction))
			{
				$this->_aRequireStack[$sType . '.' . $sFunction . '.php'] = array($sType, $sFunction, 'phpfox_' . $sType . '_' . $sFunction);

				return 'phpfox_' . $sType . '_' . $sFunction;
			}
		}
		return false;
	}

	/**
	 * Compile custom function into the template it is loaded in.
	 *
	 * @param string $sFunction Name of the function.
	 * @param string $sModifiers Modifier to load.
	 * @param string $sArguments Arguments of the function.
	 * @param string $sResult Converted string of the PHP function.
	 * @return bool TRUE function converted, FALSE if it didn't convert.
	 */
	private function _compileCustomFunction($sFunction, $sModifiers, $sArguments, &$sResult)
	{
		if ($sFunction = $this->_plugin($sFunction, "function"))
		{
			$aArgs = $this->_parseArgs($sArguments);
			foreach($aArgs as $mKey => $mValue)
			{
				if (is_bool($mValue))
				{
					$mValue = $mValue ? 'true' : 'false';
				}
				if (is_null($mValue))
				{
					$mValue = 'null';
				}
				$aArgs[$mKey] = "'$mKey' => $mValue";
			}
			$sResult = '<?php echo ';
			if (!empty($sModifiers))
			{
				$sResult .= $this->_parseModifier($sFunction . '(array(' . implode(',', (array)$aArgs) . '), $this)', $sModifiers) . '; ';
			}
			else
			{
				$sResult .= $sFunction . '(array(' . implode(',', (array)$aArgs) . '), $this);';
			}
			$sResult .= '?>';

			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Compile IF statments.
	 *
	 * @param string $sArguments If statment arguments.
	 * @param bool $bElseif TRUE if this is an ELSEIF.
	 * @param bool $bWhile TRUE of this is a WHILE loop.
	 * @return string Returns the converted PHP if statment code.
	 */
	private function _compileIf($sArguments, $bElseif = false, $bWhile = false)
	{
		$aAllowed = array(
			'defined', 'is_array', 'isset', 'empty', 'count', '=', 'PHPFOX_IS_AJAX_PAGE', 'PHPFOX_IS_USER_PROFILE', 'PHPFOX_IS_PAGES_VIEW'
		);
		
		$sResult = "";
		$aArgs = array();
		$aArgStack	= array();

		preg_match_all('/(?>(' . $this->_sVarRegexp . '|\/?' . $this->_sSvarRegexp . '|\/?' . $this->_sFuncRegexp . ')(?:' . $this->_sModRegexp . '*)?|\-?0[xX][0-9a-fA-F]+|\-?\d+(?:\.\d+)?|\.\d+|!==|===|==|!=|<>|<<|>>|<=|>=|\&\&|\|\||\(|\)|,|\!|\^|=|\&|\~|<|>|\%|\+|\-|\/|\*|\@|\b\w+\b|\S+)/x', $sArguments, $aMatches);
		$aArgs = $aMatches[0];
		
		$iCountArgs = count($aArgs);
		for ($i = 0, $iForMax = $iCountArgs; $i < $iForMax; $i++)
		{
			$sArg = &$aArgs[$i];
			switch (strtolower($sArg))
			{
				case '!':
				case '%':
				case '!==':
				case '==':
				case '===':
				case '>':
				case '<':
				case '!=':
				case '<>':
				case '<<':
				case '>>':
				case '<=':
				case '>=':
				case '&&':
				case '||':
				case '^':
				case '&':
				case '~':
				case ')':
				case ',':
				case '+':
				case '-':
				case '*':
				case '/':
				case '@':
					break;
				case 'eq':
					$sArg = '==';
					break;
				case 'ne':
				case 'neq':
					$sArg = '!=';
					break;
				case 'lt':
					$sArg = '<';
					break;
				case 'le':
				case 'lte':
					$sArg = '<=';
					break;
				case 'gt':
					$sArg = '>';
					break;
				case 'ge':
				case 'gte':
					$sArg = '>=';
					break;
				case 'and':
					$sArg = '&&';
					break;
				case 'or':
					$sArg = '||';
					break;
				case 'not':
					$sArg = '!';
					break;
				case 'mod':
					$sArg = '%';
					break;
				case '(':
					array_push($aArgStack, $i);
					break;
				case 'is':
					$iIsArgCount = count($aArgs);
					$sIsArg = implode(' ', array_slice($aArgs, 0, $i - 0));
					$aArgTokens = $this->_compileParseIsExpr($sIsArg, array_slice($aArgs, $i+1));
					array_splice($aArgs, 0, count($aArgs), $aArgTokens);
					$i = $iIsArgCount - count($aArgs);
					break;
				default:
					preg_match('/(?:(' . $this->_sVarRegexp . '|' . $this->_sSvarRegexp . '|' . $this->_sFuncRegexp . ')(' . $this->_sModRegexp . '*)(?:\s*[,\.]\s*)?)(?:\s+(.*))?/xs', $sArg, $aMatches);

					if (isset($aMatches[0]{0}) && ($aMatches[0]{0} == '$' || $aMatches[0]{0} == "'" || $aMatches[0]{0} == '"'))
					{
						$sArg = $this->_parseVariables(array($aMatches[1]), array($aMatches[2]));
					}
					
					if (!defined('PHPFOX_INSTALLER') && Phpfox::getParam('core.is_auto_hosted') && preg_match('/frontend_([a-zA-Z0-9]+)_template/i', $this->_sCurrentFile))
					{
						if (strtolower($sArg) != 'phpfox' 
								&& !in_array(trim($sArg, "'"), $aAllowed)
								&& substr($sArg, 0, 2) != '::'
								&& substr($sArg, 0, 5) != '$this'								
							)
						{
							if (function_exists($sArg))
							{
								$sArg = '';
							}
						}
					}

					break;
			}
		}
		
		if($bWhile)
		{
			return implode(' ', $aArgs);
		}
		else
		{
			if ($bElseif)
			{
				return '<?php elseif ('.implode(' ', $aArgs).'): ?>';
			}
			else
			{
				return '<?php if ('.implode(' ', $aArgs).'): ?>';
			}
		}

		return $sResult;
	}

	/**
	 * Compile IF statment expressions.
	 *
	 * @param string $sIsArg If expression arguments.
	 * @param string $aArgs Arguments.
	 * @return string Converted PHP code.
	 */
	private function _compileParseIsExpr($sIsArg, $aArgs)
	{
		$iExprEnd = 0;
		$bNegateExpr = false;

		if (($first_arg = array_shift($aArgs)) == 'not')
		{
			$bNegateExpr = true;
			$sExprType = array_shift($aArgs);
		}
		else
		{
			$sExprType = $first_arg;
		}

		switch ($sExprType)
		{
			case 'even':
				if (isset($aArgs[$iExprEnd]) && $aArgs[$iExprEnd] == 'by')
				{
					$iExprEnd++;
					$eExprArg = $aArgs[$iExprEnd++];
					$sExpr = "!(1 & ($sIsArg / " . $this->_parseVariable($eExprArg) . "))";
				}
				else
				{
					$sExpr = "!(1 & $sIsArg)";
				}
				break;
			case 'odd':
				if (isset($aArgs[$iExprEnd]) && $aArgs[$iExprEnd] == 'by')
				{
					$iExprEnd++;
					$eExprArg = $aArgs[$iExprEnd++];
					$sExpr = "(1 & ($sIsArg / " . $this->_parseVariable($eExprArg) . "))";
				}
				else
				{
					$sExpr = "(1 & $sIsArg)";
				}
				break;
			case 'div':
				if (@$aArgs[$iExprEnd] == 'by')
				{
					$iExprEnd++;
					$eExprArg = $aArgs[$iExprEnd++];
					$sExpr = "!($sIsArg % " . $this->_parseVariable($eExprArg) . ")";
				}
				else
				{
					Phpfox_Error::trigger("expecting 'by' after 'div'", E_USER_ERROR);
				}
			break;
			default:
				Phpfox_Error::trigger("unknown 'is' expression - '$sExprType'", E_USER_ERROR);
				break;
		}

		if ($bNegateExpr)
		{
			$sExpr = "!($sExpr)";
		}

		array_splice($aArgs, 0, $iExprEnd, $sExpr);

		return $aArgs;
	}

	/**
	 * Complie sections {section}{/section}
	 *
	 * @param string $sArguments Section arguments.
	 * @return string Converted PHP foreach().
	 */
	private function _compileSectionStart($sArguments)
	{
		$aAttrs = $this->_parseArgs($sArguments);

		$sOutput = '<?php ';
		$sSectionName = $aAttrs['name'];
		if (empty($sSectionName))
		{
			Phpfox_Error::trigger("missing section name", E_USER_ERROR);
		}

		$sOutput .= "if (isset(\$this->_aSections['$sSectionName'])) unset(\$this->_aSections['$sSectionName']);\n";
		$sSectionProps = "\$this->_aSections['$sSectionName']";

		foreach ($aAttrs as $sAttrName => $sAttrValue)
		{
			switch ($sAttrName)
			{
				case 'loop':
					$sOutput .= "{$sSectionProps}['loop'] = is_array($sAttrValue) ? count($sAttrValue) : max(0, (int)$sAttrValue);\n";
					break;
				case 'show':
					if (is_bool($sAttrValue))
					{
						$bShowAttrValue = $sAttrValue ? 'true' : 'false';
					}
					else
					{
						$bShowAttrValue = "(bool)$sAttrValue";
					}
					$sOutput .= "{$sSectionProps}['show'] = $bShowAttrValue;\n";
					break;
				case 'name':
					$sOutput .= "{$sSectionProps}['$sAttrName'] = '$sAttrValue';\n";
					break;
				case 'max':
				case 'start':
					$sOutput .= "{$sSectionProps}['$sAttrName'] = (int)$sAttrValue;\n";
					break;
				case 'step':
					$sOutput .= "{$sSectionProps}['$sAttrName'] = ((int)$sAttrValue) == 0 ? 1 : (int)$sAttrValue;\n";
					break;
				default:
					Phpfox_Error::trigger("unknown section attribute - '$sAttrName'", E_USER_ERROR);
					break;
			}
		}

		if (!isset($aAttrs['show']))
		{
			$sOutput .= "{$sSectionProps}['show'] = true;\n";
		}

		if (!isset($aAttrs['loop']))
		{
			$sOutput .= "{$sSectionProps}['loop'] = 1;\n";
		}

		if (!isset($aAttrs['max']))
		{
			$sOutput .= "{$sSectionProps}['max'] = {$sSectionProps}['loop'];\n";
		}
		else
		{
			$sOutput .= "if ({$sSectionProps}['max'] < 0)\n" .
						"	{$sSectionProps}['max'] = {$sSectionProps}['loop'];\n";
		}

		if (!isset($aAttrs['step']))
		{
			$sOutput .= "{$sSectionProps}['step'] = 1;\n";
		}

		if (!isset($aAttrs['start']))
		{
			$sOutput .= "{$sSectionProps}['start'] = {$sSectionProps}['step'] > 0 ? 0 : {$sSectionProps}['loop']-1;\n";
		}
		else
		{
			$sOutput .= "if ({$sSectionProps}['start'] < 0)\n" .
					   "	{$sSectionProps}['start'] = max({$sSectionProps}['step'] > 0 ? 0 : -1, {$sSectionProps}['loop'] + {$sSectionProps}['start']);\n" .
					   "else\n" .
					   "	{$sSectionProps}['start'] = min({$sSectionProps}['start'], {$sSectionProps}['step'] > 0 ? {$sSectionProps}['loop'] : {$sSectionProps}['loop']-1);\n";
		}

		$sOutput .= "if ({$sSectionProps}['show']) {\n";
		if (!isset($aAttrs['start']) && !isset($aAttrs['step']) && !isset($aAttrs['max']))
		{
			$sOutput .= "	{$sSectionProps}['total'] = {$sSectionProps}['loop'];\n";
		}
		else
		{
			$sOutput .= "	{$sSectionProps}['total'] = min(ceil(({$sSectionProps}['step'] > 0 ? {$sSectionProps}['loop'] - {$sSectionProps}['start'] : {$sSectionProps}['start']+1)/abs({$sSectionProps}['step'])), {$sSectionProps}['max']);\n";
		}
		$sOutput .= "	if ({$sSectionProps}['total'] == 0)\n" .
				   "		{$sSectionProps}['show'] = false;\n" .
				   "} else\n" .
				   "	{$sSectionProps}['total'] = 0;\n";

		$sOutput .= "if ({$sSectionProps}['show']):\n";
		$sOutput .= "
			for ({$sSectionProps}['index'] = {$sSectionProps}['start'], {$sSectionProps}['iteration'] = 1;
				 {$sSectionProps}['iteration'] <= {$sSectionProps}['total'];
				 {$sSectionProps}['index'] += {$sSectionProps}['step'], {$sSectionProps}['iteration']++):\n";
		$sOutput .= "{$sSectionProps}['rownum'] = {$sSectionProps}['iteration'];\n";
		$sOutput .= "{$sSectionProps}['index_prev'] = {$sSectionProps}['index'] - {$sSectionProps}['step'];\n";
		$sOutput .= "{$sSectionProps}['index_next'] = {$sSectionProps}['index'] + {$sSectionProps}['step'];\n";
		$sOutput .= "{$sSectionProps}['first']	  = ({$sSectionProps}['iteration'] == 1);\n";
		$sOutput .= "{$sSectionProps}['last']	   = ({$sSectionProps}['iteration'] == {$sSectionProps}['total']);\n";

		$sOutput .= "?>";

		return $sOutput;
	}

	/**
	 * Remove quotes from PHP variables.
	 *
	 * @param string $string PHP variable to work with.
	 * @return string Converted PHP variable.
	 */
	private function _removeQuote($string)
	{
		if (($string{0} == "'" || $string{0} == '"') && $string{strlen($string)-1} == $string{0})
		{
			return substr($string, 1, -1);
		}
		else
		{
			return $string;
		}
	}
}

?>