<?php
    header("Content-Type: application/json");
    session_start();
    require_once "../../config/Config.php";
    include "../../config/Model.php";
    $Model = new Model();
    $username = isset($_GET["username"])?$_GET["username"]:0;
    $imei = isset($_GET["imei"])?$_GET["imei"]:0;
    if(True){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            switch($_GET['act']){
                case 'pump':
                    $Model->execute("update controls set is_pump = 1, is_updated = 1 where imei='$imei'");
                    echo json_encode("Đã bật tưới cây");
                    break;
                case 'led':
                    $Model->execute("update controls set is_led_noti = 1, is_updated = 1 where imei='$imei'");
                    echo json_encode("Đã bật LED tín hiệu");
                    break;
                case 'pumpAll':
                    $Model->execute("update controls set is_pump = 1, is_updated = 1 where imei in (select imei from owned where username='$username')");                   
                    echo json_encode("Đã tưới tất cả các cây.");
                    break;
                case 'uvAll':
                    $Model->execute("update controls set is_led_uv = 1, is_updated = 1 where imei in (select imei from owned where username='$username')");                   
                    echo json_encode("Đã bật đèn quang hợp tất cả.");
                    break;
                case 'turnLED':
                    $toggle = $_GET['toggle'];
                    if(isset($toggle)){
                        switch($toggle){
                            case 'on':
                                $Model->execute("update controls set is_led_noti = 1, is_updated = 1 where imei='$imei'");
                                echo json_encode("Đã bật LED tín hiệu");
                                break;
                            case 'off':
                                $Model->execute("update controls set is_led_noti = 0, is_updated = 1 where imei='$imei'");
                                echo json_encode("Đã tắt LED tín hiệu");
                                break;
                        }
                    }
                    break;
                case 'turnUV':
                    $toggle = $_GET['toggle'];
                    if(isset($toggle)){
                        switch($toggle){
                            case 'on':
                                $Model->execute("update controls set is_led_uv = 1, is_updated = 1 where imei='$imei'");
                                echo json_encode("Đã bật đèn quang hợp");
                                break;
                            case 'off':
                                $Model->execute("update controls set is_led_uv = 0, is_updated = 1 where imei='$imei'");
                                echo json_encode("Đã tắt đèn quang hợp");
                                break;
                        }
                    }
                    break;
            }
        }
    }
    mysqli_close($con);
?>