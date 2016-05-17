<?php

namespace Training\LocalizedWelcome\Model;

use Magento\Framework\HTTP\ClientInterface;
use Psr\Log\LoggerInterface;

class NekudoGeoIpLookup implements GeoIpLookupInterface
{
    private $apiUrl = 'http://geoip.nekudo.com/api/%s/full';

    /**
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * @var LocationFactory
     */
    private $locationFactory;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        ClientInterface $httpClient,
        LocationFactory $locationFactory,
        LoggerInterface $logger
    ) {
        $this->httpClient = $httpClient;
        $this->locationFactory = $locationFactory;
        $this->logger = $logger;
    }

    /**
     * @param $remoteAddress
     *
     * @return Location
     */
    public function get($remoteAddress)
    {
        $this->logger->debug($remoteAddress);

        $responseData = $this->getApiResponse($remoteAddress);

        $country = $this->getCountry($responseData);
        $state = $this->getState($responseData);

        return $this->locationFactory->create(['country' => $country, 'state' => $state]);
    }

    /**
     * @param $responseData
     * @return mixed
     */
    private function getCountry($responseData)
    {
        return isset($responseData['country']['iso_code']) ?
            $responseData['country']['iso_code'] :
            '';
    }

    /**
     * @param $responseData
     * @return mixed
     */
    private function getState($responseData)
    {
        return isset($responseData['subdivisions'][0]['iso_code']) ?
            $responseData['subdivisions'][0]['iso_code'] :
            '' ;
    }

    /**
     * @param string $remoteAddress
     *
     * @return string
     */
    private function getApiUrl($remoteAddress)
    {
        return sprintf($this->apiUrl, $remoteAddress);
    }

    /**
     * @param string $remoteAddress
     *
     * @return array
     */
    private function getApiResponse($remoteAddress)
    {
        $url = $this->getApiUrl($remoteAddress);
        $this->httpClient->get($url);
        $responseData = json_decode($this->httpClient->getBody(), 1);

        return $responseData;
    }
}