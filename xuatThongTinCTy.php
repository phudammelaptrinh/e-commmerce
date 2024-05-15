<?php
include ("class/classtmdt.php");
$p = new tmdt();
?>

<!DOCTYPE html> 
<html>    
<head>
    <title>Danh Sách Công Ty</title>
</head>
<body>
    <?php
    // Gọi phương thức xuatdscty() để hiển thị danh sách công ty
    $p->xuatdscty("SELECT * FROM congty ORDER BY idcty ASC");
    ?>  
</body>
</html>
