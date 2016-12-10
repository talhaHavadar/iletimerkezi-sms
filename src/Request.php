<?php
namespace IletimerkeziSms;

/**
 * 
 */
class Request
{
    protected $xml_credentials_request = <<<XML
    <authentication>
        <username>%api_username%</username>
        <password>%api_password%</password>
    </authentication>
XML;
    function __construct()
    {
        # code...
    }

    public function credentials($credentials)
    {
        $this->credentials_xml = $this->xml_credentials_request;
        $this->credentials_info = $credentials;
        foreach ($credentials as $key => $value) {
            $this->credentials_xml = str_replace('%'.$key.'%', $value, $this->credentials_xml);
        }
        return $this;
    }
}
