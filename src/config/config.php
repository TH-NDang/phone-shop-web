<?php
function getenv_docker($env, $default)
{
    if ($fileEnv = getenv($env . '_FILE')) {
        return rtrim(file_get_contents($fileEnv), "\r\n");
    } else if (($val = getenv($env)) !== false) {
        return $val;
    } else {
        return $default;
    }
}

define('DB_HOST', getenv_docker('MYSQL_HOST', 'db'));
define('DB_NAME', getenv_docker('MYSQL_DATABASE', 'phone_shop'));
define('DB_PORT', getenv_docker('MYSQL_PORT', '3306'));
define('DB_USER', getenv_docker('MYSQL_USER', 'user'));
define('DB_PASS', getenv_docker('MYSQL_PASSWORD', 'password'));
