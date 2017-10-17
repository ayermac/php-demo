<?php
/**
*通过接口实现多态
*/
interface employee {
    public function working();
}

class teacher implements employee {
    public function working() {
        echo '教书';
    }
}

class coder implements employee {
    public function working() {
        echo '敲代码';
    }
}

function doprint(employee $i) {
    $i->working();
}

$a = new teacher();
$b = new coder();

doprint($a);
doprint($b);