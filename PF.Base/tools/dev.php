<?php

set_time_limit(0);

error_reporting(E_ALL);

define('PHPFOX_NO_RUN', true);

$config = __DIR__ . '/phpfox.json';
$apps = __DIR__ . '/../../PF.Site/Apps/';
$themes = __DIR__ . '/../../PF.Site/themes/';
$base = __DIR__ . '/../../PF.Base/';

if (!file_exists($config)) {
	exit('Missing "phpfox.json" file.');
}

require($base . 'start.php');

/*
if (!isset($argv[1])) {
	exit('No command was passed, not sure what to do.');
}
*/

// $commands = ['install', 'update', 'save'];

/*
if (!in_array($argv[1], $commands)) {
	exit('Not a valid command. We support: ' . implode(' - ', $commands));
}
*/

function l($log = null)  {
	static $output = null;

	if ($log === null) {
		return $output;
	}

	if ($output === null) {
		$output = '';
	}

	$output .= str_replace("\n", '<br /><br />', $log);
	if (substr($log, -1) != '>') {
		$output .= '<br />';
	}
}

if (isset($_POST['cmd'])) {
	try {
		$json = json_decode(file_get_contents($config));

		if (!file_exists(__DIR__ . '/../file/settings/license.sett.php')) {
			throw new Exception('PHPfox does not seem to be installed. Odd...');
		}
		// require(__DIR__ . '/../file/settings/license.sett.php');

		if ($_POST['license_id'] != PHPFOX_LICENSE_ID) {
			throw new Exception('License ID does not match.');
		}

		if ($_POST['license_key'] != PHPFOX_LICENSE_KEY) {
			throw new Exception('License Key does not match.');
		}

		switch ($_POST['cmd']) {
			case 'status':
				foreach (scandir($apps) as $app) {
					$path = $apps . $app . '/';

					if (!file_exists($path . 'app.json')) {
						continue;
					}

					chdir($path);
					l('<div class="panel panel-default"><div class="panel-heading">[app]: ' . $app . '</div>');
					l('<div class="panel-body">' . shell_exec('git status') . '</div>');
					l('</div>');
				}

				break;
			case 'save':
				$dist = time();
				$exportPath = (isset($_POST['path']) ? $_POST['path'] : false);
				if ($exportPath) {
					$exportPath = rtrim($exportPath, '/') . '/';
					if (!is_dir($exportPath)) {
						throw new Exception('Path "' . $exportPath . '" does not exist.');
					}

					$touch = $exportPath . 'test.lock';
					if (file_exists($touch)) {
						@unlink($touch);
					}
					@touch($touch);
					if (!file_exists($touch)) {
						throw new Exception('Unable to write to export path: ' . $exportPath);
					}
					unlink($touch);
				}

				foreach (scandir($themes) as $theme) {
					$path = $themes . $theme . '/';
					$json = $path . 'theme.json';
					if (file_exists($json)) {
						$json = json_decode(file_get_contents($json));

						chdir($path);
						l('<div class="panel panel-default"><div class="panel-heading">[theme]: ' . $json->name . '</div>');
						l('<div class="panel-body">');
						// l('Changed to directory: ' . $path);
						$old = $json->version;
						$new = number_format($old, 1);
						$new = $new + 1 * 0.1;

						$json->version = $new;
						file_put_contents($path . 'theme.json', json_encode($json, JSON_PRETTY_PRINT));

						if ($exportPath) {
							$dir = $exportPath . str_replace(' ', '_', $json->name) . '/';
							if (!is_dir($dir)) {
								mkdir($dir);
							}

							$zipFile = $dir . $new . '.zip';
							$themeObject = (new \Core\Theme())->get($theme);
							$themeObject->export($zipFile);
							l('ZIP created: ' . $zipFile);

							// l('Working to ZIP: ' . $zipFile);
							/*
							$zipArchive = new \ZipArchive();

							if (!$zipArchive->open($zipFile, \ZIPARCHIVE::CREATE | \ZIPARCHIVE::OVERWRITE)) {
								throw new \Exception('Unable to create ZIP archive.');
							}

							$directory = new \SplFileInfo($path);
							$exclude = array('.git');
							$filter = function ($file, $key, $iterator) use ($exclude) {
								if ($file->getFileName() == 'app.lock' || $file->getFileName() == 'composer.phar') {
									return false;
								}

								if ($iterator->hasChildren() && !in_array($file->getFilename(), $exclude)) {
									return true;
								}
								return $file->isFile();
							};
							$innerIterator = new \RecursiveDirectoryIterator(
								$directory->getRealPath(),
								\RecursiveDirectoryIterator::SKIP_DOTS
							);
							$files = new \RecursiveIteratorIterator(
								new \RecursiveCallbackFilterIterator($innerIterator, $filter)
							);

							foreach ($files as $name => $file) {
								if ($file instanceof \SplFileInfo) {
									$filePath = $file->getRealPath();
									$name = str_replace($directory->getRealPath(), '', $filePath);
									$name = str_replace('\\', '/', $name);

									$zipArchive->addFile($filePath, $name);
								}
							}

							$zipArchive->close();

							if (file_exists($zipFile)) {
								l('ZIP created: ' . $zipFile);
							}
							*/
						}

						l('</div></div>');
					}
				}

				$exclude = array('.git');
				$filter = function ($file, $key, $iterator) use ($exclude) {
					if ($file->getFileName() == 'app.lock' || $file->getFileName() == 'composer.phar') {
						return false;
					}

					if ($iterator->hasChildren() && !in_array($file->getFilename(), $exclude)) {
						return true;
					}
					return $file->isFile();
				};

				foreach (scandir($apps) as $app) {
					$path = $apps . $app . '/';

					if (!file_exists($path . 'app.json')) {
						continue;
					}

					chdir($path);
					l('<div class="panel panel-default"><div class="panel-heading">[app]: ' . $app . '</div>');
					l('<div class="panel-body">');
					// l('Changed to directory: ' . $path);

					$gitRepo = $path . '.git';
					$isGit = false;
					$status = '# modified: #';
					if (is_dir($gitRepo)) {
						$isGit = true;
						$status = shell_exec('git status');
						l('Has git.');
						l($status);
					}
					else {
						l('No git.');
					}

					if (!strpos($status, 'modified:')) {
						l('up-to-date. Nothing to do.');
					}
					else {
						$json = json_decode(file_get_contents($path . 'app.json'));
						$old = $json->version;
						$new = number_format($old, 1);
						$new = $new + 1 * 0.1;

						$json->version = $new;
						file_put_contents($path . 'app.json', json_encode($json, JSON_PRETTY_PRINT));

						if ($isGit) {
							l(shell_exec('git add --all'));
							l(shell_exec('git commit -m "Automated Dist: ' . $dist . '"'));
							l(shell_exec('git push -u origin master'));
						}

						if ($exportPath) {
							$dir = $exportPath . $json->id . '/';
							if (!is_dir($dir)) {
								mkdir($dir);
							}

							$zipFile = $dir . $new . '.zip';
							// l('Working to ZIP: ' . $zipFile);

							$zipArchive = new \ZipArchive();

							if (!$zipArchive->open($zipFile, \ZIPARCHIVE::CREATE | \ZIPARCHIVE::OVERWRITE)) {
								throw new \Exception('Unable to create ZIP archive.');
							}

							$directory = new \SplFileInfo($path);
							$innerIterator = new \RecursiveDirectoryIterator(
								$directory->getRealPath(),
								\RecursiveDirectoryIterator::SKIP_DOTS
							);
							$files = new \RecursiveIteratorIterator(
								new \RecursiveCallbackFilterIterator($innerIterator, $filter)
							);

							foreach ($files as $name => $file) {
								if ($file instanceof \SplFileInfo) {
									$filePath = $file->getRealPath();
									$name = str_replace($directory->getRealPath(), '', $filePath);
									$name = str_replace('\\', '/', $name);

									$zipArchive->addFile($filePath, $name);
								}
							}

							$zipArchive->close();

							if (file_exists($zipFile)) {
								l('ZIP created: ' . $zipFile);
							}
						}
					}

					l('</div></div>');
				}

				break;
			case 'install':

				if (isset($json->apps)) {
					foreach ($json->apps as $url) {
						$git = $url;
						$url = str_replace(['.git', 'github.com/'], ['/master/app.json', 'raw.githubusercontent.com/'], $url);
						$app = json_decode(@file_get_contents($url));

						l('<div class="panel panel-default"><div class="panel-heading">[git]: ' . $git . '</div>');
						l('<div class="panel-body">');

						if (isset($app->id)) {
							l('Found the app: ' . $app->id);

							$path = $apps . $app->id . '/';
							if (!is_dir($path)) {
								mkdir($path);
								l('Created directory: ' . $path);

								chdir($path);
								l('Changed to directory: ' . $path);

								l(shell_exec('git clone ' . $git . ' . 2>&1'));

								if (file_exists($path . 'composer.json')) {
									l('composer.json found. Running composer...');
									l(shell_exec('composer install'));
								}

								touch($path . 'app.lock');
								l('Adding lock file.');

							} else {
								l('App already exists. Moving on...');
							}
						} else {
							l('App is not valid. Cannot install.');
						}

						l('</div></div>');
						// l('####');
					}
				}
				break;
		}

	} catch (Exception $e) {
		l('<div class="alert alert-danger">' . $e->getMessage() . '</div>');
	}

	header('Content-type: application/json; charset=utf-8');
	echo json_encode(['output' => l()], JSON_PRETTY_PRINT);
	exit;
}

header('Content-type: text/html; charset=utf-8');

$commands = ['install', 'update', 'save', 'status'];

?>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en">
	<head>
		<title>PHPfox Dev Tools</title>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	</head>
	<body>
		<div class="navbar navbar-default">
			<a class="navbar-brand" href="./dev.php">PHPfox Dev Tools</a>
		</div>
		<div class="container">

			<div class="col-md-8">
				<form method="get" action="./dev.php">
					<div class="form-group">
						<label>License ID:</label>
						<input type="text" name="license_id" class="form-control">
					</div>
					<div class="form-group">
						<label>License Key:</label>
						<input type="text" name="license_key" class="form-control">
					</div>
					<div class="form-group">
						<label>Command:</label>
						<select name="cmd" class="form-control">
							<option value="">Select:</option>
							<?php foreach ($commands as $command): ?>
							<option value="<?php echo $command; ?>"><?php echo $command; ?></option>
							<?php endforeach; ?>
						</select>
					</div>

					<div class="form-group hide" id="save-path">
						<label>Save Path</label>
						<input type="text" name="path" placeholder="(optional)" class="form-control">
					</div>

					<input type="submit" class="btn btn-primary" value="Submit">
				</form>
			</div>
			<div class="col-md-4" id="js-output">

			</div>

		</div>
		<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script>
			$(function() {
				$('select[name="cmd"]').change(function() {
					var t = $(this), s = $('#save-path');

					switch (t.val()) {
						case 'save':
							s.removeClass('hide');
							break;
						default:
							s.addClass('hide');
							break;
					}
				});

				$('form').submit(function() {
					var t = $(this), o = $('#js-output');

					t.find('.btn').prop('disabled', true);
					o.html('<i class="fa fa-circle-o-notch fa-spin"></i>');
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
