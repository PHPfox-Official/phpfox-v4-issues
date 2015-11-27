<?php

$debug = __DIR__ . '/../file/settings/debug.sett.php';

if (isset($_POST['license_id'])) {

	header('Content-type: application/json; charset=utf-8');

	try {
		if (!file_exists(__DIR__ . '/../file/settings/license.sett.php')) {
			throw new Exception('PHPfox does not seem to be installed. Odd...');
		}
		require(__DIR__ . '/../file/settings/license.sett.php');

		if ($_POST['license_id'] != PHPFOX_LICENSE_ID) {
			throw new Exception('License ID does not match.');
		}

		if ($_POST['license_key'] != PHPFOX_LICENSE_KEY) {
			throw new Exception('License Key does not match.');
		}

		$out = '<div class="alert alert-success">Debug: Enabled</div>';
		if (file_exists($debug)) {
			unlink($debug);
			$out = '<div class="alert alert-danger">Debug: Disabled</div>';
		}
		else {
			file_put_contents($debug, "<?php\ndefine('PHPFOX_DEBUG', true);");
		}
	} catch (Exception $e) {
		$out = '<div class="alert alert-danger">' . $e->getMessage() . '</div>';
	}

	echo json_encode(['output' => $out], JSON_PRETTY_PRINT);
	exit;
}

?>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en">
	<head>
		<title>PHPfox Debug</title>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	</head>
	<body>
	<div class="navbar navbar-default">
		<a class="navbar-brand" href="./dev.php">PHPfox Debug</a>
	</div>
	<div class="container">
		<div class="col-md-8">
			<form method="get" action="./debug.php">
				<div class="form-group">
					<label>License ID:</label>
					<input type="text" name="license_id" class="form-control">
				</div>
				<div class="form-group">
					<label>License Key:</label>
					<input type="text" name="license_key" class="form-control">
				</div>
				<input type="submit" class="btn btn-primary" value="Toggle Debug Mode">
			</form>
		</div>

		<div class="col-md-4" id="js-output">
			<?php if (file_exists($debug)): ?>
				<div class="alert alert-success">Debug: Enabled</div>
			<?php else: ?>
				<div class="alert alert-danger">Debug: Disabled</div>
			<?php endif; ?>
		</div>

	</div>
	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script>
		$(function() {

			$('form').submit(function() {
				var t = $(this), o = $('#js-output');

				t.find('.btn').prop('disabled', true);
				// o.html('<i class="fa fa-circle-o-notch fa-spin"></i>');
				$.ajax({
					url: t.attr('action'),
					type: 'POST',
					data: t.serialize(),
					success: function(e) {
						t.find('.btn').prop('disabled', false);
						o.html(e.output);
					}
				});

				return false;
			});
		});
	</script>
	</body>
</html>