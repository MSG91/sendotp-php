<?php

namespace sendotp\Utils;

class HttpInstance
{
    /**
     * @var resource
     */
    private $curlInstance;
    /**
     * @var int
     */
    private $httpCode;
    /**
     * @var string
     */
    private $response;

    /**
     * httpInstance constructor.
     *
     * @param $url
     */
    public function __construct($url)
    {
        $this->curlInstance = curl_init($url);
    }

    //To validate JSON
    public function isJson($string) {
    	json_decode($string);
     	return (json_last_error() == JSON_ERROR_NONE);
    }

    /**
     * set Curl options
     *
     * @param $project
     * @param $key
     * @param $args
     */
    public function setParameters($args)
    {
        if(is_array($args)){
      		$post_data = $args;
      	}
      //To check if provided data is JSON string
      	else if($this->isJson($args)){
      		$post_data=json_decode($args);
      	}
      //if provided data is simple string.
      	else
      	{
      		$prepareData['data']=$args;
          $post_data=	$prepareData;
      	}

        curl_setopt($this->curlInstance, CURLOPT_POST, true);

        curl_setopt($this->curlInstance, CURLOPT_SSL_VERIFYPEER, true);

        curl_setopt($this->curlInstance, CURLOPT_POSTFIELDS, $post_data);

        curl_setopt($this->curlInstance, CURLOPT_RETURNTRANSFER, true);
    }

    /**
     * response from API
     *
     * @return mixed|string
     */
    public function getResponse()
    {
        $this->response = curl_exec($this->curlInstance);

        $this->httpCode = curl_getinfo($this->curlInstance, CURLINFO_HTTP_CODE);

        $error = curl_error($this->curlInstance);

        $errno = curl_errno($this->curlInstance);

        if (is_resource($this->curlInstance)) {

            curl_close($this->curlInstance);
        }

        if (0 !== $errno) {

            throw new \RuntimeException($error, $errno);
        }

        return $this->response;
    }

    /**
     * HTTP CODE from last request
     *
     * @return int
     */
    public function getLastHttpCode()
    {
        return $this->httpCode;
    }

}
