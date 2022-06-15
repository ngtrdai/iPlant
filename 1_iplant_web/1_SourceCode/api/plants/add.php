<?php
    header("Content-Type: application/json");
    session_start();
    require_once "../../config/Config.php";
    include "../../config/Model.php";
    include "../../config/Token.php";

    $Model = new Model();
    $Token = new Token();
    $username = $_GET["username"];
    $act = isset($_GET["act"])?$_GET["act"]:0;
    $noti = new stdClass();
    $noti -> noti = "";
    if(True){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            if($act == "add" and isset($username) and isset($_POST['imei'])){
                $imei = $_POST['imei'];
                $checkImei = $Model->count("select * from plants where imei='$imei'");
                $checkImei_owned = $Model->count("select * from owned where imei='$imei' and username='$username'");
                if($checkImei_owned == 0 and $checkImei == 1){
                    $token = $Token->generate(10);
                    $sql = "insert into owned (username, imei, token) values ('$username', '$imei', '$token')";
                    $Model->execute($sql);
                    $noti -> noti = "Thêm chậu thành công.";
                    echo json_encode($noti);
                }elseif($checkImei_owned == 1){
                    $noti -> noti = "Bạn đã sở hữu chậu này.";
                    echo json_encode($noti);
                }elseif($checkImei == 0){
                    $noti -> noti = "IMEI không tìm thấy.";
                    echo json_encode($noti);
                }                
            }
        }
    }
?>