<?php
require('connect.php');
session_start();
if(!isset($_SESSION['name_account'])){
		header('Location: LoGin.php');
		exit; 
}
if(isset($_GET['idpet'])){
	$idpet = $_GET['idpet'];
	$sqluser = "DELETE FROM myPet WHERE id_pet = '$idpet'";
	mysqli_query($conn, $sqluser);
	$sqlimg = "SELECT * FROM pets WHERE id_pet = '$idpet'";
	$query = mysqli_query($conn, $sqlimg);

	while($row = mysqli_fetch_array($query)){
		unlink('UploadAvt/'.$row['avt_pet']);
	}

	$sqlpet = "DELETE FROM pets WHERE id_pet = '$idpet'";
	mysqli_query($conn, $sqlpet);

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="styless.css">
	<title>Document</title>
</head>
<body>
<div class="containerDelete">
        <p class="DeleteSc">Xóa thành công</p>
        <a href="Myselft.php" class="btn-delete">Xóa Tiếp</a>
        <a href="Myselft.php" class="btn-cancel">Quay về My Pet</a>
    </div>
</body>
</html>