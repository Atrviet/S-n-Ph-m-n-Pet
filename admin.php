<?php
session_start();
require('connect.php');

// Kiểm tra quyền admin
if (!isset($_SESSION['LoGinAccount']) || $_SESSION['user_role'] != 'admin') {
    header('Location: LoGin.php');
    exit;
}

// Lấy danh sách tài khoản
$sqlAccounts = "SELECT id_account, tk, mk, email, names FROM account";
$resultAccounts = mysqli_query($conn, $sqlAccounts);

// Lấy danh sách pet
$sqlPets = "SELECT p.id_pet, p.name_pet, p.type_pet, p.colour_pet, p.address_pet, p.time_uppset, a.names as owner_name 
            FROM pets p 
            JOIN account a ON p.id_account = a.id_account";
$resultPets = mysqli_query($conn, $sqlPets);

// Lấy danh sách phản hồi và góp ý
$sqlFeedback = "SELECT * FROM feedback";
$resultFeedback = mysqli_query($conn, $sqlFeedback);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Your CSS styles */
        .admin-container {
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <h1>Admin Panel</h1>
        <h2>Danh sách tài khoản</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Tên tài khoản</th>
                <th>Mật khẩu</th>
                <th>Email</th>
                <th>Tên người dùng</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($resultAccounts)) { ?>
                <tr>
                    <td><?php echo $row['id_account']; ?></td>
                    <td><?php echo $row['tk']; ?></td>
                    <td><?php echo $row['mk']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['names']; ?></td>
                </tr>
            <?php } ?>
        </table>

        <h2>Danh sách thú cưng</h2>
        <table>
            <tr>
                <th>ID Pet</th>
                <th>Tên Pet</th>
                <th>Loại</th>
                <th>Màu sắc</th>
                <th>Địa chỉ</th>
                <th>Thời gian đăng</th>
                <th>Chủ sở hữu</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($resultPets)) { ?>
                <tr>
                    <td><?php echo $row['id_pet']; ?></td>
                    <td><?php echo $row['name_pet']; ?></td>
                    <td><?php echo $row['type_pet']; ?></td>
                    <td><?php echo $row['colour_pet']; ?></td>
                    <td><?php echo $row['address_pet']; ?></td>
                    <td><?php echo $row['time_uppset']; ?></td>
                    <td><?php echo $row['owner_name']; ?></td>
                </tr>
            <?php } ?>
        </table>

        <h2>Phản hồi và góp ý</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Người gửi</th>
                <th>Email</th>
                <th>Nội dung</th>
                <th>Thời gian gửi</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($resultFeedback)) { ?>
                <tr>
                    <td><?php echo $row['id_feedback']; ?></td>
                    <td><?php echo $row['sender_name']; ?></td>
                    <td><?php echo $row['sender_email']; ?></td>
                    <td><?php echo $row['message']; ?></td>
                    <td><?php echo $row['sent_time']; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
