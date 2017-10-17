<?php
class employee {
    protected function working() {
        echo "本方法需要重载才能运行";
    }
}

class teacher extends employee {
    public function working() {
        echo "教书";
    }
}

class coder extends employee {
    public function working() {
        echo "敲代码";
    }
}

function doprint($obj) {
    if (get_class($obj) == 'employee') {
        echo "Error";
    } else {
        $obj->working();
    }
}

doprint(new teacher());
doprint(new coder());
doprint(new employee());