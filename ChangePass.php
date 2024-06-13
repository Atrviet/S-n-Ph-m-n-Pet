<?php
require('connect.php');
session_start();
if(!isset($_SESSION['name_account'])){
		header('Location: LoGin.php');
		exit; 
}
if(isset($_POST['doimatkhau'])){
	$id_account = $_SESSION['IdAccount'];
$passold = $_POST['passwordold'];
$passoldagain = $_POST['passwordoldagain'];
$passnew = $_POST['passwordnew'];
$sql = "SELECT * FROM account WHERE id_account = '$id_account'";
$sqly = mysqli_query($conn,$sql);
$count = mysqli_fetch_array($sqly);
	if($count>0){
				$pass = $count['mk'];
						if(($passold == $pass) == $passoldagain){
									if(isset($passnew)){
														$sql = "UPDATE account SET mk = '$passnew' WHERE id_account = '$id_account'";
																	mysqli_query($conn,$sql);

																	echo "đổi mật khẩu thành công";
			}
		}else{
			echo "đã có lỗi vui lòng nhập lại:";
		}
	
	}
}
if(isset($_POST['quaylai'])){
	header('Location: Myselft.php');
}
?>
<link rel="stylesheet" href="styless.css">
<body class="BodyChangePass">
    <h2 class="TitleChangePass">ĐỔI MẬT KHẨU</h2>
    <div class="container">
        <form action="" method="post">
            <label for="password" class="Require">Mật khẩu cũ:</label>
            <input type="password" name="passwordold" class="PassWord">

            <label for="password" class="Require">Nhập lại mật khẩu cũ:</label>
            <input type="password" name="passwordoldagain"  class="PassWord">

            <label for="password" class="Require">Mật khẩu mới:</label>
            <input type="password" name="passwordnew"  class="PassWord">

            <input type="submit" name="doimatkhau" value="Cập nhật" class="PassWord">
            <input type="submit" name="quaylai" value="Quay lại " class="PassWord">

        </form>
    </div>
</body>
</html>