<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/10/16
 * Time: 22:25
 */
/**
 * Socket 客户端
 */
$sock = fsockopen("192.168.0.5", 12345, $errno, $errstr, 1);

if (!$sock) {
    echo "$errstr ($errno)<br/>\n";
} else {
    socket_set_blocking($sock, false);
    fwrite($sock, "send data...\r\n");
    /**
     * 注意: 数据末尾需要加上"\r\n" 提交此请求数据，否则可能将无法获取服务端的回应，
     * 即使刷新缓冲也无效，这样就只有等到此连接关闭时才能获取到回应
     * 使用 end 命令终止此客户端的连接
     */
    fwrite($sock, "end\r\n");

    while (!feof($sock)) {
        echo fread($sock, 128);
        flush();
        ob_flush();
        sleep(1);
    }
    fclose($sock);
}
