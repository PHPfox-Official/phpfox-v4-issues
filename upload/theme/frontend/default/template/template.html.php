<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="{$sLocaleDirection}" lang="{$sLocaleCode}">
	<head>
		<title>{title}</title>	
		{header}
	</head>
	<body>
		{body}	
		{block location='9'}
		<div id="header">			
			<div class="holder">
				{block location='10'}
				<div id="header_holder">
					<div id="header_left">
						{logo}
					</div>
					<div id="header_right">
						<div id="header_top">
							<div id="holder_notify">
								{notification}
							</div>

							<div id="header_search">	
								<div id="header_menu_space">
									<div id="header_sub_menu_search">
										<form method="post" id='header_search_form' action="{url link='search'}">																						
											<input type="text" name="q" placeholder="{phrase var='core.search_dot'}" id="header_sub_menu_search_input" autocomplete="off" class="js_temp_friend_search_input" />
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
					{block location='6'}
				</div>
			</div>

			<div id="header_menu_page_holder">
				<div class="holder">
					<div id="header_menu">
						{module name='feed.form2' menu=true}
						<nav>
							{menu}
						</nav>
					</div>
				</div>
			</div>
		</div>
		
		<div id="main_core_body_holder">

			<div id="top">
				{block location='11'}
				{block location='13'}
				{breadcrumb}
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
									{menu_sub}
									{block location='1'}
								</div>

								<div id="right" class="content_column">
									{search}
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