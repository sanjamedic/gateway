<?php

namespace G4\Gateway;

class Options
{

    const DEFAULT_TIMEOUT           = 10;
    const COMPLEX_CLIENT_TYPE       = 'complex';
    const SIMPLE_CLIENT_TYPE        = 'simple';
    const SEND_PARAMS_ARRAY_TYPE    = 'array';
    const SEND_PARAMS_JSON_TYPE     = 'json';

    /**
     * @var string
     */
    private $clientType;

    /**
     * @var array
     */
    private $headers;

    /**
     * @var boolean
     */
    private $sslVerifyPeer;

    /**
     * @var string
     */
    private $sendParamsType;

    /**
     * @var int
     */
    private $timeout;


    public function __construct()
    {
        $this->headers = [];
        $this->useComplexClientType();
        $this->useSendParamsArrayType();
    }

    /**
     * @return array:
     */
    public function getHeaders()
    {
        return array_filter($this->headers);
    }

    /**
     * @return bool
     */
    public function getSslVerifyPeer()
    {
        return $this->sslVerifyPeer !== null
            ? $this->sslVerifyPeer
            : true;
    }

    /**
     * @return int
     */
    public function getTimeout()
    {
        return $this->timeout === null
            ? self::DEFAULT_TIMEOUT
            : $this->timeout;
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function addHeader($key, $value)
    {
        $this->headers[$key] = $value;
        return $this;
    }

    /**
     * @param boolean $value
     * @return \G4\Gateway\Options
     */
    public function setSslVerifyPeer($value)
    {
        $this->sslVerifyPeer = $value;
        return $this;
    }

    /**
     * @param int $timeout
     * @return \G4\Gateway\Options
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSimpleClientType()
    {
        return $this->clientType == self::SIMPLE_CLIENT_TYPE;
    }

    /**
     * @return $this
     */
    public function useComplexClientType()
    {
        $this->clientType = self::COMPLEX_CLIENT_TYPE;
        return $this;
    }

    /**
     * @return $this
     */
    public function useSimpleClientType()
    {
        $this->clientType = self::SIMPLE_CLIENT_TYPE;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSendParamsArrayType()
    {
        return $this->sendParamsType == self::SEND_PARAMS_ARRAY_TYPE;
    }

    /**
     * @return $this
     */
    public function useSendParamsArrayType()
    {
        $this->sendParamsType = self::SEND_PARAMS_ARRAY_TYPE;
        return $this;
    }

    /**
     * @return $this
     */
    public function useSendParamsJsonType()
    {
        $this->sendParamsType = self::SEND_PARAMS_JSON_TYPE;
        return $this;
    }
}