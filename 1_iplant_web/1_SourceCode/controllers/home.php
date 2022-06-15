<?php
    class home extends Controller{
        public function __construct(){
            parent::__construct();
            $Parsedown = new Parsedown();
            $readme = $this->Model->fetchOne("select readme from settings");
            $users = $this -> Model->fetch("select * from users order by id desc limit 5");
            $sql = "select * from plants where imei in (select imei from owned where username='".$_SESSION['account']."')";
            $countPlants = $this -> Model -> count($sql);
            $myPlants = $this -> Model -> fetch($sql);
            include "views/home.php";
        }
    }
    new home();
?>