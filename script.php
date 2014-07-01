<?php

require('iPullSocket.php');
require('PullSocket.php');

use Reader\PullSocket;

$socket = new PullSocket('./config.json');

foreach ($socket as $item) {
    printf("Evaluating: %s\n", $item->getPathName());
}
