<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng tải thành công!</title>
    <link rel="stylesheet" href="styless.css">
</head>
<?php
session_start();
require('connect.php');
$id_account = $_SESSION['IdAccount'];
if(!isset($_SESSION['name_account'])){
	header('Location: LoGin.php');
exit; 
}
if(isset($_SESSION['IdPetUp']))

$id_pet =$_SESSION['IdPetUp'];
include('BotNoti/bot.php');
     $id_account = $_SESSION['IdAccount'];
    //    id account
   $sql = "INSERT INTO myPet(id_account,id_pet,pet_trangthai) VALUES('$id_account','$id_pet','Đăng Tải')";
    mysqli_query($conn,$sql);

    
?>
<body class="BodyUploadSC">
    <div class="success-message">
        <h1 class="Celebrate">Chúc mừng!</h1>
        <p class="Noti">Bạn đã đăng tải thông tin thú cưng thành công!</p>
        <div class="buttons">
            <a href="UpLoad.php?tk=<?php echo $_SESSION['name_account'] ?>" class="BtnUpload">Thêm Pet</a>
            <a href="index.php?tk=<?php echo $_SESSION['name_account'] ?>" class="BtnUpload">Quay về Trang chủ</a>
        </div>
    </div>
</body>
</html>
