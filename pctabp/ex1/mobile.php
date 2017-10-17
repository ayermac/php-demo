<?php
// 继承拥有比组合更少的代码量
class car {
    public function addoil() {
        echo "ADD oil", PHP_EOL;
    }
}

// 继承
class bmw extends car {

}

// 组合
class benz {
    public $car;
    public function __construct() {
        $this->car = new car();
    }

    public function addoil() {
        $this->car->addoil();
    }
}

$bmw = new bmw();
$bmw->addoil();

$benz = new benz();
$benz->addoil();