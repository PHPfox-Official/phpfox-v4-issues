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
 * @package 		Phpfox_Service
 * @version 		$Id: tag.class.php 3127 2011-09-19 12:47:21Z Raymond_Benc $
 */
class Photo_Service_Tag_Tag extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('photo_tag');	
	}
	
	public function getJs($iPhotoId)
	{
		$sJs = 'id: \'#js_photo_view_image\', tag_link_id: \'#js_tag_photo\', name: \'val[tag]\', item_id: ' . $iPhotoId . ', in_photo: \'#js_photo_in_this_photo\'';
		if (($sNotes = $this->getJavascript($iPhotoId)))
		{
			$sJs .= ', notes: ' . $sNotes . '';
			
			$sNotes = preg_replace('/\(<a(.*?)>(.*?)<\/a>\)/i', '', $sNotes);
			$sNotes = preg_replace('/<a(.*?)>(.*?)<\/a>/i', '\\2', $sNotes);
			
			$sJs .= ', js_notes: ' . $sNotes . '';
		}
		
		if (Phpfox::isUser())
		{
			$sJs .= ', user_id: ' . Phpfox::getUserId();
		}		
		
		return $sJs;
	}
	
	public function getJavascript($iPhotoId)
	{
		$aTags = $this->database()->select('p.user_id AS photo_owner_id, pt.tag_id, pt.user_id AS post_user_id, pt.content, pt.position_x, pt.position_y, pt.width, pt.height, ' . Phpfox::getUserField())
			->from($this->_sTable, 'pt')
			->leftJoin(Phpfox::getT('user'), 'u', 'u.user_id = pt.tag_user_id')
			->join(Phpfox::getT('photo'), 'p', 'p.photo_id = pt.photo_id')
			->where('pt.photo_id = ' . (int) $iPhotoId)
			->execute('getSlaveRows');
		
		if (!count($aTags))
		{
			return false;
		}
			
		$sNotes = '[';
		foreach ($aTags as $aTag)
		{
			$sNotes .= '{';
			$sNotes .= 'note_id: ' . $aTag['tag_id'] . ', ';
			$sNotes .= 'x1: ' . $aTag['position_x'] . ', ';
			$sNotes .= 'y1: ' . $aTag['position_y'] . ', ';
			$sNotes .= 'width: ' . $aTag['width'] . ', ';
			$sNotes .= 'height: ' . $aTag['height'] . ', ';

			$sRemove = (($aTag['post_user_id'] == Phpfox::getUserId() || $aTag['photo_owner_id'] == Phpfox::getUserId() || $aTag['user_id'] == Phpfox::getUserId()) ? ' (<a href="#" onclick="if (confirm(\\\'' . Phpfox::getPhrase('photo.are_you_sure') . '\\\')) { $(\\\'#noteform\\\').hide(); $(\\\'#js_photo_view_image\\\').imgAreaSelect({ hide: true }); $(this).parent(\\\'span:first\\\').remove(); $.ajaxCall(\\\'photo.removePhotoTag\\\', \\\'tag_id=' . $aTag['tag_id'] . '\\\'); } return false;">' . Phpfox::getPhrase('photo.remove_tag') . '</a>)' : '');
			
			if (!empty($aTag['user_id']))
			{
				$sNotes .= 'note: \'<a href="' . Phpfox::getLib('url')->makeUrl($aTag['user_name']) . '" id="js_photo_tag_user_id_' . $aTag['user_id'] . '">' . $aTag['full_name'] . '</a>' . $sRemove . '\'';
			}
			else 
			{				
				$sNotes .= 'note: \'' . str_replace("'", "\'", Phpfox::getLib('parse.output')->clean($aTag['content'])) . $sRemove . '\'';
			}
			$sNotes .= '},';
		}
		$sNotes = rtrim($sNotes, ',');
		$sNotes .= ']';	

		return $sNotes;
	}
	
	/**
	 * If a call is made to an unknown method attempt to connect
	 * it to a specific plug-in with the same name thus allowing 
	 * plug-in developers the ability to extend classes.
	 *
	 * @param string $sMethod is the name of the method
	 * @param array $aArguments is the array of arguments of being passed
	 */
	public function __call($sMethod, $aArguments)
	{
		/**
		 * Check if such a plug-in exists and if it does call it.
		 */
		if ($sPlugin = Phpfox_Plugin::get('photo.service_tag_tag__call'))
		{
			return eval($sPlugin);
		}
			
		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}	
}

?>