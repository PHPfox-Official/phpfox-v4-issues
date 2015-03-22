<module>
	<data>
		<module_id>rate</module_id>
		<product_id>phpfox</product_id>
		<is_core>0</is_core>
		<is_active>1</is_active>
		<is_menu>0</is_menu>
		<menu />
		<phrase_var_name>module_rate</phrase_var_name>
		<writable />
	</data>
	<hooks>
		<hook module_id="rate" hook_type="component" module="rate" call_name="rate.component_block_display_clean" added="1242299564" version_id="2.0.0beta2" />
		<hook module_id="rate" hook_type="controller" module="rate" call_name="rate.component_controller_index_clean" added="1242299564" version_id="2.0.0beta2" />
		<hook module_id="rate" hook_type="service" module="rate" call_name="rate.service_process__call" added="1242299564" version_id="2.0.0beta2" />
		<hook module_id="rate" hook_type="service" module="rate" call_name="rate.service_rate__call" added="1242299564" version_id="2.0.0beta2" />
		<hook module_id="rate" hook_type="service" module="rate" call_name="rate.service_callback__call" added="1242299564" version_id="2.0.0beta2" />
		<hook module_id="rate" hook_type="component" module="rate" call_name="rate.component_block_show_clean" added="1286546859" version_id="2.0.7" />
	</hooks>
	<phrases>
		<phrase module_id="rate" version_id="2.0.0beta2" var_name="module_rate" added="1242039437">Rate</phrase>
		<phrase module_id="rate" version_id="2.0.0rc4" var_name="unable_to_load_rating_callback" added="1255329311">Unable to load rating callback.</phrase>
		<phrase module_id="rate" version_id="2.0.0rc4" var_name="not_a_valid_post" added="1255329317">Not a valid POST.</phrase>
		<phrase module_id="rate" version_id="2.0.0rc4" var_name="not_a_valid_item_to_rate" added="1255329333">Not a valid item to rate.</phrase>
		<phrase module_id="rate" version_id="2.0.0rc4" var_name="sorry_you_are_not_able_to_rate_your_own_item" added="1255329341">Sorry, you are not able to rate your own item.</phrase>
		<phrase module_id="rate" version_id="2.0.0rc4" var_name="you_have_already_voted_on_this_item" added="1255329350">You have already voted on this item.</phrase>
		<phrase module_id="rate" version_id="2.0.0rc4" var_name="thanks_for_rating" added="1255329640">Thanks for rating!</phrase>
		<phrase module_id="rate" version_id="2.0.0rc8" var_name="rate" added="1258557372">Rate</phrase>
	</phrases>
</module>