<?php
namespace app\api;

class Curl
{

    private $curl;
    public function __construct(String $url)
    {
        $this->curl = curl_init($url);
    }


    public function setOpt(mixed $options, $val)
    {
        curl_setopt($this->curl, $options, $val);
    }

    public function exec()
    {
        return curl_exec($this->curl);
    }

    public function getHeaderSize()
    {
        return curl_getinfo($this->curl, CURLINFO_HEADER_SIZE);
    }

    public function close()
    {
        curl_close($this->curl);
    }

    public function getError()
    {
        return curl_error($this->curl);
    }
}


