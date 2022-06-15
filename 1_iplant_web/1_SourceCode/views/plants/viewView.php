<div class="container-xl px-4 mt-4">
    <div class="card invoice">
        <div class="card-header p-4 p-md-5 border-bottom-0 bg-gradient-primary-to-secondary text-white-50">
            <div class="row justify-content-between align-items-center">
                <div class="col-12 col-lg-auto mb-5 mb-lg-0 text-center text-lg-start">
                    <img class="invoice-brand-img rounded-circle mb-4" src="https://iplant.svute.com/public/images/iplants/<?php echo $plant["img_url"]?>.svg" alt="" />
                    <div class="h2 text-white mb-0">iPlant | <?php echo $plant['name'] ?> <button class="btn btn-datatable btn-icon btn-transparent-light me-2" type="button" data-bs-toggle="modal" data-bs-target="#editModal"><i class="fa-solid fa-pen-to-square" style="font-size: 15px"></i></button></div>
                    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel">Chỉnh sửa thông tin chậu cây</h5>
                                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="editForm" method="post" action="Javascript:void(0);">
                                        <div class="mb-3">
                                            <label class="small mb-1 text-dark">Ảnh đại diện cho chậu cây</label>
                                            <select class="form-select mb-3" aria-label="Chọn ảnh đại diện" name="img_url" id="img_url_id" onchange="changeImg_preview()" require>
                                                <option selected disabled>Chọn ảnh đại diện</option>
                                                <?php $imgList = $this->Model->getEnum("plants", "img_url") ?>
                                                <?php foreach ($imgList as $img){?>
                                                <option <?php if($plant["img_url"] == $img){echo "selected";} ?>  data-thumbnail="https://iplant.svute.com/public/images/iplants/<?php echo $img?>.svg" value="<?php echo $img?>"><?php echo $img?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <img id="imgLoad" width="100rem" src="https://iplant.svute.com/public/images/iplants/<?php echo $plant['img_url'] ?>.svg">
                                        </div>
                                        <div class="mb-3">
                                            <label class="small mb-1 text-dark">Đổi tên chậu cây</label>
                                            <input class="form-control" type="text" placeholder="Nhập tên chậu bạn muốn đặt" name="name" value="<?php echo $plant['name'] ?>" required />
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer"><button class="btn btn-secondary" type="reset" data-bs-dismiss="modal">Đóng</button><button form="editForm" class="btn btn-primary" id="btnEdit" type="button">Sửa</button></div>
                            </div>
                        </div>
                    </div>
                    <?php echo $site_info['about'] ?>
                </div>
                <div class="col-12 col-lg-auto text-center text-lg-end">
                    <div class="h3 text-white"><?php echo $owned['fullname'] ?></div>
                    <?php
                        date_default_timezone_set('asia/Ho_Chi_Minh');
                        if(date("H") >= 01 and date("H") <= 10){
                            echo "Chào buổi sáng 😀";
                        }elseif(date("H") >= 11 and date("H") <= 16){
                            echo "Chào buổi trưa 🌞";
                        }else{
                            echo "Chào buổi tối🌛";
                        }
                        
                    ?>
                </div>
            </div>
        </div>
        <div class="card-body ">
            <div class="row">
                <div class="col-md-8 mb-2">
                    <div class="border border-lg rounded p-2 mb-3">
                        <div class="bg-light">
                            <div class="card bg-gradient-primary-to-secondary mb-2">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="me-3">
                                            <div class="small text-white-50 fw-500">DỮ LIỆU THỜI GIAN THỰC</div>
                                            <div class="h1 text-white">DỮ LIỆU CẢM BIẾN</div>
                                        </div>
                                        <div class="text-white fw-700"><?php if($plant['is_connected'] == 1){echo '<span class="badge bg-success">Đã kết nối</span>';}else{echo '<span class="badge bg-warning">Chưa kết nối</span>';}?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-2">
                            <div class="card-body">
                                MỰC NƯỚC: <div class="progress"><div class="progress-bar bg-primary" id="waterLevel" role="progressbar" style="width: 33%" aria-valuemin="0" aria-valuemax="100"></div></div>
                                        
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header border-bottom">
                                <ul class="nav nav-tabs card-header-tabs" id="cardTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="doAmDat-tab" href="#doAmDat" data-bs-toggle="tab" role="tab" aria-controls="doAmDat" aria-selected="true">Độ ẩm đất</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="anhSang-tab" href="#anhSang" data-bs-toggle="tab" role="tab" aria-controls="anhSang" aria-selected="false">Ánh sáng</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="nhietDo-tab" href="#nhietDo" data-bs-toggle="tab" role="tab" aria-controls="nhietDo" aria-selected="false">Nhiệt độ</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="cardTabContent">
                                    <div class="tab-pane fade show active" id="doAmDat" role="tabpanel" aria-labelledby="doAmDat-tab">
                                        <div class="chart-area"><canvas id="doAmDatChart" width="100%" height="20"></canvas></div>
                                    </div>
                                    <div class="tab-pane fade" id="anhSang" role="tabpanel" aria-labelledby="anhSang-tab">
                                        <div class="chart-area"><canvas id="anhSangChart" width="100%" height="20"></canvas></div>
                                    </div>
                                    <div class="tab-pane fade" id="nhietDo" role="tabpanel" aria-labelledby="nhietDo-tab">
                                        <div class="chart-area"><canvas id="nhietDoChart" width="100%" height="20"></canvas></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-2">
                    <div class="border border-lg rounded p-0 mb-3">
                        <div class="bg-light p-2">
                            <div class="card bg-gradient-primary-to-secondary mb-2">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="me-3">
                                            <div class="small text-white-50 fw-500">TÁC VỤ</div>
                                            <div class="h1 text-white">ĐIỀU KHIỂN</div>
                                        </div>
                                        <button class="btn btn-info me-2" type="button" data-bs-toggle="modal" data-bs-target="#qrCode<?php echo $plant['imei'] ?>Modal"><i class="fa-solid fa-qrcode"></i></button>
                                        <div class="modal fade" id="qrCode<?php echo $plant['imei'] ?>Modal" tabindex="-1" role="dialog" aria-labelledby="#qrCode<?php echo $plant['imei'] ?>ModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="#qrCode<?php echo $plant['imei'] ?>ModalLabel">Mã QR của chậu cây</h5>
                                                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <img class="card-img-bottom" src="<?php echo $plant['qr_code'] ?>" alt="<?php echo $plant['imei'] ?>">
                                                    </div>
                                                    <div class="modal-footer"><button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Đóng</button><button class="btn btn-primary" type="button">Tải về</button></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid p-2">
                            <div class="card mb-3 h-100">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12 mb-3">
                                            <button id="btnPump" class="btn btn-info" style="width: 100%" id="btnTuoiTatCa"><strong>TƯỚI CÂY</strong></button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 mb-3">
                                            <a class="btn btn-info" style="width: 100%" href="?controller=controls/alarm"><strong>HẸN GIỜ</strong></a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <a class="btn btn-info" style="width: 100%" href="?controller=controls/config"><strong>CẤU HÌNH TỰ ĐỘNG</strong></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-lg-6 mb-2">
                                    <div class="card h-100">
                                        <div class="card-header">
                                            Bật/Tắt đèn hiệu
                                        </div>
                                        <div class="card-body d-flex justify-content-center">
                                            <img width="40rem" class='me-2' id="imgLED_status" alt="">
                                            <div class="form-switch me-2">
                                                <input class="form-check-input" onchange="changeImg_LED();" style="width: 4em; height:2em;" type="checkbox" role="switch" id="IsEnable_LED" <?php $imei = $plant['imei']; $statusLED = $this->Model->fetchOne("select is_led_noti from controls where imei='$imei'"); if($statusLED['is_led_noti'] == 1){echo "checked";} ?>>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <div class="card h-100">
                                        <div class="card-header">
                                            Bật/Tắt đèn UV
                                        </div>
                                        <div class="card-body d-flex justify-content-center">
                                            <img width="40rem" class='me-2' id="imgUV_status" alt="">
                                            <div class="form-switch me-2">
                                                <input class="form-check-input" onchange="changeImg_LED();" style="width: 4em; height:2em;" type="checkbox" role="switch" id="IsEnable_UV" <?php $imei = $plant['imei']; $statusUV = $this->Model->fetchOne("select is_led_uv from controls where imei='$imei'"); if($statusUV['is_led_uv'] == 1){echo "checked";} ?>>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-2 h-100">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <button id="btnDelete" class="btn btn-danger" style="width: 100%" id="btnTuoiTatCa"><strong>XOÁ CHẬU CÂY</strong></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="border border-lg rounded p-0 mb-3">
                        <div class="bg-light p-2">
                            <div class="card">
                                <div class="card-header">NGƯỜI KẾT NỐI</div>
                                <div class="card-body mb-0">
                                    <?php $users = $this->Model->fetch("select * from users where username in (select username from owned where imei='".$plant['imei']."')"); ?>
                                    <?php $stt=0; foreach ($users as $user) {$stt++;?>
                                    <div class="d-flex align-items-center justify-content-between mt-<?php if($stt == 1){echo "0";} else{echo "4";} ?>">
                                        <div class="d-flex align-items-center flex-shrink-0 me-3">
                                            <div class="avatar avatar-xl me-3 bg-gray-200"><img class="avatar-img img-fluid" src="<?php echo $user['avatar_img'] ?>" alt="" /></div>
                                            <div class="d-flex flex-column fw-bold">
                                                <a class="text-dark line-height-normal mb-1" href="#!"><?php echo $user['fullname'] ?></a>
                                                <div class="small text-muted line-height-normal">@<?php echo $user['username'] ?></div>
                                            </div>
                                        </div>
                                        <div class="dropdown no-caret">
                                            <button class="btn btn-transparent-dark btn-icon dropdown-toggle" id="dropdownPeople1" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i data-feather="more-vertical"></i></button>
                                            <div class="dropdown-menu dropdown-menu-end animated--fade-in-up" aria-labelledby="dropdownPeople1">
                                                <a class="dropdown-item" href="#!">Xem hồ sơ</a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="border border-lg rounded p-2">
                        <div class="bg-light">
                            <div class="card bg-gradient-primary-to-secondary mb-2">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="me-3">
                                            <div class="small text-white-50 fw-500">HOẠT ĐỘNG</div>
                                            <div class="h1 text-white">LỊCH TƯỚI CÂY</div>
                                        </div>
                                        <div class="text-white">
                                            <div class="dropdown no-caret">
                                                <button class="btn btn-transparent-dark btn-icon dropdown-toggle" id="dropdownMenuButton" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="text-gray-500" data-feather="more-vertical"></i></button>
                                                <div class="dropdown-menu dropdown-menu-end animated--fade-in-up" aria-labelledby="dropdownMenuButton">
                                                    <h6 class="dropdown-header">Phân loại</h6>
                                                    <a class="dropdown-item"><span class="badge bg-green-soft text-green my-1">Đã tưới</span></a>
                                                    <a class="dropdown-item"><span class="badge bg-blue-soft text-blue my-1">Đã lên lịch</span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="timeline timeline-xs">
                                    <!-- Timeline Item 1-->
                                    <?php foreach($alarms as $alarm){ ?>
                                    <div class="timeline-item">
                                        <div class="timeline-item-marker">
                                            <div class="timeline-item-marker-text" style="width: 4rem;">
                                                <?php 
                                                    $dateAlarm = date("m-d H:i",strtotime($alarm['time_set']));
                                                    echo $dateAlarm;
                                                ?>
                                            </div>
                                            <div class="timeline-item-marker-indicator bg-<?php if($alarm['status'] == "Đã lên lịch") {echo "blue";} else{echo "green";} ?>"></div>
                                        </div>
                                        <div class="timeline-item-content">
                                            Lịch tưới cho cây
                                            <a class="fw-bold text-dark"><?php echo $plant['name'] ?></a>.
                                        </div>
                                    </div>
                                    <?php }?>
                                    <?php 
                                        if(empty($alarms)){
                                            echo "Cây này của bạn chưa có lịch tưới nào!";
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function changeImg_preview(){
        var value = "https://iplant.svute.com/public/images/iplants/" + document.getElementById("img_url_id").value + ".svg";
        $("#imgLoad").attr('src', value);

    }

    function changeImg_LED(){
        var ledOn = "https://iplant.svute.com/public/images/icons/sunrise.svg";
        var ledOff = "https://iplant.svute.com/public/images/icons/sunset.svg";
        if(document.getElementById("IsEnable_LED").checked){
            $("#imgLED_status").attr('src', ledOn);
        }else{
            $("#imgLED_status").attr('src', ledOff);
        }
        if(document.getElementById("IsEnable_UV").checked){
            $("#imgUV_status").attr('src', ledOn);
        }else{
            $("#imgUV_status").attr('src', ledOff);
        }
    }
</script>
<script>
    var label = [];
    var dataDoAmDat = [];
    var dataNhietDo = [];
    var dataAnhSang = [];
    
    const chartdataDoAmDat = {
    labels: label,
        datasets: [{
            label: 'Độ ẩm đất',
            pointStyle: 'triangle',
            data: dataDoAmDat,
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgba(255, 99, 132 ,0.7)',
            fill: false,
            cubicInterpolationMode: 'monotone',
            tension: 0.4
        }
        ]
    };
    const chartdataAnhSang = {
    labels: label,
        datasets: [{
            label: 'Ánh sáng',
            pointStyle: 'triangle',
            data: dataAnhSang,
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgba(255, 99, 132 ,0.7)',
            fill: false,
            cubicInterpolationMode: 'monotone',
            tension: 0.4
        }
        ]
    };
    const chartdataNhietDo = {
    labels: label,
        datasets: [{
            label: 'Nhiệt độ',
            pointStyle: 'triangle',
            data: dataAnhSang,
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgba(255, 99, 132 ,0.7)',
            fill: false,
            cubicInterpolationMode: 'monotone',
            tension: 0.4
        }
        ]
    };
    const configDoAmDat = {
    type: 'line',
    data: chartdataDoAmDat,
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
                text: 'Dữ liệu độ ẩm đất'
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
                    text: 'Value'
                },
                suggestedMin: -10,
                suggestedMax: 200,
                gridLines: {
                    color: "rgb(234, 236, 244)",
                    zeroLineColor: "rgb(234, 236, 244)",
                    drawBorder: false,
                    borderDash: [2],
                    zeroLineBorderDash: [2]
                }
            }
        }
        },
    };
    const configAnhSang = {
    type: 'line',
    data: chartdataAnhSang,
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
                text: 'Dữ liệu ánh sáng'
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
                text: 'Value'
                },
                suggestedMin: -10,
                suggestedMax: 200
            }
        }
        },
    };
    const configNhietDo = {
    type: 'line',
    data: chartdataNhietDo,
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
                text: 'Dữ liệu nhiệt độ'
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
                text: 'Value'
                },
                suggestedMin: -10,
                suggestedMax: 200
            }
        }
        },
    };
    var doAmDatChart = new Chart(
        document.getElementById('doAmDatChart'),
        configDoAmDat
    );

    var anhSangChart = new Chart(
        document.getElementById('anhSangChart'),
        configAnhSang
    );

    var nhietDoChart = new Chart(
        document.getElementById('nhietDoChart'),
        configNhietDo
    );

    $(document).ready(function(){
        updateChart();
        changeImg_LED();
        $('#IsEnable_LED').change(function() {
            console.log("abc")
            if(document.getElementById("IsEnable_LED").checked){
                $.post('../../api/plants/control.php?act=turnLED&imei=<?php echo $plant['imei']?>&toggle=on', function(data){
                    console.log(data);
                });
            }else{
                $.post('../../api/plants/control.php?act=turnLED&imei=<?php echo $plant['imei']?>&toggle=off', function(data){
                    console.log(data);
                });
            }
        });

        $('#IsEnable_UV').change(function() {
            if(document.getElementById("IsEnable_UV").checked){
                $.post('../../api/plants/control.php?act=turnUV&imei=<?php echo $plant['imei']?>&toggle=on', function(data){
                    console.log(data);
                });
            }else{
                $.post('../../api/plants/control.php?act=turnUV&imei=<?php echo $plant['imei']?>&toggle=off', function(data){
                    console.log(data);
                });
            }
        });

        $('#btnPump').click(function() {
            $.post('../../api/plants/control.php?act=pump&username=<?php echo $owned['username']?>&imei=<?php echo $plant['imei']?>', function(data){
                console.log(data);
                if(data == "Đã bật tưới cây"){
                    alert("Đã bật tưới cây!");
                    location.reload();
                }
            });
        });

        $('#btnLed').click(function() {
            $.post('../../api/plants/control.php?act=led&username=<?php echo $owned['username']?>&imei=<?php echo $plant['imei']?>', function(data){
                console.log(data);
                if(data == "Đã bật LED tín hiệu"){
                    alert("Đã bật LED tín hiệu!");
                    location.reload();
                }
            });
        });

        $('#btnDelete').click(function() {
            var _conf = confirm("Bạn có thực sự muốn xoá không?");
            if (_conf === true){
                $.post('../../api/plants/delete.php?username=<?php echo $owned['username']?>&imei=<?php echo $plant['imei']?>', function(data){
                    console.log(data);
                    if(data.noti == "Xoá chậu cây thành công"){
                        alert("Xoá chậu cây thành công!");
                        window.location.href='/index.php';
                    }
                });
            }
        });

        $('#btnEdit').click(function() {
            $.post('../../api/plants/edit.php?&username=<?php echo $owned['username']?>&imei=<?php echo $plant['imei']?>',$('#editForm').serialize(), function(data){
                console.log(data.noti);
                if(data.noti == "Chỉnh sửa thông tin chậu thành công"){
                    alert("Chỉnh sửa thông tin chậu thành công");
                    location.reload();
                }
            });
        });
    });

    setInterval(updateChart,2000);
    function updateChart(){
        // gui request xuong database de lay data
        $.post('../api/plants/getValue.php?act=sensors&imei=<?php echo $plant['imei'] ?>',function(data){
            var label = [];
            var dataDoAmDat = [];
            var dataAnhSang = [];
            var dataNhietDo = [];
            for(var i in data.value){
                label.push(data.value[i].updated_at);
                dataDoAmDat.push(data.value[i].soil_moisture);
                dataNhietDo.push(data.value[i].temperature_env);
                dataAnhSang.push(data.value[i].light_sensor);
            }
            doAmDatChart.data.labels = label;
            doAmDatChart.data.datasets[0].data = dataDoAmDat;
            doAmDatChart.update();
            anhSangChart.data.labels = label;
            anhSangChart.data.datasets[0].data = dataAnhSang;
            anhSangChart.update();
            nhietDoChart.data.labels = label;
            nhietDoChart.data.datasets[0].data = dataNhietDo;
            nhietDoChart.update();
            console.log(data.value[24].water_level);
            if(data.value[24].water_level == "warning"){
                document.getElementById("waterLevel").style.width = "0%";
            }else if(data.value[24].water_level == "low"){
                document.getElementById("waterLevel").style.width = "33%";
            }else if(data.value[24].water_level == "medium"){
                document.getElementById("waterLevel").style.width = "66%";
            }else if(data.value[24].water_level == "full"){
                document.getElementById("waterLevel").style.width = "100%";
            }
        })
    }
</script> 