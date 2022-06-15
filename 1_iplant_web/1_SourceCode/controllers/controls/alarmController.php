<?php
    class alarms extends Controller{
        public function __construct(){
            parent::__construct();
            $schedules = $this->Model->fetch("select * from alarm where imei in (select imei from owned where username='".$_SESSION['account']."')");
            $imeis = $this->Model->fetch("select imei from owned where username='".$_SESSION['account']."'");
            foreach($schedules as $row){
                $row['sdate'] = date("F d, Y h:i A",strtotime($row['time_set']));
                $name = $this->Model->fetchOne("select name from plants where imei='".$row['imei']."'");
                $row['title'] = "Tưới cây: ".$name['name'];
                $row['flag_loop'] == 1?$row['loopChecked'] = 'checked':0;
                $row['flag_pump'] == 1?$row['pumpChecked'] = 'checked':0;
                $row['flag_uv'] == 1?$row['uvChecked'] = 'checked':0;
                $sched_res[$row['id']] = $row;
            }
            include "views/controls/alarmView.php";
        }
    }
    new alarms();
?>