<?php

namespace Apzcrawl\PelitaAir\RetailV1;

use Apzcrawl\Airlines\Helpers\StageInterface;
use Apzcrawl\Airlines\AirlinesInterface;

class ParseSearch implements StageInterface
{
    public function process(AirlinesInterface &$obj)
    {
        var_dump($obj->lastRetval->getBody()->getContents());
    }
}
