<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="<?php echo $site_info["about"] ?>" />
        <meta name="author" content="ngtrdai" />
        <title>ĐĂNG NHẬP - <?php echo $site_info["site_name"] ?></title>
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
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header justify-content-center"><h3 class="fw-light my-4">ĐĂNG NHẬP</h3></div>
                                    <div class="card-body">
                                        <!-- Login form-->
                                        <form id="form_dangnhap" method="post" action="Javascript:void(0);">
                                            <div class="mb-3">
                                                <label class="small mb-1" for="username">Tài khoản</label>
                                                <input class="form-control" name="username"  id="username" type="text" placeholder="Nhập tài khoản người dùng" />
                                                <span class="invalid-feedback"></span>
                                            </div>
                                            <div class="mb-3">
                                                <label class="small mb-1" for="password">Mật khẩu</label>
                                                <input class="form-control" name="password"  id="password" type="password" placeholder="Nhập mật khẩu" />
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="auth-password-basic.html">Quên mật khẩu?</a>
                                                <button class="btn btn-primary" type="submit">Đăng nhập</button>
                                                <span class="invalid-feedback"></span>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="small"><a href="/index.php?act=dangky">Bạn chưa có tài khoản? Đăng ký!</a></div>
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
                            <div class="copyright text-center my-auto" style="color: #ffffff; font-weight: 600;">&copy; <strong><?php echo $site_info['site'] ?></strong> 2022 | @ngtrdai</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../public/js/layout.js"></script>
        <script>
            $(document).ready(function(){
                $(document).on('submit', '#form_dangnhap', function(){
                    $.post('../api/users/login.php', $('#form_dangnhap').serialize(), function(data){
                        console.log(data.loginErr);
                        if(data.err == "Đăng nhập thành công."){
                            window.location.href='/index.php';
                        }
                    })
                });
            });
        </script>
    </body>
</html>