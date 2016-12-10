<?php
namespace IletimerkeziSms;
use IletimerkeziSms\Request;
/**
 *
 */
class SMSRequest extends Request
{
    protected $xml_template = <<<XML
    <request>
        %credentials%
        <order>
            <sender>%sender_name%</sender>
            <sendDateTime>%send_date_time%</sendDateTime>
            %messages%
        </order>
    </request>
XML;

    protected $xml_message_template = <<<XML_MESSAGE
    <message>
        <text><![CDATA[%content%]]></text>
        <receipents>
            %numbers%
        </receipents>
    </message>
XML_MESSAGE;

    protected $xml_number_template = <<<XML_NUMBER
    <number>%phone_number%</number>
XML_NUMBER;

    function __construct($credentials)
    {
        $this->credentials($credentials);
        $this->request = $this->xml_template;
        $this->request = str_replace('%credentials%', $this->credentials_xml, $this->request);
        $this->request = str_replace('%sender_name%', $this->credentials_info['sender_name'], $this->request);
    }

    public function date(\DateTime $dt)
    {
        $datetime = $dt->format('d/m/Y H:i');
        $this->request = str_replace('%send_date_time%', $datetime, $this->request);
        return $this;
    }

    /**
    *
    * $message parameter should be an array with this signature:
    *
    *       [
    *           "numbers": ["xxxxxxxxxx", ],
    *           "content": "some message"
    *       ]
    *
    **/
    public function message($message)
    {
        $message_xml = str_replace('%content%', $message['content'], $this->xml_message_template);

        foreach ($message['numbers'] as $num) {
            $num_xml = str_replace('%phone_number%', $num, $this->xml_number_template);
            $message_xml = str_replace('%numbers%', $num_xml.'%numbers%', $message_xml);
        }
        $message_xml = str_replace('%numbers%', '', $message_xml);
        $this->request = str_replace('%messages%', $message_xml.'%messages%', $this->request);
        return $this;
    }

    public function post($url = 'http://api.iletimerkezi.com/v1/send-sms') {
        $this->request = str_replace('%messages%', '', $this->request);
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
