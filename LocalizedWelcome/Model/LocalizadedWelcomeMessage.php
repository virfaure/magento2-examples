<?php

namespace Training\LocalizedWelcome\Model;

use Magento\Framework\Config\DataInterface as WelcomeConfig;
use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;

class LocalizadedWelcomeMessage
{

    /**
     * @var WelcomeConfig
     */
    private $config;

    /**
     * @var GeoIpLookupInterface
     */
    private $geoIpLookup;

    /**
     * @var RemoteAddress
     */
    private $remoteAddress;

    public function __construct(
        WelcomeConfig $config,
        GeoIpLookupInterface $geoIpLookup,
        RemoteAddress $remoteAddress
    ) {
        $this->config = $config;
        $this->geoIpLookup = $geoIpLookup;
        $this->remoteAddress = $remoteAddress;
    }

    public function hasMessage()
    {
        return $this->getConfigValue() !== null;
    }

    public function getMessage()
    {
        $message = $this->getConfigValue();
        if (!$message) {
            throw new \RuntimeException('No welcome message');
        }

        return $message;
    }

    /**
     * @return mixed
     */
    private function getConfigValue()
    {
        $remoteAddress = $this->remoteAddress->getRemoteAddress();
        $remoteAddress = '8.8.8.8';
        $location = $this->geoIpLookup->get($remoteAddress);

        if ($this->hasMessageForState($location)) {
            $configPath = $this->getMessageForState($location);
        } else {
            $configPath = $this->getMessageForDefaultState($location);
        }

        return $this->config->get($configPath);
    }

    /**
     * @param $location
     *
     * @return bool
     */
    private function hasMessageForState($location)
    {
        return $this->getMessageForState($location) !== null;
    }

    /**
     * @param $location
     *
     * @return string
     */
    private function getMessageForState($location)
    {
        return strtolower($location->getCountry() . '/' . $location->getState());
    }

    /**
     * @param $location
     *
     * @return string
     */
    private function getMessageForDefaultState($location)
    {
        return strtolower($location->getCountry() . '/default');
    }
}
