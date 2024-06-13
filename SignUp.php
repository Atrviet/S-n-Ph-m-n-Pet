<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="styless.css">
    <link rel="icon" href="UploadAvt/logo web pet.png">
</head>
<style>
    .BodySignUp {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background: linear-gradient(45deg, #83a4d4, #b6fbff);
}

.SignUp {
    width: 900px;
    background: rgba(255, 255, 255, 0.9);
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    text-align: center;
    transition: transform 0.3s ease-in-out;
}

.SignUp:hover {
    transform: scale(1.05);
}

.img_logo {
    width: 120px;
    height: auto;
}

.TextRegis {
    margin: 20px 0;
    color: #333;
}

.form-group {
    margin-bottom: 15px;
}

.Infor {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #444;
}

#account, #password, #email, #username {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    transition: border-color 0.3s ease-in-out;
}

#account:focus, #password:focus, #email:focus, #username:focus {
    border-color: #007bff;
    outline: none;
}

.enter {
    width: 100%;
    padding: 10px;
    background: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s ease-in-out;
}

.enter:hover {
    background: #0056b3;
}

.message {
    margin-top: 20px;
    font-size: 16px;
    display: none;
    padding: 10px;
    border-radius: 5px;
}

.message.success {
    background-color: #d4edda;
    color: #155724;
}

.message.error {
    background-color: #f8d7da;
    color: #721c24;
}

.message.show {
    display: block;
    animation: fadein 1s, fadeout 1s 3s;
}

@keyframes fadein {
    from {opacity: 0;}
    to {opacity: 1;}
}

@keyframes fadeout {
    from {opacity: 1;}
    to {opacity: 0;}
}
.login_now {
    display: block;
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #28a745;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s, transform 0.3s;
    text-align: center;
}

.login_now:hover {
    background-color: #218838;
    transform: scale(1.1);
}
</style>
<?php
  session_start();
  require('connect.php');
  if(isset($_SESSION['name_account'])){
          header('Location: index.php');
          exit; 
  }
if(isset($_POST['register'])){
    $account= $_POST['account'];
    $password= $_POST['password'];
    $username= $_POST['username'];
    $email= $_POST['email'];
    if (preg_match('/[^a-zA-Z0-9]/', $account) || preg_match('/[^a-zA-Z0-9]/', $password)) {
        echo "<script>alert('Tài Khoản hoặc Mật Khẩu không được chứa kí tự đặc biệt');</script>";
    } else {
        $sql_check = "SELECT * FROM account WHERE tk='$account'";
        $sql_check_query = mysqli_query($conn, $sql_check);
        $check_tk = mysqli_fetch_array($sql_check_query);
    
        if($check_tk > 0){
            echo "<script>alert('Tài khoản đã tồn tại');</script>";
        } else {
            $sql_register = "INSERT INTO account(tk,mk,email,names) VALUES('$account','$password','$email','$username')";
            $query = mysqli_query($conn, $sql_register);
                header("Location: LoGin.php");
            }
        }
    }

?>
</head>
<body class="BodySignUp">
<div class="SignUp">
    <img src="UploadAvt/logo web pet.png" alt="" class="img_logo">
    <h2 class="TextRegis">Đăng ký</h2>
    <form action="" method="POST" onsubmit="return validateForm()">
        <div class="form-group">
            <label class="Infor">Tên tài khoản:</label>
            <input type="text" id="account" name="account" required>
        </div>
        <div class="form-group">
            <label class="Infor">Mật khẩu:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label class="Infor">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label class="Infor">Name:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <input type="submit" name="register" value="Đăng Ký" class="enter">
    </form>
    <div id="message" class="message"><?php echo $message; ?></div>
</div>
<a href="LoGin.php" class="login_now">Đăng Nhập Ngay</a>
<a href="ForgotPass.php" class="login_now">Quên Mật Khẩu</a>

<script>
    function validateForm() {
        var account = document.getElementById("account").value;
        var password = document.getElementById("password").value;
        var email = document.getElementById("email").value;

        // Check if email contains '@'
        if (email.indexOf('@') === -1) {
            alert("Vui lòng nhập đúng định dạng email.");
            return false;
        }

        // Check length of account and password
        if (account.length < 6 || password.length < 6) {
            alert("Tài khoản và mật khẩu phải từ 6 ký tự trở lên.");
            return false;
        }

        // Form is valid
        return true;
    }
</script>

</body>
</html>