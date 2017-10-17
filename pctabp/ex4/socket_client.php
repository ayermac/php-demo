<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/10/16
 * Time: 22:25
 */
$sock = fsockopen("192.168.0.5", 12345, $errno, $errstr, 1);

if (!$sock) {
    echo "$errstr ($errno)<br/>\n";
} else {
    socket_set_blocking($sock, false);
    fwrite($sock, "send data...\r\n");
    fwrite($sock, "end\r\n");

    while (!feof($sock)) {
        echo fread($sock, 128);
        flush();
        ob_flush();
        sleep(1);
    }
    fclose($sock);
}
