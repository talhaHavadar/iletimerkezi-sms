<?php

namespace IletimerkeziSms;

/**
 * 
 */
class Response
{
    
    function __construct($xml_string)
    {
        $this->xml_string = $xml_string;
    }

    public function json()
    {
        $xml = simplexml_load_string($this->xml_string);
        return json_encode($xml);
    }

    public function array()
    {
        $xml = simplexml_load_string($this->xml_string);
        $json = json_encode($xml);
        return json_decode($json,TRUE);
    }
}
