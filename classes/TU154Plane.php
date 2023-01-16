<?php
require_once('Plane.php');

class TU154Plane extends Plane {
    public function __construct($name = 'TU154Plane', $maxSpeed = 950, $airport = false) {
        $this->name = $name;
        $this->maxSpeed = $maxSpeed;
        $this->airport = $airport;
    }
}