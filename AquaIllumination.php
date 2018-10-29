<?php

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
		if($l > 4294967296/2) {	// Fixes signed vs unsigned difference between PHP and JS
			$l -= 4294967296;
		}
	}
	if($l < 0) {
		$l = ~$l;
	}
	return $l;
}

