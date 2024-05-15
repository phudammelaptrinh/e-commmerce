<?php
include("class/classtmdt.php");

class khachhang extends tmdt {
    public function xemdssanpham($sql) {
        $link = $this->connect();
        $result = mysqli_query($link, $sql);

        if ($result) {
            $i = mysqli_num_rows($result);
            if ($i > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    $idsp = $row['idsp'];
                    $tensp = $row['tensp'];
                    $gia = $row['gia'];
                    $hinh = $row['hinh'];
                    
                    echo '<div id="sanpham">
                            <div id="sanpham_ten">' . $tensp . '</div>
                            <div id="sanpham_hinh"><a href="chitietsanpham.php?id='.$idsp.'"><img src="hinh/'. $hinh . '" width="150px" height="120px"></a></div>
                            <div id="sanpham_gia">Giá: ' . $gia . '</div>
                          </div>';
                }
            } else {
                echo 'Đang cập nhật dữ liệu';
            }
        } else {
            echo 'Lỗi truy vấn SQL: ' . mysqli_error($link);
        }
    }

    public function xemdscongty($sql) {
        $link = $this->connect();
        $result = mysqli_query($link, $sql);
        $i = mysqli_num_rows($result);

        if ($i > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $idcty = $row['idcty'];
                $tencty = $row['tencty'];
                echo '<a href="?id=' . $idcty . '">' . $tencty . '</a><br>';
            }
        } else {
            echo 'Đang cập nhật dữ liệu';
        }
    }
	
	
	public function xemchitietsanpham($sql) {
    $link = $this->connect();
    $result = mysqli_query($link, $sql);

    if ($result) {
        $i = mysqli_num_rows($result);

        if ($i > 0) {
            echo '<table width="660" border="1" align="center" cellpadding="5" cellspacing="2" style="border-collapse: collapse;">
                    <tbody>';
            while ($row = mysqli_fetch_array($result)) {
                $idsp = $row['idsp'];
                $tensp = $row['tensp'];
                $mota = $row['mota'];
                $hinh = $row['hinh'];
                $gia  = $row['gia'];
                $giamgia = $row['giamgia'];
                $idcty = $row['idcty'];
                $tencty = $this->laycot("SELECT tencty FROM congty WHERE idcty = '$idcty' LIMIT 1");

                echo '<tr>
                        <td width="221" rowspan="6" style="text-align: center; vertical-align: middle;"><img src="hinh/' . $hinh . '" width="157" height="127" alt=""/></td>
                        <td width="126" style="text-align: center; font-weight: bold;">Tên Sản Phẩm</td>
                        <td width="267" style="text-align: center;">' . $tensp . '</td>
                    </tr>
                    <tr>
                        <td style="text-align: center; font-weight: bold;">Nhà Sản Xuất</td>
                        <td style="text-align: center;">' . $tencty . '</td>
                    </tr>
                    <tr>
                        <td height="73" style="text-align: center; font-weight: bold;">Mô Tả</td>
                        <td style="text-align: center;">' . $mota . '</td>
                    </tr>
                    <tr>
                        <td height="73" style="text-align: center; font-weight: bold;">Giá</td>
                        <td style="text-align: center;">' . $gia . '</td>
                    </tr>
                    <tr>
                        <td style="text-align: center; font-weight: bold;">Giảm Giá</td>
                        <td style="text-align: center;">' . $giamgia . '</td>
                    </tr>
                    <tr>
                        <td style="text-align: center; font-weight: bold;">Số Lượng</td>
                        <td style="text-align: center;"><input type="text" name="txtsoluong" id="txtsoluong" value="1"></td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: center;"><input type="submit" name="nut" id="nut" value="Thêm vào giỏ hàng"></td>
                    </tr>';
            }
            echo '</tbody></table>';
        } else {
            echo 'Đang cập nhật dữ liệu';
        }
    } else {
        echo 'Lỗi truy vấn SQL: ' . mysqli_error($link);
    }
	}
	
	
	public function giohang($sql) {
    $link = $this->connect();
    $result = mysqli_query($link, $sql);
	$i = mysqli_num_rows($result);

        if ($i > 0) {
						echo '<table width="700" border="1" align="center" cellspacing="2">
				<tbody>
				  <tr>
					<td align="center" valign="middle">STT</td>
					<td align="center" valign="middle">Ten San Pham</td>
					<td align="center" valign="middle">So Luong </td>
					<td align="center" valign="middle">Don Gia</td>
					<td align="center" valign="middle">Giam Gia </td>
				  </tr>
				  <tr>';
			$dem = 1; 
           while($row = mysqli_fetch_array($result))
		   {
			   $idsp =$row[0];
			   $tensp = $this->laycot("select tensp from sanpham  where idsp ='$idsp' limit 1");
			   $soluong = $row[1];
			   $dongia =$row[2];
			   $giamgia =$row[3];
			   
			   echo ' <tr>
						<td align="center" valign="middle">'.$dem.'</td>
						<td align="center" valign="middle">'.$tensp.'</td>
						<td align="center" valign="middle">'.$soluong.'</td>
						<td align="center" valign="middle">'.$dongia.'</td>
						<td align="center" valign="middle">'.$giamgia.'</td>
					  </tr>';
			   $dem ++;
		   }
			echo '</tbody>
  				</table>';
		}
		else {
         echo 'Đang cập nhật dữ liệu';
    	}
    
	
	}
	

} 

?>
