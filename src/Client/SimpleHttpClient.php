<?php

namespace G4\Gateway\Client;

use G4\Gateway\Url;
use G4\Gateway\Options;
use G4\Gateway\HttpMethod;
use G4\ValueObject\IntegerNumber;

class SimpleHttpClient implements HttpClientInterface
{
    /**
     * @var Options
     */
    private $options;

    private $imageTypes = [
        'image/png',
        'image/jpeg',
        'image/gif',
    ];
    /**
     * SimpleHttpClient constructor.
     * @param $options
     */
    public function __construct($options)
    {
        $this->options = $options;
    }

    /**
     * @param Url $url
     * @param HttpMethod $method
     * @return SimpleResponse
     * @throws \Exception
     */
    public function send(Url $url, HttpMethod $method)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL             => $url->getUri(),
            CURLOPT_CUSTOMREQUEST   => $method,
            CURLOPT_HTTPHEADER      => $this->getHeaders(),
            CURLOPT_POSTFIELDS      => $this->options->isSendParamsArrayType() ? $url->getParams()->toArray() : $url->getParams()->toJson(),
            CURLOPT_VERBOSE         => true,
            CURLINFO_HEADER_OUT     => true,
            CURLOPT_RETURNTRANSFER  => true,

        ]);

        $response        = curl_exec($curl);
        $error           = curl_error($curl);
        $code            = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curlErrorNumber = curl_errno($curl);

        $responseType = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);
        if(in_array($responseType, $this->imageTypes)){
            $response = $responseType;
        }

        curl_close($curl);

        if ($curlErrorNumber == 0) {
            return (new SimpleResponse($response, new IntegerNumber($code), $url))
                ->setHeaders($url->getParams()->toArray());
        }

        throw new \Exception('Curl error: '. $error, 500);
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        $headers = [];
        if(!empty($this->options->getHeaders())) {
            foreach($this->options->getHeaders() as $key => $value) {
                $headers[] = $key.': '.$value;
            }
        }

        return $headers;
    }
}