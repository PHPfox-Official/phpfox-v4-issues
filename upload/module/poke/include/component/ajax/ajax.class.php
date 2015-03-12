<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package 		Phpfox_Ajax
 * @version 		$Id: ajax.class.php 100 2009-01-26 15:15:26Z Raymond_Benc $
 */
class Poke_Component_Ajax_Ajax extends Phpfox_Ajax
{

	public function poke()
	{		
		$this->setTitle(Phpfox::getPhrase('poke.poke'));
		
		Phpfox::getBlock('poke.poke');
	}
	
	public function doPoke()
	{
		if (!Phpfox::getUserParam('poke.can_poke'))
		{
			return Phpfox_Error::display(Phpfox::getPhrase('poke.you_are_not_allowed_to_send_pokes'));
		}
		if (Phpfox::getUserParam('poke.can_only_poke_friends') && 
				!Phpfox::getService('friend')->isFriend(Phpfox::getUserId(), $this->get('user_id')))
		{
			return Phpfox_Error::display(Phpfox::getPhrase('poke.you_can_only_poke_your_own_friends'));
		}
		
		
		if (Phpfox::getService('poke.process')->sendPoke($this->get('user_id')))
		{
			/* Type 1 is when poking back from the display block*/
			if ($this->get('type') == '1')
			{
				$this->call('$("#poke_'.$this->get('user_id') .'").hide().remove();');
			}
			else
			{
				$this->call('$("#liPoke").hide().remove();');
				$this->alert(Phpfox::getPhrase('poke.poke_sent'));
			}			
		}
		else
		{
			$this->alert(Phpfox::getPhrase('poke.poke_could_not_be_sent'));
		}
		
		list($iTotalPokes, $aPokes) = Phpfox::getService('poke')->getPokesForUser(Phpfox::getUserId());
		if (!$iTotalPokes)
		{
			$this->call('$("#js_block_border_poke_display").remove();');
		}
		else
		{
			$this->call('$("#poke_'.$this->get('user_id') .'").hide().remove();');
		}
	}
	
	public function ignore()
	{
		Phpfox::getService('poke.process')->ignore($this->get('user_id'));
		
		list($iTotalPokes, $aPokes) = Phpfox::getService('poke')->getPokesForUser(Phpfox::getUserId());
		if (!$iTotalPokes)
		{
			$this->call('$("#js_block_border_poke_display").remove();');
		}
		else
		{
			$this->call('$("#poke_'.$this->get('user_id') .'").hide().remove();');
		}
	}
	
	public function viewMore()
	{
		list($iTotalPokes, $aPokes) = Phpfox::getService('poke')->getPokesForUser(Phpfox::getUserId());
		
		Phpfox::getBlock('poke.display');
		
		$this->html('#js_block_border_poke_display .content', $this->getContent(false));
	}
}

?>