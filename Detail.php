<style>
    .ContentMain {
    width: 100%;
    max-width: 800px; /* Thay đổi kích thước theo nhu cầu */
    margin: 0 auto;
    padding: 20px;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

.containerPet {
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    padding: 20px;
    margin-bottom: 20px;
}

.pet {
    text-align: center;
}

.imgPet {
    width: 150px; /* Thay đổi kích thước ảnh theo nhu cầu */
    height: 150px; /* Thay đổi kích thước ảnh theo nhu cầu */
    border-radius: 50%;
    object-fit: cover;
}

.inforPet {
    margin-left: 20px;
}

.Name {
    font-size: 24px;
    font-weight: bold;
}

.detailPet {
    font-size: 16px;
    margin-bottom: 10px;
}

.imgBoss {
    text-align: center;
}

.imgB {
    width: 100px; /* Thay đổi kích thước ảnh theo nhu cầu */
    height: 100px; /* Thay đổi kích thước ảnh theo nhu cầu */
    border-radius: 50%;
    object-fit: cover;
    margin-top: 10px;
}

.addresspet::before,
.timepet::before {
    content: "Thông tin: ";
    font-weight: bold;
}
.selectOption {
    display: flex;
    justify-content: space-between;
    margin-top: 20px; /* Khoảng cách giữa các phần tử và phần tử trên */
}

.selectOption a {
    padding: 10px 20px;
    text-decoration: none;
    color: #fff;
    background-color: #007bff;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.selectOption a:hover {
    background-color: #0056b3; /* Màu nền khi di chuột qua */
}

</style>
<div class="ContentMain">
<?php
require('connect.php');
session_start();
if(!isset($_SESSION['name_account'])){
		header('Location: LoGin.php');
		exit; 
}
$id_pet = $_GET['idpet'];
    $sql = "SELECT * FROM pets WHERE id_pet = '$id_pet'";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($result)) {
					
       ?>
       
       <div class="containerPet">
            <div class="pet">
                <img src="./UploadAvt/<?php echo $row['avt_pet'] ?>" alt="" class="imgPet">
            </div>
            <div class="inforPet">
                <p class="Name">
                    <?php
                    echo $row['name_pet'];
                    ?>
                </p>
                <p class="charactis notepet">
                <?php
                    echo $row['note_pet'];
                    ?>
                </p>
                <p class="detailPet typepet">
                <?php
                    echo "Chủng loại: ".$row['type_pet'];
                    ?>
                </p>
                <p class="detailPet colorpet">
                <?php
                    echo "Màu sắc: ". $row['colour_pet'];
                    ?>
                </p>
                <p class="detailPet addresspet">
                <?php
                    echo "Địa chỉ: " . $row['address_pet'];
                    ?>
                </p>
                <p class="detailPet timepet">
                <?php
                    echo $row['time_uppset'];
                    ?>
                </p>
                
                 <div class="imgBoss">
                    <?php
                    $sql = "SELECT * FROM myPet where id_pet = '$id_pet'";
                    $sqli = mysqli_query($conn,$sql);
                    while ($row = mysqli_fetch_array($sqli)) {
                        $id_account = $row['id_account'];
                        $sqlper = "SELECT * FROM account where id_account = '$id_account'";
                        $sqliper = mysqli_query($conn,$sqlper);
                        while ($rows = mysqli_fetch_array($sqliper)) {
            
                            echo   "Email: ".$rows['email'] . "</br>";
                            echo "Name: ".$rows['names'];
                            echo "<img src='./UploadAvt/" . $rows['img_user'] . "' class='imgB'>";
                            echo "<div class='stars'>";
                            for($i =1; $i <= $rows['star'];$i++){
                                ?>
                                <!-- &#9733; kí hiệu ngôi sao -->
                                <span class="star" style="color: gold";>&#9733;</span>
                               
                                <?php
                            }
                            echo "</div>";
                        }
                       

                        
                    }
                    ?>
                    
                </div>
                   

        </div>
        
</div>
<?php
    }
    ?>

<div class="selectOption">
    <a href="index.php">Quay về trang chủ</a>
    <a href="RequireAdopt.php?idpet=<?php echo  $id_pet ?>">Gửi Yêu Cầu Nhận Nuôi</a>
</div>