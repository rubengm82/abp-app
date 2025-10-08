<?php
phpinfo();

echo "Test";
function logger($level) {
    $datetime = date('Y-m-d H:i:s');
    $uri = $_SERVER['REQUEST_URI'] ?? '';
    $message = "$datetime $uri - Called logger with level: $level\n";
    error_log("TESTRRRR", 0);
}

logger("infoaaaaaaaaaaaaaaaaaaaaaaaa");
syslog(LOG_INFO, "Test syslog");
?>