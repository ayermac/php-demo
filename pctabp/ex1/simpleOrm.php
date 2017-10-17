<?php
// 简单ORM模型
abstract class ActiveRecord {
    protected static $table;
    protected $fieldvalues;
    public $select;

    static function findById($id) {
        $query = "SELECT * FROM "
            .static::table
            ." WHERE id = $id";
        return self::createDomain($query);
    }

    function __get($fieldname) {
        return $this->fieldvalues[$fieldname];
    }

    static function __callStatic($method, $args) {
        $field = preg_replace('/^findBy(\w*)$/', '${1}', $method);
        $query = "SELECT * FROM "
            .static::table
            ." WHERE $field = '$args[0]'";
        return self::createDomain($query);
    }

    private static function createDomain($query) {
        $klass = get_called_class();
        $domain = new $klass();
        $domain->fieldvalues = array();
        $domain->select = $query;
        foreach ($klass::$fields as $field => $type) {
            $domain->fieldvalues[$field] = 'TODO: set from sql result';
        }
        return $domain;
    }
}

class Customer extends ActiveRecord {
    protected static $table = 'custdb';
    protected static $fields = array(
        'id' => 'int',
        'email' => 'varchar',
        'lastname' => 'varchar'
    );
}

class Sales extends ActiveRecord {
    protected static $table = 'salesdb';
    protected static $fields = array(
        'id' => 'init',
        'item' => 'varchar',
        'qty' => 'int'
    );
}

assert("SELECT * FROM custdb WHERE id = 123" == Customer::findById(123)->select);
assert("TODO: set from sql result" == Customer::findById(123)->email);
assert("SELECT * FROM salesdb WHERE id = 321" == Customer::findByLastname('Denoncourt')->select);