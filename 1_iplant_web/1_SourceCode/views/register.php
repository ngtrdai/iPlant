<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="<?php echo $site_info["about"] ?>" />
        <meta name="author" content="ngtrdai" />
        <title>ĐĂNG KÝ - <?php echo $site_info["site_name"] ?></title>
        <link href="../public/css/style.css" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="<?php echo $site_info["logo_url"] ?>" />
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container-xl px-4">
                        <div class="row justify-content-center">
                        <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header justify-content-center"><h3 class="fw-light my-4">Đăng ký tài khoản</h3></div>
                                    <div class="card-body">
                                        <form id="form_dangky" method="post" action="Javascript:void(0);">
                                            <div class="mb-3">
                                                <label class="small mb-1" for="user_fullname">Họ và tên</label>
                                                <input class="form-control" id="user_fullname" name="fullname" type="text" placeholder="Nhập họ và tên bạn" />
                                                <span class="invalid-feedback"  id="invalid_fullname"></span>
                                            </div>
                                            <div class="mb-3">
                                                <label class="small mb-1" for="user_form">Tên người dùng</label>
                                                <input class="form-control"  id="user_form" type="text" name="username" placeholder="Nhập tên người dùng" />
                                                <span class="invalid-feedback" id="invalid_username"></span>
                                            </div>
                                            <div class="mb-3">
                                                <label class="small mb-1" for="email_form">Địa chỉ email</label>
                                                <input class="form-control"  id="email_form" type="email" name="email" placeholder="Nhập địa chỉ email" />
                                                <span class="invalid-feedback" id="invalid_email"></span>
                                            </div>
                                            <div class="row gx-3">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="small mb-1" for="user_password1">Mật khẩu</label>
                                                        <input class="form-control" id="user_password1" type="password" name="password1" placeholder="Nhập mật khẩu" />
                                                        <span class="invalid-feedback"  id="invalid_password1"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="small mb-1" for="user_password2">Xác nhận mật khẩu</label>
                                                        <input class="form-control" id="user_password2" type="password" name="password2" placeholder="Xác nhận mật khẩu" />
                                                        <span class="invalid-feedback"  id="invalid_password2"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="btn btn-primary btn-block" type="submit">Đăng ký</button>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="small"><a href="/index.php">Bạn đã có tài khoản? Đăng nhập!</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="footer-admin mt-auto footer-dark">
                    <div class="container-xl px-4">
                        <div class="row">
                            <div class="copyright text-center my-auto" style="color: #ffffff; font-weight: 600;">&copy;<strong><?php echo $site_info['site'] ?></strong> 2022 | <a style="text-decoration: none"href="https://github.com/ngtrdai">@ngtrdai</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../public/js/layout.js"></script>
        <script>
            $(document).ready(function(){
                $(document).on('submit', '#form_dangky', function(){
                    $.post('../api/users/register.php', $('#form_dangky').serialize(), function(data){
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
                        if(data.err == "Tạo tài khoản thành công..."){
                            window.location.href='/index.php';
                        }
                    });  
                    return false;         
                });
            });
        </script>
    </body>
</html>