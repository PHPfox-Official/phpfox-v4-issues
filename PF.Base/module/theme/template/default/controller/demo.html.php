{if $demoId}
<div class="demo-overlay demo-overlay-full">
	<i class="fa fa-spin fa-circle-o-notch"></i>
	<meta http-equiv="refresh" content="0; url={url link=''}">
</div>
{else}
<div class="demo-holder">
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
	<div class="demo-overlay" style="display:none;">
		<i class="fa fa-spin fa-circle-o-notch"></i>
	</div>
	<div class="demo-themes" style="display:block;">
		<h1>Select your Flavor</h1>
		<div class="themes">
			{foreach from=$flavors item=flavor}
			<article {$flavor.image}>
			<h1>
				<a href="{url link='theme.demo' id=$flavor.style_id}" class="no_ajax" target="demo-frame">
					<span>{$flavor.theme_name|clean} {$flavor.name|clean}</span>
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
				$('.theme-selector.active').removeClass('active');

				if ($('.demo-content').length && !$('.demo-content').hasClass('built')) {
					frame.attr('src', demoUrl);
					frame.attr('id', 'demo-frame');
					frame.attr('name', 'demo-frame')

					$('.demo-content').html(frame);
					frame.load(function() {
						// $('.demo-overlay').fadeOut();
					});
				}

				frame.load(function() {
					p('frame is reloaded...');
					$('.demo-overlay').hide();
					$('.demo-content').show();
				});
			});

			$('.theme-selector').click(function() {
				var t = $(this);
				if (t.hasClass('active')) {
					$('.demo-overlay, .demo-themes').hide();
					$('.demo-content').show();
					t.removeClass('active');
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