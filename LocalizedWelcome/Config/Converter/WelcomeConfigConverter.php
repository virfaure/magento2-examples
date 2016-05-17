<?php

namespace Training\LocalizedWelcome\Config\Converter;

use Magento\Framework\Config\ConverterInterface;

class WelcomeConfigConverter implements ConverterInterface
{
    /**
     * Convert config
     *
     * @param \DOMDocument $source
     * @return array
     */
    public function convert($source)
    {
        $data = [];

        foreach ($source->childNodes as $node) {
            if ($node->nodeType != \XML_ELEMENT_NODE) {
                continue;
            }

            if ($node->nodeName === 'welcome_message') {
                $data = $this->convert($node);
            } elseif ($node->nodeName == 'country') {
                $data[$this->getCodeAttribute($node)] = $this->convert($node);
            } elseif ($node->nodeName == 'state') {
                $data[$this->getCodeAttribute($node)] = $node->textContent;
            }
        }

        return $data;
    }

    /**
     * @param $node
     * @return mixed
     */
    private function getCodeAttribute($node)
    {
        return $node->attributes->getNamedItem('code')->nodeValue;
    }
}