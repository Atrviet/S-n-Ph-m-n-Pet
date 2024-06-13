<?php
require('connect.php');
session_start();
if(!isset($_SESSION['name_account'])){
		header('Location: LoGin.php');
		exit; 
}

if(isset($_GET['idpet'])){
    $IdAccount = $_SESSION['IdAccount'];
    $idpet = $_GET['idpet'];
    $sqlcheck = "SELECT * FROM adopt WHERE id_account = '$IdAccount' AND pet_id = '$idpet'";
    $sqlchecki = mysqli_query($conn,$sqlcheck);
     
    if(mysqli_num_rows($sqlchecki) > 0){
					header("Location: NotiIsset.php");
    }
    else{
					$sql_boss = "SELECT id_account FROM pets WHERE id_pet='$idpet'";
					$query_boss = mysqli_query($conn,$sql_boss);
					while($row = mysqli_fetch_array($query_boss)){
						$id_account_boss = $row['id_account'];
						if($IdAccount == $id_account_boss){
						     echo "<script>alert('Đây là pet của bạn. Không Thể Nhận nuôi!!!');</script>";
						     
						}else{
						$sqla = "INSERT INTO adopt(id_account,pet_id,id_account_boss) VALUES ('$IdAccount','$idpet','$id_account_boss')";
						mysqli_query($conn,$sqla);
				        require('BotNoti/botAdopt.php');
						    
						}
					}
				
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
	<div class="Container_require">
	    <?php
	    if($IdAccount == $id_account_boss){
					?>
		<a href="index.php" class="btn_Home">Quay về trang chủ</a>
		<a href="Detail.php?idpet=<?php echo $idpet ?>"  class="btn_Home">Quay lại</a>
					<?php
						     
						}else{
						    ?>
						    	<h1 class="RequireNoti">Bạn đã yêu cầu thành công hãy đợi chủ nhé</h1>
		<a href="index.php" class="btn_Home">Quay về trang chủ</a>
		<a href="Detail.php?idpet=<?php echo $idpet ?>"  class="btn_Home">Quay lại</a>
		 <!--onclick="history.go(-1); -->
						    
						    <?php
						    
						    
						}
	    ?>
	

	
	</div>
</body>
</html>