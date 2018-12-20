<?php

require_once('AquaIllumination.php');



function echoerr($string) {
	fwrite(STDERR, $string);
}
function dieerr($string) {
	fwrite(STDERR, $string);
	exit(1);
}



if($argc != 3) {
	dieerr("Usage: php -f {$argv[0]} <in-file> <out-file>\n");
}



$inFile = (string) $argv[1];
$outFile = (string) $argv[2];

if(empty($inFile) || !file_exists($inFile)) {
	dieerr("Invalid in-file\n");
}
if(empty($outFile)) {
	dieerr("Invalid out-file\n");
}



echo "Reading {$inFile}\n";
$buf = file_get_contents($inFile);

echo "Hashing data\n";
$newHash = AI_Hash($buf);
$out = preg_replace('/<checksum>[^<]+<\/checksum>/', "<checksum>{$newHash}</checksum>", $buf);


echo "Creating {$outFile}\n";
file_put_contents($outFile, $out);

