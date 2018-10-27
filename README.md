# php-AquaIlluminationTools
Tools for Aqua Illumination Hydra lights

## moveXmin.php
A tool to modify an AIP file with X minutes. Use negative numbers to move it back in time, positive numbers to move it forward in time. I myself am using [David Saxby's](https://www.theaquariumsolution.com/light-presets-hd-ai-led-aquarium-lighting) presets, but wished for the cycle to start 1 hour earlier, mainly because I wanted it to go dark earlier.

The tool has been written and tested with two Hydra 26 running firmware 2.4.0. It has not been tested with a preset that does things over midnight, and this will probably break. It should be easy to add a check for negative numbers and add 1440 minutes to them though. Right now the program is skipping points that are on midnight, that might need a change as well then.
