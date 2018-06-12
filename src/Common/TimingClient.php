<?php

namespace Sportic\Omniresult\Common;

use Sportic\Omniresult\Common\Parsers\AbstractParser;
use Sportic\Omniresult\Common\Scrapers\AbstractScraper;

/**
 * Class TimingClient
 * @package Sportic\Omniresult\Common
 */
class TimingClient implements TimingClientInterface
{

    /**
     * @param $class
     * @param $parameters
     * @return AbstractParser
     */
    protected function executeScrapper($class, $parameters)
    {
        $scrapper = static::createScrapper($class, $parameters);

        return $scrapper->execute();
    }

    /**
     * @param $class
     * @param $parameters
     * @return AbstractScraper
     */
    protected static function createScrapper($class, $parameters)
    {
        /** @var AbstractScraper $obj */
        $obj = new $class();
        $obj->initialize($parameters);

        return $obj;
    }
}