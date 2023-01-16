<?php
require_once('Plane.php');

class MIGPlane extends Plane {
    public function __construct($name = 'MIGPlane', $maxSpeed = 2500, $airport = false) {
        $this->name = $name;
        $this->maxSpeed = intval($maxSpeed);
        $this->airport = $airport;
    }

    public function attack() {
        if (!$this->airport) {
            echo sprintf('[%s] [PLANE-INFO]: Произведен выстрел.<br>', htmlspecialchars($this->name));
            return true;
        } else {
            echo sprintf('[%s] [PLANE-INFO]: Выстрел запрещен, самолёт находится в аэропорту.<br>', htmlspecialchars($this->name));
            return false;
        }
    }
}