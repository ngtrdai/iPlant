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
            $noti = new stdClass();
            if(!empty($imei)){
                $name = $_POST["name"];
                $img_url = $_POST["img_url"];
                if(!empty($name)){
                    $Model->execute("update plants set name='$name', img_url='$img_url' where imei='$imei'");
                    $noti -> noti = "Chỉnh sửa thông tin chậu thành công";
                }else{
                    $noti -> noti = "Tên bị null kìa Android Dev";
                }
                echo json_encode($noti);
            }
        }
    }
    mysqli_close($con);
?>