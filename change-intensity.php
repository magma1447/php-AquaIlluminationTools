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
	dieerr("Usage: php -f {$argv[0]} <in-file> <out-file> <multiplier>\n");
}



$inFile = (string) $argv[1];
$outFile = (string) $argv[2];
$multiplier = (float) $argv[3];

if(empty($inFile) || !file_exists($inFile)) {
	dieerr("Invalid in-file\n");
}
if(empty($outFile)) {
	dieerr("Invalid out-file\n");
}
if(empty($multiplier)) {
	dieerr("Invalid difference-in-minutes\n");
}



echo "Reading {$inFile}\n";
$buf = file_get_contents($inFile);


echo "Parsing {$inFile}\n";
$lines = explode(PHP_EOL, $buf);
$out = array();
foreach($lines as $line) {
	if(preg_match('/<intensity>([^<]+)<\/intensity>/', $line, $matches) === 1) {
		$intensity = $matches[1];
		if($intensity != '0') {
			$intensity = round($intensity*$multiplier);
		}

		$line = "\t\t\t\t<intensity>{$intensity}</intensity>";
	}

	$out[] = $line;
}
$out = implode(PHP_EOL, $out);


echo "Hashing data\n";
$newHash = AI_Hash($out);
$out = preg_replace('/<checksum>[^<]+<\/checksum>/', "<checksum>{$newHash}</checksum>", $out);


echo "Creating {$outFile}\n";
file_put_contents($outFile, $out);

