<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (isset($_SESSION['id']) && isset($_SESSION['user'])&& isset($_SESSION['pass']) && isset($_SESSION['phanquyen'])) 
{
    
    include("../class/clslogin.php");

   	$l = new login();
	$l -> confirmlogin($_SESSION['id'],$_SESSION['user'],$_SESSION['pass'],$_SESSION['phanquyen']);
}
else
{
	header('location:../login/login.php ');
}


?>

<?php
include('../class/clsadmin.php');

$p = new admin();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nut'])) {
        switch ($_POST['nut']) {
            case 'Thêm':
                // Lấy thông tin từ form
                $idcty = $_POST['congty'];
                $ten = $_POST['txtten'];
                $gia = $_POST['txtgia'];
                $mota = $_POST['txtmota'];
                $giamgia = $_POST['txtgiamgia'];
                
                // Kiểm tra nếu có file được tải lên
                if (!empty($_FILES['myFile']['name'])) {
                    $name = time() . "_" . $_FILES['myFile']['name'];
                    $tmp_name = $_FILES['myFile']['tmp_name'];
                    
                    // Upload file vào thư mục hình
                    $uploadPath = "../hinh/";
                    $uploadResult = $p->upLoadFile($name, $tmp_name, $uploadPath);
                    
                    if ($uploadResult) {
                        // Thêm sản phẩm vào cơ sở dữ liệu
                        $insertResult = $p->themxoasua("INSERT INTO sanpham(tensp, gia, mota, hinh, giamgia, idcty) VALUES ('$ten', '$gia', '$mota', '$name', '$giamgia', '$idcty')");
                        
                        if ($insertResult) {
                            echo '<script>alert("Thêm sản phẩm thành công!");</script>';
                        } else {
                            echo '<script>alert("Thêm sản phẩm không thành công!");</script>';
                        }
                    } else {
                        echo '<script>alert("Upload hình không thành công!");</script>';
                    }
                } else {
                    echo '<script>alert("Vui lòng chọn hình sản phẩm!");</script>';
                }
                
                // Chuyển hướng người dùng về trang quản lý sản phẩm
                echo '<script>window.location="../admin/admin.php";</script>';
                break;
            
            case 'Xóa':
                $idxoa = $_POST['txtID'];
                $hinh = $p->laycot("SELECT hinh FROM sanpham WHERE idsp='$idxoa' LIMIT 1");
                if ($idxoa > 0) {
                    if ($p->themxoasua("DELETE FROM sanpham WHERE idsp='$idxoa' LIMIT 1") == 1) {
                        if (unlink("../hinh/".$hinh)) {
                            echo '<script>alert("Xóa sản phẩm thành công!");</script>';
                        } else {
                            echo '<script>alert("Xóa hình không thành công!");</script>';
                        }
                    } else {
                        echo '<script>alert("Xóa sản phẩm không thành công!");</script>';
                    }
                } else {
                    echo '<script>alert("Vui lòng chọn sản phẩm cần xóa!");</script>';
                }
                break;
                
            case 'Chèn':
                // Lấy thông tin từ form
                $idsua = $_POST['txtID'];
                $idcty = $_POST['congty'];
                $ten = $_POST['txtten'];
                $gia = $_POST['txtgia'];
                $mota = $_POST['txtmota'];
                $giamgia = $_POST['txtgiamgia'];
                
                if ($idsua > 0) {
                    if ($p->themxoasua("UPDATE sanpham SET tensp='$ten', gia='$gia', mota='$mota', giamgia='$giamgia', idcty='$idcty' WHERE idsp='$idsua' LIMIT 1") == 1) {
                        echo '<script>alert("Sửa thành công !");</script>';
                    } else {
                        echo '<script>alert("Sửa không thành công !");</script>';
                    }
                } else {
                    echo '<script>alert("Vui lòng chọn sản phẩm cần sửa !");</script>';
                }
                echo '<script>window.location="../admin/admin.php";</script>';
                break;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Quản Lý Sản Phẩm</title>
</head>

<body>
<?php
$layid = isset($_GET['id']) ? $_GET['id'] : ''; // Sử dụng $_GET thay vì $_REQUEST
$layten = $p->laycot("SELECT tensp FROM sanpham WHERE idsp='$layid' LIMIT 1");
$laygia = $p->laycot("SELECT gia FROM sanpham WHERE idsp='$layid' LIMIT 1");
$laymota = $p->laycot("SELECT mota FROM sanpham WHERE idsp='$layid' LIMIT 1");
$laygiamgia = $p->laycot("SELECT giamgia FROM sanpham WHERE idsp='$layid' LIMIT 1");

// Lấy id công ty mặc định cho sản phẩm (nếu có)
$layidcty = '';
if (!empty($layid)) {
    $layidcty = $p->laycot("SELECT idcty FROM sanpham WHERE idsp='$layid' LIMIT 1");
}
?>
<form id="form1" name="form1" method="post" enctype="multipart/form-data">
  <table width="600" border="1" align="center" cellspacing="2">
    <tbody>
      <tr>
        <td colspan="2" style="text-align: center">Quản Lý Sản Phẩm</td>
      </tr>
      <tr>
        <td width="145" style="text-align: left">Chọn công ty </td>
        <td width="439">
          <?php
          $p->choncongty("SELECT * FROM congty ORDER BY tencty ASC", $layidcty);
          ?>
          <input type="hidden" name="txtID" id="txtID" value="<?php echo $layid; ?>"></td>
      </tr>
      <tr>
        <td style="text-align: left">Nhập tên sản phẩm</td>
        <td><input type="text" name="txtten" id="txtten" value="<?php echo $layten; ?>"></td>
      </tr>
      <tr>
        <td style="text-align: left">Nhập giá</td>
        <td><input type="text" name="txtgia" id="txtgia" value="<?php echo $laygia; ?>"></td>
      </tr>
      <tr>
        <td style="text-align: left">Nhập mô tả</td>
        <td><textarea name="txtmota" id="txtmota" cols="30" rows="3"><?php echo $laymota; ?></textarea></td>
      </tr>
      <tr>
        <td style="text-align: left">Hình đại diện</td>
        <td><input type="file" name="myFile" id="myFile"></td>
      </tr>
      <tr>
        <td style="text-align: left">Nhập giảm giá</td>
        <td><input type="text" name="txtgiamgia" id="txtgiamgia" value="<?php echo $laygiamgia; ?>"></td>
      </tr>
      <tr>
        <td colspan="2" style="text-align: center">
          <input type="submit" name="nut" value="Thêm">
          <input type="submit" name="nut" value="Xóa">
          <input type="submit" name="nut" value="Chèn">
        </td>
      </tr>
    </tbody>
  </table>
<hr>
    <?php
    $p->danhsachcongty("SELECT * FROM sanpham ORDER BY idsp DESC");
    ?>
</form>
</body>
</html>
