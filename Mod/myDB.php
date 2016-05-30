<?php

define("HOST","localhost");
define("USER_ID","root");
define("USER_PW","1234");
define("DB_NAME","jsy");

function db_connection()
{
    $db_connect=mysqli_connect(HOST,USER_ID,USER_PW);
    mysqli_select_db($db_connect,DB_NAME);

    return $db_connect;
}



?>