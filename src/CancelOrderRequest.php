<?php
namespace IletimerkeziSms;
/**
 *
 */
class CancelOrderRequest extends Request
{
    protected $xml_template = <<<XML
    <request>
        %credentials%
        <order>
            <id>%order_id%</id>
        </order>
    </request>
XML;

    function __construct($credentials)
    {
        $this->credentials($credentials);
        $this->request = $this->xml_template;
        $this->request = str_replace('%credentials%', $this->credentials_xml, $this->request);
    }

    public function order($order_id)
    {
        $this->request = str_replace('%order_id%', $order_id, $this->request);
        return $this;
    }

    public function post($url = 'http://api.iletimerkezi.com/v1/cancel-order') {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->request);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type' => 'application/xml']);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        $result = curl_exec($ch);
        return $result;
    }

}
