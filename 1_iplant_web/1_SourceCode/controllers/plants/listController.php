<?php
    class plantsList extends Controller{
        public function __construct(){
            parent::__construct();
            $sql = "select * from plants where imei in (select imei from owned where username='".$_SESSION['account']."')";
            $myPlants = $this->Model->fetch($sql);
            include "views/plants/listView.php";
        }
    }
    new plantsList();
?>