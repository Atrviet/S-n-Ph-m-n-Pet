<?php
session_start();
require('connect.php');

if (isset($_SESSION['IdAccount'])) {
    $idaccount = $_SESSION['IdAccount'];
} else {
    header('Location: LoGin.php');
    exit;
}

if (isset($_GET['idpet'])) {
    $idpet = $_GET['idpet'];
}

if (isset($_POST['finish'])) {
    $name = $_POST['name_pet'];
    $type = $_POST['type_pet'];
    $color = $_POST['colour_pet'];
    $address = $_POST['address_pet'];
$avatar = $_FILES['uploaded_file']['name'];
    // Check if a new image was uploaded
    if (!empty($avatar)) {
    $avatar = md5($_FILES['uploaded_file']['name']).'.jpg';
    $avatar_tmp = $_FILES['uploaded_file']['tmp_name'];
        // Move the uploaded file to the final directory
        move_uploaded_file($avatar_tmp, 'UploadAvt/' . $avatar);
        // Include the new image in the SQL query
        $sql = "UPDATE pets SET name_pet='$name', type_pet='$type', colour_pet='$color', address_pet='$address', avt_pet='$avatar',sent='0' WHERE id_pet='$idpet'";
    } else {
        // Exclude the image from the SQL query
        $sql = "UPDATE pets SET name_pet='$name', type_pet='$type', colour_pet='$color', address_pet='$address' WHERE id_pet='$idpet'";
    }

    mysqli_query($conn, $sql);
    include('BotNoti/botFixPet.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa thông tin PET</title>
    <style>
        /* General styles */
body, html {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
}

.BodyMySelft {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
}

.HeaderMySelft {
    text-align: center;
    background-color: #0073e6;
    color: white;
    padding: 20px 0;
    width: 100%;
    margin-bottom: 20px;
}

.HeaderMySelft h1 {
    margin: 0;
    font-size: 2em;
}

/* Profile section styles */
.DetailMySelft {
    width: 80%;
    max-width: 1000px;
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.profile {
    text-align: center;
    margin-bottom: 30px;
}

.MyImg {
    border-radius: 50%;
    width: 150px;
    height: 150px;
    object-fit: cover;
    cursor: pointer;
}

.NameAcc {
    font-size: 1.5em;
    margin-top: 20px;
}

/* Rating section styles */
.rating {
    text-align: center;
    margin-bottom: 30px;
}

.Point {
    font-size: 1.5em;
    margin-bottom: 10px;
}

.stars {
    font-size: 2em;
    color: #FFD700;
}

.star {
    display: inline-block;
}

/* Pet container styles */
.pet-container {
    margin-bottom: 30px;
}

.MyPetInfor {
    background-color: #f9f9f9;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.products h2 {
    font-size: 1.5em;
    margin-bottom: 20px;
}

.ListInfor {
    list-style-type: none;
    padding: 0;
}

.InforMain {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.avt_pet {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 10px;
    margin-top: 10px;
}

.status {
    font-weight: bold;
    color: #0073e6;
}

a {
    color: #0073e6;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

/* Buttons */
.btn-back {
    display: inline-block;
    margin: 10px 10px 0 0;
    padding: 10px 20px;
    background-color: #0073e6;
    color: white;
    text-align: center;
    border-radius: 5px;
    text-decoration: none;
}

.btn-back:hover {
    background-color: #005bb5;
}

/* Form styles */
form {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

form input[type="text"], form input[type="file"] {
    margin-bottom: 10px;
    padding: 5px;
    font-size: 1em;
    width: 100%;
}

form input[type="submit"] {
    align-self: center;
    padding: 10px 20px;
    background-color: #0073e6;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

form input[type="submit"]:hover {
    background-color: #005bb5;
}

form label {
    font-weight: bold;
}

    </style>
</head>
<body class="BodyMySelft">
    <header class="HeaderMySelft">
        <h1>Chỉnh sửa thông tin PET</h1>
    </header>
    <main class="DetailMySelft">
        <div class="pet-container">
            <div class="MyPetInfor">
                <section class='products'>
                    <h2>PET ĐĂNG TẢI</h2>
                    <ul class='ListInfor'>
                        <?php
                        $sql_pet = "SELECT * FROM pets WHERE id_pet='$idpet'";
                        $sql_query_pet = mysqli_query($conn, $sql_pet);

                        while ($rows_pet = mysqli_fetch_array($sql_query_pet)) {
                            $avt_pet = $rows_pet['avt_pet'];
                            $name_pet = $rows_pet['name_pet'];
                            $time_uppset = $rows_pet['time_uppset'];
                            $type_pet = $rows_pet['type_pet'];
                            $colour_pet = $rows_pet['colour_pet'];
                            $address_pet = $rows_pet['address_pet'];
                        ?>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <li class='InforMain'>
                                <label for="name_pet">Tên Thú Cưng:</label>
                                <input type='text' value='<?php echo $name_pet; ?>' name="name_pet">
                                <br>
                                <label for="type_pet">Loại Thú Cưng:</label>
                                <input type='text' value='<?php echo $type_pet; ?>' name="type_pet">
                                <br>
                                <label for="colour_pet">Màu Sắc:</label>
                                <input type='text' value='<?php echo $colour_pet; ?>' name="colour_pet">
                                <br>
                                <label for="address_pet">Địa Chỉ:</label>
                                <input type='text' value='<?php echo $address_pet; ?>' name="address_pet">
                                <br>
                                <label for="time_pet">Thời Gian:</label>
                                <input type='text' value='<?php echo $time_uppset; ?>' name="time_pet" readonly>
                                <br>
                                <label for="uploaded_file">Hình ảnh PET:</label>
                                <input type='file' name='uploaded_file'>
                                <img src='UploadAvt/<?php echo $avt_pet; ?>' alt='Hình ảnh pet' name="img_pet">
                                <br>
                                <input type="submit" value="Hoàn Tất" name="finish">
                            </li>
                        </form>
                        <?php } ?>
                    </ul>
                </section>
            </div>
        </div>
        <a href="index.php" class="btn-back">Quay lại trang chủ</a>
        <a href="ChangePass.php" class="btn-back">Đổi mật khẩu</a>
        <a href="LoGin.php?logout" class="btn-back" name="dangxuat">Đăng xuất</a>
    </main>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.querySelector("form");
        const inputs = form.querySelectorAll("input[type='text']");
        const fileInput = form.querySelector("input[type='file']");
        const submitButton = form.querySelector("input[type='submit']");
        const imgPreview = form.querySelector("img[name='img_pet']");

        let originalValues = {};
        inputs.forEach(input => {
            originalValues[input.name] = input.value;
        });

        fileInput.addEventListener("change", function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imgPreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        form.addEventListener("submit", function(event) {
            let hasChanged = false;

            inputs.forEach(input => {
                if (input.value !== originalValues[input.name]) {
                    hasChanged = true;
                }
            });

            if (fileInput.files.length > 0) {
                hasChanged = true;
            }

            if (!hasChanged) {
                event.preventDefault();
                alert("Bạn chưa thay đổi gì cả!");
            }
        });
    });
    </script>
</body>
</html>
