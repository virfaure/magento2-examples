<?php


namespace Training\LocalizedWelcome\Model;

class Location
{
    /** @var string */
    private $country;

    /** @var string */
    private $state;

    /**
     * @param string $country
     * @param string $state
     */
    public function __construct($country, $state)
    {
        $this->country = $country;
        $this->state = $state;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }
}
