<?php
/** $Id: phpfox.xml.php 3074 2011-09-12 13:57:28Z Raymond_Benc $ **/
defined('PHPFOX') or exit('NO DICE!');
?>
<theme>
	<design_css>
		<![CDATA[
					$aAdvanced = array(				
						array(
							'block' => 'Body',
							'name' => 'body',
							'id' => 'body',
							'design' => array(
								'background' => array(
									'color' => true,
									'image' => true,									
									'attachment' => true,
									'position' => true,
									'repeat' => true
								)								
							)							
						),
						array(
							'block' => 'Body Text',
							'name' => '#content_holder, h1 a, h1 a:hover, ul.activity_feed_form_attach li a.active, ul.activity_feed_form_attach li a.active:hover, .extra_info',
							'id' => 'body_text',
							'design' => array(
								'font' => array(
									'color' => true,
									'family' => true,
									'size' => true,
									'style' => true,
									'weight' => true									
								)								
							)							
						),	
						array(
							'block' => 'Body Link',
							'name' => '#content_holder a',
							'id' => 'body_link',
							'design' => array(
								'font' => array(
									'color' => true,
									'family' => true,
									'size' => true,
									'style' => true,
									'weight' => true									
								)								
							)							
						),
						array(
							'block' => 'Body Link Hover',
							'name' => '#content_holder a:hover',
							'id' => 'body_link_hover',
							'design' => array(
								'font' => array(
									'color' => true,
									'family' => true,
									'size' => true,
									'style' => true,
									'weight' => true									
								)								
							)							
						),								
						
						/**
						* #header
						*/
						array(
							'block' => 'Header',
							'name' => '#header',
							'id' => 'header',
							'design' => array(
								'background' => array(
									'color' => true
								)								
							)							
						),
						array(
							'block' => 'Header Search',
							'name' => '#header_sub_menu_search_input, #header_sub_menu_search .focus',
							'id' => 'header_search',
							'design' => array(
								'background' => array(
									'color' => true
								),
								'font' => array(
									'color' => true,
									'family' => true,
									'size' => true,
									'style' => true,
									'weight' => true									
								)								
							)							
						),						
						array(
							'block' => 'Header Link',
							'name' => '#holder_notify ul li a.notify_drop_link, #header_menu_holder ul li a, #header_menu_holder ul li a.has_drop_down',
							'id' => 'header_link',
							'design' => array(
								'background' => array(
									'color' => true
								),
								'font' => array(
									'color' => true,
									'family' => true,
									'size' => true,
									'style' => true,
									'weight' => true									
								),
								'border' => array(
									'type' => array(
										'top' => true,
										'right' => true,
										'bottom' => true,
										'left' => true
									)
								),
								'padding' => array(
									'type' => array(
										'top' => true,
										'right' => true,
										'bottom' => true,
										'left' => true
									)
								),
								'text' => array(
									'align' => true,
									'transform' => true,
									'decoration' => true
								)								
							)							
						),	
						array(
							'block' => 'Header Link Hover',
							'name' => '#holder_notify ul li a.notify_drop_link:hover, #header_menu_holder ul li a:hover, #header_menu_holder ul li a.has_drop_down:hover',
							'id' => 'header_link_hover',
							'design' => array(
								'background' => array(
									'color' => true
								),
								'font' => array(
									'color' => true,
									'family' => true,
									'size' => true,
									'style' => true,
									'weight' => true									
								),
								'border' => array(
									'type' => array(
										'top' => true,
										'right' => true,
										'bottom' => true,
										'left' => true
									)
								),
								'padding' => array(
									'type' => array(
										'top' => true,
										'right' => true,
										'bottom' => true,
										'left' => true
									)
								),
								'text' => array(
									'align' => true,
									'transform' => true,
									'decoration' => true
								)								
							)							
						),						
						
						/**
						* #header_menu
						*/	
						array(
							'block' => 'Header Menu',
							'name' => '#header_menu',
							'id' => 'header_menu',
							'design' => array(
								'background' => array(
									'color' => true
								)								
							)							
						),						
						array(
							'block' => 'Header Menu Link',
							'name' => '#header_menu ul li a',
							'id' => 'header_menu_link',
							'design' => array(
								'background' => array(
									'color' => true
								),
								'font' => array(
									'color' => true,
									'family' => true,
									'size' => true,
									'style' => true,
									'weight' => true									
								),
								'border' => array(
									'type' => array(
										'top' => true,
										'right' => true,
										'bottom' => true,
										'left' => true
									)
								),
								'padding' => array(
									'type' => array(
										'top' => true,
										'right' => true,
										'bottom' => true,
										'left' => true
									)
								),
								'text' => array(
									'align' => true,
									'transform' => true,
									'decoration' => true
								)								
							)							
						),
						array(
							'block' => 'Header Menu Link Hover',
							'name' => '#header_menu ul li a:hover',
							'id' => 'header_menu_link_hover',
							'design' => array(
								'background' => array(
									'color' => true
								),
								'font' => array(
									'color' => true,
									'family' => true,
									'size' => true,
									'style' => true,
									'weight' => true									
								),
								'border' => array(
									'type' => array(
										'top' => true,
										'right' => true,
										'bottom' => true,
										'left' => true
									)
								),
								'padding' => array(
									'type' => array(
										'top' => true,
										'right' => true,
										'bottom' => true,
										'left' => true
									)
								),
								'text' => array(
									'align' => true,
									'transform' => true,
									'decoration' => true
								)								
							)							
						),
						
						/**
						* #content_holder
						*/	
						array(
							'block' => 'Content Holder',
							'name' => '#content_holder',
							'id' => 'content_holder',
							'design' => array(
								'background' => array(
									'color' => true,
									'image' => true,									
									'attachment' => true,
									'position' => true,
									'repeat' => true
								),
								'border' => array(
									'type' => array(
										'top' => true,
										'right' => true,
										'bottom' => true,
										'left' => true
									)
								),
								'padding' => array(
									'type' => array(
										'top' => true,
										'right' => true,
										'bottom' => true,
										'left' => true
									)
								),						
							)							
						),	
						
						/**
						* .block
						*/	
						array(
							'block' => 'Block',
							'name' => '.block .content',
							'id' => 'block',
							'design' => array(
								'background' => array(
									'color' => true
								),
								'border' => array(
									'type' => array(
										'top' => true,
										'right' => true,
										'bottom' => true,
										'left' => true
									)
								),
								'padding' => array(
									'type' => array(
										'top' => true,
										'right' => true,
										'bottom' => true,
										'left' => true
									)
								)								
							)							
						),		
						array(
							'block' => 'Block Header',
							'name' => '#left .block .title, #right .block .title, #content .block .title',
							'id' => 'block_title',
							'design' => array(
								'background' => array(
									'color' => true
								),
								'font' => array(
									'color' => true,
									'family' => true,
									'size' => true,
									'style' => true,
									'weight' => true									
								),								
								'border' => array(
									'type' => array(
										'top' => true,
										'right' => true,
										'bottom' => true,
										'left' => true
									)
								),								
								'padding' => array(
									'type' => array(
										'top' => true,
										'right' => true,
										'bottom' => true,
										'left' => true
									)
								)								
							)							
						),						
					);
		]]>
	</design_css>
	<reset_css>
		<![CDATA[
				if (!isset($bAlreadyAddedBg) && $sSelector == 'body' && ($sProperty == 'background-color' || $sProperty == 'background-image'))
				{					
					if (!empty($sValue))
					{						
						$this->database()->delete(Phpfox::getT($aCallback['table']), $aCallback['field'] . ' = ' . $aCallback['value'] . ' AND css_selector = \'#main_content_holder' AND css_property = \'background\'');
						
						$bAlreadyAddedBg = true;
					}					
				}	
				
			]]>	
	</reset_css>
	<update_css>
		<![CDATA[
				if (!isset($bAlreadyAddedBg) && $sSelector == 'body' && ($sProperty == 'background-color' || $sProperty == 'background-image'))
				{					
					if (!empty($sValue))
					{
						$this->database()->insert(Phpfox::getT($aCallback['table']), array(
								$aCallback['field'] => $aCallback['value'],
								'css_selector' => '#main_content_holder',
								'css_property' => 'background',
								'css_value' => 'none',
								'ordering' => '1'
							)
						);
						$bAlreadyAddedBg = true;
					}					
				}
				
				if ($sSelector == '#header' && ($sProperty == 'background-color'))
				{					
					if (!empty($sValue))
					{
						$this->database()->insert(Phpfox::getT($aCallback['table']), array(
								$aCallback['field'] => $aCallback['value'],
								'css_selector' => '#header',
								'css_property' => 'background',
								'css_value' => 'none',
								'ordering' => '1'
							)
						);
					}					
				}				
				
				if ($sSelector == '#header_menu' && ($sProperty == 'background-color'))
				{					
					if (!empty($sValue))
					{
						$this->database()->insert(Phpfox::getT($aCallback['table']), array(
								$aCallback['field'] => $aCallback['value'],
								'css_selector' => '#header_menu',
								'css_property' => 'background',
								'css_value' => 'none',
								'ordering' => '1'
							)
						);
					}					
				}	
				
				if ($sSelector == '#header_sub_menu_search_input, #header_sub_menu_search .focus' && ($sProperty == 'background-color'))
				{					
					if (!empty($sValue))
					{
						$this->database()->insert(Phpfox::getT($aCallback['table']), array(
								$aCallback['field'] => $aCallback['value'],
								'css_selector' => '#header_sub_menu_search_input, #header_sub_menu_search .focus',
								'css_property' => 'background',
								'css_value' => 'none',
								'ordering' => '1'
							)
						);
					}					
				}				
		]]>
	</update_css>
</theme>