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
            $query = "select token, username, password, fullname, avatar_img, role from users where username = ?";
            if($stmt = mysqli_prepare($con, $query)){
                mysqli_stmt_bind_param($stmt, "s", $paramUsername);
                $paramUsername = $username;
                if(mysqli_stmt_execute($stmt)){
                    mysqli_stmt_store_result($stmt);
                    if(mysqli_stmt_num_rows($stmt) == 1){
                        mysqli_stmt_bind_result($stmt,$token, $username, $hashedPassword, $fullname, $avatar_img, $role);
                        if(mysqli_stmt_fetch($stmt)){
                            if(password_verify($password, $hashedPassword)){
                                session_start();
                                $_SESSION['token'] = $token;
                                $_SESSION['account'] = $username;
                                $_SESSION['avatar_img'] = $avatar_img;
                                $_SESSION['fullname'] = $fullname;
                                $_SESSION['role'] = $role;
                                setcookie("username", $username, time()+ (10 * 365 * 24 * 60 * 60));
                                setcookie("password", $password, time()+ (10 * 365 * 24 * 60 * 60));
                                $noti->err = "Đăng nhập thành công.";
                            } else {
                                $loginErr = "Tên tài khoản hoặc mật khẩu không đúng.";
                                $noti->loginErr = $loginErr;

                            }
                        } 
                    } else {
                        $loginErr = "Tên tài khoản hoặc mật khẩu không đúng.";
                        $noti->loginErr = $loginErr;
                        session_start();
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