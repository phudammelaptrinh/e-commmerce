-<?php

include("../class/clslogin.php");
$p = new login();

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Dang nhap khach hang </title>
</head>

<body style="text-align: center">
<form id="form1" name="form1" method="post">
  <table width="400" border="1" align="center" cellpadding="5" cellspacing="2">
    <tbody>
      <tr valign="middle">
        <td colspan="2" align="center" valign="middle" style="text-align: center">ĐĂNG NHẬP </td>
      </tr>
      <tr valign="middle">
        <td width="171" style="text-align: center">Nhập username : </td>
        <td width="197" style="text-align: center"><input type="text" name="txtuser" id="txtuser"></td>
      </tr>
      <tr valign="middle">
        <td style="text-align: center">Nhập mật khẩu </td>
        <td style="text-align: center"><input type="password" name="txtpass" id="txtpass"></td>
      </tr>
      <tr valign="middle">
        <td height="30" colspan="2" align="center" style="text-align: center"><input type="submit" name="nut" id="nut" value="Đăng nhập"></td>
      </tr>
    </tbody>
  </table>
<div align="center">
<?php
 switch($_POST['nut'])
 {
	 case 'Đăng nhập':
		 {
			 $user = $_REQUEST['txtuser'];
			 $pass =$_REQUEST['txtpass'];
			 
			
			 if($user != '' && $pass !='')
			 {
				 if ($p->mylogin($user,$pass,"taikhoan","../admin/admin.php") ==0 )
				 {
					 echo 'Sai email và password !';
				 }
				
				
			 }
			 else
			 {
				 echo '<script language="javascript">
							alert("Vui lòng đăng nhập đầy đủ !");
						</script>';
			 }
			 break;
		 }
 }	
?>	
</div>
</form>
</body>
</html>
