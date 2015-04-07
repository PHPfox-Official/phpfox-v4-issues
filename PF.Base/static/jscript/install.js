
(function($) {

	var boot = function() {
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
			$.ajax({
				url: BasePath + '?step=' + step,
				type: (type ? type : 'GET'),
				data: data,
				success: function(e) {
					console.log(e);
					// e = $.parseJSON(e);

					if (typeof(e.next) == 'string') {
						if (typeof(e.message) == 'string') {
							$('#installer').html('<div class="process">' + e.message + '<i class="fa fa-spin fa-circle-o-notch"></i></div>');
						}
						runStep(e.next);
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