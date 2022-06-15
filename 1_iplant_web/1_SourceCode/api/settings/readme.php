<?php 
    header("Content-Type: application/json");
    require_once "../../config/Config.php";
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        switch($_GET['act']){
            case 'update':
                $content = $_POST['content'];
                $query = "update settings set readme='$content' where id=1";
                mysqli_query($con, $query);
                echo json_encode("Cập nhật thành công.");
                break;
            case 'getValue':
                $query = "select readme from settings";
                $result = mysqli_query($con, $query);
                $info = mysqli_fetch_row($result);
                echo json_encode($info);
        }
    }
    mysqli_close($con);
?>