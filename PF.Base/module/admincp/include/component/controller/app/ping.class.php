<?php

class Admincp_Component_Controller_App_Ping extends Phpfox_Component {
	public function process() {

		$url = $this->request()->get('url');
		if (substr($url, 0, 8) != 'https://') {
			exit('p("Not an app")');
		}
		$file = PHPFOX_DIR_FILE . 'static/' . md5($url) . '.log';
		if (!file_exists($file)) {
			$out = '';
		}
		else {
			$out = file_get_contents($file);
		}

		/*
		$filename = $file;  //about 500MB
		$output = shell_exec('exec tail -n50 ' . $filename);  //only print last 50 lines
		echo str_replace(PHP_EOL, '<br />', $output);         //add newlines
		flush();
		*/

		header('Content-type: application/javascript');
		echo "var js = " . json_encode(['output' => $out]) . ";";
		echo "$('#debug_info').html(js.output);";
		echo "setTimeout(runPing, 400);";
		exit;

		/*
		$content = file_get_contents($file);
		ob_end_clean();

		$len = strlen($content);             // Get the length
		header('Connection: close');         // Tell the client to close connection
		header("Content-Length: $len");     // Close connection after $len characters
		echo $content;
		flush();
		// Optional: kill all other output buffering
		while (ob_get_level() > 0) {
			ob_end_clean();
		}
		*/
	}
}