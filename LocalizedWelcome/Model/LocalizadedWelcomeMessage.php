<?php

namespace Training\LocalizedWelcome\Model;

use Magento\Framework\Config\DataInterface as WelcomeConfig;

class LocalizadedWelcomeMessage
{

    /**
     * @var WelcomeConfig
     */
    private $config;

    public function __construct(WelcomeConfig $config)
    {
        $this->config = $config;
    }

    public function hasMessage()
    {
        return true;
    }

    public function getMessage()
    {
        return $this->config->get('us/TX');
    }
}