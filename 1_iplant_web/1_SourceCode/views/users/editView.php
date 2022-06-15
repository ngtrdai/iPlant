<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
    <div class="container-fluid px-4">
        <div class="page-header-content">
            <div class="row align-items-center justify-content-between pt-3">
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="user"></i></div>
                        Chỉnh sửa người dùng
                    </h1>
                </div>
                <div class="col-12 col-xl-auto mb-3">
                    <a class="btn btn-sm btn-light text-primary" href="?controller=users/list">
                        <i class="me-1" data-feather="arrow-left"></i>
                        Trở lại danh sách
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="container-xl px-4 mt-4">
    <div class="row">
        <div class="col-xl-4">
            <div class="card mb-4 mb-xl-0">
                <div class="card-header">Tải lên ảnh đại diện</div>
                <div class="card-body text-center">
                    <img class="img-account-profile rounded-circle mb-2" src="<?php echo $value['avatar_img'] ?>" alt="" />
                    <div class="small font-italic text-muted mb-4">JPG hoặc PNG không lớn hơn 5 MB</div>
                    <button class="btn btn-primary" type="button">Tải ảnh lên</button>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card mb-4">
                <form id="form_capnhat" method="post">
                    <div class="card-header">Thông tin người dùng</div>
                    <div class="card-body">
                        <div class="row gx-3 mb-3">
                            <div class="col-md-6">
                                <label class="small mb-1" for="user_fullname">Họ và tên</label>
                                <input class="form-control" id="user_fullname" type="text" name="fullname" placeholder="Nhập vào họ và tên người dùng" value="<?php echo $value['fullname'] ?>" />
                                <span class="invalid-feedback"  id="invalid_fullname"></span>
                            </div>
                            <div class="col-md-6">
                                <label class="small mb-1" for="user_form">Tên người dùng</label>
                                <input class="form-control" id="user_form" type="text" name="username" placeholder="Nhập vào tên người dùng" value="<?php echo $value['username'] ?>" />
                                <span class="invalid-feedback" id="invalid_username"></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="email_form">Địa chỉ e-mail</label>
                            <input class="form-control" id="email_form" type="email" name="email" placeholder="Nhập vào địa chỉ e-mail" value="<?php echo $value['email'] ?>" />
                            <span class="invalid-feedback" id="invalid_email"></span>
                        </div>
                        <?php if($_SESSION['role'] == 'admin'){?>
                            <div class="mb-3">
                                <label class="small mb-1">Role</label>
                                <select class="form-select" aria-label="Lựa chọn phân quyền" name="role">
                                    <option selected disabled>Lựa chọn phân quyền</option>
                                    <?php foreach($roles as $role){?>
                                        <option
                                            <?php if($role == $value["role"]) {echo "selected";} ?>
                                            value="<?php echo $role;?>">
                                            <?php echo $role;?>
                                        </option>
                                    <?php }?>
                                </select>
                            </div>
                        <?php } ?>
                    
                        <div class="row gx-3 mb-3">
                            <div class="col-md-6">
                                <label class="small mb-1" for="user_password1">Mật khẩu</label>
                                <input class="form-control" id="user_password1" type="password" name="password1" placeholder="Nhập mật khẩu người dùng" value="" />
                                <span class="invalid-feedback"  id="invalid_password1"></span>
                            </div>
                            <div class="col-md-6">
                                <label class="small mb-1" for="user_password2">Xác nhận mật khẩu</label>
                                <input class="form-control" id="user_password2" type="password" name="password2" placeholder="Xác nhận mật khẩu người dùng" value="" />
                                <span class="invalid-feedback"  id="invalid_password2"></span>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Cập nhật thông tin</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $(document).on('submit', '#form_capnhat', function(){
            $.post('../../api/users/edit.php?token=<?php echo $value['token'] ?>', $('#form_capnhat').serialize(), function(data){
                document.getElementById("invalid_username").innerHTML = data.usernameErr;
                document.getElementById("invalid_password1").innerHTML = data.password1Err;
                document.getElementById("invalid_password2").innerHTML = data.password2Err;
                document.getElementById("invalid_fullname").innerHTML = data.fullnameErr;
                document.getElementById("invalid_email").innerHTML = data.emailErr;
                data.usernameErr != "" ? document.getElementById("user_form").classList.add("is-invalid") : document.getElementById("user_form").classList.remove("is-invalid");
                data.password1Err != "" ? document.getElementById("user_password1").classList.add("is-invalid") : document.getElementById("user_password1").classList.remove("is-invalid");
                data.password2Err != "" ? document.getElementById("user_password2").classList.add("is-invalid") : document.getElementById("user_password2").classList.remove("is-invalid");
                data.fullnameErr != "" ? document.getElementById("user_fullname").classList.add("is-invalid") : document.getElementById("user_fullname").classList.remove("is-invalid");
                data.emailErr != "" ? document.getElementById("email_form").classList.add("is-invalid") : document.getElementById("email_form").classList.remove("is-invalid");
                if(data.err == "Cập nhật tài khoản thành công..."){
                    alert("Cập nhật tài khoản thành công.");
                }
                if(data.err == "Bạn không có quyền chỉnh sửa người dùng này!"){
                    alert("Bạn không có quyền chỉnh sửa người dùng này!");
                }
                // console.log(data);
            });  
            return false;         
        });
    });
</script>