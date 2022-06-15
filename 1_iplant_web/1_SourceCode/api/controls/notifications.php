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
                case 'getNoti':
                    $username = $_GET["username"];
                    if($_POST["view"] != ''){
                        $Model->execute("update notification set status=1 where (status=0 and imei in (select imei from owned where username='$username'))");
                    }
                    $sql = "select * from notification where imei in (select imei from owned where username='$username') order by id desc limit 5";
                    $result = $Model->fetch($sql);
                    $count = $Model->count($sql);
                    $output = '';
                    if($count > 0){
                        foreach($result as $row){
                            $img = $Model->fetchOne("select img_url from plants where imei ='".$row['imei']."'");
                            $output .= '
                            <a class="dropdown-item dropdown-notifications-item" href="#!">
                                <div class="dropdown-notifications-item-icon bg-warning"><img src="https://iplant.svute.com/public/images/iplants/'.$img[0].'.svg" width="20rem"></div>
                                <div class="dropdown-notifications-item-content">
                                    <div class="dropdown-notifications-item-content-details">'.$row['created_at'].'</div>
                                    <div class="dropdown-notifications-item-content-text">'.$row['content'].'</div>
                                </div>
                             </a>';
                        }
                    }else{
                        $output .= '
                            <a class="dropdown-item dropdown-notifications-item" href="#!">
                                <div class="dropdown-notifications-item-icon bg-warning"><i class="fa-solid fa-ban"></i></div>
                                <div class="dropdown-notifications-item-content">
                                    <div class="dropdown-notifications-item-content-details">Bây giờ</div>
                                    <div class="dropdown-notifications-item-content-text fw-700">KHÔNG CÓ THÔNG BÁO NÀO</div>
                                </div>
                        </a>';
                    }
                    $sql = "select * from notification where status=0 and imei in(select imei from owned where username='$username')";
                    $count = $Model->count($sql);
                    $data = array(
                        'notification'   => $output,
                        'unseen_notification' => $count
                    );
                    echo json_encode($data);
                    break;
            } 
        }
    }
?>