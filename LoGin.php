<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="UploadAvt/logo web pet.png">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(45deg, #ff9a9e, #fad0c4);
            font-family: 'Arial', sans-serif;
            margin: 0;
        }

        .LoGinContainer {
            background: rgba(255, 255, 255, 0.8);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }

        .LoGinContainer h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .input-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .TaiKhoan, .MatKhau {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: bold;
        }

        .InputAccount, .InputPassword {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s;
        }

        .InputAccount:focus, .InputPassword:focus {
            border-color: #007bff;
            outline: none;
        }

        .LoGin {
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s, transform 0.3s;
        }

        .LoGin:hover {
            background: #0056b3;
            transform: scale(1.05);
        }

        .Sign_Up_Now {
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

        .Sign_Up_Now:hover {
            background-color: #218838;
            transform: scale(1.1);
        }

        .message {
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
            font-size: 16px;
            text-align: center;
        }

        .message.error {
            background-color: #f8d7da;
            color: #721c24;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .img_gg{
            height: 30px;
            width: 30px;
        }
    </style>
</head>
<body class="body_login">
    <?php
   session_start();
   require('connect.php');
  
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 0;
    }
    $message = "";
    if (isset($_POST['LoGin'])) {
        $account = $_POST['account'];
        $password = $_POST['password'];
        if (preg_match('/[^a-zA-Z0-9]/', $account) || preg_match('/[^a-zA-Z0-9]/', $password)) {
            echo "<script>alert('Tài Khoản hoặc Mật Khẩu không được chứa kí tự đặc biệt');</script>";
            
        }else{
            $sql = "SELECT * FROM account WHERE tk='$account' AND mk='$password'";
            $result = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($result);
    
            if ($count > 0) {
                $_SESSION['name_account'] = $account;
                $_SESSION['login_attempts'] = 0; // Reset attempts on successful login
                header("Location: index.php");
            } else {
                $_SESSION['login_attempts'] += 1;
                if ($_SESSION['login_attempts'] > 3) {
                    $message = "Bạn đã đăng nhập thất bại quá 3 lần. Vui lòng thử lại sau.";
                } else {
                    $message = "Đăng nhập thất bại. Vui lòng đăng nhập lại.";
                }
            }
        }
    }
    if (isset($_GET['logout'])) {
        session_destroy();
    }
    if(isset($_SESSION['name_account'])){
        header('Location: index.php');
        exit; 
}
    ?>

    <div class="LoGinContainer">
        <form action="" method="post">
            <img src="UploadAvt/logo web pet.png" alt="" class="logo_web">
            <h2>Đăng nhập</h2>
            <div class="input-group">
                <label for="account" class="TaiKhoan">Tài khoản</label>
                <input type="text" id="account" name="account" class="InputAccount" required>
            </div>
            <div class="input-group">
                <label for="password" class="MatKhau">Mật khẩu</label>
                <input type="password" id="password" name="password" class="InputPassword" required>
            </div>
            <input type="submit" name="LoGin" class="LoGin" value="Đăng Nhập">
           
            <?php
            include('LoginGG/index.php');
            ?>
            <a href="SignUp.php" class="Sign_Up_Now">Đăng Ký Ngay</a>
            <a href="ForgotPass.php" class="Sign_Up_Now">Quên Mật Khẩu</a>

        </form>
        <?php if ($message != ""): ?>
            <div class="message error">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="scripts.js"></script>
</body>
</html>