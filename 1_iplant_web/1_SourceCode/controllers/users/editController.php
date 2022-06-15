<?php 

    class editUsers extends Controller{
        public function __construct(){
            parent::__construct();
            $act = isset($_GET["act"])?$_GET["act"]:"";
            $token = isset($_GET["token"])?$_GET["token"]:0;
            $roles = $this->Model->getEnum('users', 'role');
            $value = $this -> Model -> fetchOne("select * from users where token = '$token'");
            
            include "views/users/editView.php";
        }
    }
    new editUsers();
?>