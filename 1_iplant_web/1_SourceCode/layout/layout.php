<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Website tổng hợp các bài tập thực hành trong môn IoT - HCMUTE." />
        <meta name="author" content="ngtrdai" />
        <link rel="icon" type="image/x-icon" href="<?php echo $site_info['logo_url'] ?>">
        <title><?php echo $site_info['site_name'] ?></title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="../public/css/style.css" rel="stylesheet" />
        <link href="https://unpkg.com/easymde/dist/easymde.min.css" rel="stylesheet" />
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.2.0/chart.min.js"> </script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />    
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.28.0/plugins/line-numbers/prism-line-numbers.min.css" integrity="sha512-cbQXwDFK7lj2Fqfkuxbo5iD1dSbLlJGXGpfTDqbggqjHJeyzx88I3rfwjS38WJag/ihH7lzuGlGHpDBymLirZQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body class="nav-fixed">
        <nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light bg-white" id="sidenavAccordion">
            <button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 me-2 ms-lg-2 me-lg-0" id="sidebarToggle"><i data-feather="menu"></i></button>
            <a class="navbar-brand pe-3 ps-4 ps-lg-2" href="index.php">iPlant <sup>UTE</sup></a>
            <ul class="navbar-nav align-items-center ms-auto">
                <li class="nav-item dropdown no-caret d-none d-sm-block me-3 dropdown-notifications">
                    <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownAlerts" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i data-feather="bell"></i><i class="count"></i></a>
                    <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownAlerts">
                        <h6 class="dropdown-header dropdown-notifications-header">
                            <i class="me-2" data-feather="bell"></i>
                            Thông báo
                        </h6>
                        <div class="noti">

                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown no-caret dropdown-user me-3 me-lg-4">
                    <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="img-fluid" src="<?php  echo $_SESSION['avatar_img']?>" /></a>
                    <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownUserImage">
                        <h6 class="dropdown-header d-flex align-items-center">
                            <img class="dropdown-user-img" src="<?php  echo $_SESSION['avatar_img']?>" />
                            <div class="dropdown-user-details">
                                <div class="dropdown-user-details-name"><?php  echo $_SESSION['fullname']?></div>
                                <div class="dropdown-user-details-email"><?php  echo $_SESSION['email']?></div>
                            </div>
                        </h6>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="?controller=users/edit&token=<?php echo $_SESSION['token'] ?>">
                            <div class="dropdown-item-icon"><i data-feather="settings"></i></div>
                            Hồ sơ
                        </a>
                        <a class="dropdown-item" href="?act=logout">
                            <div class="dropdown-item-icon"><i data-feather="log-out"></i></div>
                            Đăng xuất
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sidenav shadow-right sidenav-light">
                    <div class="sidenav-menu">
                        <div class="nav accordion" id="accordionSidenav">
                            <div class="sidenav-menu-heading">iPlant</div>
                            <a class="nav-link <?php if($controller == '' || $controller == 'controllers/home.php') {echo "active";} ?>" href="/index.php">
                                <div class="nav-link-icon"><i data-feather="home"></i></div>
                                Trang chủ
                            </a>
                            <a class="nav-link <?php if($controller == 'controllers/infoController.php') {echo "active";} ?>" href="?controller=info">
                                <div class="nav-link-icon"><i data-feather="info"></i></div>
                                Thông tin Project
                            </a>
                            <div class="sidenav-menu-heading">iPlant | Quản lí chậu</div>
                            <a class="nav-link <?php if($controller == 'controllers/plants/listController.php') {echo "active";} ?>" href="?controller=plants/list">
                                <div class="nav-link-icon"><i data-feather="list"></i></div>
                                Danh sách cây của tôi
                            </a>
                            <?php $stt=0; foreach ($myPlants as $plant){ $stt++;?>
                            <a class="nav-link <?php if($_GET['imei'] == $plant['imei']) {echo "active";} ?>" href="?controller=plants/view&imei=<?php echo $plant['imei'] ?>">
                                <div class="nav-link-icon"><i class="fa-solid fa-seedling"></i></div>
                                CÂY.<?php if($stt < 10){echo '0'.$stt;}else{echo $stt;}?> | <?php echo $plant['name']?>
                            </a>
                            <?php }?>
                            
                            <div class="sidenav-menu-heading">LÊN LỊCH VÀ KỊCH BẢN</div>
                            <a class="nav-link <?php if($controller == 'controllers/controls/alarmController.php') {echo "active";} ?>" href="?controller=controls/alarm">
                                <div class="nav-link-icon"><i class="fa-solid fa-calendar-day"></i></div>
                                Hẹn giờ
                            </a>
                            <a class="nav-link <?php if($controller == 'controllers/controls/configController.php') {echo "active";} ?>" href="?controller=controls/config">
                                <div class="nav-link-icon"><i class="fa-solid fa-scroll"></i></div>
                                Kịch bản tự động
                            </a>
                            <div class="sidenav-menu-heading">QUẢN LÝ WEBSITE</div>
                            <a class="nav-link <?php if($controller == 'controllers/users/listController.php' || $controller == 'controllers/users/addController.php' || $controller == 'controllers/users/editController.php ') {echo "active";} ?>" href="?controller=users/list">
                                <div class="nav-link-icon"><i data-feather="user"></i></div>
                                Người dùng
                            </a>
                            <a class="nav-link <?php if($controller == 'controllers/settings/plantsController.php') {echo "active";} ?>" href="?controller=settings/plants">
                                <div class="nav-link-icon"><i class="fa-solid fa-tree"></i></div>
                                Chậu cây
                            </a>
                            <a class="nav-link <?php if($controller == 'controllers/settings/listController.php') {echo "active";} ?>" href="?controller=settings/list">
                                <div class="nav-link-icon"><i data-feather="settings"></i></div>
                                Cài đặt
                            </a>
                            <a class="nav-link" href="?controller=apis/list">
                                <div class="nav-link-icon"><i data-feather="terminal"></i></div>
                                APIs
                            </a>
                        </div>
                    </div>
                    <div class="sidenav-footer">
                        <div class="sidenav-footer-content">
                            <div class="sidenav-footer-subtitle">Liên hệ hỗ trợ</div>
                            <a class="sidenav-footer-title" href="mailto: ngtrdai@svute.com" style="text-decoration: none;"><code>ngtrdai@svute.com</code></a>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <?php 
                        if(file_exists($controller)){ 
                            include $controller; 
                        }
                    ?>
                </main>
                <footer class="footer-admin mt-auto footer-light">
                    <div class="container-xl px-4">
                        <div class="row">
                            <div class="copyright text-center my-auto">&copy;<strong><?php echo $site_info['site'] ?></strong> 2022 | <a style="text-decoration: none"href="https://github.com/ngtrdai">@ngtrdai</a></div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../public/js/layout.js"></script>
        <script src="../public/vendor/simple_datatables.js"></script>
        <script>
            $(document).ready(function(){
                function showUnreadNotifications(view=''){
                    $.ajax({
                        url: '../api/controls/notifications.php?act=getNoti&username=<?php echo $_SESSION['account'] ?>',
                        method: 'POST',
                        data: {view: view},
                        dataType: "json",
                        success: function(data){
                            $('.noti').html(data.notification);
                            if(data.unseen_notification > 0){
                                $('.count').html(data.unseen_notification);
                            }
                        }
                    });
                }
                showUnreadNotifications();
                $(document).on('click', '.dropdown-toggle', function(){
                    console.log("ahuhu");
                    $('.count').html('');
                    showUnreadNotifications('yes');
                });
                setInterval(function(){ 
                    showUnreadNotifications();; 
                }, 2000);
            });
        </script>
    </body>
</html>