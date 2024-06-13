<?php
require('connect.php');
session_start();
if(isset($_POST['create_qr'])){
	$count = $_POST['count'];
$noidung = $_SESSION['name_account'];
$name = "NGUYEN HUU KHANG";
?>

<?php
}else{
	
}
?>
<style>
	.qr_code{
		height: 300px;
		width: 300px;
		position: absolute;
	/* margin-left: 600px; */
	}
	.naptien{
		height: 500px;
		width: 1030px;
		margin-left: 200px;
	}.one_line{
		display: flex;
	}.num{
		font-weight: bold;
		font-size: 19px;
	}
	/* Thiết kế cho phần tử .naptien */
.naptien {
    background-color: #f0f0f0;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

/* Thiết kế cho tiêu đề .title */
.title {
    color: #333;
    font-size: 24px;
    margin-bottom: 10px;
}

/* Thiết kế cho phần tử .note */
.note {
    color: #666;
    font-size: 14px;
}

/* Thiết kế cho phần tử .num */
.num {
    color: #ff6600;
    font-size: 36px;
    margin-top: 5px;
}

/* Hiệu ứng "ảo animal" */
.animated {
    animation-duration: 1s;
    animation-fill-mode: both;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    10%, 30%, 50%, 70%, 90% { transform: translateX(-10px); }
    20%, 40%, 60%, 80% { transform: translateX(10px); }
}
#amountInput {
    padding: 8px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.submitButton {
    padding: 8px 16px;
    font-size: 16px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.submitButton:hover {
    background-color: #0056b3;
}
@media screen and (max-width: 1200px) {
    .naptien{
        margin-left: 0px;
        padding-right: auto;
        width: auto;
    }
}
    </style>
</head>
<body>
    <form action="" method="post">
        <div class="naptien">
            <h2 class="title">Thông tin Chuyển Khoản</h2>
            <span class="one_line"> 
                <h5 class="small_money">Cho ít nhất </h5>  
                <h4 class="num"> 20000đ</h4>
            </span>
            
            <form id="paymentForm">
                <input type="number" placeholder="Nhập số tiền nạp" name="count" id="amountInput">
                <input type="submit" value="Tạo QR-CODE" class="submitButton" name="create_qr" onclick="validateAndGenerateQR(event)">
                <a href="index.php" class="submitButton" name="">Trang chủ</a>

            </form>
            <div id="qrCodeContainer" style="display: none;">
                <!-- Ảnh QR code sẽ được hiển thị ở đây -->
            </div>
        </div>
    </form>

    <script>
        function validateAndGenerateQR(event) {
            event.preventDefault(); // Ngăn chặn sự kiện mặc định của nút submit

            // Lấy giá trị nhập vào từ người dùng
            var amount = document.getElementById('amountInput').value;

            // Kiểm tra nếu giá trị nhập vào nhỏ hơn hoặc bằng 20000
            if (amount < 20000) {
                alert("Số tiền nạp phải lớn hơn hoặc bằng 20000đ");
                return; // Ngăn chặn việc tiếp tục thực hiện
            }

            // Nếu giá trị nhập vào hợp lệ, hiển thị hình ảnh QR code
            displayQRCode(amount);
        }

        function displayQRCode(count) {
            // Hiển thị phần container cho hình ảnh QR code
            document.getElementById('qrCodeContainer').style.display = 'block';

            // Tạo một thẻ img mới để chứa hình ảnh QR code
            var img = document.createElement('img');
            var noidung = '<?php echo $_SESSION['name_account'] ?>';
            var name = "NGUYEN HUU KHANG";
            img.src = 'https://img.vietqr.io/image/mbbank-0984127353-compact2.jpg?amount=' + count + '&addInfo=' + noidung + '&accountName=' + name;
            img.className = 'qr_code'; // Thêm class cho hình ảnh QR code

            // Thêm hình ảnh vào phần container
            document.getElementById('qrCodeContainer').appendChild(img);
        }
    </script>
</body>
</html>