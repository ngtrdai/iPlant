<?php 
    class register extends Controller{

        public function __construct(){
            parent::__construct();
            $site_info = $this->Model->fetchOne("select * from settings");
            include "views/register.php";
        }
    }
    new register();
?>