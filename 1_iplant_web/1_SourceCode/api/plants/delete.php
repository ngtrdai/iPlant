<?php
    header("Content-Type: application/json");
    session_start();
    require_once "../../config/Config.php";
    include "../../config/Model.php";
    $Model = new Model();
    $username = isset($_GET["username"])?$_GET["username"]:0;
    $imei = isset($_GET["imei"])?$_GET["imei"]:0;
    $noti = new stdClass();
    if(True){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            if(!empty($imei)){
                $checkImei_owned = $Model->count("select * from owned where imei='$imei' and username='$username'");
                if($checkImei_owned == 1){
                    $Model->execute("delete from owned where imei='$imei' and username='$username'");
                    $noti -> noti = "Xoá chậu cây thành công";
                    echo json_encode($noti);
                }else{
                    $noti -> noti = "Không tìm thấy chậu cây được sở hữu.";
                    echo json_encode($noti);
                }
            }else{
                $noti -> noti = "Lỗi!";
                echo json_encode($noti);
            }
        }
    }
    mysqli_close($con);
?>