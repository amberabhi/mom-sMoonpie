<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class HttpService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * Make a GET request.
     *
     * @param string $url
     * @param array $params
     * @param array $headers
     * @return array|string
     */
    public function getRequest(string $url, array $params = [], array $headers = [])
    {
        try {
            if(!empty($params)){
                $response = $this->client->request('GET', $url, [
                    'query' => $params,
                    'headers' => $headers
                ]);
            }else{
                if(empty($headers)){
                    $headers = array(
                        'Content-Type' => 'application/json'
                    );
                }
                $response = $this->client->request('GET', $url, [
                    'headers' => $headers
                ]);
            }


            return $this->handleResponse($response);
        } catch (RequestException $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Make a POST request.
     *
     * @param string $url
     * @param array $data
     * @param array $headers
     * @return array|string
     */
    public function postRequest(string $url, $data, array $headers = [])
    {
        try {
            $response = $this->client->request('POST', $url, [
                'json' => $data,
                'headers' => $headers
            ]);

            return $this->handleResponse($response);
        } catch (RequestException $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Handle the response.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return array|string
     */
    protected function handleResponse($response)
    {
        $statusCode = $response->getStatusCode();
        $body = $response->getBody();

        if ($statusCode === 200) {
            $contentType = $response->getHeader('Content-Type')[0];
            if (strpos($contentType, 'application/json') !== false) {
                return json_decode($body, true);
            } else {
                return (string)$body;
            }
        }

        return "Error: Received status code {$statusCode}";
    }

    /**
     * Handle the exception.
     *
     * @param RequestException $e
     * @return array|string
     */
    protected function handleException(RequestException $e)
    {
        if ($e->hasResponse()) {
            $response = $e->getResponse();
            return $this->handleResponse($response);
        }

        return 'Error: ' . $e->getMessage();
    }
}
