<?php

$time = Time::parse('March 9, 2016 12:00:00', 'America/Chicago');
echo $time->toDateTimeString(); // 2016-03-09 12:00:00
