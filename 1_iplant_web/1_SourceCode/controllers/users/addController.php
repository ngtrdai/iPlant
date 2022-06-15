<?php 
    class addUsers extends Controller{
        public function __construct(){
            parent::__construct();      
            $roles = $this->Model->getEnum('users', 'role');
            include "views/users/addView.php";
        }
    }
    new addUsers();
?>