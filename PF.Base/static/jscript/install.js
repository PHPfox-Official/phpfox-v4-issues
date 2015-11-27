
(function($) {

	var boot = function() {

		$('#license_selector a').click(function() {
			var t = $(this);

			if (t.hasClass('premium')) {
				// $('#license_selector').hide();
				$('#license_selector').html('<div class="process"><i class="fa fa-spin fa-circle-o-notch"></i></div>');
				setTimeout(function() {
					$('#license_selector').hide();
					$('#client_details').fadeIn();
				}, 800);
			}
			else {
				$('#license_id, #license_key').val('techie');
				if (t.hasClass('trial')) {
					$('#license_trial').val(1);
				}
				$('#js_form').trigger('submit');
			}

			return false;
		});

		$('form:not(.built)').submit(function() {
			var t = $(this);

			t.addClass('built');
			$('.table_clear').fadeOut();
			runStep(t.attr('action').replace('#', ''), 'POST', 1, t.serialize());

			return false;
		});
	};

	var runStep = function(step, type, timeout, data) {
		$('#installer .error').remove();
		setTimeout(function() {
			var isUpgrade = '';
			if ($('#is-upgrade').length) {
				isUpgrade = '&phpfox-upgrade=1';
			}
			$.ajax({
				url: BasePath + '?step=' + step + isUpgrade,
				type: (type ? type : 'GET'),
				data: data,
				error: function(e) {
					// $('html').html(e.responseText);
					document.open();
					document.write(e.responseText);
					document.close();
				},
				success: function(e) {

					if (typeof(e.next) == 'string') {
						if (typeof(e.message) == 'string') {
							$('#installer').html('<div class="process">' + e.message + '<i class="fa fa-spin fa-circle-o-notch"></i></div>');
						}
						runStep(e.next, 'GET', timeout, (typeof(e.extra) == 'string' ? e.extra : ''));
					}
					else if (typeof(e.content) == 'string') {
						$('#installer').html(e.content);
						boot();
					}
					else if (typeof(e.errors) == 'object') {
						$('.table_clear').fadeIn();
						for (var i in e.errors) {
							$('#installer form').prepend('<div class="error">' + e.errors[i] + '</div>');
						}
					}
				}
			});
		}, (timeout ? timeout : 2));
	};

	$(document).ready(function() {
		if (!$('.process').length) {
			console.log('Requirements did not pass...');
			boot();
			return;
		}
		runStep('key');
	});
})(jQuery);