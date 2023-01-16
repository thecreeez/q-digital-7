<?php
class Airport {

    protected $planesInPark = array();
    protected $planesReadyToFlight = array();
    protected $name;

    public function __construct($name = 'UnnamedAirport') {
        $this->name = $name;
    }

    /**
     * Принять самолет
     * $plane - Самолет
     */
    public function takePlane($plane) {
        if (get_parent_class($plane) != "Plane") {
            echo sprintf('[%s] [AIRPORT-INFO]: Самолёт не получилось принять. Не наследуется от "Plane" <br>', htmlspecialchars($this->name), htmlspecialchars($plane->getName()));
            return false;
        }

        echo sprintf('[%s] [AIRPORT-INFO]: Cамолёт [%s] теперь находится в аэропорту <br>', htmlspecialchars($this->name), htmlspecialchars($plane->getName()));
        array_push($this->planesInPark, $plane);

        $this->printPlanes();
        return true;
    }

    /**
     * Самолет освободил место и улетел
     * $plane - Самолет
     */
    public function sendPlane($plane) {
        $key = array_search($plane, $this->planesReadyToFlight);

        if ($key !== false) {
            echo sprintf('[%s] [AIRPORT-INFO]: Cамолёт [%s] вылетел <br>', htmlspecialchars($this->name), htmlspecialchars($plane->getName()));
            unset($this->planesReadyToFlight[$key]);

            $this->printPlanes();
            return true;
        } else {
            echo sprintf('[%s] [AIRPORT-INFO]: Cамолёт [%s] не может вылететь т.к. он не обнаружен среди готовых к вылету (airport->prepareToFlight(plane)) <br>', htmlspecialchars($this->name), htmlspecialchars($plane->getName()));
            return false;
        }
    }

    /**
     * Самолет ушел на стоянку
     * $plane - Самолет
     */
    public function parkPlane($plane) {
        $key = array_search($plane, $this->planesReadyToFlight);

        if ($key !== false) {
            echo sprintf('[%s] [AIRPORT-INFO]: Cамолёт [%s] припаркован. <br>', htmlspecialchars($this->name), htmlspecialchars($plane->getName()));

            array_push($this->planesInPark, $this->planesReadyToFlight[$key]);
            unset($this->planesReadyToFlight[$key]);

            $this->printPlanes();
            return true;
        } else {
            echo sprintf('[%s] [AIRPORT-INFO]: Cамолёт [%s] не может быть подготовлен к полёту т.к. он не обнаружен среди готовых к вылету (airport->prepareToFlight(plane)/plane->landing(airport)) <br>', htmlspecialchars($this->name), htmlspecialchars($plane->getName()));
            return false;
        }
    }

    /**
     * Самолет готов взлетать (Подготовить самолет к взлёту)
     * $plane - Самолет
     */
    public function prepareToFlight($plane) {
        $key = array_search($plane, $this->planesInPark);

        if ($key !== false) {
            echo sprintf('[%s] [AIRPORT-INFO]: Cамолёт [%s] приготовлен к полёту. <br>', htmlspecialchars($this->name), htmlspecialchars($plane->getName()));

            array_push($this->planesReadyToFlight, $this->planesInPark[$key]);
            unset($this->planesInPark[$key]);

            $this->printPlanes();
            return true;
        } else {
            echo sprintf('[%s] [AIRPORT-INFO]: Cамолёт [%s] не может быть подготовлен к полёту т.к. он не обнаружен на стоянке (airport->parkPlane(plane)/plane->landing(airport)) <br>', htmlspecialchars($this->name), htmlspecialchars($plane->getName()));
            return false;
        }
    }

    /**
     * Вывод всех самолётов
     */
    public function printPlanes() {
        if (empty($this->planesReadyToFlight) && empty($this->planesInPark)) {
            echo sprintf("[%s] [AIRPORT-INFO]: Аэропорт не содержит самолётов<br>", $this->name);
            return;
        }

        echo sprintf("[%s] [AIRPORT-INFO]: Самолёты в аэропорту: <br>", $this->name);
        echo "-----------------------------------------------<br>";
        foreach($this->planesReadyToFlight as $plane) {
            echo sprintf("| [%s] - %s <br>", $plane->getName(), "Готов к вылету");
        }
        foreach($this->planesInPark as $plane) {
            echo sprintf("| [%s] - %s <br>", $plane->getName(), "Припаркован");
        }

        echo "-----------------------------------------------<br>";
    }

    public function getName() {
        return $this->name;
    }

    /**
     * Собрать самолет
     * $type - Тип самолета (MIG/TU154)
     * $name - Имя самолета (String)
     * $maxSpeed - Максимальная скорость самолета (int)
     */
    public function createPlane($type, $name = 'CreatedPlane', $maxSpeed = 500) {
        if (!class_exists($type.'Plane')) {
            echo sprintf('[%s] [AIRPORT-INFO]: Не удалось собрать самолёт, Неизвестный тип [%s], Варианты: [MIG, TU154] <br>', htmlspecialchars($type));    
            return false;
        }

        $planeType = $type.'Plane';

        echo sprintf('[%s] [AIRPORT-INFO]: Собран самолёт [%s] типа [%s] со скоростю [%d] <br>', htmlspecialchars($this->name),htmlspecialchars($name), htmlspecialchars($type), intval($maxSpeed));    
        $plane = new $planeType($name, intval($maxSpeed), $this);
        $this->takePlane($plane);

        return $plane;
    }
}