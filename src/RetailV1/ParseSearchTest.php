<?php

namespace Apzcrawl\PelitaAir\RetailV1;

use Apzcrawl\Airlines\Helpers\StageInterface;
use Apzcrawl\Airlines\AirlinesInterface;
use Apzcrawl\Airlines\Flight\Flight;
use Apzcrawl\Airlines\Flight\FlightCollection;
use Apzcrawl\Airlines\Flight\TransitFlight;

class ParseSearch implements StageInterface
{
    public function process(AirlinesInterface &$obj)
    {
        $retval = json_decode($obj->lastRetval->getBody()->getContents());
        $flightCollection = new FlightCollection($obj->data->origin, $obj->data->dest, $obj->data->adult, $obj->data->child, $obj->data->infant);
        $flights = $retval->DATA[0];

        foreach ($flights as $flight) {
            if (!$this->isValidFlight($flight)) {
                continue;
            }
            $flightObj = new Flight();
            $city = $flight->CityFrom;
            $flightCode = $flight->Segments[0]->CarrierCode . $flight->Segments[0]->NoFlight;
            $fareClass = $flight->FARE_FAMILY[0]->DESCRIPTION;
            $class = $flight->ClassesAvailable_B2C;
            $departure = strtotime($flight->Std);
            $dptDateTime = date('Y-m-d h:i:s', $departure);
            $arrival = strtotime($flight->Sta);
            $arrDateTime = date('Y-m-d h:i:s', $arrival);
            $priceAdult = $class->ECONOMY[0]->PriceDetail[0]->FareComponent[0]->Amount;
            $adultPSCFee =
                $class->ECONOMY[0]->PriceDetail[0]->FareComponent[1]->Amount;
            $adultVAT =
                $class->ECONOMY[0]->PriceDetail[0]->FareComponent[2]->Amount;
            $adultIWJR =
                $class->ECONOMY[0]->PriceDetail[0]->FareComponent[3]->Amount;
            $adultSC =
                $class->ECONOMY[0]->PriceDetail[0]->FareComponent[4]->Amount;
            $taxAdult = $adultPSCFee + $adultVAT + $adultIWJR + $adultSC;
            $priceChild = $class->ECONOMY[0]->PriceDetail[1]->FareComponent[0]->Amount;
            $childPSCFee =
                $class->ECONOMY[0]->PriceDetail[1]->FareComponent[1]->Amount;
            $childVAT =
                $class->ECONOMY[0]->PriceDetail[1]->FareComponent[2]->Amount;
            $childIWJR =
                $class->ECONOMY[0]->PriceDetail[1]->FareComponent[3]->Amount;
            $childSC =
                $class->ECONOMY[0]->PriceDetail[1]->FareComponent[4]->Amount;
            $taxChild = $childPSCFee + $childVAT + $childIWJR + $childSC;
            $priceInfant = $class->ECONOMY[0]->PriceDetail[2]->FareComponent[0]->Amount;
            $infantVAT =
                $class->ECONOMY[0]->PriceDetail[2]->FareComponent[1]->Amount;
            $infantIWJR =
                $class->ECONOMY[0]->PriceDetail[2]->FareComponent[2]->Amount;
            $taxInfant = $infantVAT + $infantIWJR;
            // echo "<br/>";
            // echo "flightCode: " . $flightCode;
            // echo "<br/>";
            // echo $city;
            // echo "<br/>";
            // echo $dptDateTime;
            // echo "<br/>";
            // echo $arrDateTime;
            // echo "<br/>";
            // echo $fareClass;
            // echo "<br/>";
            // echo "Basic fare: ";
            // echo $priceAdult;
            // echo "<br/>";
            // echo "adult tax: ";
            // echo $taxAdult;
            // echo "<br/>";
            if (isset($flight->Segments[1])) {
                // Transit Flight
                throw new \Exception("Transit Flight Found");
                $transitAirport = "";
                $transitFlightCode = "";
                $transitArrDateTime = $arrDateTime;
                $transitDptDateTime = "";
                $arrDateTime = "";
                $trsFlight = new TransitFlight($transitAirport, $transitFlightCode, $transitDptDateTime, $transitArrDateTime);
            }

            $flightObj->addFlight($flightCode, $fareClass, $dptDateTime, $arrDateTime);
            if (isset($trsFlight)) {
                $flightObj->addTransit($trsFlight);
            }
            $price = 0;
            $flightObj->addPrice('adult', 'price', $priceAdult, 'IDR');
            $flightObj->addPrice('adult', 'tax', $taxAdult, 'IDR');
            if ($obj->data->child > 0) {
                $flightObj->addPrice('child', 'price', $priceChild, 'IDR');
                $flightObj->addPrice('child', 'tax', $taxChild, 'IDR');
            }
            if ($obj->data->infant > 0) {
                $flightObj->addPrice('infant', 'price', $priceInfant, 'IDR');
                $flightObj->addPrice('infant', 'tax', $taxInfant, 'IDR');
            }
            $flightCollection->add($flightObj);
            // dd($flightCode);
            // foreach ($flight as $flightDataKey => $flightDataValue) {
            //     // dd($flightDataValue);
            //     print_r($flightDataKey);
            //     echo ' = ';
            //     print_r($flightDataValue);
            //     echo "<br/>";
            //     // foreach ($flight_data as $flight_data2) {
            //     //     // print_r($flight_data2);
            //     //     echo '<br/>';
            //     //     foreach ($flight_data2 as $flight_data3) {
            //     //         print_r($flight_data3);
            //     //         echo '<br/>';
            //     //     }
            //     // }
            // }
            // echo "<br/>";
            // echo "<hr/>";
            // echo "<br/>";
        }
        // echo $city;
        // echo "<br/>";
        // echo $departure;
        // echo "<br/>";
        // echo $flightCode;
        // print_r($retval->DATA[0][0]);
        // echo "<br/>";
        return $flightCollection;
    }

    private function isValidFlight($flight)
    {
        if (count($flight->Segments) > 2) {
            return false;
        }
        return true;
    }
}
