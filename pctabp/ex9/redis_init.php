<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/10/24
 * Time: 21:12
 */
/**
 * PHP Redis 基础使用
 */
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);

/**
 * String (字符串)操作
 */
//设置 Redis 字符串数据
//$result = $redis->set('key', 'value');

//获取 Redis 字符串数据
//$result = $redis->get('key');
//var_dump($result); // value

//删除指定的键
//$redis->delete('key');

//将 key 的值设为 value ，当且仅当 key 不存在。
//若给定的 key 已经存在，则 SETNX 不做任何动作。
//$redis->set('key', '666');
//$redis->setnx('key', '888');
//echo $redis->get('key'); // 结果：666
//$redis->delete('key');
//$redis->setnx('key',"888");
//echo $redis->get('key');  //结果：888

// 检查给定 key 是否存在。
//$redis->set('key', '666');
//var_dump($redis->exists('key')); // 结果：bool(true)

//将 key 中储存的数字值增一。
//如果 key 不存在，那么 key 的值会先被初始化为 0 ，然后再执行 INCR 操作。
//$redis->set('key', '1');
//var_dump($redis->incr('key')); // 结果：int(2)

//将 key 中储存的数字值减一。
//如果 key 不存在，那么 key 的值会先被初始化为 0 ，然后再执行 DECR 操作。
//$redis->set('key', '2');
//var_dump($redis->decr('key')); // 结果：int(1)

//取得所有指定键的值。如果一个或多个键不存在，该数组中该键的值为假
//$redis->set('key1', '1');
//$redis->set('key2', '2');
//$result = $redis->getMultiple(array('key1', 'key2'));
//print_r($result);// 结果：Array ( [0] => 1 [1] => 2 )
//////////////////////////////////////////////////////////////////////////////////////

/**
 * List (列表)操作
 */
//将一个或多个值 value 插入到列表 key 的表头
//如果有多个 value 值，那么各个 value 值按从左到右的顺序依次插入到表头
//如果 key 不存在，一个空列表会被创建并执行 LPUSH 操作。
//当 key 存在但不是列表类型时，返回一个错误。
//$redis->delete('key');
//var_dump($redis->lPush('key', '123'));//结果：int(1)
//var_dump($redis->lPush('key', '456'));//结果：int(2)

//将一个或多个值 value 插入到列表 key 的表尾(最右边)。
//如果有多个 value 值，那么各个 value 值按从左到右的顺序依次插入到表尾。
//如果 key 不存在，一个空列表会被创建并执行 RPUSH 操作。
//当 key 存在但不是列表类型时，返回一个错误。
//$redis->delete('key');
//var_dump($redis->lPush('key', '123'));//结果：int(1)
//var_dump($redis->lPush('key', '456'));//结果：int(2)
//var_dump($redis->rPush('key', '789'));//结果：int(3)
//var_dump($redis->rPush('key', '012'));//结果：int(4)

//移除并返回列表 key 的头元素。
//$redis->delete('key');
//$redis->lpush("key","123");
//$redis->lpush("key","456");
//$redis->rpush("key","789");
//$redis->rpush("key","012");
//var_dump($redis->lpop("key"));  //结果：string(3) "456"

//返回的列表的长度。如果列表不存在或为空，该命令返回0。如果该键不是列表，该命令返回FALSE。
//$redis->delete('key');
//$redis->lpush("key","123");
//$redis->lpush("key","456");
//$redis->rpush("key","789");
//$redis->rpush("key","012");
//var_dump($redis->lsize("key"));  //结果：int(4)
//var_dump($redis->llen("key"));  //结果：int(4)

//返回指定键存储在列表中指定的元素。 0第一个元素，1第二个… -1最后一个元素，-2的倒数第二…错误的索引或键不指向列表则返回FALSE。
//$redis->delete('key');
//$redis->lpush("key","123");
//$redis->lpush("key","456");
//$redis->rpush("key","789");
//$redis->rpush("key","012");
//var_dump($redis->lGet("key", 3));  //结果：string(3) "012"

//为列表指定的索引赋新的值,若不存在该索引返回false.
//$redis->delete('key');
//$redis->lpush("key","123");
//$redis->lpush("key","456");
//var_dump($redis->lget("key",1));  //结果：string(3) "123"
//var_dump($redis->lset("key",1,"666"));  //结果：bool(true)
//var_dump($redis->lget("key",1));  //结果：string(3) "666"

//返回在该区域中的指定键列表中开始到结束存储的指定元素，lGetRange(key, start, end)。0第一个元素，1第二个元素… -1最后一个元素，-2的倒数第二…
//$redis->delete('key');
//$redis->lpush("key","123");
//$redis->lpush("key","456");
//print_r($redis->lgetrange("key",0,-1));  //结果：Array ( [0] => 456  [1] => 123 )

//从列表中从头部开始移除count个匹配的值。如果count为零，所有匹配的元素都被删除。如果count是负数，内容从尾部开始删除。
//$redis->delete('key');
//$redis->lpush('key','a');
//$redis->lpush('key','b');
//$redis->lpush('key','c');
//$redis->rpush('key','a');
//print_r($redis->lgetrange('key', 0, -1)); //结果：Array ( [0] => c [1] => b [2] => a [3] => a )
//var_dump($redis->lremove('key','a',2));   //结果：int(2)
//print_r($redis->lgetrange('key', 0, -1)); //结果：Array ( [0] => c [1] => b )
//////////////////////////////////////////////////////////////////////////////////////

/**
 * Set (集合)操作
 */
//为一个Key添加一个值。如果这个值已经在这个Key中，则返回FALSE。
//$redis->delete('key');
//var_dump($redis->sadd('key','111'));   //结果：bool(true)
//var_dump($redis->sadd('key','333'));   //结果：bool(true)
//print_r($redis->sort('key')); //结果：Array ( [0] => 111 [1] => 333 )

//删除Key中指定的value值
//$redis->delete('key');
//$redis->sadd('key','111');
//$redis->sadd('key','333');
//$redis->sremove('key','111');
//print_r($redis->sort('key'));    //结果：Array ( [0] => 333 )

//将Key1中的value移动到Key2中
//$redis->delete('key');
//$redis->delete('key1');
//$redis->sadd('key','111');
//$redis->sadd('key','333');
//$redis->sadd('key1','222');
//$redis->sadd('key1','444');
//$redis->smove('key',"key1",'111');
//print_r($redis->sort('key1'));    //结果：Array ( [0] => 111 [1] => 222 [2] => 444 )

//检查集合中是否存在指定的值。
//$redis->delete('key');
//$redis->sadd('key','111');
//$redis->sadd('key','112');
//$redis->sadd('key','113');
//var_dump($redis->scontains('key', '111')); //结果：bool(true)

//返回集合中存储值的数量
//$redis->delete('key');
//$redis->sadd('key','111');
//$redis->sadd('key','112');
//echo $redis->ssize('key');   //结果：2

//随机移除并返回key中的一个值
//$redis->delete('key');
//$redis->sadd("key","111");
//$redis->sadd("key","222");
//$redis->sadd("key","333");
//var_dump($redis->spop("key"));  //结果：string(3) "333"

//返回一个所有指定键的交集。如果只指定一个键，那么这个命令生成这个集合的成员。如果不存在某个键，则返回FALSE。
//$redis->delete('key');
//$redis->delete('key1');
//$redis->sadd("key","111");
//$redis->sadd("key","222");
//$redis->sadd("key","333");
//$redis->sadd("key1","111");
//$redis->sadd("key1","444");
//var_dump($redis->sinter("key","key1"));  //结果：array(1) { [0]=> string(3) "111" }

//执行sInter命令并把结果储存到新建的变量中。
//$redis->delete('key');
//$redis->delete('key1');
//$redis->sadd("key","111");
//$redis->sadd("key","222");
//$redis->sadd("key","333");
//$redis->sadd("key1","111");
//$redis->sadd("key1","444");
//var_dump($redis->sinterstore('new',"key","key1"));  //结果：int(1)
//var_dump($redis->smembers('new'));  //结果:array(1) { [0]=> string(3) "111" }

//返回一个所有指定键的并集
//$redis->delete('key');
//$redis->delete('key1');
//$redis->sadd("key","111");
//$redis->sadd("key","222");
//$redis->sadd("key","333");
//$redis->sadd("key1","111");
//$redis->sadd("key1","444");
//print_r($redis->sunion("key","key1"));  //结果：Array ( [0] => 111 [1] => 222 [2] => 333 [3] => 444 )

//执行sunion命令并把结果储存到新建的变量中。
//$redis->delete('key');
//$redis->delete('key1');
//$redis->delete('new');
//$redis->sadd("key","111");
//$redis->sadd("key","222");
//$redis->sadd("key","333");
//$redis->sadd("key1","111");
//$redis->sadd("key1","444");
//var_dump($redis->sunionstore('new',"key","key1"));  //结果：int(4)
//print_r($redis->smembers('new'));  //结果:Array ( [0] => 111 [1] => 222 [2] => 333 [3] => 444 )

//返回第一个集合中存在并在其他所有集合中不存在的结果
//$redis->delete('key');
//$redis->delete('key1');
//$redis->sadd("key","111");
//$redis->sadd("key","222");
//$redis->sadd("key","333");
//$redis->sadd("key1","111");
//$redis->sadd("key1","444");
//print_r($redis->sdiff("key","key1"));  //结果：Array ( [0] => 222 [1] => 333 )

//执行sdiff命令并把结果储存到新建的变量中。
//$redis->delete('key');
//$redis->delete('key1');
//$redis->delete('new');
//$redis->sadd("key","111");
//$redis->sadd("key","222");
//$redis->sadd("key","333");
//$redis->sadd("key1","111");
//$redis->sadd("key1","444");
//var_dump($redis->sdiffstore('new',"key","key1"));  //结果：int(2)
//print_r($redis->smembers('new'));  //结果:Array ( [0] => 222 [1] => 333 )

//返回集合的内容
//$redis->delete('key');
//$redis->sadd("key","111");
//$redis->sadd("key","222");
//print_r($redis->smembers('key'));  //结果:Array ( [0] => 111 [1] => 222 )
//////////////////////////////////////////////////////////////////////////////////////