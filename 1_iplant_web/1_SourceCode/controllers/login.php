<?php 

    class login extends Controller{

        public function __construct(){
            parent::__construct();
            $site_info = $this->Model->fetchOne("select * from settings");
            include "views/login.php";
        }
    }
    new login();
?>