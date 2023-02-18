<?php

namespace Apzcrawl\PelitaAir\RetailV1;

use Apzcrawl\Airlines\Helpers\CurlStageInterface;
use Apzcrawl\Airlines\AirlinesInterface;

class CurlSearch implements CurlStageInterface
{
    public function getUrl(AirlinesInterface &$obj)
    {
        return 'https://www.pelita-air.com/home/search_flight';
    }

    public function getParams(AirlinesInterface &$obj)
    {
        $params = [
            'CityFrom' => $obj->data->origin,
            'CityTo' => $obj->data->dest,
            'DepartDate' => $obj->data->dptDate,
            'Adult' => $obj->data->adult,
            'Child' => $obj->data->child,
            'Infant' => $obj->data->infant,
            'PromoCode' => '',

        ];
        return $params;
    }

    public function getMethod(AirlinesInterface &$obj)
    {
        return 'POST';
    }

    public function getHeaders(AirlinesInterface &$obj)
    {
        return [
            'authority' => 'www.pelita-air.com',
            'accept' => 'application/json, text/javascript, */*; q=0.01',
            'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.46',
            'content-type' => 'application/x-www-form-urlencoded; charset=UTF-8'
        ];
    }
}
