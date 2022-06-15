<?php
    class settings extends Controller{
        public function __construct(){
            parent::__construct();
            if($_SESSION['role'] == 'admin'){
                $info = $this->Model->fetchOne("select readme from settings");
                include "views/settings/listView.php";
            }else{
                echo "<script> window.location.href='index.php'</script>";
            }
        }
    }
    new settings();
?>