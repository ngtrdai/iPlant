<header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
    <div class="container-xl px-4">
        <div class="page-header-content pt-4">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><img src="../public/images/iPlant_logo.svg" alt="..." style="width: 2rem" /></div>
                        iPlant
                    </h1>
                    <div class="page-header-subtitle">Chậu cây IoT - Theo dõi cây ở mọi nơi</div>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="container-xl px-4 mt-n10">
    <div class="row">
        <div class="col-xl-4 mb-4">
            <?php if($countPlants != 0){ ?>
            <a class="card lift h-100" href="?controller=plants/view&imei=<?php echo $myPlants[0]['imei']?>">
                <div class="card-body d-flex justify-content-center flex-column">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="me-3">
                            <i class="feather-xl text-primary mb-3" data-feather="heart"></i>
                            <h5>CÂY.01 | <?php echo $myPlants[0]['name'] ?></h5>
                            <div class="text-muted small"><?php if($myPlants[0]['is_connected'] == 1){echo '<span class="badge bg-success">Đã kết nối</span>';}else{echo '<span class="badge bg-warning">Chưa kết nối</span>';}?></div>
                        </div>
                        <img src="https://iplant.svute.com/public/images/iplants/<?php echo $myPlants[0]['img_url'] ?>.svg" alt="..." style="width: 8rem" />
                    </div>
                </div>
            </a>
            <?php }else{?>
            <a class="card lift h-100" href="?controller=plants/list">
                <div class="card-body d-flex justify-content-center flex-column">
                    <div class="d-flex align-items-center justify-content-between">
                    <div>
                            <div class="h3 text-primary">Thêm chậu mới</div>
                            <p class="text-muted mb-4">Thêm chậu iPlant mới cho cây của bạn.</p>
                        </div>
                        <div class="icons-org-create align-items-center mx-auto mt-auto">
                            <i class="icon-users" data-feather="users"></i>
                            <i class="icon-plus fas fa-plus"></i>
                        </div>
                    </div>
                </div>
            </a>
            <?php }?>
        </div>
        <div class="col-xl-4 mb-4">
            <?php if($countPlants > 1){ ?>
            <a class="card lift h-100" href="?controller=plants/view&imei=<?php echo $myPlants[1]['imei']?>">
                <div class="card-body d-flex justify-content-center flex-column">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="me-3">
                            <i class="feather-xl text-secondary mb-3" data-feather="heart"></i>
                            <h5>CÂY.02 | <?php echo $myPlants[1]['name'] ?></h5>
                            <div class="text-muted small"><?php if($myPlants[1]['is_connected'] == 1){echo '<span class="badge bg-success">Đã kết nối</span>';}else{echo '<span class="badge bg-warning">Chưa kết nối</span>';}?></div>
                        </div>
                        <img src="https://iplant.svute.com/public/images/iplants/<?php echo $myPlants[1]['img_url'] ?>.svg" alt="..." style="width: 8rem" />
                    </div>
                </div>
            </a>
            <?php }else{?>
            <a class="card lift h-100" href="?controller=plants/list">
                <div class="card-body d-flex justify-content-center flex-column">
                    <div class="d-flex align-items-center justify-content-between">
                    <div>
                            <div class="h3 text-primary">Thêm chậu mới</div>
                            <p class="text-muted mb-4">Thêm chậu iPlant mới cho cây của bạn.</p>
                        </div>
                        <div class="icons-org-create align-items-center mx-auto mt-auto">
                            <i class="icon-users" data-feather="users"></i>
                            <i class="icon-plus fas fa-plus"></i>
                        </div>
                    </div>
                </div>
            </a>
            <?php }?>
        </div>
        <div class="col-xl-4 mb-4">
            <?php if($countPlants > 2){ ?>
            <a class="card lift h-100" href="?controller=plants/view&imei=<?php echo $myPlants[2]['imei']?>">
                <div class="card-body d-flex justify-content-center flex-column">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="me-3">
                            <i class="feather-xl text-green mb-3" data-feather="heart"></i>
                            <h5>CÂY.03 | <?php echo $myPlants[2]['name'] ?></h5>
                            <div class="text-muted small"><?php if($myPlants[2]['is_connected'] == 1){echo '<span class="badge bg-success">Đã kết nối</span>';}else{echo '<span class="badge bg-warning">Chưa kết nối</span>';}?></div>
                        </div>
                        <img src="https://iplant.svute.com/public/images/iplants/<?php echo $myPlants[2]['img_url'] ?>.svg" alt="..." style="width: 8rem" />
                    </div>
                </div>
            </a>
            <?php }else{?>
            <a class="card lift h-100" href="?controller=plants/list">
                <div class="card-body d-flex justify-content-center flex-column">
                    <div class="d-flex align-items-center justify-content-between">
                    <div>
                            <div class="h3 text-primary">Thêm chậu mới</div>
                            <p class="text-muted mb-4">Thêm chậu iPlant mới cho cây của bạn.</p>
                        </div>
                        <div class="icons-org-create align-items-center mx-auto mt-auto">
                            <i class="icon-users" data-feather="users"></i>
                            <i class="icon-plus fas fa-plus"></i>
                        </div>
                    </div>
                </div>
            </a>
            <?php }?>
        </div>
    </div>
    <div class="row">
        <div class="col-xxl-8 col-xl-8">
            <div class="card mb-4">
                <div class="card-header border-bottom">
                    <ul class="nav nav-tabs card-header-tabs" id="dashboardNav" role="tablist">
                        <?php $stt=0; foreach($myPlants as $plant){ $stt++; ?>
                        <li class="nav-item"><a class="nav-link <?php if($stt == 1){echo "active";} ?>" id="cay<?php echo "_".$stt; ?>-pill" href="#cay<?php echo "_".$stt; ?>" data-bs-toggle="tab" role="tab" aria-controls="cay<?php echo "_".$stt; ?>" aria-selected="true"><?php echo $plant['name']; ?></a></li>
                        <?php }?>
                        <li class="nav-item me-1"><a class="nav-link" id="capNhat-pill" href="#capNhat" data-bs-toggle="tab" role="tab" aria-controls="capNhat" aria-selected="true">Có gì mới?</a></li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="dashboardNavContent">
                        <?php $stt=0; foreach($myPlants as $plant){ $stt++; ?>
                        <div class="tab-pane fade show <?php if($stt == 1){echo "active";} ?>" id="cay<?php echo "_".$stt; ?>" role="tabpanel" aria-labelledby="cay<?php echo "_".$stt; ?>-pill">
                            <div class="chart-area">
                                <canvas id="iplant_<?php echo $stt; ?>" width="100%" height="30"></canvas>
                            </div>
                        </div>
                        <?php }?>
                        <div class="tab-pane fade" id="capNhat" role="tabpanel" aria-labelledby="capNhat-pill">
                            <?php echo $Parsedown->text($readme['readme']); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-4 col-xl-4">
            <div class="row">
                <div class="col-xl-12 col-xxl-12">
                    <div class="card card-header-actions mb-4">
                        <div class="card-header">HÀNH ĐỘNG NHANH 
                            <i class="text-muted" data-feather="info" data-bs-toggle="tooltip" data-bs-placement="left" title="Lưu ý: Tưới tất cả các cây cùng lúc."></i>
                        </div> 
                        <div class="card-body">
                            <p>Thực hiện các tác vụ nhanh.</p>
                            <div class="row">
                                <div class="col-lg-4 mb-2">
                                    <button class="btn btn-info" style="width: 100%" id="btnTuoiTatCa"><strong>TƯỚI CÂY</strong></button>
                                </div>
                                <div class="col-lg-4">
                                    <a type="button" href="https://iplant.svute.com/index.php?controller=controls/alarm" class="btn btn-primary" style="width: 100%"><strong>HẸN GIỜ</strong></a>
                                </div>
                                <div class="col-lg-4">
                                    <a type="button" href="https://iplant.svute.com/index.php?controller=controls/config" class="btn btn-secondary" style="width: 100%"><strong>AUTO</strong></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12 col-xxl-12 mb-4">
                    <a class="card lift h-100" href="/public/app/IoTLAB_app.apk">
                        <div class="card-body d-flex justify-content-center flex-column">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="me-3">
                                    <i class="feather-xl text-red mb-3" data-feather="smartphone"></i>
                                    <h5>TẢI NGAY APP iPlant!</h5>
                                    <div class="text-muted small">Ứng dụng iPlant (Android).</div>
                                </div>
                                <img src="../public/images/app_qr_code.svg" alt="..." style="width: 10rem" />
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var label = [];
    var doAmDat_Cay1 = [];
    var nhietDo_Cay1 = [];
    var anhSang_Cay1 = [];
    var doAmDat_Cay2 = [];
    var nhietDo_Cay2 = [];
    var anhSang_Cay2 = [];
    var doAmDat_Cay3 = [];
    var nhietDo_Cay3 = [];
    var anhSang_Cay3 = [];
    const chartdata = {
    labels: label,
        datasets: [{
            label: 'Nhiệt độ',
            pointStyle: 'triangle',
            data: nhietDo_Cay1,
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgba(255, 99, 132 ,0.7)',
            fill: false,
            cubicInterpolationMode: 'monotone',
            tension: 0.4
        },
        {
            label: 'Độ ẩm đất',
            pointStyle: 'circle',
            pointStyle: 'star',
            backgroundColor: 'rgb(99, 255, 132)',
            borderColor: 'rgba(99, 255, 132, 0.7)',
            data: doAmDat_Cay1,
            fill: false,
            cubicInterpolationMode: 'monotone',
            tension: 0.4
        },
        {
            label: 'Ánh sáng',
            backgroundColor: 'rgb(132, 99, 255)',
            borderColor: 'rgba(132, 99, 255, 0.7)',
            data: anhSang_Cay1,
            fill: false,
            cubicInterpolationMode: 'monotone',
            tension: 0.4
        }
        ]
    };
    const config = {
    type: 'line',
    data: chartdata,
    options: {
        maintainAspectRatio: false,
        layout: {
            padding: {
                left: 10,
                right: 25,
                top: 0,
                bottom: 0
            }
        },
        plugins: {
            title: {
                display: true,
                text: 'THÔNG SỐ REALTIME CÂY CỦA BẠN'
            },
            tooltip: {
                usePointStyle: true
            }
        },
        interaction: {
            intersect: false,
            mode: 'index',
        },
        scales: {
            x: {
                display: true,
                title: {
                    display: true
                },
                gridLines: {
                    display: false,
                    drawBorder: false
                },
            },
            y: {
                display: true,
                title: {
                display: true,
                text: 'Giá trị'
                },
                suggestedMin: -10,
                suggestedMax: 200
            }
        }
        },
    };
    var iplant_1 = new Chart(
        document.getElementById('iplant_1'),
        config
    );
    var iplant_2 = new Chart(
        document.getElementById('iplant_2'),
        config
    );
    var iplant_3 = new Chart(
        document.getElementById('iplant_3'),
        config
    );
    var noPlants = 0;
    // load data tu database
    $(document).ready(function(){
        getCountPlants();
        if(noPlants > 0){
            updateChart();
        }

        $("#btnTuoiTatCa").click(function(){
            $.post('../../api/plants/control.php?act=pumpAll&username=<?php echo $_SESSION['account']; ?>', function(data){
                console.log(data);
                alert(data);
                location.reload();
            });
        })
    });
    setInterval(updateChart,1000);
    function getCountPlants(){
        $.post('../api/plants/getValue.php?act=countPlants&username=<?php echo $_SESSION['account'] ?>',function(data){
            noPlants = data;
        })
    }
    function updateChart(){
        if(noPlants == 1){
            $.post('../api/plants/getValue.php?act=sensors&imei=<?php echo $myPlants[0]["imei"]?>',function(data){
                var label = [];
                var doAmDat_Cay1 = [];
                var nhietDo_Cay1 = [];
                var anhSang_Cay1 = [];
                for(var i in data.value){
                    label.push(data.value[i].updated_at);
                    doAmDat_Cay1.push(data.value[i].soil_moisture);
                    nhietDo_Cay1.push(data.value[i].temperature_env);
                    anhSang_Cay1.push(data.value[i].light_sensor);
                }
                // console.log(data1);
                iplant_1.data.labels = label;
                iplant_1.data.datasets[0].data = nhietDo_Cay1;
                iplant_1.data.datasets[1].data = doAmDat_Cay1;
                iplant_1.data.datasets[2].data = anhSang_Cay1;
                iplant_1.update();
            })
        }else if(noPlants==2){
            $.post('../api/plants/getValue.php?act=sensors&imei=<?php echo $myPlants[0]["imei"]?>',function(data){
                var label = [];
                var doAmDat_Cay1 = [];
                var nhietDo_Cay1 = [];
                var anhSang_Cay1 = [];
                for(var i in data.value){
                    label.push(data.value[i].updated_at);
                    doAmDat_Cay1.push(data.value[i].soil_moisture);
                    nhietDo_Cay1.push(data.value[i].temperature_env);
                    anhSang_Cay1.push(data.value[i].light_sensor);
                }
                // console.log(data1);
                iplant_1.data.labels = label;
                iplant_1.data.datasets[0].data = nhietDo_Cay1;
                iplant_1.data.datasets[1].data = doAmDat_Cay1;
                iplant_1.data.datasets[2].data = anhSang_Cay1;
                iplant_1.update();
            });
            $.post('../api/plants/getValue.php?act=sensors&imei=<?php echo $myPlants[1]["imei"]?>',function(data){
                var label = [];
                var doAmDat_Cay2 = [];
                var nhietDo_Cay2 = [];
                var anhSang_Cay2 = [];
                for(var i in data.value){
                    label.push(data.value[i].updated_at);
                    doAmDat_Cay2.push(data.value[i].soil_moisture);
                    nhietDo_Cay2.push(data.value[i].temperature_env);
                    anhSang_Cay2.push(data.value[i].light_sensor);
                }
                // console.log(data1);
                iplant_2.data.labels = label;
                iplant_2.data.datasets[0].data = nhietDo_Cay2;
                iplant_2.data.datasets[1].data = doAmDat_Cay2;
                iplant_2.data.datasets[2].data = anhSang_Cay2;
                iplant_2.update();
            });
        }else if(noPlants>=3){
            $.post('../api/plants/getValue.php?act=sensors&imei=<?php echo $myPlants[0]["imei"]?>',function(data){
                var label = [];
                var doAmDat_Cay1 = [];
                var nhietDo_Cay1 = [];
                var anhSang_Cay1 = [];
                for(var i in data.value){
                    label.push(data.value[i].updated_at);
                    doAmDat_Cay1.push(data.value[i].soil_moisture);
                    nhietDo_Cay1.push(data.value[i].temperature_env);
                    anhSang_Cay1.push(data.value[i].light_sensor);
                }
                // console.log(data1);
                iplant_1.data.labels = label;
                iplant_1.data.datasets[0].data = nhietDo_Cay1;
                iplant_1.data.datasets[1].data = doAmDat_Cay1;
                iplant_1.data.datasets[2].data = anhSang_Cay1;
                iplant_1.update();
            });
            $.post('../api/plants/getValue.php?act=sensors&imei=<?php echo $myPlants[1]["imei"]?>',function(data){
                var label = [];
                var doAmDat_Cay2 = [];
                var nhietDo_Cay2 = [];
                var anhSang_Cay2 = [];
                for(var i in data.value){
                    label.push(data.value[i].updated_at);
                    doAmDat_Cay2.push(data.value[i].soil_moisture);
                    nhietDo_Cay2.push(data.value[i].temperature_env);
                    anhSang_Cay2.push(data.value[i].light_sensor);
                }
                // console.log(data1);
                iplant_2.data.labels = label;
                iplant_2.data.datasets[0].data = nhietDo_Cay2;
                iplant_2.data.datasets[1].data = doAmDat_Cay2;
                iplant_2.data.datasets[2].data = anhSang_Cay2;
                iplant_2.update();
            });
            $.post('../api/plants/getValue.php?act=sensors&imei=<?php echo $myPlants[2]["imei"]?>',function(data){
                var label = [];
                var doAmDat_Cay3 = [];
                var nhietDo_Cay3 = [];
                var anhSang_Cay3 = [];
                for(var i in data.value){
                    label.push(data.value[i].updated_at);
                    doAmDat_Cay3.push(data.value[i].soil_moisture);
                    nhietDo_Cay3.push(data.value[i].temperature_env);
                    anhSang_Cay3.push(data.value[i].light_sensor);
                }
                // console.log(data1);
                iplant_3.data.labels = label;
                iplant_3.data.datasets[0].data = nhietDo_Cay3;
                iplant_3.data.datasets[1].data = doAmDat_Cay3;
                iplant_3.data.datasets[2].data = anhSang_Cay3;
                iplant_3.update();
            })
        }
        
    }
</script> 