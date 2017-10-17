<?php
class mysql {
    function connect($db) {
        echo "连接到数据库${db[0]}\r\n";
    }
}

class sqlproxy {
    private $target;
    function __construct($tar) {
        $this->target[] = new $tar();
    }

    function __call($name, $args) {
        foreach($this->target as $obj) {
            $r = new ReflectionClass($obj);
            if ($method= $r->getMethod($name)) {
                if ($method->isPublic() && !$method->isAbstract()) {
                    echo "方法前拦截记录 LOG\r\n";
                    $method->invoke($obj, $args);
                    echo "方法后拦截\r\n";
                }
            }
        }
    }
}

$obj = new sqlproxy('mysql');
$obj->connect('member');