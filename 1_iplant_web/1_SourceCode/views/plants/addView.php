<div class="container-xl px-4">
    <div class="row justify-content-center">
        <div class="col-xl-5 col-lg-6 col-md-8 col-sm-11">
            <div class="card mt-5">
                <div class="card-body p-5 text-center">
                    <div class="icons-org-create align-items-center mx-auto">
                        <i class="fa-solid fa-seedling me-3" style="font-size: 45px; color: green;"></i>
                        <i class="icon-plus fas fa-plus"></i>
                    </div>
                    <div class="h3 text-primary mb-0">THÊM CHẬU CÂY MỚI</div>
                </div>
                <hr class="m-0" />
                <div class="card-body p-5">
                    <form id="form_addIPlant" method="post" action="Javascript:void(0);">
                        <div class="mb-3"><i class="text-muted" data-feather="info" data-bs-toggle="tooltip" data-bs-placement="right" title="IMEI được in trên chậu."></i><input class="form-control form-control-solid" type="text" placeholder="Nhập IMEI chậu của bạn" aria-label="Nhập IMEI chậu của bạn" aria-describedby="plantImeiExample" name="imei" /></div>
                        <div class="d-grid"><button class="btn btn-primary" type="submit">Thêm chậu mới</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $(document).on('submit', '#form_addIPlant', function(){
            $.post('../../api/plants/add.php?act=add&username=<?php echo $_SESSION['account'] ?>', $('#form_addIPlant').serialize(), function(data){
                if(data.noti == "Thêm chậu thành công."){
                    alert("Thêm chậu thành công!");
                    window.location.href='/index.php?controller=plants/list';
                }else if(data.noti == "Bạn đã sở hữu chậu này."){
                    alert("Bạn đã sở hữu chậu này!");
                }else if(data.noti == "IMEI không tìm thấy."){
                    alert("IMEI không tìm thấy!");
                }
            });  
            return false;         
        });
    });
</script>