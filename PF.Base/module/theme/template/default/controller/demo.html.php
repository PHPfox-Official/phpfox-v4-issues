{if $demoId}
<div class="demo-overlay demo-overlay-full">
	<i class="fa fa-spin fa-circle-o-notch"></i>
</div>
{else}
<div class="demo-holder">
	<!--
	<header>
		<i class="fa fa-paint-brush"></i>
		<h1><a href="http://phpfox.com/">PHPfox Community Demo</a></h1>
		<a href="http://phpfox.com/">Buy Now</a>
	</header>
	-->


	<div class="demo-buttons">
		<ul>
			<li><span class="r"></span></li>
			<li><span class="y"></span></li>
			<li><span class="g"></span></li>
			<li class="tab">
				PHPfox Community Demo
			</li>
		</ul>
		<div>
			<ul>
				<li class="theme-selector">Themes</li>
				<li class="get"><a href="http://phpfox.com/">Get PHPfox</a></li>
			</ul>
		</div>
	</div>
	<div class="demo-overlay">
		<i class="fa fa-spin fa-circle-o-notch"></i>
	</div>
	<div class="demo-themes">
		<div class="themes">
			{foreach from=$themes item=theme}
			<article {$theme.image}>
			<h1>
				<a href="{url link='theme.demo' id=$theme.theme_id}" class="no_ajax" target="demo-frame">
					<span>{$theme.name|clean}</span>
					<em>Try</em>
				</a>
			</h1>
			</article>
			{/foreach}
		</div>
	</div>
	<div class="demo-content">

	</div>

	<script>
		var demoUrl = '{url link=''}';
		{literal}
		$Ready(function() {

			var frame = $('<iframe></iframe>');

			$('.demo-themes .themes a').click(function() {
				$('.demo-themes').hide();
				$('.demo-content').hide();
				$('.demo-overlay').show();
				frame.load(function() {
					p('frame is reloaded...');
					$('.demo-overlay').hide();
					$('.demo-content').show();
				});
			});

			if ($('.demo-content').length && !$('.demo-content').hasClass('built')) {
				frame.attr('src', demoUrl);
				frame.attr('id', 'demo-frame');
				frame.attr('name', 'demo-frame')

				$('.demo-content').html(frame);
				frame.load(function() {
					$('.demo-overlay').fadeOut();
				});
			}

			$('.theme-selector').click(function() {
				var t = $(this);
				if (t.hasClass('active')) {
					$('.demo-overlay, .demo-themes').hide();
					$('.demo-content').show();
					return;
				}

				t.addClass('active');
				$('.demo-overlay, .demo-content').fadeOut('fast', function() {
					$('.demo-themes').fadeIn();
				});
			});
		});
		{/literal}
	</script>
</div>
{/if}