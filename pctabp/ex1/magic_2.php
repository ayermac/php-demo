<?php
class Account {
    public $user = 1;
    private $pwd = 2;

    // 自定义的格式化输出方法
    public function __toString() {
        return "当前对象的用户名是 {$this->user} , 密码是 {$this->pwd}";
    }
}

$a = new Account();
echo $a;
echo PHP_EOL;
print_r($a);