<?php 
    header("Content-Type: application/json");
    require_once "../../config/Config.php";
    require_once "../../config/Token.php";
    $username = $password1 = $password2 = $fullname = $email = "";
    $usernameErr = $password1Err = $password2Err = $fullnameErr = $emailErr = "";
    $noti = new stdClass();
    $noti->usernameErr =  $usernameErr;
    $noti->password1Err =  $password1Err;
    $noti->password2Err =  $password2Err;
    $noti->fullnameErr =  $fullnameErr;
    $noti->emailErr =  $emailErr;
    $noti->err = "";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // Kiểm tra Username, password có rỗng không?
        if(empty(trim($_POST['username']))){
            $usernameErr = "Vui lòng nhập tên đăng nhập";
            $noti->usernameErr =  $usernameErr;
        } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
            $usernameErr = "Chỉ có thể chứa các chữ cái, số và dấu gạch dưới.";
            $noti->usernameErr =  $usernameErr;
        } else {
            // Kiểm tra tên đăng nhập có bị trùng trong CSDL không.
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
        }

        if(empty(trim($_POST['email']))){
            $emailErr = "Vui lòng dịa chỉ email";
            $noti->emailErr =  $emailErr;
        } elseif (!filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)){
            $emailErr = "Địa chỉ email không hợp lệ.";
            $noti->emailErr =  $emailErr;
        } else {
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
        }

        // Kiểm tra mật khẩu
        if(empty(trim($_POST['password1']))){
            $password1Err = "Vui lòng nhập mật khẩu";
            $noti->password1Err =  $password1Err;
        } elseif (strlen(trim($_POST['password1'])) < 6){
            $password1Err = "Mật khẩu phải nhiều hơn 5 kí tự.";
            $noti->password1Err =  $password1Err;
        } else {
            $password1 = trim($_POST['password1']);
        }

        // Kiểm tra xác nhận mật khẩu
        if(empty(trim($_POST['password2']))){
            $password2Err = "Vui lòng nhập xác nhận mật khẩu";
            $noti->password2Err =  $password2Err;
        } else {
            $password2 = trim($_POST['password2']);
            if(empty($password1Err) && ($password1 != $password2)){
                $password2Err = "Mật khẩu không khớp";
                $noti->password2Err =  $password2Err;
            }
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
            $query = "insert into users(username, password, fullname, avatar_img, email, role, token) values (?, ?, ?, ?, ?, ?, ?)";
            if($stmt = mysqli_prepare($con, $query)){
                mysqli_stmt_bind_param($stmt, "sssssss", $paramUsername, $paramPassword, $paramFullname, $paramAvatarImg, $paramEmail, $paramRole,  $paramToken);
                $paramAvatarImg = "https://ui-avatars.com/api/?background=random&name=".$username."&format=svg";
                $paramUsername = $username;
                $paramFullname = $fullname;
                $paramEmail = $email;
                $token = new Token();
                $paramPassword = password_hash($password1, PASSWORD_DEFAULT);

                if(isset(($_POST['role']))){
                    $paramRole = trim($_POST['role']);
                }else{
                    $paramRole = "user";
                }
                
                $paramToken = $token->generate(10);
                if(mysqli_stmt_execute($stmt)){
                    // header("location: /user/login.php");
                    $noti->err =  "Tạo tài khoản thành công...";
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
?>