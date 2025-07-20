#!/bin/bash

cd /home/pi/weather-station
python3 weather.py &
cd /home/pi/weather-station/www
php -S 0.0.0.0:80

