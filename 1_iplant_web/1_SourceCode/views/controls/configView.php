<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
    <div class="container-xl px-4">
        <div class="page-header-content">
            <div class="row align-items-center justify-content-between pt-3">
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i class="fa-solid fa-scroll"></i></div>
                        Cấu hình kịch bản tự động
                    </h1>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="container-xl px-4 mt-4">
    <div class="row">
        <div class="col-lg-8">
            <div class="card card-header-actions mb-4">
                <div class="card-header">DANH SÁCH CẤU HÌNH 
                    <i class="text-muted" data-feather="info" data-bs-toggle="tooltip" data-bs-placement="left" title="Mỗi một chậu cây chỉ có 1 kịch bản tự động."></i>
                </div> 
                <div class="card-body">
                    <?php $stt=0; foreach($autoList as $auto){$stt++; ?>
                    <?php $plant = $this->Model->fetchOne("select name, token from plants where imei='".$auto['imei']."'"); ?>
                    <div class="card bg-gradient-primary-to-secondary mt-<?php if($stt ==  1){echo "0";} else{echo "4";} ?>">
                        <div class="card-body" style="height: 10rem">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="me-3">
                                    <div class="small text-white-50 fw-500">CẤU HÌNH CỦA CHẬU</div>
                                    <div class="h4 text-white"><?php echo $plant['name'] ?></div>
                                </div>
                                <div class="text-white">
                                    <button class="btn btn-datatable btn-icon btn-transparent-light me-2" type="button" data-bs-toggle="modal" data-bs-target="#edit<?php echo $plant['token'] ?>Modal"><i class="fa-solid fa-pen-to-square" style="font-size: 15px"></i></button>
                                    <div class="modal fade" id="edit<?php echo $plant['token'] ?>Modal" tabindex="-1" role="dialog" aria-labelledby="edit<?php echo $plant['token'] ?>ModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="edit<?php echo $plant['token'] ?>ModalLabel">Chỉnh sửa cấu hình tự động</h5>
                                                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form>
                                                        <div class="mb-3">
                                                            <label class="small mb-1 text-dark fw-700">Cài đặt độ ẩm đất</label>
                                                            <input class="form-control form-control-solid" type="number" step="0.5" min="0" max="100" id="doAmDat_<?php echo $plant['token'] ?>" value="<?php echo $auto['soil_moisture'] ?>">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="small mb-1 text-dark fw-700">Cài đặt nhiệt độ</label>
                                                            <input class="form-control form-control-solid" type="number" style='width:"100%"' step="0.5" min="10" max="40" id="nhietDo_<?php echo $plant['token'] ?>" value="<?php echo $auto['temperature_env'] ?>">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="small mb-1 text-dark fw-700">Cài đặt ánh sáng</label>
                                                            <input class="form-control form-control-solid" type="number" step="1" min="0" max="100" id="anhSang_<?php echo $plant['token'] ?>" value="<?php echo $auto['light_sensor'] ?>">
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer"><button class="btn btn-secondary" type="reset" data-bs-dismiss="modal">Đóng</button><button class="btn btn-primary" onclick='editConfig("<?php echo $plant["token"] ?>", "<?php echo $auto["imei"] ?>")' id="btnEdit" type="button">Sửa</button></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mt-2">
                                <div class="me-3">
                                    <span class="btn btn-cyan btn-icon" style="width: 3.5rem!important; height: 3.5rem!important;" type="button">
                                        <i class="fa-solid fa-water me-1"></i><?php echo $auto['soil_moisture']; ?>
                                    </span>
                                    <span class="btn btn-teal btn-icon" style="width: 3.5rem!important; height: 3.5rem!important;" type="button">
                                        <i class="fa-solid fa-temperature-high me-1"></i><?php echo $auto['temperature_env']; ?>
                                    </span>
                                    <span class="btn btn-yellow btn-icon" style="width: 3.5rem!important; height: 3.5rem!important;" type="button">
                                        <i class="fa-solid fa-sun me-1"></i><?php echo $auto['light_sensor']; ?>
                                    </span>
                                </div>
                                <div class="text-white">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" style="width: 4em; height:2em; backgroud-color: black!important;" type="checkbox" role="switch" onchange="toggleTurnON_OFF('<?php echo $auto['imei'] ?>')" id="IsEnabled_<?php echo $auto['imei'] ?>" <?php if($auto['status'] == 1) {echo "checked";} ?> name="interrupt">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">ĐIỀU KHIỂN THỦ CÔNG</div>
                <div class="card-body">
                    <div class="alert alert-info fw-700 d-flex align-items-center" role="alert">
                        <span class="badge bg-warning me-2 fw-500">Lưu ý</span>ÁP DỤNG CHO TẤT CẢ.
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mb-2">
                            <button class="btn btn-info" id='btnTuoiTatCa' style="width: 100%"><strong>TƯỚI CÂY</strong></button>
                        </div>
                        <div class="col-lg-6">
                            <button class="btn btn-primary" id='btnBatDenTatCa' style="width: 100%"><strong>ĐÈN QUANG HỢP</strong></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function toggleTurnON_OFF(imei){
        var isChecked = document.getElementById("IsEnabled_"+imei).checked
        $.post('../../api/controls/auto.php?act=toggle&turnOn='+isChecked+'&imei='+imei, function(data){
            console.log(data.noti);
            alert(data.noti);
            location.reload();
        });
        console.log(isChecked)
    };

    function editConfig(token, imei){
        var doAmDat = document.getElementById("doAmDat_"+token).value;
        var nhietDo = document.getElementById("nhietDo_"+token).value;
        var anhSang = document.getElementById("anhSang_"+token).value;
        $.post('../../api/controls/auto.php?act=edit&soil_moisture='+doAmDat+'&soil_moisture='+doAmDat+'&temperature_env='+nhietDo+'&light_sensor='+anhSang+'&imei='+imei, function(data){
            console.log(data.noti);
            alert(data.noti);
            location.reload();
        });
        console.log(doAmDat);
    }
    $(document).ready(function(){
        $(document).on('submit', '#content_form', function(){
            updateInfo();
            return false;
        });

        $("#btnTuoiTatCa").click(function(){
            $.post('../../api/plants/control.php?act=pumpAll&username=<?php echo $_SESSION['account']; ?>', function(data){
                console.log(data);
                alert(data);
                location.reload();
            });
        });

        $("#btnBatDenTatCa").click(function(){
            $.post('../../api/plants/control.php?act=uvAll&username=<?php echo $_SESSION['account']; ?>', function(data){
                console.log(data);
                alert(data);
                location.reload();
            });
        })
    });
</script>