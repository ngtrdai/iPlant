<?php
    header("Content-Type: application/json");
    session_start();
    require_once "../../config/Config.php";
    include "../../config/Model.php";
    include "../../config/Token.php";

    $Model = new Model();
    $Token = new Token();

    $act = isset($_GET["act"])?$_GET["act"]:0;
    if($_SESSION['role'] == 'admin'){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            switch ($act){
                case "add1Chau":
                    $imei = $Token->generate(10);
                    $token = $Token->generate(20);
                    $img_url = "img_iplant_".rand(0,5);
                    $is_connected = 0;
                    $qr_code = "https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=".$imei;
                    $sql = "insert into plants (imei, img_url, token, is_connected, qr_code) values ('$imei', '$img_url', '$token', $is_connected, '$qr_code')";
                    $Model->execute($sql);
                    $Model->execute("insert into controls (imei) values ('$imei')");
                    $Model->execute("insert into led (imei) values ('$imei')");
                    $Model->execute("insert into pump (imei) values ('$imei')");
                    $Model->execute("insert into sensors (imei) values ('$imei')");
                    $Model->execute("insert into auto (imei) values ('$imei')");
                    echo json_encode("Thêm chậu thành công.");
                    break;
                case "addNChau":
                    for($i=0; $i < 5; $i++){
                        $imei = $Token->generate(10);
                        $token = $Token->generate(20);
                        $img_url = "img_iplant_".rand(0,5);
                        $is_connected = 0;
                        $qr_code = "https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=".$imei;
                        $sql = "insert into plants (imei, img_url, token, is_connected, qr_code) values ('$imei', '$img_url', '$token', $is_connected, '$qr_code')";
                        $Model->execute($sql);
                        $Model->execute("insert into controls (imei) values ('$imei')");
                        $Model->execute("insert into led (imei) values ('$imei')");
                        $Model->execute("insert into sensors (imei) values ('$imei')");
                        $Model->execute("insert into auto (imei) values ('$imei')");
                    }
                    echo json_encode("Thêm chậu thành công.");
                    break;
            }
            
        }
    }else{
        echo json_encode("Bạn không có quyền này.");
    }
    mysqli_close($con);
?>