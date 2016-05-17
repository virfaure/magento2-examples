<?php

namespace Training\LocalizedWelcome\Model;

use Magento\Framework\App\CacheInterface;

class CachingGeoIpLookupDecorator implements GeoIpLookupInterface
{

    /**
     * @var GeoIpLookupInterface
     */
    private $subject;

    /**
     * @var CacheInterface
     */
    private $cache;

    /**
     * @var LocationFactory
     */
    private $location;

    public function __construct(
        GeoIpLookupInterface $subject,
        CacheInterface $cache,
        LocationFactory $location
    ) {
        $this->subject = $subject;
        $this->cache = $cache;
        $this->location = $location;
    }

    /**
     * @param string $remoteAddress
     *
     * @return Location
     */
    public function get($remoteAddress)
    {

        $cacheRecord = $this->cache->load($this->getCacheKey($remoteAddress));

        if ($cacheRecord) {
            return $this->hydrateLocationFromCache($cacheRecord);
        }

        $location = $this->subject->get($remoteAddress);
        $this->cacheData($location, $this->getCacheKey($remoteAddress));

        return $location;
    }

    /**
     * @param $remoteAddress
     * @return string
     */
    private function getCacheKey($remoteAddress)
    {
        return 'training_localized_welcome_message_geoip_lookup_' . $remoteAddress;
    }

    /**
     * @param $location
     * @param $key
     */
    private function cacheData($location, $key)
    {
        $cacheData = ['country' => $location->getCountry(), 'state' => $location->getState()];
        $this->cache->save(json_encode($cacheData), $key);
    }

    /**
     * @param $cacheRecord
     * @return Location
     */
    private function hydrateLocationFromCache($cacheRecord)
    {
        $data = json_decode($cacheRecord, true);
        return $this->location->create(['country' => $data['country'], 'state' => $data['state']]);
    }
}
