<?php
require('connect.php');
session_start();
if(!isset($_SESSION['name_account'])){
		header('Location: LoGin.php');
		exit; 
}
$id =$_SESSION['IdAccount'];
if(isset($_POST['get_id'])){
	$id_tele = $_POST['id_tele'];
    if(strlen($id_tele)<= 9 ||strlen($id_tele) >= 15){
        echo "<script>alert('ID không chính xác, ID tele cần từ 9 tới 15 kí tự');</script>";
    }else{
        $sql = "UPDATE account SET tele_id='$id_tele' WHERE id_account='$id'";
        mysqli_query($conn,$sql);
        echo "<script>alert('Cập Nhật ID thành công!!!');</script>";
    }
}

?>
    <style>
        .body_bot {
            font-family: Arial, sans-serif;
         
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f5f5f5;
        }
        .container_bot {
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            max-width: 400px;
            width: 100%;
            text-align: center;
												margin-left: 230px;
        }
        .container_bot p {
            margin: 10px 0;
        }
        .container_bot input[type="number"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .container_bot input[type="submit"] {
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .container_bot input[type="submit"]:hover {
            background-color: #218838;
        }
        .notification {
            display: none;
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #28a745;
            color: #fff;
            padding: 15px;
            border-radius: 4px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            animation: fadeInOut 5s forwards;
        }
        @keyframes fadeInOut {
            0% { opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { opacity: 0; }
        }
        @media (max-width: 600px) {
            .container_bot {
                margin: 20px;
                padding: 15px;
            }
        }
        @media (max-width: 486px) {
            .container_bot {
                margin: 0px;
                padding: 0px;
            }
        }
								.home_btn {
    display: inline-block;
    margin: 10px;
    padding: 10px 20px;
    background-color: #0073e6;
    color: white;
    text-align: center;
    border-radius: 5px;
    text-decoration: none;
}

.home_btn:hover {
    background-color: #005bb5;
}

    </style>
</head>
<form action="" method="post">
<body class="body_bot">
    <div class="container_bot">
        <p class="id_tele">ID TELEGRAM</p>
        <input type="number" name="id_tele"  placeholder="Nhập ID telegram của bạn">
        <p class="note">Mọi Thông Báo sẽ được tự động gửi về tài khoản TELEGRAM của bạn</p>
        <p class="step_take_ID">Bước 1: Lấy ID TELEGRAM của bạn bằng nhấp nhấn<a href="https://t.me/getmyid_bot?start=botostore"> TẠI ĐÂY</a> và bấm START sau đó copy ID</p>
        <p class="step_detail">Bước 2: Bấm <a href="#">VÀO ĐÂY</a> !!! , Khi có bất cứ thông tin mới bot sẽ cập nhật cho bạn</p>
        <p class="step_detail">Bước 3: Bấm nút XÁC NHẬN để bot bắt đầu làm việc</p>
        <p class="step_take_ID">***: Trường hợp phòng khi quên mật khẩu hãy dùng Bot bằng nhấp nhấn<a href="#"> TẠI ĐÂY</a> và bấm START sau đó nhập sđt </p>
        <input type="submit" value="XÁC NHẬN" id="submit_btn" name="get_id">
        <a href="index.php" class="home_btn" name="">Trang Chủ</a>
        </form>
    </div>
    <div class="notification" id="notification">
        Bạn đã cập nhật ID Telegram thành công!
    </div>

    
</body>
</html>
