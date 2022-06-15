<?php
    define('DB_SERVER', '188.166.181.100');
    define('DB_USERNAME', 'iplant');
    define('DB_PASSWORD', '3OJrCSbdpR5leDEF');
    define('DB_NAME', 'iplant');
    $con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    mysqli_set_charset($con, "utf8");
    $cookie_name = 'siteAuth';
    $cookie_time = (3600 * 24 * 30);    
    if($con === false){
        die("LỖI: Không thể kết nối với CSDL. ".mysqli_connect_error());
    }
?>