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



echo "Reading {$inFile}\n";
$buf = file_get_contents($inFile);


echo "Parsing {$inFile}\n";
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
$out = implode(PHP_EOL, $out);


echo "Hashing data\n";
$hashData = preg_replace('/\s+/', '', $out);
$hashData = preg_match('/.*(<colors>.*<\/colors>).*/', $hashData, $matches);
$newHash = AI_Hash($matches[1]);
$out = preg_replace('/<checksum>[^<]+<\/checksum>/', "<checksum>{$newHash}</checksum>", $out);


echo "Creating {$outFile}\n";
file_put_contents($outFile, $out);

