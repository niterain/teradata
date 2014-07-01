<?php

require('iPullSocket.php');
require('PullSocket.php');

use Reader\PullSocket;

print "reading in config file.\n";
$socket = new PullSocket('./config.json');

foreach ($socket as $item) {
    printf(":: evaluating: %s\n", $item->getPathName());
}
$socket->copyTo('output.json');
print "finished.\n";
