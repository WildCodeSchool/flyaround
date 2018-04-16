<?php

/**
 * FlightInfo service file
 *
 * PHP Version 7.1
 *
 * @category Service
 * @package  Service
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */

namespace AppBundle\Service;

/**
 * FlightInfo class service.
 *
 * @category Service
 * @package  Service
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */
class FlightInfo
{
    /**
     * @var string
     */
    private $unit;

    /**
     * Constructor
     *
     * @param string $unit Defined in config.yml
     */
    public function __construct($unit)
    {
        $this->unit = $unit;
    }

    /**
     * Distance calculation between latitude/longitude based on Harnive's formula
     * http://www.codecodex.com/wiki/Calculate_Distance_Between_Two_Points_on_a_Globe#PHP
     *
     * @param float $latitudeFrom  Departure
     * @param float $longitudeFrom Departure
     * @param float $latitudeTo    Arrival
     * @param float $longitudeTo   Arrival
     *
     * @return float
     */
    public function getDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo)
    {
        $d = 0;
        $earth_radius = 6371;
        $dLat = deg2rad($latitudeTo - $latitudeFrom);
        $dLon = deg2rad($longitudeTo - $longitudeFrom);

        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($latitudeFrom))
            * cos(deg2rad($latitudeTo)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * asin(sqrt($a));

        switch ($this->unit) {
        case 'km':
            $d = $c * $earth_radius;
            break;
        case 'mi':
            $d = $c * $earth_radius / 1.609344;
            break;
        case 'nmi':
            $d = $c * $earth_radius / 1.852;
            break;
        }

        return $d;
    }

    /**
     * Calculate a flight time with distance and plane cruise speed
     *
     * @param float   $distance    Distance between departure and arrival
     * @param integer $cruiseSpeed Plane's cruise speed
     *
     * @return float
     */
    public function getTime($distance, $cruiseSpeed)
    {
        return round(($distance / $cruiseSpeed) * 60);
    }
}
