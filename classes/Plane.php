<?php

abstract class Plane {

    protected $airport = false;

    protected $name = 'Unnamed';
    protected $maxSpeed = 0;


    // Взлёт
    public function takeoff() {
        echo sprintf('[%s] [PLANE-INFO]: Попытка взлёта. Максимальная скорость: %d <br>', htmlspecialchars($this->name), intval($this->maxSpeed));

        if ($this->maxSpeed <= 0) {
            echo sprintf('[%s] [PLANE-INFO]: Попытка взлёта не удалась. Самолет слишком медленный. <br>', htmlspecialchars($this->name));
            return false;
        }

        if (!$this->airport) {
            echo sprintf('[%s] [PLANE-INFO]: Попытка взлёта не удалась. Самолёт уже находится в полёте <br>', htmlspecialchars($this->name));
            return false;
        }

        if ($this->airport->sendPlane($this)) {
            $this->airport = false;
            echo sprintf('[%s] [PLANE-INFO]: Попытка взлёта удалась. <br>', htmlspecialchars($this->name));
            return true;
        }

        return false;
    }

    // Посадка
    public function landing($airport) {
        echo sprintf('[%s] [PLANE-INFO]: Попытка посадки самолёта. <br>', htmlspecialchars($this->name));

        if (get_class($airport) != "Airport") {
            echo sprintf('[%s] [PLANE-INFO]: Попытка посадки самолёта провалена. Неверные аргументы. <br>', htmlspecialchars($this->name));
            return false;
        }

        if ($this->airport) {
            echo sprintf('[%s] [PLANE-INFO]: Попытка посадки самолёта провалена. Самолёт в аэропорту. <br>', htmlspecialchars($this->name));
            return false;
        }

        if ($airport->takePlane($this)) {
            echo sprintf('[%s] [PLANE-INFO]: Попытка посадки успешна. Теперь он в [%s]! <br>', htmlspecialchars($this->name), htmlspecialchars($airport->getName()));

            $this->airport = $airport;
            return true;
        }

        return false;
    }

    public function isInFlight() {
        return !$this->airport;
    }

    public function getName() {
        return $this->name;
    }

    public function getMaxSpeed() {
        return $this->maxSpeed;
    }

    public function getAirport() {
        return $this->airport;
    }
}