# php-AquaIlluminationTools
Tools for Aqua Illumination Hydra lights

## moveXmin.php
A tool to modify an AIP file with X minutes. Use negative numbers to move it back in time, positive numbers to move it forward in time. I myself am using [David Saxby's](https://www.theaquariumsolution.com/light-presets-hd-ai-led-aquarium-lighting) presets, but wished for the cycle to start 1 hour earlier, mainly because I wanted it to go dark earlier.

The tool has been written and tested with two Hydra 26 running firmware 2.4.0. It has not been tested with a preset that does things over midnight, and this will probably break. It should be easy to add a check for negative numbers and add 1440 minutes to them though. Right now the program is skipping points that are on midnight, that might need a change as well then.

## My settings
My goal was to change the schedule by one hour, and reduce the intensity by 10%. I also thought there was a bit too much blue coloring, so I added some more cool_white again.
I have created my settings using these snippets:
php -f moveXmin.php TQ1\ D.Saxby\ cleaner\ resp\ spikes\ nov\ 2016v2.aip my.aip -60
php -f change-intensity.php my.aip my2.aip 0.9
Now I manually copied the cool_white section from my.aip into my2.aip.
php -f update-hash.php my2.aip my2.aip 

