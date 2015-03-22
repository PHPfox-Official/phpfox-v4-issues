<?php

class Phpfoxsample_Component_Block_Panel extends Phpfox_Component
{	
	public function process()
	{
		$this->template()->assign(array(
				'sHeader' => 'Panel Block',
				'aFooter' => array(
					'Panel Link' => $this->url()->makeUrl('phpfoxsample.add')
				),
			)
		);
		
		return 'block';
	}
}

?>