<?php
require __DIR__ . '/vendor/autoload.php';

use sendotp\sendotp;

$otp = new sendotp( '2500AgQ0U0Hu54e1a0d3','My otp is {{otp}}. Please do not share Me.');

// print_r($otp->send('91998153xxxx', 'MSGIND'));
// print_r($otp->retry('91998153xxxx','text'));
// print_r($otp->verify('91998153xxxx', '3051'));

?>
