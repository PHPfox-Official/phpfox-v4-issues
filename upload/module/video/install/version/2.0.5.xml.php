<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>video</module_id>
			<is_hidden>0</is_hidden>
			<type>string</type>
			<var_name>params_for_ffmpeg</var_name>
			<phrase_var_name>setting_params_for_ffmpeg</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.5</version_id>
			<value>-i {source}  -s {width}x{height} {destination}</value>
		</setting>
		<setting>
			<group />
			<module_id>video</module_id>
			<is_hidden>0</is_hidden>
			<type>string</type>
			<var_name>params_for_mencoder</var_name>
			<phrase_var_name>setting_params_for_mencoder</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.5</version_id>
			<value>{source} -o {destination} -of lavf -oac mp3lame -lameopts abr:br=56 -ovc lavc -lavcopts vcodec=flv:vbitrate=800:mbd=2:mv0:trell:v4mv:cbp:last_pred=3 -vf scale={width}:{height}</value>
		</setting>
		<setting>
			<group />
			<module_id>video</module_id>
			<is_hidden>0</is_hidden>
			<type>string</type>
			<var_name>params_for_mencoder_fallback</var_name>
			<phrase_var_name>setting_params_for_mencoder_fallback</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.5</version_id>
			<value>{source} -o {destination} -of lavf -oac pcm -ovc lavc -lavcopts vcodec=flv:vbitrate=800:mbd=2:mv0:trell:v4mv:cbp:last_pred=3 -srate 22050 -ofps 24 -vf scale={width}:{height}</value>
		</setting>
		<setting>
			<group />
			<module_id>video</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>enable_flvtool2</var_name>
			<phrase_var_name>setting_enable_flvtool2</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.5</version_id>
			<value>0</value>
		</setting>
		<setting>
			<group />
			<module_id>video</module_id>
			<is_hidden>0</is_hidden>
			<type>string</type>
			<var_name>params_for_flvtool2</var_name>
			<phrase_var_name>setting_params_for_flvtool2</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.5</version_id>
			<value>-U {destination}</value>
		</setting>
		<setting>
			<group />
			<module_id>video</module_id>
			<is_hidden>0</is_hidden>
			<type>string</type>
			<var_name>flvtool2_path</var_name>
			<phrase_var_name>setting_flvtool2_path</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.5</version_id>
			<value>flvtool2</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.5</version_id>
			<var_name>setting_params_for_ffmpeg</var_name>
			<added>1275917842</added>
			<value><![CDATA[<title>Params for FFMPEG</title><info>This is the string to be used when converting videos using ffmpeg. 
The following replacements apply:
{source} path and file of the video to convert
{destination} path and file of the converted video
{width} frame width
{height} frame height</info>]]></value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.5</version_id>
			<var_name>setting_params_for_mencoder</var_name>
			<added>1275918473</added>
			<value><![CDATA[<title>Params for Mencoder</title><info>This is the string to be used when converting videos using mencoder.
The following replacements apply:
{source} path and file of the video to convert
{destination} path and file of the converted video
{width} frame width
{height} frame height</info>]]></value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.5</version_id>
			<var_name>setting_params_for_mencoder_fallback</var_name>
			<added>1275919046</added>
			<value><![CDATA[<title>Fallback Params for Mencoder</title><info>In case the first mencoder call fails this other param will be used in a subsequent call. The following replacements apply:
{source} path and file of the video to convert
{destination} path and file of the converted video
{width} frame width
{height} frame height</info>]]></value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.5</version_id>
			<var_name>setting_flvtool2_path</var_name>
			<added>1275991521</added>
			<value><![CDATA[<title>Path to FLVTool2</title><info>Path to FLVTool2</info>]]></value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.5</version_id>
			<var_name>setting_params_for_flvtool2</var_name>
			<added>1275991617</added>
			<value><![CDATA[<title>Params for FLVTool2</title><info>This is the string to be used when calling FLVTool2. The following replacements apply:
{source} path and file of the video to convert
{destination} path and file of the converted video
{width} frame width
{height} frame height</info>]]></value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.5</version_id>
			<var_name>setting_enable_flvtool2</var_name>
			<added>1275992422</added>
			<value><![CDATA[<title>Enable FLVTool2</title><info>Should the script call FLVTool2 after converting videos?</info>]]></value>
		</phrase>
	</phrases>
</upgrade>