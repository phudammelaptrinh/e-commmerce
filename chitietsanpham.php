<?php
session_start();
include("class/clskhachhang.php");
$p = new khachhang();

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Chi Tiết Sản Phẩm</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
<div id="container">
    <div id="banner">
    
    </div>
    
    <div id="main">
        <div align="right">
            <?php
            if(isset($_SESSION['id'])) {
                $idkh = $_SESSION['id'];
                $tenkh = $p->laycot("select ten from khachhang where iduser='$idkh' limit 1");
                if($tenkh) {
                    echo 'Xin chào ' . $tenkh;
					echo '|<a href="logout/logout.php">Dang xuat</a> ';
                }
            }
			
            ?>
            <form id="form1" name="form1" method="post">
                <?php
                if(isset($_REQUEST['id'])) {
                    $idsp = $_REQUEST['id'];
                    $p->xemchitietsanpham("select * from 	sanpham where idsp='$idsp' limit 1");
                }
                ?>
                <?php
				
				
                if(isset($_POST['nut']) && $_POST['nut'] == 'Thêm vào giỏ hàng') {
                    if(isset($_SESSION['id'])) {
                        $idkh = $_SESSION['id'];
                        $ngaydathang = date('Y-m-d');
                        if($p->themxoasua("insert into dathang(idkh, ngaydathang) values('$idkh', '$ngaydathang')") == 1) {
                            $iddh = $p->laycot("select iddh from dathang where idkh='$idkh' order by iddh desc limit 1");
                            $idsp = $_REQUEST['id'];			
                            $soluong = $_REQUEST['txtsoluong'];
                            $dongia = $p->laycot("select gia from sanpham where idsp='$idsp' limit 1");
                            $giamgia = $p->laycot("select giamgia from sanpham where idsp='$idsp' limit 1");
                            if($p->themxoasua("insert into dathang_chitiet(iddh, idsp, soluong, dongia, giamgia) values('$iddh', '$idsp', '$soluong', '$dongia', '$giamgia')") == 1) {
								
                            } else {
                                echo '<script language="javascript">
                                    alert("Đặt hàng không thành công !");
                                    </script>';
                            }
                        }
                    } else {
                            echo '<script language="javascript">
							
                                alert("Vui lòng đăng nhập trước khi đặt hàng!");
                                window.location="khachhang/khachhang.php";
                                </script>';
                        }
                }
                ?>
            </form>
			<hr>
			<?php 
			if(isset($_SESSION['id'])) 
			{
			$idkh = $_SESSION['id'];
			$p -> giohang("select ct.idsp, ct.soluong, ct.dongia , ct.giamgia
							from dathang dh, dathang_chitiet ct
							where dh.iddh = ct.iddh and dh.idkh='$idkh'");
				
			}
			?>
        </div>
    </div>

    <div id="footer">
    
    </div>
</div>
</body>
</html>
