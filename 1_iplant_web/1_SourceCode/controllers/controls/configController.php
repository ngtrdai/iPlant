<?php
    class configs extends Controller{
        public function __construct(){
            parent::__construct();
            $username = $_SESSION['account'];
            $sql =  "select * from auto where imei in (select imei from owned where username='$username')";
            $res = $this->Model->fetch($sql);
            $autoList = array();
            foreach($res as $auto){
                $record['id'] = $auto['id'];
                $record['imei'] = $auto['imei'];
                $record['soil_moisture'] = $auto['soil_moisture'];
                $record['temperature_env'] = $auto['temperature_env'];
                $record['light_sensor'] = $auto['light_sensor'];
                $record['is_updated'] = $auto['is_updated'];
                $record['status'] = $auto['status'];
                array_push($autoList, $record);
            }
            include "views/controls/configView.php";
        }
    }
    new configs();
?>