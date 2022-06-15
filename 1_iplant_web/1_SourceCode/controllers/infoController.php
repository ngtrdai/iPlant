<?php
    class infoLab extends Controller{
        public function __construct(){
            parent::__construct();
            $site_info = $this->Model->fetchOne("select * from settings");
            $username_m1 = $site_info['member_1'];
            $username_m2 = $site_info['member_2'];
            $username_m3 = $site_info['member_3'];
            $thanhvien1 = $this->Model->fetchOne("select * from users where username='$username_m1'");
            $thanhvien2 = $this->Model->fetchOne("select * from users where username='$username_m2'");
            $thanhvien3 = $this->Model->fetchOne("select * from users where username='$username_m3'");
            include "views/infoView.php";
        }
    }
    new infoLab();
?>