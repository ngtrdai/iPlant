<?php
    class ListUsers extends Controller{
        public function __construct()
        {
            parent::__construct();
            $act = isset($_GET["act"])?$_GET["act"]:"";
            if($_SESSION['role'] == 'admin'){
                switch ($act) {
                    case 'delete':
                        if($_SESSION['role'] == 'admin'){
                            $token = isset($_GET["token"])?$_GET["token"]:0;
                            $this->Model->execute("delete from users where token='$token'");
                            echo "<script> window.location.href='index.php?controller=users/list'</script>";
                        }else{
                            echo "<script> alert('Bạn không có quyền xoá người dùng.')</script>";
                        }
                        break;
                }
                $users = $this->Model->fetch("select * from users");
                include "views/users/listView.php";
            }else{
                echo "<script> window.location.href='index.php'</script>";
            }
        }
    }
    new ListUsers();
?>