<?php

namespace Apzcrawl\PelitaAir;

use Apzcrawl\Airlines\AirlinesCurlBase;
use Apzcrawl\Airlines\AirlinesBookPchInterface;

class PelitaAirANOALL extends AirlinesCurlBase implements AirlinesBookPchInterface
{
    /**
     *
     * @param string $agentID Inventory Ex: 9905_AIRASIAAIRWAYMEMALL_MY1
     */
    public function __construct($agentID)
    {
        parent::__construct($agentID);
        $this->airlines       = 'PelitaAir';
        $this->maxAdult       = $this->maxChild  = $this->maxInfant = 4;
        $this->cmdCrawlRoute  = 'RetailV1';
        $this->cmdCrawl       = 'RetailV1';
        $this->cmdCrawlReturn = 'RetailV1';

        $this->cmdBook        = 'RetailV1';
        $this->cmdBookNPay    = 'RetailV1';
        $this->cmdPch         = 'RetailV1';

        $this->cmdBookWaiting  = 'RetailV1';
    }


    /**
     * The initial steps of crawlRoute
     *
     * @return the list of array contains class that implements StageInterface
     */
    public function initCrawlRoute()
    {
        return [];
    }

    /**
     * The initial steps of Crawl
     *
     * @return the list of array contains class that implements StageInterface
     */
    public function initCrawl()
    {
        return [
            'RetailV1' => [
                'CurlSearch'  => 'Apzcrawl\PelitaAir\RetailV1\CurlSearch',
                'ParseSearch' => 'Apzcrawl\PelitaAir\RetailV1\ParseSearch',
            ]
        ];
    }

    public function initCrawlReturn()
    {
        return [];
    }


    public function initBookWaiting()
    {
        return [];
    }


    public function initBook()
    {
        return [];
    }

    public function initBookNPay()
    {
        return [];
    }

    public function initPch()
    {
        return [];
    }
}
