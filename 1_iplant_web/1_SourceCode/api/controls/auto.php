<?php
    header("Content-Type: application/json");
    session_start();
    require_once "../../config/Config.php";
    include "../../config/Model.php";
    $Model = new Model();
    $act = isset($_GET["act"])?$_GET["act"]:0;
    $noti = new stdClass();
    $noti -> noti = "";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        switch($act){
            case "edit":
                $imei = isset($_GET["imei"])?$_GET["imei"]:0;
                $soil_moisture = $_GET['soil_moisture'];
                $temperature_env = $_GET['temperature_env'];
                $light_sensor = $_GET['light_sensor'];
                if(isset($imei) && isset($soil_moisture) && isset($temperature_env) && isset($light_sensor)){
                    $sql = "update auto set soil_moisture = '$soil_moisture', temperature_env='$temperature_env',light_sensor='$light_sensor', is_updated=1 where imei='$imei'";
                    $Model -> execute($sql);
                    $Model->execute("update controls set is_updated_auto=1 where imei='$imei'");
                    $noti -> noti = "Cập nhật kịch bản thành công.";
                    echo json_encode($noti);
                }
                break;
            case "toggle":
                $imei = isset($_GET["imei"])?$_GET["imei"]:0;
                $turnOn = $_GET["turnOn"]=="true"?1:0;
                if(isset($imei)){
                    switch($turnOn){
                        case "0":
                            $sql = "update auto set status=0 where imei='$imei'";
                            $Model->execute($sql);
                            $Model->execute("update controls set is_updated_auto=1 where imei='$imei'");
                            $noti -> noti = "Tắt chế độ tự động thành công.";
                            break;
                        case "1":
                            $sql = "update auto set status=1 where imei='$imei'";
                            $Model->execute($sql);
                            $Model->execute("update controls set is_updated_auto=1 where imei='$imei'");
                            $noti -> noti = "Bật chế độ tự động thành công.";
                            break;
                    }
                }else{
                    $noti -> noti = "Địa chỉ IMEI không hợp lệ.";
                }
                echo json_encode($noti);
                break;
            case "getListAuto":
                $username = isset($_GET["username"])?$_GET["username"]:0;
                if(isset($username)){
                    $sql =  "select * from auto where imei in (select imei from owned where username='$username')";
                    $res = $Model->fetch($sql);
                    $autoList = array();
                    foreach($res as $auto){
                        $record['id'] = $auto['id'];
                        $record['imei'] = $auto['imei'];
                        $record['soil_moisture'] = $auto['soil_moisture'];
                        $record['temperature_env'] = $auto['temperature_env'];
                        $record['light_sensor'] = $auto['light_sensor'];
                        $record['is_updated'] = $auto['is_updated'];
                        $record['status'] = $auto['status'];
                        array_push($autoList, $record);
                    }
                    echo json_encode($autoList);
                }
                break;
            case "getAuto":
                $imei = isset($_GET["imei"])?$_GET["imei"]:0;
                if(isset($_GET["imei"])){
                    $sql =  "select * from auto where imei = '$imei'";
                    $auto = $Model->fetchOne($sql);
                    $autoList = array();
                    $record['id'] = $auto['id'];
                    $record['imei'] = $auto['imei'];
                    $record['soil_moisture'] = $auto['soil_moisture'];
                    $record['temperature_env'] = $auto['temperature_env'];
                    $record['light_sensor'] = $auto['light_sensor'];
                    $record['is_updated'] = $auto['is_updated'];
                    $record['status'] = $auto['status'];
                    array_push($autoList, $record);
                    echo json_encode($autoList);
                }
                break;
        }
    }
?>