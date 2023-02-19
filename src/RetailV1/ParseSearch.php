<?php

namespace Apzcrawl\PelitaAir\RetailV1;

use Apzcrawl\Airlines\Helpers\StageInterface;
use Apzcrawl\Airlines\AirlinesInterface;
use Apzcrawl\Airlines\Flight\FlightCollection;

class ParseSearch implements StageInterface
{
    public function process(AirlinesInterface &$obj)
    {
        // var_dump(json_decode($obj->lastRetval->getBody()->getContents()));
        $retval = json_decode($obj->lastRetval->getBody()->getContents());
        $flightCollection = new FlightCollection($obj->data->origin, $obj->data->dest, $obj->data->adult, $obj->data->child, $obj->data->infant);
        // print_r($retval->DATA[0]);
        $data = $retval->DATA[0][0];
        echo "<br/>";
        foreach ($data as $key => $value) {
            echo $key . ' = ' . $value;
            echo "<br/>";
        }
        // // print_r($retval->DATA[0][0]);
        // echo "<br/>";

    }
}
