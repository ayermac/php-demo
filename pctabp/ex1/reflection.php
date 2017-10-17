<?php
// 反射Api
class person {
    public $name;
    public $gender;
    public function say() {
        echo $this->name, " \tis ", $this->gender, "\r\n";
    }

    public function __set ( $name, $value ) {
        echo "Setting $name to $value \r\n";
        $this->$name = $value;
    }

    public function __get ( $name ) {
        if ( !isset( $this->name ) ) {
            echo "未设置";
            $this->$name = "正在为你设置默认值";
        }
        return $this->$name;
    }
}

$student = new person();
$student->name = 'Tom';
$student->gender = 'male';
$student->age = 24;

// 获取对象属性列表
$reflect = new ReflectionObject($student);
$props   = $reflect->getProperties();
foreach($props as $prop) {
    print $prop->getName(). "\n";
}

// 获取对象方法列表
$m = $reflect->getMethods();
foreach($m as $prop) {
    print $prop->getName(). '\n';
}

// 也可以不用反射api
// 返回对象属性的关联数组
var_dump(get_object_vars($student));
// 类属性
var_dump(get_class_vars(get_class($student)));
// 返回由类方法名组成的数组
var_dump(get_class_methods(get_class($student)));

// 获取对象属性列表所属的类
echo get_class($student);

/**
*通过反射获取类的原型
*/
$obj = new ReflectionClass('person');
$className = $obj->getName();
$Methods = $Propertes = array();
foreach($obj->getProperties() as $v) {
    $Propertes[$v->getName()] = $v;
}
foreach($obj->getMethods() as $v) {
    $Methods[$v->getName()] = $v;
}

echo "class {$className}\n{\n";
is_array($Propertes) && ksort($Propertes);

foreach($Propertes as $k => $v) {
    echo "\t";
    echo $v->isPublic() ? ' public' : '' , $v->isPrivate() ? ' private' : '',
    $v->isProtected() ? ' protected' : '',
    $v->isStatic() ? ' static' : '';
    echo "\t{$k}\n";
}

echo "\n";
if (is_array($Methods)) ksort($Methods);
foreach($Methods as $k => $v) {
    echo "\tfunction {$k}() {}\n";
}

echo "}\n";