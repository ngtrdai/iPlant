<?php
    class viewPlants extends Controller{
        public function __construct(){
            parent::__construct();
            $imei = isset($_GET["imei"])?$_GET["imei"]:"";
            $checkImei = FALSE;
            $username = $_SESSION['account'];
            $imei_user = $this->Model->fetch("select imei from owned where username='$username'");
            foreach($imei_user as $i){
                if($i['imei'] == $imei){
                    $checkImei=TRUE;
                }
            }
            if($imei != "" and $checkImei==TRUE){
                $plant = $this->Model->fetchOne("select * from plants where imei='$imei'");
                $owned = $this->Model->fetchOne("select * from users where username='$username'");
                $owned_token = $this->Model->fetchOne("select token from owned where username='$username' and imei='$imei'");
                $alarms = $this->Model->fetch("select * from alarm where imei='$imei'");
                include "views/plants/viewView.php";
            }
        }
    }
    new viewPlants();
?>