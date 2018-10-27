<?php

// Config
$inFile = 'TQ1 D.Saxby cleaner resp spikes nov 2016v2.aip';
$outFile = 'my.aip';
$minutes = -60;
//--


/*
    var d = function(m) {
        var l = 0;
        if (m.length == 0) {
            return l
        }
        for (var k = 0; k < m.length; k++) {
            var j = m.charCodeAt(k);
            l = ((l << 5) - l) + j;
            l = l & 4294967295
        }
        if (l < 0) {
            l = ~l
        }
        return l
    };
*/
function AI_Hash($m) {
	$l = 0;
	if(strlen($m) == 0) {
		return $l;
	}
	for($k = 0 ; $k < strlen($m) ; $k++) {
		$j = ord($m[$k]);
		$l = (($l << 5) - $l) + $j;
		$l = $l & 4294967295;
		if($l > 4294967296/2) {
			$l -= 4294967296;
		}
	}
	if($l < 0) {
		$l = ~$l;
	}
	return $l;
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

