<?php

namespace sendotp;

use sendotp\Utils\HttpInstance;

class sendotp
{
    /**
     * Creates a new SendOTPApi Connect instance
     *
     * @param $project {Name of the project you are working with}
     * @param $key {API key for the project}
     */
    public function __construct($key,$message)
    {
        if(isset($message)){
            $this->messageTemplate = $message;
        }else{
            $this->messageTemplate = "Your otp is {{otp}}. Please do not share it with anybody";
        }
        $this->key = $key;
    }

    /**
    * Returns the 4 digit otp
    * @returns {integer} 4 digit otp
    */
   public function generateOtp() {
       return rand(1000, 9000);
   }

   /**
     * Send Otp to given mobile number
     * @param {string} contactNumber receiver's mobile number along with country code
     * @param {string} senderId
     * @param {string, optional} otp
     * Return promise if no callback is passed and promises available
     */
    public function send($contactNumber, $senderId, $otp=null) {

        if (!isset($otp) || strlen($otp)<3 || strlen($otp)>11) {
            $otp = $this->generateOtp();
        }

        $requestArgs["authkey"]=$this->key;
        $requestArgs["mobile"]=$contactNumber;
        $requestArgs["sender"]=$senderId;
        $requestArgs["message"]=str_replace('{{otp}}', $otp, $this->messageTemplate);
        $requestArgs["otp"]=$otp;
        $this->message=$requestArgs["message"];
        $response  = $this->call("sendotp.php", $requestArgs);
        if($response["type"]=="success"){
          $response["otp"]=$requestArgs["otp"];
        }
        else{
          $response["otp"]="";
        }
        return $response;
    }

    /**
    * Retry Otp to given mobile number
    * @param {string} contactNumber receiver's mobile number along with country code
    * @param {boolean} retryVoice, false to retry otp via text call, default true
    * Return promise if no callback is passed and promises available
    */
   public function retry($contactNumber, $retryByText=null) {
       $retryType =  'voice';
       if (isset($retryByText) && !is_null($retryByText)) {
           $retryType = 'text';
       }
       $requestArgs["authkey"]=$this->key;
       $requestArgs["mobile"]=$contactNumber;
       $requestArgs["retrytype"]=$retryType;

       $response  = $this->call("retryotp.php", $requestArgs);
       return $response;
   }

   /**
    * Verify Otp to given mobile number
    * @param {string} contactNumber receiver's mobile number along with country code
    * @param {string} otp otp to verify
    * Return promise if no callback is passed and promises available
    */
   public function verify($contactNumber, $otp) {

     $requestArgs["authkey"]=$this->key;
     $requestArgs["mobile"]=$contactNumber;
     $requestArgs["otp"]=$otp;
     $response  = $this->call("verifyRequestOTP.php", $requestArgs);
     return $response;

      //  return SendOtp.doRequest('get', "verifyRequestOTP.php", args, callback);
   }


    /**
     * Returns the base URL for block calls
     *
     * @returns string Base URL for block calls
     */
    public static function getBaseUrl()
    {
        return "https://control.msg91.com/";
    }

    /**
     * Build a URL for a block call
     *
     * @param $pack {Package where the block is}
     * @param $block {Block to be called}
     * @returns string Generated URL
     */
    public static function actionUrlBuild($action)
    {
        return static::getBaseUrl() . '/api/' . $action;
    }

    /**
     * Call a block
     *
     * @param $pack {Package of the block}
     * @param $block {Name of the block}
     * @param $args {Arguments to send to the block (JSON)}
     * @return mixed|string
     */
    public function call($action, $args)
    {
        $callback = [];

        $httpInstance = new HttpInstance(static::actionUrlBuild($action));

        $httpInstance->setParameters($args);

        try {

            $response = json_decode($httpInstance->getResponse(), true);

            if ($httpInstance->getLastHttpCode() != 200) {

                $callback = $response;

                return $callback;
            } else {

                if(isset($response['payload'])){
                  $callback = $response['payload'];
                }
                else {
                  $callback = $response;
                }

                return $callback;
            }

        } catch (\RuntimeException $ex) {

            $callback = sprintf('Http error %s with code %d', $ex->getMessage(), $ex->getCode());

            return $callback;
        }
    }

}
