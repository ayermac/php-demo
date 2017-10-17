<?php
$a = null;
try {
    $a = 5/0;
    echo $a,PHP_EOL;
} catch (exception $e) {
    $e->getMessage();
    $a = -1;
}
// echo $a;

class emailException extends exception {

}

class pwdException extends exception {
    function __toString() { // 改写抛出异常结果
        return "<div class='error'>Exception{$this->getCode()}: 
                {$this->getMessage()} in File: {$this->getFile()} on line: {$this->getLine()} </div>";
    }
}

function reg($reginfo = null) {
    if (empty($reginfo) || !isset($reginfo)) {
        throw new Exception("参数非法");
    }
    if (empty($reginfo['email'])) {
        throw new emailException("邮件为空");
    }
    if($reginfo['pwd'] != $reginfo['repwd']) {
        throw new pwdException("两次密码不一致");
    }
    echo "注册成功";
}

try {
    reg(array('email' => 'waitfox@qq.com', 'pwd' => 123456, 'repwd' => 12345678));
} catch (emailException $ee) {
    echo $ee->getMessage();
} catch (pwdException $ep) {
    echo $ep;
    echo PHP_EOL, '特殊处理';
} catch (Exception $e) {
    echo $e->getTraceAsString();
    echo PHP_EOL, '其他情况，统一处理';
}


// 合理的异常处理代码一
/*try {
    // 可能出错的代码段
    if (文件上传不成功) throw(上传异常);
    if (插入数据库不成功) throw(数据库操作异常);
} catch (异常) {
    必须的补救措施，如删除文件、删除数据库插入记录，这个处理很细致
}*/

/*// 合理的异常处理代码二
上传{
    if (文件上传不成功) throw(上传异常);
    if (插入数据库不成功) throw(数据库操作异常);
}
// 其他代码...
try{
    上传;
    其他;
} catch (上传异常) {
    必须的补救措施，如删除文件、删除数据库插入记录
} catch (其他异常) {
    记录日志
}*/