<?php
try {
    define('APPLICATION_PATH', dirname(__FILE__) . "/../");

    $application = new Yaf_Application(APPLICATION_PATH . "/conf/application.ini");

    $application->bootstrap()->run();
} catch (Exception $e) {
    Response::json(-999999, 'error.'. $e->getMessage());
}
?>
