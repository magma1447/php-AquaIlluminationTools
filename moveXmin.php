<?php

require_once('AquaIllumination.php');



function echoerr($string) {
	fwrite(STDERR, $string);
}
function dieerr($string) {
	fwrite(STDERR, $string);
	exit(1);
}



if($argc != 4) {
	dieerr("Usage: php -f {$argv[0]} <in-file> <out-file> <difference-in-minutes>\n");
}



$inFile = (string) $argv[1];
$outFile = (string) $argv[2];
$minutes = (int) $argv[3];

if(empty($inFile) || !file_exists($inFile)) {
	dieerr("Invalid in-file\n");
}
if(empty($outFile)) {
	dieerr("Invalid out-file\n");
}
if(empty($minutes)) {
	dieerr("Invalid difference-in-minutes\n");
}




$buf = file_get_contents($inFile);

$lines = explode(PHP_EOL, $buf);
$out = array();
foreach($lines as $line) {
	if(preg_match('/<time>([^<]+)<\/time>/', $line, $matches) === 1) {
		$time = $matches[1];
		if($time != '0') {
			$time += $minutes;
		}

		$line = "\t\t\t\t<time>{$time}</time>";
	}

	$out[] = $line;
}


// Create a string to checksum
$store = FALSE;
$hashData = array();
foreach($out as $line) {
	if($store === FALSE && strpos($line, '<colors') !== FALSE) {
		$store = TRUE;
		$line  = str_replace("\t", '', $line);
	}
	else if($store === TRUE && strpos($line, '</ramp>') !== FALSE) {
		$store = FALSE;
	}

	if($store === TRUE) {
		$hashData[] = $line;
	}
}
$hashData = implode($hashData);

$hashData = preg_replace('/\s+/', '', $hashData);
$newHash = AI_Hash($hashData);



$out = implode(PHP_EOL, $out);
$out = preg_replace('/<checksum>[^<]+<\/checksum>/', "<checksum>{$newHash}</checksum>", $out);

file_put_contents($outFile, $out);

