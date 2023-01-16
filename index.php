<?php

require_once('classes/MIGPlane.php');
require_once('classes/TU154Plane.php');
require_once("classes/Airport.php");

$sheremetievoAirport = new Airport('Sheremetievo');
$moscowCityAirport = new Airport('MoscowCity');

$plane = $sheremetievoAirport->createPlane('MIG', 'TESTMIG1', 300);

$sheremetievoAirport->prepareToFlight($plane);

$plane->takeoff();
$plane->attack();
$plane->landing($moscowCityAirport);

$moscowCityAirport->prepareToFlight($plane);
$moscowCityAirport->parkPlane($plane);