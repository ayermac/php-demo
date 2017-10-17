<?php
/**
*缓存管理，项目经理定义接口，技术人员负责实现
*/
interface cache {
    const maxKey = 10000;                 // 最大换存量
    public function getc($key);           // 获取缓存
    public function setc($key, $value);   // 设置缓存
    public function flush();              // 清空缓存
}

