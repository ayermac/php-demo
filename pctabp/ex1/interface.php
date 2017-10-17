<?php
interface mobile {
    public function run(); // 驱动方法
}

class plain implements mobile {
    public function run() {
        echo "我是飞机";
    }

    public function fly() {
        echo "飞行";
    }
}

class car implements mobile {
    public function run() {
        echo "我是汽车\r\n";
    }
}

class machine {
    function demo(mobile $a) {
        $a->fly(); // mobile 接口是没有这个方法的
    }
}

$obj = new machine();
$obj->demo(new plain()); // 运行成功
$obj->demo(new car()); // 运行失败