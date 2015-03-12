<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: mini.html.php 2592 2011-05-05 18:51:50Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
	<li>
		<div class="block_listing_image">
			<a href="{permalink module='marketplace' id=$aMiniListing.listing_id title=$aMiniListing.title}">{img server_id=$aMiniListing.server_id title=$aMiniListing.title path='marketplace.url_image' file=$aMiniListing.image_path suffix='_50_square' max_width='50' max_height='50'}
		</div>
		<div class="block_listing_title" style="padding-left:56px;">
			<a href="{permalink module='marketplace' id=$aMiniListing.listing_id title=$aMiniListing.title}">{$aMiniListing.title|clean|shorten:25:'...'|split:20}</a>
			<div class="extra_info">
				<ul class="extra_info_middot"><li>{if $aMiniListing.price == '0.00'}{phrase var='marketplace.free'}{else}{$aMiniListing.currency_id|currency_symbol}{$aMiniListing.price|number_format:2}{/if}</li><li>&middot;</li><li>{$aMiniListing.country_iso|location}</li></ul>
			</div>
			{if isset($aMiniListing.images) && count($aMiniListing.images) > 1}
				<ul class="extra_info_middot">{foreach from=$aMiniListing.images item=aMiniListingImage}<li>{img thickbox=true server_id=$aMiniListingImage.server_id title=$aMiniListing.title path='marketplace.url_image' file=$aMiniListingImage.image_path suffix='_50_square' max_width='32' max_height='32'}</li>{/foreach}</ul>
			{/if}
		</div>
		<div class="clear"></div>
	</li>