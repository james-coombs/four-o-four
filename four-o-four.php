<?php
	function getStatusCode($url) {
		$url = trim($url); // THIS IS IMPORTANT!!!!! (strips invisible chars)
		$ch = curl_init($url); // Init the cURL req

		curl_setopt($ch, CURLOPT_HEADER, true); // We want headers!
		curl_setopt($ch, CURLOPT_NOBODY, true); // We don't want bodies!
		curl_setopt ($ch, CURLOPT_URL, $url); // Set URL for req
		curl_setopt($ch, CURLOPT_TIMEOUT, 500); // Timeout
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Returns the value of curl_exec

		$result = curl_exec($ch); // Execute cURL and store curl res in var
		$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Assign the http code to a var

		curl_close($ch); // End req
		// print curl_error($ch); // <-- Errors here
		print "URL: " . $url . PHP_EOL;
		print "Status: " . $http_status . PHP_EOL;
	}

	function getUrlsFromFile($file) {
		$url_list = array();
		$handle = fopen($file, "r"); // Open file for "r"ead only

		if ($handle) {
			while (($line = fgets($handle)) !== false) { // Gets the line of the file pointer ($handle)
				array_push($url_list, $line); // Store file line in $url_list
			}
			fclose($handle); // End read file
		} else {
			print "Error Reading File";
		}

		array_walk($url_list, "getStatusCode"); // Call function "getStatusCode" on each item in arr
	}

	$file = $argv[1];
	getUrlsFromFile($file);
?>
