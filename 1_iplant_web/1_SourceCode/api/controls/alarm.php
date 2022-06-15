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
            case "add":
                $imei = isset($_POST['imei'])?$_POST['imei']:0;
                $set_time = $_POST['set_time'];
                $date_set = explode("T",$set_time)[0];
                $clock_set = explode("T",$set_time)[1];
                $flag_loop = $_POST['flag_loop'] == "on" ? 1 : 0;
                $flag_pump = $_POST['flag_pump'] == "on" ? 1 : 0;
                $flag_uv = $_POST['flag_uv'] == "on" ? 1 : 0;
                if(!empty($set_time)){
                    $Model->execute("insert into alarm (imei, time_set, date_set, clock_set, flag_loop, flag_pump, flag_uv) values ('$imei', '$set_time','$date_set','$clock_set', $flag_loop, $flag_pump, $flag_uv)");
                    $noti -> noti = "Thêm lịch thành công";
                }
                echo json_encode($noti);
                break;
            case "edit":
                $set_time = $_POST['set_time_edit'];
                $date_set = explode("T",$set_time)[0];
                $clock_set = explode("T",$set_time)[1];
                $imei = $_POST['imei_edit'];
                $id = $_GET['id'];
                $flag_loop = $_POST['flag_loop_edit'] == 'on' ? 1 : 0;
                $flag_pump = $_POST['flag_pump_edit'] == "on" ? 1 : 0;
                $flag_uv = $_POST['flag_uv_edit'] == "on" ? 1 : 0;
                if(!empty($set_time)){
                    mysqli_query($con,"update alarm set imei = '$imei', time_set = '$set_time', date_set='$date_set', clock_set='$clock_set',flag_loop = $flag_loop, flag_pump = $flag_pump, flag_uv = $flag_uv where id=$id");
                    $noti -> noti = "Sửa lịch thành công";
                }
                echo json_encode($noti);
                break;
            case "toggleLoop":
                if(isset($_GET['id'])){
                    $id = $_GET['id'];
                    $flag_loop = $_GET['flag_loop'] == "on" ? 1 : 0;
                    $Model -> execute("update alarm set flag_loop=$flag_loop where id=$id");
                    $noti -> noti = "Chỉnh sửa thành công";
                }
                echo json_encode($noti);
                break;
            case "delete":
                if(isset($_GET['id'])){
                    $id = $_GET['id'];
                    $Model->execute("delete from alarm where id=$id");
                    $noti -> noti = "Xoá lịch thành công";
                }
                echo json_encode($noti);
                break;
            case "getAlarms":
                $username =  $_GET['username'];
                if(isset($username)){
                    $alarms = $Model->fetch("select * from alarm where imei in (select imei from owned where username='$username')");
                    $sched_res = array();
                    foreach($alarms as $alarm){
                        $plant = $Model->fetchOne("select * from plants where imei='".$alarm['imei']."'");
                        $record['id'] = $alarm['id'];
                        $record['imei'] = $alarm['imei'];
                        $record['name'] = $plant['name'];
                        $record['img_url'] = $plant['img_url'];
                        $record['flag_loop'] = $alarm['flag_loop'];
                        $record['flag_pump'] = $alarm['flag_pump'];
                        $record['flag_uv'] = $alarm['flag_uv'];
                        $record['date'] = date("d-m",strtotime($alarm['time_set']));
                        $record['hour'] = date("h",strtotime($alarm['time_set']));
                        $record['minute'] = date("i",strtotime($alarm['time_set']));
                        array_push($sched_res, $record);
                    }
                    echo json_encode($sched_res);
                }
                break;
            case "getAlarm":
                $imei = $_POST['imei'];
                if(isset($imei)){
                    $alarms = $Model->fetch("select * from alarm where imei='$imei'");
                    $sched_res = array();
                    foreach($alarms as $alarm){
                        $plant = $Model->fetchOne("select * from plants where imei='$imei'");
                        $record['id'] = $alarm['id'];
                        $record['imei'] = $alarm['imei'];
                        $record['name'] = $plant['name'];
                        $record['img_url'] = $plant['img_url'];
                        $record['flag_loop'] = $alarm['flag_loop'];
                        $record['flag_pump'] = $alarm['flag_pump'];
                        $record['flag_uv'] = $alarm['flag_uv'];
                        $record['date'] = date("d-m",strtotime($alarm['time_set']));
                        $record['hour'] = date("h",strtotime($alarm['time_set']));
                        $record['minute'] = date("i",strtotime($alarm['time_set']));
                        array_push($sched_res, $record);
                    }
                    echo json_encode($sched_res);
                }
                break;
        }
    }
?>