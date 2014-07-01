<?php

namespace Reader;

use Iterator;

class PullSocket implements iPullSocket, Iterator {

    protected $file;
    protected $data = array();
    protected $id = 0;
    protected $numberOfRequests = 0;

    public function __construct($fileName) {
        if (file_exists($fileName)) {
            $json = json_decode($cnt = file_get_contents($fileName), true);

            if (!empty($json['data'])) {
                $this->data['urls'] = $json['data'];
            }
        } else {
            throw new \Exception('file does not exists.');
        }
    }

    /**
     * Increments the number of requests, also brings down the file to get the file size
     * @return \SplFileObject
     */
    public function getInformation()
    {
        $this->numberOfRequests++;
        $file = new \SplFileObject($this->data['urls'][$this->key()]['url']);
        $fp = fopen($this->key().'-'.$file->getFilename(), 'w');
        $this->data['urls'][$this->key()]['size'] = 0;
        while(!$file->eof()) {
            fwrite($fp, $string = $file->fgets());
            $this->data['urls'][$this->key()]['size'] += strlen($string);
        }
        fclose($fp);
        return $file;
    }

    /**
     * This copies the data array into a file in json format.
     * @param $fileName
     * @return int
     */
    public function copyTo($fileName)
    {
        try {
            $fp = fopen($fileName, 'w');
            if ($this->numberOfRequests == 1) {
                fwrite($fp, $this->data['urls'][0]['size']."\n");
            } else {
                $this->data['numberOfRequests'] = $this->numberOfRequests;
                fwrite($fp, json_encode($this->data, JSON_PRETTY_PRINT));
            }
            fclose($fp);
        } catch (\Exception $e) {
            return 0;
        }
        return 1;
    }

    /**
     * This is will only have be used for html files, to parse and get new html
     * It will only work if the xhtml since I am using SimpleXml and xpath
     * @param $type
     * @param null $outputFile
     */
    public function parse($type, $outputFile = null)
    {
        if ($type === 'html') {
            //TODO:  Read in the file to be parsed.
        }
    }

    /**
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function current()
    {
        return $this->getInformation();
    }

    /**
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        if ($this->valid()){
            $this->id++;
        }
    }

    /**
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        return $this->id;
    }

    /**
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid()
    {
        return ($this->id < count($this->data['urls']));
    }

    /**
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        $this->id = 0;
    }
}
