<?php

namespace Training\LocalizedWelcome\Model;

interface GeoIpLookupInterface
{
    /**
     * @param string $remoteAddress
     *
     * @return Location
     */
    public function get($remoteAddress);
}