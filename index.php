<?php
session_start();
require('connect.php');
if(isset($_GET['login'])){
    $token =$_GET['login'];
    $sql = "SELECT * FROM login_gg WHERE token = '$token'";
    $query = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_array($query)){
        $name = $row['full_name'];
        $picture = $row['picture'];
        $email = $row['email'];
        $check = "SELECT email FROM account WHERE email='$email'";
        $check_query = mysqli_query($conn,$check);
        if(mysqli_num_rows($check_query) > 0){
            
        }else{
            $insert = "INSERT INTO account(email,names,tk) VALUES ('$email','$name','$name')";
            mysqli_query($conn,$insert);
        }
    }
	$_SESSION['name_account'] = $name;
}
if(!isset($_SESSION['name_account'])){
		header('Location: LoGin.php');
		exit; 
}
// Phân trang
$countPetInAPage = 8;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$begin = ($page == '' || $page == 1) ? 0 : ($page * $countPetInAPage) - $countPetInAPage;

// Lấy tài khoản đang đăng nhập
$tk = $_SESSION['name_account'];
$sql = "SELECT * FROM account WHERE tk='$tk'";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($result)) {
    $IdAccount = $row['id_account'];
    $_SESSION['IdAccount'] = $IdAccount;
}
$id_account = $_SESSION['IdAccount'];

// Lấy thông tin tài khoản
$sql = "SELECT * FROM account WHERE id_account = '$id_account'";
$sqli = mysqli_query($conn, $sql);
$count = mysqli_fetch_array($sqli);
if ($count > 0) {
    $_SESSION['$imgUser'] = $count['img_user'];
}
$img_new = $_SESSION['$imgUser'];

// Lấy danh sách loại thú cưng
$sqlType = "SELECT DISTINCT type_pet FROM pets";
$typeResult = mysqli_query($conn, $sqlType);

// Lấy danh sách màu sắc
$sqlColor = "SELECT DISTINCT colour_pet FROM pets";
$colorResult = mysqli_query($conn, $sqlColor);

// Lấy danh sách địa chỉ
$sqlAddress = "SELECT DISTINCT address_pet FROM pets";
$addressResult = mysqli_query($conn, $sqlAddress);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Exchange</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="styles_home.css">
</head>

<body class="BodyHome">
<header class="HeaderHome">
    <h1 class="logo">Pet Exchange</h1>
    <?php
    // check logined
    if (isset($_SESSION['name_account'])) {
        echo "<h1 class='LoGinSC'>Welcome " . $_SESSION['name_account'] . "</h1>";
    } else {
        header('Location: LoGin.php');
        exit;
    }
    ?>
    <nav class="NavBar">
    <ul class="ul_nav">
        <li class="noti">
           <a href="formTele.php"><i class="fa-solid fa-bell"></i></a>
        </li>
    </ul>
    </nav>
    <div class="MySelft">
        <a href="Myselft.php"><img class="ImgMyselft" src="UploadAvt/<?php echo $img_new ?>" alt="User Avatar"></a>
    </div>
</header>

<div class="ContentSearchHome">
    <div class="search-bar">
        <div class="search-bar-item">
            <input type="text" placeholder="Search..." class="Search">
        </div>
        <div class="search-bar-item">
            <button type="submit" class="BtnSearch">Search</button>
        </div>
    </div>
    <!-- <div  class="upload-button">
        <a class="icon" href="" class="fas fa-upload">Thông báo nhận nuôi</a>
    </div> -->
    <div class="upload-button">
        <a class="icon" href="UpLoad.php?tk=<?php echo $_SESSION['name_account'] ?>"><i class="fas fa-upload"></i> Upload Product</a>
    </div>
</div>

<div class="phanloai">
    <form method="GET" action="">
        <div class="form-group">
            <!-- <label for="type">Thú Cưng:</label> -->
            <select name="type" id="type">
                <option value="">Tất cả loại thú cưng</option>
                <?php
                while ($row = mysqli_fetch_assoc($typeResult)) {
                    echo '<option value="' . $row['type_pet'] . '">' . ucfirst($row['type_pet']) . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <!-- <label for="color">Màu sắc:</label> -->
            <select name="color" id="color">
                <option value="">Tất cả màu sắc</option>
                <?php
                mysqli_data_seek($colorResult, 0);
                while ($row = mysqli_fetch_assoc($colorResult)) {
                    echo '<option value="' . $row['colour_pet'] . '">' . ucfirst($row['colour_pet']) . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <!-- <label for="address">Địa chỉ:</label> -->
            <select name="address" id="address">
                <option value="">Tất cả địa chỉ</option>
                <?php
                mysqli_data_seek($addressResult, 0);
                while ($row = mysqli_fetch_assoc($addressResult)) {
                    echo '<option value="' . $row['address_pet'] . '">' . ucfirst($row['address_pet']) . '</option>';
                }
                ?>
            </select>
        </div>

        <button type="submit" class="BtnFilter">Lọc</button>
    </form>
</div>

<div class="pet-container">
    <?php
    // Lọc theo các tiêu chí
    $type_filter = isset($_GET['type']) ? $_GET['type'] : '';
    $color_filter = isset($_GET['color']) ? $_GET['color'] : '';
    $address_filter = isset($_GET['address']) ? $_GET['address'] : '';

    $conditions = [];
    if (!empty($type_filter)) {
        $conditions[] = "type_pet = '$type_filter'";
    }
    if (!empty($color_filter)) {
        $conditions[] = "colour_pet = '$color_filter'";
    }
    if (!empty($address_filter)) {
        $conditions[] = "address_pet = '$address_filter'";
    }

    $where_clause = !empty($conditions) ? "WHERE " . implode(" AND ", $conditions) : '';

    $sql = "SELECT * FROM pets $where_clause LIMIT $begin, $countPetInAPage";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Truy vấn thất bại: " . mysqli_error($conn));
    }

    // Hiển thị các thú cưng
    while ($row = mysqli_fetch_array($result)) {
    ?>
        <div class="containerPet">
            <div class="pet">
                <img src="UploadAvt/<?php echo $row['avt_pet'] ?>" alt="" class="imgPet">
            </div>
            <div class="inforPet">
                <p class="Name"><?php echo $row['name_pet']; ?></p>
                <p class="detailPet typepet"><?php echo "Chủng loại: " . $row['type_pet']; ?></p>
                <p class="detailPet colorpet"><?php echo "Màu sắc: " . $row['colour_pet']; ?></p>
                <p class="detailPet addresspet"><?php echo "Địa chỉ: " . $row['address_pet']; ?></p>
                <p class="charactis"><?php echo $row['note_pet']; ?></p>
                <p class="detailPet timePet" id="timePet"><?php echo $row['time_uppset']; ?></p>
                <div class="imgBoss">
                    <?php
                    $id_account = $row['id_account'];
                    $sql = "SELECT * FROM account WHERE id_account = '$id_account'";
                    $sqli = mysqli_query($conn, $sql);
                    if ($rows = mysqli_fetch_array($sqli)) {
                    ?>
                        <img src="./UploadAvt/<?php echo $rows['img_user'] ?>" alt="" class="imgB">
                    <?php } ?>
                </div>
                <div class="MoreInfor">
                    <p class="WatchPetMores">
                        <a class="WatchPetMore" href="Detail.php?idpet=<?php echo $row['id_pet'] ?>">Xem Chi Tiết</a>
                    </p>
                </div>
            </div>
        </div>
    <?php } ?>
</div>  

<div class="Page">
    <?php
    $sql = "SELECT COUNT(*) as total FROM pets";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $totalPets = $row['total'];
    $totalPages = ceil($totalPets / $countPetInAPage);

    for ($i = 1; $i <= $totalPages; $i++) {
    ?>
        <p class="page"><a class="NumPage" href="index.php?page=<?php echo $i ?>"><?php echo $i ?></a></p>
    <?php } ?>
</div>
<footer class="footer">
        <div class="footer-child">
                <img class="footer-first" src="">
                <h2 class="slogan">Chó là bạn,không phải đồ ăn</h2>
            </div>
            <div class="footer-two">
                <p class="support">Bạn cần hỗ trợ</p>
                <p class= "support">1900 123</p>
                <p class="address">Địa chỉ: ngách 326/14 đường sông Nhuệ</p>
                <p class="address">Email:khangkutr6324@gmail.com</p>
                <div class="icon-support">
                    <i class="fab fa-facebook-f"></i>
                    <i class="fab fa-facebook-messenger"></i>
                    <i class="fab fa-telegram"></i>
                    <i class="fab fa-instagram-square"></i>
                </div>
                
            </div>
            <div class="footer-last">
                <ul class="shop">Hướng dẫn mua hàng</ul>
                <li class="list">Giới thiệu</li>
                <li class="list">Liên hệ</li>
                <li class="list">Tin tức</li>
                <li class="list">Hướng dẫn sử dụng</li>
            </div>
        </footer>
