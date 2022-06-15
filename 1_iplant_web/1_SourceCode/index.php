<?php
    session_start();
    include "./config/Config.php";
    include "./config/Model.php";
    include "./config/Controller.php";
    include "./config/Token.php";
    include "./public/vendor/Parserdown.php";

    if (isset($_GET["act"]) && $_GET["act"]=="logout") {
        unset($_SESSION["account"]);
    }

    if (isset($_SESSION['account'])) {
        $Model = new Model();
        $site_info = $Model->fetchOne("select * from settings");
        $sql = "select * from plants where imei in (select imei from owned where username='".$_SESSION['account']."')";
        $myPlants = $Model->fetch($sql);
        $controller = isset($_GET["controller"]) ? "controllers/".$_GET["controller"]."Controller.php":"controllers/home.php";
        include "./layout/layout.php";
    }else{
        if(isset($_COOKIE['username'])){
            $usr = $_COOKIE['username'];
            $hash = $_COOKIE['password'];
            $sql="select * from users where username='$usr' and password='$hash'";
 
            $result = mysqli_query($con,$sql);
            if($result){
                $controller = isset($_GET["controller"]) ? "controllers/".$_GET["controller"]."Controller.php":"controllers/home.php";
                include "./layout/layout.php";
            }
        }else{
            if(isset($_GET["act"]) && $_GET["act"]=="dangky"){
                include "controllers/register.php";
            }else{
                include "controllers/login.php";
            }
        }
    }
?>