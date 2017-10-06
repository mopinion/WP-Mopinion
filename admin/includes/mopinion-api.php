<?php

class MopinionApiHandler
{

    const API_URL     = 'https://api.mopinion.com';
    const API_VERSION = '1.17.0';

    const PUBLIC_KEY        = 'wordpress';
    const SIGNATURE_TOKEN   = 'qSGODPb0ehx%mS2m77oUvWoAiw0RjipJ2^qGNBH@';

    const HASH_METHOD   = 'sha256';

    private $method;
    private $route;
    private $body    = null;
    private $jsonBody = '{}';
    private $headers = [];
    private $query   = [];

    public function __construct()
    {
        $this->headers = array(
            'cache-control' =>  'no-cache',
            'content-type' =>  'application/json',
            'version' => self::API_VERSION,
        );
    }


    public function post($resource, $params)
    {
        $this->setRoute($resource);
        $this->method = 'POST';
        $this->setParams($params);
        $response = $this->request();

         //update the key with mopinion deployment key
        $json = json_decode($response);

        return $json;
    }


    public function get($resource, $params){}
    public function put($resource, $params){}
    public function delete($resource, $params){}


    private function getRequestHeaders()
    {
        $requestHeaders = array();
        foreach($this->headers as $key => $value){
            $requestHeaders[] = "{$key}:{$value}";
        }

        return $requestHeaders;
    }


    private function setRoute($resource)
    {
        // just some cleanup so we are sure the formatting is right
        $this->route = "/". trim($resource, '/');
    }


    private function getRoute($includeQuery=true)
    {
        $query = '';

        if($includeQuery && !empty($this->query)){

            foreach ($this->query as $key => $value) {
                $query .="{$key}={$value}&";
            }

            $query = '?'.trim($query, "&");
        }

        return $this->route . $query;
    }


    private function setParams($params)
    {
        if(isset($params['body'])){
            $this->body = $params['body'];
            $this->jsonBody = !empty($this->body) ? json_encode($this->body) : '{}';
        }

        if(isset($params['headers'])){
            foreach ($params['headers'] as $key => $value) {
                $this->headers[$key] = $value;
            }
        }

        if(isset($params['query'])){

            foreach ($params['query'] as $key => $value) {
                $this->query[$key] = $value;
            }
        }
    }

    /**
     * Generate an authorization token using the public key and the signature
     * @return string
     */
    private function generateAuthToken()
    {
        if(empty(self::SIGNATURE_TOKEN)){
            throw new \Exception("Signature token is not set");
        }

        $signature = hash_hmac(self::HASH_METHOD, $this->getRoute(false).'|'.$this->jsonBody, self::SIGNATURE_TOKEN);

        return base64_encode(self::PUBLIC_KEY.":".$signature);
    }


    private function setToken($token)
    {
        $this->headers["x-auth-token"] = $token;
        return $this;
    }


    private function request()
    {
        $token = $this->generateAuthToken();
        $this->setToken($token);

        $options = array(
            CURLOPT_URL => self::API_URL.$this->getRoute(),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $this->method,
            CURLOPT_HTTPHEADER => $this->getRequestHeaders()
        );

        if(!empty($this->body)){
            $options[CURLOPT_POSTFIELDS] = json_encode($this->body);
        }

        $curl = curl_init();
        curl_setopt_array($curl, $options );
        $response = curl_exec($curl);
        $err = curl_error($curl);

        return $response;
    }
}