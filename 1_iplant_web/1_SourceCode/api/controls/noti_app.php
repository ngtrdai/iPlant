<?php
    header("Content-Type: application/json");
    session_start();
    require_once "../../config/Config.php";
    include "../../config/Model.php";
    $Model = new Model();
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_GET['act'])){
            $act = isset($_GET["act"])?$_GET["act"]:0;
            switch($act){
                case 'getNotis':
                    $username = $_GET["username"];
                    $sql = "select * from (select * from notification where imei in (select imei from owned where username='$username') order by created_at desc limit 25) sub order by id desc";
                    $values = $Model->fetch($sql);
                    $count = $Model->count($sql);
                    $output = array();
                    $noti = new stdClass();
                    if($count > 0){
                        foreach($values as $value){
                            $plant = $Model->fetchOne("select img_url, name from plants where imei ='".$value['imei']."'");
                            $record['img_url'] = $plant['img_url'];
                            $record['title'] = $value['title'] ." - " . $plant['name'];;
                            $record['content'] = $value['content'];
                            $record['created_at'] = $value['created_at'];
                            array_push($output, $record);
                        }
                    }
                    $noti -> data = $output;
                    echo json_encode($noti);
                    break;
            } 
        }
    }
?>