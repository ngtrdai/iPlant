<header class="page-header page-header-dark bg-gradient-primary-to-secondary mb-4">
    <div class="container-xl px-4">
        <div class="page-header-content pt-4">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i class="fa-solid fa-sun-plant-wilt"></i></div>
                        iPlant của tôi
                    </h1>
                    <div class="page-header-subtitle mb-1">Danh sách các iPlant mà bạn đã sở hữu.</div>
                    <a class="btn btn-sm btn-light text-primary" type="button" href="?controller=plants/add">
                        <i class="fa-solid fa-circle-plus me-1"></i>
                        Thêm iPlant
                    </a>
                </div>
            </div>
            <div class="page-header-search mt-3">
                <div class="input-group input-group-joined">
                    <input class="form-control" type="text" placeholder="Tìm kiếm chậu cây..." aria-label="Search" autofocus />
                    <span class="input-group-text"><i data-feather="search"></i></span>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="container-xl px-4">
    <div class='row'>
        <?php $stt=1;
        foreach ($myPlants as $plant){?>
            <div class="col-lg-6 mb-4">
                <a class="card lift lift-sm h-100" href="index.php?controller=plants/view&imei=<?php echo $plant["imei"]?>">
                    <div class="card-header">
                        <h5 class="card-title text-success mb-2">
                            <i class="fa-solid fa-glass-water"></i>
                            <?php echo "CHẬU CÂY SỐ: ".$stt++; ?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="card card-icon">
                            <div class="row no-gutters">
                                <div class="col-lg-4 card-icon-aside">
                                    <img class="img-fluid" width="150rem" src="https://iplant.svute.com/public/images/iplants/<?php echo $plant["img_url"]?>.svg" alt="...">
                                </div>
                                <div class="col-lg-8">
                                    <?php 
                                        $sensor = $this->Model->fetchOne("select * from sensors where imei='".$plant['imei']."' order by id desc")
                                    ?>
                                    <div class="card-body">
                                        <h3 class="card-title"><?php echo $plant["name"] ?></h3>
                                        <i class="fa-solid fa-water me-2"></i> ĐỘ ẨM ĐẤT: <?php echo $sensor['soil_moisture']?> %
                                        <hr><i class="fa-solid fa-sun me-2"></i> ÁNH SÁNG: <?php echo $sensor['light_sensor']?> (lux)
                                        <hr><i class="fa-solid fa-temperature-high me-2"></i> NHIỆT ĐỘ: <?php echo $sensor['temperature_env']?> *C 
                                        <hr><i class="fa-solid fa-glass-water-droplet me-2"></i> LƯỢNG NƯỚC: <?php
                                                                                                                switch($sensor['water_level']){
                                                                                                                    case "low":
                                                                                                                        $str = '<div class="progress"><div class="progress-bar bg-primary" role="progressbar" style="width: 33%" aria-valuenow="Thấp" aria-valuemin="0" aria-valuemax="100"></div></div>';
                                                                                                                        echo $str;
                                                                                                                        break;
                                                                                                                    case "medium":
                                                                                                                        $str = '<div class="progress"><div class="progress-bar bg-primary" role="progressbar" style="width: 66%" aria-valuenow="Trung bình" aria-valuemin="0" aria-valuemax="100"></div></div>';
                                                                                                                        echo $str;
                                                                                                                        break;
                                                                                                                    case "full":
                                                                                                                        $str = '<div class="progress"><div class="progress-bar bg-primary" role="progressbar" style="width: 100%" aria-valuenow="Đầy" aria-valuemin="0" aria-valuemax="100"></div></div>';
                                                                                                                        echo $str;
                                                                                                                        break;
                                                                                                                }
                                                                                                            ?> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer"><div class="small text-muted">Trạng thái: <?php if($plant['is_connected'] == 1){echo '<span class="badge bg-success">Đã kết nối</span>';}else{echo '<span class="badge bg-warning">Chưa kết nối</span>';}?></div></div>
                </a>
            </div>
        <?php }?>
    </div>
</div>