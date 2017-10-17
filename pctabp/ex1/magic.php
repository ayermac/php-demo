<?php
class Account {
    private $user = 1;
    private $pwd = 2;

    // 可以动态地 "创建" 类属性和方法
    public function __set ( $name, $value )
    {
        echo "Setting $name to $value \r\n";
        $this->$name = $value;
    }

    public function __get ( $name ) 
    {
        if ( !isset( $this->name ) ) {
            echo "未设置";
            $this->$name = "正在为你设置默认值";
        }
        return $this->$name;
    }

    // 动态创建不存在的方法
    public function __call ( $name, $arguments ) 
    {
        switch ( count( $arguments ) ) {
            case 2:
                echo $arguments[0]*$arguments[1], PHP_EOL;
                break;
            case 3:
                echo array_sum($arguments), PHP_EOL;
                break;
            default:
                echo '参数不对', PHP_EOL;
                break;
        }
    } 
}

// 私有属性不能外部调用, 除非设置了 __set 和 __get 魔术方法
$a = new Account();
echo $a->user;
$a->name = 5;
echo $a->name;
echo $a->big;

$a->make(5);
$a->make(5, 6);