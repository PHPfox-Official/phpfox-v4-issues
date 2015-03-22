<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="{$sLocaleDirection}" lang="{$sLocaleCode}">
	<head>
		<title>{title}</title>	
		{header}
	</head>
	<body>
		{body}

		<div id="header">
			{logo}
			{breadcrumb}
		</div>

		<div id="panel"></div>
		<div id="main_header" class="nano">
			<div id="header_menu" class="nano-content">
				{module name='feed.form2' menu=true}
				{notification}
				<nav>
					{menu}
				</nav>
			</div>
		</div>
		
		<div id="main_core_body_holder">

			<div id="top">
				{block location='11'}
				{search}
				{block location='7'}
			</div>

			<div id="main_content_holder">
				<div {holder_name}>

					<div {is_page_view} class="holder">

						{block location='12'}

						<div id="content_holder"{if isset($sMicroPropType)} itemscope itemtype="http://schema.org/{$sMicroPropType}"{/if}>		

							<div id="main_content">

								<div id="main_content_padding">

									<div id="content_load_data">

										<div class="_block_h1">
											{if isset($aBreadCrumbTitle) && count($aBreadCrumbTitle)}
											<h1{if isset($sMicroPropType)} itemprop="name"{/if}><a href="{$aBreadCrumbTitle[1]}"{if isset($sMicroPropType)} itemprop="url"{/if}>{$aBreadCrumbTitle[0]|clean|split:30}</a></h1>
											{/if}
										</div>

										<div id="content">
											{error}
											{block location='2'}
											{content}
											{block location='4'}
										</div>

									</div>												
								</div>				
							</div>

							<div id="panels">
								<div id="left" class="content_column">
									{block location='1'}
								</div>

								<div id="right" class="content_column">
									{block location='3'}
								</div>
							</div>

						</div>		
						{block location='8'}
					</div>							
				</div>
			</div>

			<footer>
				<nav>
					{menu_footer}
				</nav>
				<div id="copyright">
					{copyright}
				</div>
				{block location='5'}
			</footer>
                        
            {footer}
		</div>        
    </body>
</html>