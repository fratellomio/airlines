<?php

namespace Apzcrawl\PelitaAir\RetailV1;

use Apzcrawl\Airlines\Helpers\CurlStageInterface;
use Apzcrawl\Airlines\AirlinesInterface;

class CurlSearch implements CurlStageInterface
{
    public function getUrl(AirlinesInterface &$obj)
    {
        return '';
    }

    public function getParams(AirlinesInterface &$obj)
    {
        $params = [
        ];
        return $params;
    }

    public function getMethod(AirlinesInterface &$obj)
    {
        return 'post';
    }

    public function getHeaders(AirlinesInterface &$obj)
    {
        return [];
    }
}
