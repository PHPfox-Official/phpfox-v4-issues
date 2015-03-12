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
 * @package  		Module_Quiz
 * @version 		$Id: index.class.php 3551 2011-11-22 14:49:19Z Raymond_Benc $
 */
class Quiz_Component_Controller_Index extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (defined('PHPFOX_IS_USER_PROFILE') && ($sLegacyTitle = $this->request()->get('req3')) && !empty($sLegacyTitle))
		{			
			Phpfox::getService('core')->getLegacyItem(array(
					'field' => array('quiz_id', 'title'),
					'table' => 'quiz',		
					'redirect' => 'quiz',
					'title' => $sLegacyTitle
				)
			);
		}		
		
		Phpfox::getUserParam('quiz.can_access_quiz', true);
		
		if (($iRedirect = $this->request()->getInt('redirect')) && ($sUrl = Phpfox::getService('quiz.callback')->getFeedRedirect($iRedirect)))
		{
			$this->url()->forward($sUrl);
		}
		
		$bIsProfile = false;
		if (defined('PHPFOX_IS_AJAX_CONTROLLER'))
		{
			$bIsProfile = true;
			$aUser = Phpfox::getService('user')->get($this->request()->get('profile_id'));
			$this->setParam('aUser', $aUser);
		}
		else 
		{		
			$bIsProfile = $this->getParam('bIsProfile');	
			if ($bIsProfile === true)
			{
				$aUser = $this->getParam('aUser');
			}
		}		
		
		if ($this->request()->getInt('req2') > 0)
		{
			return Phpfox::getLib('module')->setController('quiz.view');
		}			

		$sView = $this->request()->get('view');	
		
		$this->search()->set(array(
				'type' => 'quiz',
				'field' => 'q.quiz_id',				
				'search_tool' => array(
					'table_alias' => 'q',
					'search' => array(
						'action' => (defined('PHPFOX_IS_USER_PROFILE') ? $this->url()->makeUrl($aUser['user_name'], array('quiz', 'view' => $this->request()->get('view'))) : $this->url()->makeUrl('quiz', array('view' => $this->request()->get('view')))),
						'default_value' => Phpfox::getPhrase('quiz.search_quizzes'),
						'name' => 'search',
						'field' => 'q.title'
					),
					'sort' => array(
						'latest' => array('q.time_stamp', Phpfox::getPhrase('quiz.latest')),
						'most-viewed' => array('q.total_view', Phpfox::getPhrase('quiz.most_viewed')),
						'most-liked' => array('q.total_like', Phpfox::getPhrase('quiz.most_liked')),
						'most-talked' => array('q.total_comment', Phpfox::getPhrase('quiz.most_discussed'))
					),
					'show' => array(Phpfox::getParam('quiz.quizzes_to_show'), Phpfox::getParam('quiz.quizzes_to_show') * 2, Phpfox::getParam('quiz.quizzes_to_show') * 3)
				)
			)
		);			
		
		switch ($sView)
		{
			case 'my':
				Phpfox::isUser(true);
				$this->search()->setCondition('AND q.user_id = ' . (int) Phpfox::getUserId());
				break;
			case 'pending':
				Phpfox::isUser(true);
				Phpfox::getUserParam('quiz.can_approve_quizzes', true);
				$this->search()->setCondition('AND q.view_id = 1');
				break;
			default:
				if ($this->getParam('bIsProfile') === true)
				{
					$this->search()->setCondition('AND q.view_id IN(' . ($aUser['user_id'] == Phpfox::getUserId() ? '0,1' : '0') . ') AND q.user_id = ' . (int) $aUser['user_id'] . ' AND  q.privacy IN(' . (Phpfox::getParam('core.section_privacy_item_browsing') ? '%PRIVACY%' : Phpfox::getService('core')->getForBrowse($aUser)) . ')');
				}
				else 
				{
					$this->search()->setCondition('AND q.view_id = 0 AND q.privacy IN(%PRIVACY%)');
				}
				break;
		}		
		
		$aBrowseParams = array(
			'module_id' => 'quiz',
			'alias' => 'q',
			'field' => 'quiz_id',
			'table' => Phpfox::getT('quiz'),
			'hide_view' => array('pending', 'my')				
		);			
		
		$this->search()->browse()->params($aBrowseParams)->execute();
		
		$iCnt = $this->search()->browse()->getCount();
		$aQuizzes = $this->search()->browse()->getRows();				
		
		foreach ($aQuizzes as $aQuiz)
		{
			$this->template()->setMeta('keywords', $this->template()->getKeywords($aQuiz['title']));
		}
		
		Phpfox::getLib('pager')->set(array('page' => $this->search()->getPage(), 'size' => $this->search()->getDisplay(), 'count' => $iCnt));		
		
		$aFilterMenu = array();
		if (!defined('PHPFOX_IS_USER_PROFILE'))
		{			
			$aFilterMenu = array(
				Phpfox::getPhrase('quiz.all_quizzes') => '',
				Phpfox::getPhrase('quiz.my_quizzes') => 'my'				
			);			
			
			if (Phpfox::isModule('friend') && !Phpfox::getParam('core.friends_only_community'))
			{			
				$aFilterMenu[Phpfox::getPhrase('quiz.friends_quizzes')] = 'friend';
			}
			
			if (Phpfox::getUserParam('quiz.can_approve_quizzes'))
			{
				$iPendingTotal = Phpfox::getService('quiz')->getPendingTotal();

				if ($iPendingTotal)
				{
					$aFilterMenu[Phpfox::getPhrase('quiz.pending_quizzes') . ' <span class="pending">' . $iPendingTotal . '</span>'] = 'pending';
				}				
			}
		}		
		
		$this->template()->buildSectionMenu('quiz', $aFilterMenu);			

		$this->template()->setTitle((defined('PHPFOX_IS_USER_PROFILE') ? Phpfox::getPhrase('quiz.full_name_s_quizzes', array('full_name' => $aUser['full_name'])) : Phpfox::getPhrase('quiz.quizzes')))
			->setBreadcrumb(Phpfox::getPhrase('quiz.quizzes'), (defined('PHPFOX_IS_USER_PROFILE') ? $this->url()->makeUrl($aUser['user_name'], 'quiz') : $this->url()->makeUrl('quiz')))
			->setMeta('keywords', Phpfox::getParam('quiz.quiz_meta_keywords'))
			->setMeta('description', Phpfox::getParam('quiz.quiz_meta_description'))
			->setHeader('cache', array(
					'pager.css' => 'style_css',
					'quiz.js' => 'module_quiz',				
					'jquery/plugin/jquery.highlightFade.js' => 'static_script',
					'comment.css' => 'style_css'
				)
			)
			->setPhrase(array(
					'quiz.are_you_sure_you_want_to_delete_this_quiz'
				)
			)			
			->assign(array(
				'aQuizzes' => $aQuizzes,
				'sSuffix' =>  '_' . Phpfox::getParam('quiz.quiz_max_image_pic_size'),
				'bIsProfile' => (defined('PHPFOX_IS_USER_PROFILE') && PHPFOX_IS_USER_PROFILE) ? true : false
			)
		);
		
		$this->setParam('global_moderation', array(
				'name' => 'quiz',
				'ajax' => 'quiz.moderation',
				'menu' => array(
					array(
						'phrase' => Phpfox::getPhrase('quiz.delete'),
						'action' => 'delete'
					),
					array(
						'phrase' => Phpfox::getPhrase('quiz.approve'),
						'action' => 'approve'
					)					
				)
			)
		);			
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('quiz.component_controller_index_clean')) ? eval($sPlugin) : false);
	}
}

?>