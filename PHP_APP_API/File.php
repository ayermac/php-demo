<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/10/9
 * Time: 22:30
 */
class File{

    private $_dir; // 存放缓存数据的文件夹

    const DS  = DIRECTORY_SEPARATOR;
    const EXT = '.txt';

    public function __construct()
    {
        $this->_dir = dirname(__FILE__) . self::DS . 'files' . self::DS;
    }

    public function cacheData($key, $value = '', $time = 0)
    {
        $filename = $this->_dir.$key.self::EXT;

        // 将 value 值写入缓存
        if ($value !== '') {
            // 清除缓存
            if (is_null($value)) {
                return unlink($filename);
            }

            $dir = dirname($filename);
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }

            $time = sprintf('%011d', $time);
            return file_put_contents($filename, $time.json_encode($value));
        }

        // 获取缓存
        if (!file_exists($filename)) {
            return false;
        }
        $contents = file_get_contents($filename);
        $time = (int)substr($contents, 0, 11);
        $value = substr($contents, 11);

        // 缓存失效
        if ($time !=0 && $time + filemtime($filename) < time()) {
            unlink($filename);
            return false;
        }
        return json_decode($value, true);
    }
}