<?php

namespace Reader;

interface iPullSocket {
    public function getInformation();
    public function copyTo($filename);
    public function parse($type, $outputFile = null);
}
