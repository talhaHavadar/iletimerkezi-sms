<?php

namespace IletimerkeziSms;

interface SmsInterface {

    public function message($message);

    public function cancel($orderId);

    public function send(\DateTime $dt);
}
