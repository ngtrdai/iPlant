<?php
    // Khởi tạo session.
    header("Content-Type: application/json");
    session_start();
    require_once "../../config/Config.php";

    $username = $password = "";
    $usernameErr = $passwordErr = $loginErr = "";

    $noti = new stdClass();
    $noti-> usernameErr = $usernameErr;
    $noti-> passwordErr = $passwordErr;
    $noti-> loginErr = $loginErr;
    $noti-> err = "";
    $noti-> username="";
    $noti-> fullname="";
    $noti-> avatar_img="";
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(empty(trim($_POST['username']))){
            $usernameErr = "Vui lòng nhập tài khoản.";
            $noti->usernameErr = $usernameErr;
        } else {
            $username = trim($_POST['username']);
        }

        if(empty(trim($_POST['password']))){
            $passwordErr = "Vui lòng nhập mật khẩu.";
            $noti->passwordErr = $passwordErr;

        } else {
            $password = trim($_POST['password']);
        }
        if(empty($usernameErr) && empty($passwordErr)){
            $query = "select username, password, fullname, avatar_img, role from users where username = ?";
            if($stmt = mysqli_prepare($con, $query)){
                mysqli_stmt_bind_param($stmt, "s", $paramUsername);
                $paramUsername = $username;
                if(mysqli_stmt_execute($stmt)){
                    mysqli_stmt_store_result($stmt);
                    if(mysqli_stmt_num_rows($stmt) == 1){
                        mysqli_stmt_bind_result($stmt, $username, $hashedPassword, $fullname, $avatar_img, $role);
                        if(mysqli_stmt_fetch($stmt)){
                            if(password_verify($password, $hashedPassword)){
                                session_start();
                                $noti->err = "Đăng nhập thành công.";
                                $noti-> username = $username;
                                $noti-> avatar_img = $avatar_img;
                                $noti-> fullname = $fullname;
                            } else {
                                $loginErr = "Tên tài khoản hoặc mật khẩu không đúng.";
                                $noti->loginErr = $loginErr;

                            }
                        } 
                    } else {
                        $loginErr = "Tên tài khoản hoặc mật khẩu không đúng.";
                        $noti->loginErr = $loginErr;
                    }
                } else {
                    $noti->err = "Có lỗi xảy ra, vui lòng thử lại.";
                }

                mysqli_stmt_close($stmt);
            }
        }
        mysqli_close($con);
        echo json_encode($noti);
    }
?>