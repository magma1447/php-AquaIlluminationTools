// NodeJS test function of the hash function. Usable to compare results between PHP and JS.

var fs = require('fs');

var d = function(m) {
	var l = 0;
        if (m.length == 0) {
            return l;
        }
        for (var k = 0; k < m.length; k++) {
		var j = m.charCodeAt(k);
		l = ((l << 5) - l) + j;
		l = l & 4294967295;

		console.log('l:' + l);
        }
        if (l < 0) {
            l = ~l;
        }
        return l;
}

fs.readFile('hashme', 'utf8', function(err, contents) {
	d(contents);
});

