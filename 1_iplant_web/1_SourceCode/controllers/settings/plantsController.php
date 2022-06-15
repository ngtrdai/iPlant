<?php
    class listPlantsAdmin extends Controller{
        public function __construct(){
            parent::__construct();
            if($_SESSION['role'] == 'admin'){
                $plants = $this->Model->fetch("select * from plants");
                include "views/settings/plantsView.php";
            }else{
                echo "<script> window.location.href='index.php'</script>";
            }
        }
    }
    new listPlantsAdmin();
?>