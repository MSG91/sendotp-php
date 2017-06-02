#SendOTP - PHP SDK

This SDK allows you to connect to SendOTP server from your php app. To start off, follow the following guide:

[![MIT Licence](https://badges.frapsoft.com/os/mit/mit.png?v=103)](https://opensource.org/licenses/mit-license.php)
[![forthebadge](http://forthebadge.com/images/badges/built-by-developers.svg)](http://forthebadge.com)

##Set-up:

First of all, download the sdk by composer:

    composer require sendotp/sendotp

    or add this into your composer.json   
      "require": {
              "sendotp/sendotp": "^1.0"
          }


Then, require composer autoload and use package in your code:

    require __DIR__ . '/vendor/autoload.php';

    use sendotp\sendotp;

Once required, the last step is to initialize the SDK with your project name and project API Key:

    $otp = new sendotp('AUTK-KEY','Message Template : My otp is {{otp}}. Please do not share Me.');

That's all, your SDK is set up! You can now use any block by copying the code snippet from the marketplace.

##Usage:

    print_r($otp->send('91998153xxxx', 'MSGIND'));

The printed result will be:

    Array
    (
      [message] => 37646d6b7658303839363039
      [type] => success
      [otp] => 8227
    )


##Issues:

As this is a pre-release version of the SDK, you may expirience bugs. Please report them in the issues section to let us know. You may use the intercom chat on https://msg91.com for support at any time.

##Licence:

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
