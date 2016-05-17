<?php

namespace Training\LocalizedWelcome\Plugin;

use Training\LocalizedWelcome\Model\LocalizadedWelcomeMessage;

class WelcomeMessageBlockPlugin
{
    /**
     * @var LocalizadedWelcomeMessage
     */
    private $welcomeMessage;

    public function __construct(LocalizadedWelcomeMessage $welcomeMessage)
    {
        $this->welcomeMessage = $welcomeMessage;
    }

    /**
     * @param \Magento\Theme\Block\Html\Header $header
     * @param $result
     *
     * @return string
     */
    public function afterGetWelcome(\Magento\Theme\Block\Html\Header $header, $result)
    {
        return $this->welcomeMessage->hasMessage() ?
            $this->welcomeMessage->getMessage() :
            $result;
    }
}
