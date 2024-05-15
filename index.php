<?php
include("class/clskhachhang.php");
$p = new khachhang();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="css/style.css"> <!-- Sử dụng đường dẫn tương đối cho file CSS -->
<title>Index of Page</title>
</head>
<body>
    <div id="container">
        <div id="banner"></div>
        <div id="main">
            <div id="left">
				<?php
				$p->xemdscongty("SELECT * FROM congty ORDER BY tencty");
				?>
			</div>
            <div id="right">
                <?php
				if (isset($_REQUEST['id']) && $_REQUEST['id'] > 0) {
					$idcty = $_REQUEST['id'];
					$p->xemdssanpham("SELECT * FROM sanpham WHERE idcty='$idcty' ORDER BY gia ASC");
				} else {
					$p->xemdssanpham("SELECT * FROM sanpham ORDER BY gia ASC");
				}
                ?>
            </div>
        </div>
        <div id="footer"></div>
    </div>
</body>
</html>
