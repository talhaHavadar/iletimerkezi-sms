<?php

namespace IletimerkeziSms;

class Sms implements SmsInterface
{
    protected $messages = [];
    public function __construct()
    {
        $this->configuration = function_exists('config') ? config('iletimerkezi') : require __DIR__."/config/iletimerkezi.php";
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
    public function message($message){
        array_push($this->messages, $message);
        return $this;
    }


    public function cancel($orderId){
        $request = new CancelOrderRequest($this->configuration);
        return $request->order($orderId)->post();
    }


    public function send(\DateTime $dt){
        $request = new SMSRequest($this->configuration);
        $request->date($dt);
        foreach ($this->messages as $message) {
            $request->message($message);
        }
        $res = new Response($request->post());
        return $res->array();
    }

}
