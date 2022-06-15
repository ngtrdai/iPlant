<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
    <div class="container-fluid px-4">
        <div class="page-header-content">
            <div class="row align-items-center justify-content-between pt-3">
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i class="fa-solid fa-tree"></i></div>
                        Danh sách chậu cây
                    </h1>
                </div>
                <div class="col-12 col-xl-auto mb-3">
                    <a class="btn btn-sm btn-light text-primary" href="#!">
                        <i class="me-1" data-feather="plus"></i>
                        Thêm 1 chậu cây
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="container-fluid px-4">
    <div class="card">
        <div class="card-body">
            <table id="dbPlantList">
                <thead>
                    <tr>
                        <th>IMEI</th>
                        <th>Tên chậu cây</th>
                        <th>Trạng thái</th>
                        <th>Sở hữu</th>
                        <th>QR Code</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>IMEI</th>
                        <th>Tên chậu cây</th>
                        <th>Trạng thái</th>
                        <th>Sở hữu</th>
                        <th>QR Code</th>
                        <th>Hành động</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php foreach($plants as $plant) {?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <?php echo $plant['imei'] ?>
                            </div>
                        </td>
                        <td><?php echo $plant['name'] ?></td>
                        <td>
                            <?php 
                                if($plant['is_connected'] == 1){echo "Đã kết nối";}else{echo "Chưa kết nối";}
                            ?>
                        </td>
                        <td>
                            <?php 
                                $sql = "select username from owned where imei='".$plant['imei']."'";
                                $owners = $this->Model->fetch($sql);
                                foreach ($owners as $owner){
                                    echo "<span class='badge bg-green-soft text-green me-1'>".$owner['username']."</span>";
                                }
                            ?>
                        </td>
                        <td>
                            
                            <button class="btn btn-primary me-2" type="button" data-bs-toggle="modal" data-bs-target="#qrCode<?php echo $plant['imei'] ?>Modal"><i class="fa-solid fa-qrcode"></i></button>
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
                        </td>
                        <td>
                            <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" href="#"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
window.addEventListener('DOMContentLoaded', event => {
    const dbPlantList = document.getElementById('dbPlantList');
    if (dbPlantList) {
        new simpleDatatables.DataTable(dbPlantList);
    }
});
</script>