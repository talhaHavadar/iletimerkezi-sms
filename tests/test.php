<?php

require __DIR__.'/../vendor/autoload.php'; // Autoload files using Composer autoload

use IletimerkeziSms\Sms;
use IletimerkeziSms\Request;
$sms = new Sms();

$dt = DateTime::createFromFormat('d/m/Y H:i', "11/12/2016 12:00")->setTimezone(new DateTimeZone("Europe/Istanbul"));
echo $dt->format('d/m/Y H:i')."\n";

echo $sms->message(['content' => "merhabalar", "numbers" => ['(xxx) xxx xxxx']])->send($dt)."\n";
// echo $sms->cancel('20331773');