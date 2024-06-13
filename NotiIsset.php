<?php
session_start();
if(!isset($_SESSION['name_account'])){
		header('Location: LoGin.php');
		exit; 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông báo đã nhận nuôi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
        }

        .btn {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>BẠN ĐÃ NHẬN NUÔI PET NÀY RỒI ĐƠI CHỦ PHẢN HỒI NHÉ</h1>
        <a href="index.php" class="btn">Quay về trang chủ</a>
        <a href="#" onclick="history.go(-1);" class="btn">Quay lại</a>
    </div>
</body>
</html>
