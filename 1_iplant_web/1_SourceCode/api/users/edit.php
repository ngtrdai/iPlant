<?php
    header("Content-Type: application/json");
    session_start();
    require_once "../../config/Config.php";
    $username = $password1 = $password2 = $fullname = $email = $role = "";
    $usernameErr = $password1Err = $password2Err = $fullnameErr = $emailErr = "";

    $noti = new stdClass();
    $noti->usernameErr =  $usernameErr;
    $noti->password1Err =  $password1Err;
    $noti->password2Err =  $password2Err;
    $noti->fullnameErr =  $fullnameErr;
    $noti->emailErr =  $emailErr;
    $noti->err = "";

    // $act = isset($_GET["act"])?$_GET["act"]:"";
    $token = isset($_GET["token"])?$_GET["token"]:0;
    // $id = isset($_POST["id_user"])?$_POST["id_user"]:0;
    if(($_SESSION['role'] == 'admin') || ($_SESSION['token'] == $token)){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $query = "select * from users where token = '$token'";
            $result = mysqli_query($con,$query);
			$user = mysqli_fetch_array($result);
            if(empty(trim($_POST['username']))){
                $usernameErr = "Vui lòng nhập tên đăng nhập";
                $noti->usernameErr =  $usernameErr;
            } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
                $usernameErr = "Chỉ có thể chứa các chữ cái, số và dấu gạch dưới.";
                $noti->usernameErr =  $usernameErr;
            } else {
                // Kiểm tra tên đăng nhập có bị trùng trong CSDL không.
                if($_POST['username'] != $user['username']){
                    $query = "select * from users where username = ?";
                    if ($stmt =  mysqli_prepare($con, $query)){
                        // Truyền Username từ form vào câu truy vấn.
                        mysqli_stmt_bind_param($stmt, "s", $paramUsername);
                        $paramUsername = trim($_POST['username']);
        
                        // Thực thi câu query
                        if(mysqli_stmt_execute($stmt)){
                            mysqli_stmt_store_result($stmt);
                            if(mysqli_stmt_num_rows($stmt) == 1){
                                $usernameErr = "Tên người dùng đã tồn tại.";
                                $noti->usernameErr =  $usernameErr;
                            } else {
                                $username = trim($_POST['username']);
                            }
                        } else {
                            // echo "LỖI! Vui lòng thử lại.";
                            $noti->err =  "LỖI! Vui lòng thử lại.";
                        }
                        // Đóng câu Statement
                        mysqli_stmt_close($stmt);
                    }
                } else {
                    $username = trim($_POST['username']);
                }
            }
    
            if(empty(trim($_POST['email']))){
                $emailErr = "Vui lòng dịa chỉ email";
                $noti->emailErr =  $emailErr;
            } elseif (!filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)){
                $emailErr = "Địa chỉ email không hợp lệ.";
                $noti->emailErr =  $emailErr;
            } else {
                if(trim($_POST['email']) != $user['email']){
                    // Kiểm tra email có bị trùng trong CSDL không.
                    $query = "select * from users where email = ?";
                    if ($stmt =  mysqli_prepare($con, $query)){
                        mysqli_stmt_bind_param($stmt, "s", $paramEmail);
                        $paramEmail = trim($_POST['email']);
        
                        // Thực thi câu query
                        if(mysqli_stmt_execute($stmt)){
                            mysqli_stmt_store_result($stmt);
                            if(mysqli_stmt_num_rows($stmt) == 1){
                                $emailErr = "Địa chỉ email đã tồn tại.";
                                $noti->emailErr =  $emailErr;
                            } else {
                                $email = trim($_POST['email']);
                            }
                        } else {
                            // echo "LỖI! Vui lòng thử lại.";
                            $noti->err =  "LỖI! Vui lòng thử lại.";
                        }
                        // Đóng câu Statement
                        mysqli_stmt_close($stmt);
                    } 
                }else {
                    $email = trim($_POST['email']);
                }
                
            }
            if(!empty($_POST['password1']) || !empty($_POST['password2'])){
                if(empty(trim($_POST['password1']))){
                    $password1Err = "Vui lòng nhập mật khẩu";
                    $noti->password1Err =  $password1Err;
                } elseif (strlen(trim($_POST['password1'])) < 6){
                    $password1Err = "Mật khẩu phải nhiều hơn 5 kí tự.";
                    $noti->password1Err =  $password1Err;
                } else {
                    $password1 = trim($_POST['password1']);
                    
                }

                if(empty(trim($_POST['password2']))){
                    $password2Err = "Vui lòng nhập xác nhận mật khẩu";
                    $noti->password2Err =  $password2Err;
                } else {
                    $password2 = trim($_POST['password2']);
                    if(empty($password1Err) && ($password1 != $password2)){
                        $password2Err = "Mật khẩu không khớp";
                        $noti->password2Err =  $password2Err;
                    }else{
                        $password1 = password_hash($password1, PASSWORD_DEFAULT);
                    }
                }
            }else{
                $password1 = $user['password'];
            }
            // Kiểm tra họ và tên
            if(empty(trim($_POST['fullname']))){
                $fullnameErr = "Vui lòng nhập họ và tên.";
                $noti->fullnameErr =  $fullnameErr;
            } elseif(strlen(trim($_POST['fullname'])) > 100){
                $fullnameErr = "Họ và tên quá dài.";
                $noti->fullnameErr =  $fullnameErr;
            } else {
                $fullname = trim($_POST['fullname']);
            }
    
            // Kiểm tra và insert dữ liệu vào CSDL
            if(empty($usernameErr) && empty($password1Err) && empty($password2Err) && empty($fullnameErr) && empty($emailErr)){
                $query = "update users set fullname = ?, username = ?, password = ?, email = ?, role = ? where token='$token'";
                if($stmt = mysqli_prepare($con, $query)){
                    mysqli_stmt_bind_param($stmt, "sssss", $paramFullname, $paramUsername, $paramPassword, $paramEmail, $paramRole);
                    $paramUsername = $username;
                    $paramFullname = $fullname;
                    $paramEmail = $email;
                    $paramPassword = $password1;
                    if($_SESSION['role'] == 'admin'){
                        $paramRole = trim($_POST['role']);
                    }else{
                        $paramRole = "member";
                    }
                    if(mysqli_stmt_execute($stmt)){
                        // header("location: /user/login.php");
                        $noti->err =  "Cập nhật tài khoản thành công...";
                    } else {
                        // echo "Có lỗi xảy ra, vui lòng thử lại...";
                        $noti->err =  "Có lỗi xảy ra, vui lòng thử lại...";
    
                    }
                    mysqli_stmt_close($stmt);
                }
            }
            mysqli_close($con);
            echo json_encode($noti);

        }
    }else{
        $noti->err = "Bạn không có quyền chỉnh sửa người dùng này!";
        echo json_encode($noti);
    }
?>