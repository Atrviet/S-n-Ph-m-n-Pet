<?php
session_start();
if(!isset($_SESSION['name_account'])){
		header('Location: LoGin.php');
		exit; 
}
require('connect.php');
$tk = $_SESSION['name_account'];
$idaccount = $_SESSION['IdAccount'];

if(isset($_POST['Complete'])){
    $img_new = $_FILES['ReplaceImg']['name'];
    $img_new_tmp = $_FILES['ReplaceImg']['tmp_name'];

    if (!empty($img_new)) {
        move_uploaded_file($img_new_tmp, 'UploadAvt/' . $img_new);
        $sql = "UPDATE account SET img_user = '$img_new' WHERE id_account = '$idaccount'";
        mysqli_query($conn, $sql);
    } else {
        echo "<script>alert('Vui lòng chọn ảnh mới trước khi hoàn tất');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Cá Nhân</title>
    <!-- <link rel="stylesheet" href="styless.css"> -->
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

</style>
</head>
<body class="BodyMySelft">
    <header class="HeaderMySelft">
        <h1>Trang Cá Nhân</h1>
        <h1>Welcome, <?php echo $_SESSION['name_account']; ?>!</h1>
    </header>
    <main class="DetailMySelft">
        <section class="profile">
            <?php
            $sql = "SELECT img_user FROM account WHERE id_account = '$idaccount'";
            $sql_q = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_array($sql_q)) {
                $img_user = $row['img_user'];
            ?>
            <form action="" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                <label for="SelectImg">
                   <img class="MyImg" id="avatarPreview"  src="./UploadAvt/<?php echo $img_user ?>" alt="Ảnh Đại Diện">
                </label>
                   <input type="file" name="ReplaceImg" id="SelectImg" style="display: none;" onchange="previewImage(event)">
                   <input type="submit" name="Complete" class="Complete" value="XONG" >
            </form>
            <?php
            }
            ?>
            <p class="NameAcc">Tên Tài Khoản: <?php echo $_SESSION['name_account']; ?></p>
        </section>

        <section class="rating">
            <h2 class="Point">Điểm Uy Tín</h2>
            <div class="stars">
                <?php
                $sql_user = "SELECT * FROM account WHERE id_account='$idaccount'";
                $sql_query = mysqli_query($conn, $sql_user);
                if ($rows = mysqli_fetch_array($sql_query)) {
                    for ($i = 1; $i <= $rows['star']; $i++) {
                        echo '<span class="star">&#9733;</span>';
                    }
                }
                ?>
            </div>
        </section>

        <div class="pet-container">
            <div class="MyPetInfor">
                <?php
                if (isset($idaccount)) {
                    $sql_user = "SELECT * FROM myPet WHERE id_account='$idaccount'";
                    $sql_query = mysqli_query($conn, $sql_user);

                    echo "<section class='products'>";
                    echo "<h2>PET ĐĂNG TẢI</h2>";
                    echo "<ul class='ListInfor'>";

                    if ($rows = mysqli_fetch_array($sql_query)) {
                        $pettrangthai = $rows['pet_trangthai'];

                        $sql_pet = "SELECT * FROM pets WHERE id_account='$idaccount'";
                        $sql_query_pet = mysqli_query($conn, $sql_pet);

                        while ($rows_pet = mysqli_fetch_array($sql_query_pet)) {
                            $avt_pet = $rows_pet['avt_pet'];

                            echo "<li class='InforMain'>";
                            echo "<strong>Tên Thú Cưng: </strong>" . $rows_pet['name_pet'];
                            echo "<br>";
                            echo "<em>Thời Gian $pettrangthai " . $rows_pet['time_uppset'] . "</em>";
                            echo "<br>";
                            echo "<img src='UploadAvt/$avt_pet' class='avt_pet'>";
                            echo "<br>";
                            echo "<span class='status'>Trạng Thái: $pettrangthai </span>";
                            echo "<br>";
                            echo "<a href='FixPet.php?idpet=" . $rows_pet['id_pet'] . "'>Sửa thông tin PET của tôi</a>";
                            echo "<br>";
                            echo "<a href='DeleteMyPet.php?idpet=" . $rows_pet['id_pet'] . "'>Xóa thông tin PET của tôi</a>";
                            echo "<br>";
                            echo "</li>";
                        }
                    }

                    echo "</ul>";
                    echo "</section>";
                } else {
                    header('Location: LoGin.php');
                }
                ?>
            </div>
        </div>

        <a href="index.php" class="btn-back">Quay lại trang chủ</a>
        <a href="ChangePass.php" class="btn-back">Đổi mật khẩu</a>
        <a href="LoGin.php?logout" class="btn-back" name="dangxuat">Đăng xuất</a>
        <a href="qrCode.php" class="btn-back">Donate Web</a>
    </main>
    <script>
    function validateForm() {
        const fileInput = document.getElementById('SelectImg');
        if (fileInput.files.length === 0) {
            alert('Vui lòng chọn ảnh mới trước khi hoàn tất');
            return false;
        }
        return true;
    }

    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('avatarPreview');
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }

    document.getElementById('avatarPreview').addEventListener('click', function() {
        document.getElementById('SelectImg').click();
    });
    </script>
</body>
</html>
