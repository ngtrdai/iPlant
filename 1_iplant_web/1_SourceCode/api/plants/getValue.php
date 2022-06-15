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
                case 'sensors':
                    $sensorsValue = new stdClass();
                    $sql = "select * from (select * from sensors where imei='$imei' order by id desc limit 25) sub order by id asc";
                    $namePlant = $Model->fetchOne("select name, img_url from plants where imei='$imei'");
                    $sensorsValue -> name = $namePlant['name'];
                    $sensorsValue -> img_url = $namePlant['img_url'];
                    $values = $Model->fetch($sql);
                    $sched_res = array();
                    foreach($values as $value){
                        $record['imei'] = $value['imei'];
                        $record['soil_moisture'] = $value['soil_moisture'];
                        $record['temperature_env'] = $value['temperature_env'];
                        $record['light_sensor'] = $value['light_sensor'];
                        $record['water_level'] = $value['water_level'];
                        $record['updated_at'] = $value['updated_at'];
                        array_push($sched_res, $record);
                    }
                    $sensorsValue -> value = $sched_res;
                    echo json_encode($sensorsValue);
                    break;
                case 'getStatusLED':
                    $sql = "select is_led_noti, is_led_uv from controls where imei='$imei'";
                    $status = $Model->fetchOne($sql);
                    echo json_encode($status);
                    break;
                case 'getMyPlants':
                    $sql = "select * from plants where imei in (select imei from owned where username='".$username."')";
                    $myPlants = $Model->fetch($sql);
                    echo json_encode($myPlants);
                    break;
                case 'countPlants':
                    $sql = "select * from plants where imei in (select imei from owned where username='".$username."')";
                    $counts = $Model->count($sql);
                    echo json_encode($counts);
                    break;
                case 'getAll':
                    $dataX = new stdClass();
                    $sql = "select * from (select * from sensors where imei='$imei' order by id desc limit 25) sub order by id asc";
                    $datas = $Model->fetch($sql);
                    $sched_res = array();
                    foreach($datas as $data){
                        $record['soil_moisture'] = $data['soil_moisture'];
                        $record['temperature_env'] = $data['temperature_env'];
                        $record['light_sensor'] = $data['light_sensor'];
                        $record['water_level'] = $data['water_level'];
                        $record['updated_at'] = $data['updated_at'];
                        array_push($sched_res, $record);
                    }
                    $dataX->data=$sched_res;
                    echo json_encode($dataX);
                    break;
            }
        }
    }
    mysqli_close($con);
?>