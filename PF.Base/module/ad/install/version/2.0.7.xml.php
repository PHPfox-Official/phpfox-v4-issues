<upgrade>
	<phrases>
		<phrase>
			<module_id>ad</module_id>
			<version_id>2.0.7</version_id>
			<var_name>total_ad_views</var_name>
			<added>1288277434</added>
			<value>{total} views</value>
		</phrase>
		<phrase>
			<module_id>ad</module_id>
			<version_id>2.0.7</version_id>
			<var_name>invoice_successfully_deleted</var_name>
			<added>1288620889</added>
			<value>Invoice successfully deleted</value>
		</phrase>
	</phrases>
	<hooks>
		<hook>
			<module_id>ad</module_id>
			<hook_type>service</hook_type>
			<module>ad</module>
			<call_name>ad.service_ad_deleteinvoice__start</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>ad</module_id>
			<hook_type>service</hook_type>
			<module>ad</module>
			<call_name>ad.service_process_addcustom_before_insert_ad</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
		<hook>
			<module_id>ad</module_id>
			<hook_type>service</hook_type>
			<module>ad</module>
			<call_name>ad.service_process_addcustom_before_insert_invoice</call_name>
			<added>1286546859</added>
			<version_id>2.0.7</version_id>
			<value />
		</hook>
	</hooks>
</upgrade>