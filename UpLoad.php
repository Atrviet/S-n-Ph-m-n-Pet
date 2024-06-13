<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Information</title>
    <link rel="stylesheet" href="styless.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<?php
session_start();
if(!isset($_SESSION['name_account'])){
    header('Location: LoGin.php');
    exit; 
}
include('connect.php');

function resizeImage($file, $new_width, $new_height) {
    list($orig_width, $orig_height) = getimagesize($file);

    $image_p = imagecreatetruecolor($new_width, $new_height);
    $image = imagecreatefromjpeg($file);

    // Resize and crop
    $orig_aspect = $orig_width / $orig_height;
    $new_aspect = $new_width / $new_height;

    if ($orig_aspect >= $new_aspect) {
        // If original image is wider than required aspect ratio
        $temp_height = $new_height;
        $temp_width = (int) ($new_height * $orig_aspect);
        $src_x = (int) (($temp_width - $new_width) / 2);
        $src_y = 0;
    } else {
        // If original image is taller than required aspect ratio
        $temp_width = $new_width;
        $temp_height = (int) ($new_width / $orig_aspect);
        $src_x = 0;
        $src_y = (int) (($temp_height - $new_height) / 2);
    }

    imagecopyresampled($image_p, $image, 0, 0, $src_x, $src_y, $new_width, $new_height, $temp_width, $temp_height);

    $resized_file = 'UploadAvt/resized_' . md5($file) . '.jpg';
    imagejpeg($image_p, $resized_file, 100);

    imagedestroy($image_p);
    imagedestroy($image);

    return $resized_file;
}

if(isset($_GET['tk'])){
    $tk = $_GET['tk'];
    if(isset($_POST['UpLoad'])){
        $petName = $_POST['petName'];
        $petType = $_POST['petType'];
        $petColor = $_POST['petColor'];
        $petAddress = $_POST['petAddress'];
        $petNote = $_POST['petNote'];
        $avatar_tmp = $_FILES['petAvatar']['tmp_name'];
        $avatar = resizeImage($avatar_tmp, 275, 183);
        $avatar_name = md5($avatar) . '.jpg';
        rename($avatar, 'UploadAvt/' . $avatar_name);
        $current_timestamp = time();
        $datetime = date("Y-m-d H:i:s", $current_timestamp);

        $sql= "SELECT * FROM account WHERE tk='$tk'";
        $result = mysqli_query($conn,$sql);
        while($row = mysqli_fetch_array($result)){
            $IdAccount = $row['id_account'];
            $_SESSION['IdAccount'] = $IdAccount;
            $sqlThem = "INSERT INTO pets(name_pet, type_pet, colour_pet, address_pet, note_pet, id_account, avt_pet, time_uppset) 
                        VALUES ('$petName','$petType','$petColor','$petAddress','$petNote','$IdAccount','$avatar_name','$datetime')";
            mysqli_query($conn, $sqlThem);
            $newPetId = mysqli_insert_id($conn);
            $_SESSION['IdPetUp'] = $newPetId;

            header('Location: UpLoadSC.php');
        }
    }
}
?>
<body class="BodyUpload">
    <h1 class="InforPet">Thông tin Pet</h1>

    <form action="" class="FormUpload" method="post" enctype="multipart/form-data">
        <label for="petName" class="TitleInfor">Tên Pet:</label>
        <input type="text" id="petName" name="petName" required class="Size">

        <label for="petType" class="TitleInfor">Loại Pet:</label>
        <input type="radio" value="Chó" name="petType">Chó
        <input type="radio" value="Mèo" name="petType">Mèo

        <label for="petColor" class="TitleInfor">Màu sắc:</label>
        <input type="radio" value="white" name="petColor">Trắng
        <input type="radio" value="black" name="petColor">Đen
        <input type="radio" value="other" name="petColor">Khác

        <label for="petAddress" class="TitleInfor">Địa chỉ:</label>
        <input type="text" id="petAddress" name="petAddress" required class="Size">

        <label for="petAvatar" class="TitleInfor">Ảnh đại diện:</label>
        <input type="file" id="petAvatar" name="petAvatar" required class="Size">  

        <label for="petNote" class="TitleInfor">Ghi chú:</label>
        <textarea id="petNote" name="petNote" rows="4" class="note"></textarea>

        <input type="submit" name="UpLoad" value="Đăng tải" class="BtnUpload">
        <a href="index.php" class="BtnUpload BackHome">Back Home</a>
    </form>
</body>
</html>
