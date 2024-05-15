<?php
include("classtmdt.php");

class admin extends tmdt {
    public function choncongty($sql,$idchon) {
        $link = $this->connect();

        $result = mysqli_query($link, $sql);
        if (!$result) {
            die('Lỗi truy vấn SQL: ' . mysqli_error($link));
        }

        $num_rows = mysqli_num_rows($result);

        if ($num_rows > 0) {
            echo '<select name="congty" id="congty">';
            echo '<option>Mời chọn công ty</option>';
            while ($row = mysqli_fetch_array($result)) {
                $id = $row['idcty'];
                $name = $row['tencty'];
				if($id == $idchon){
					echo '<option value="' . $id . '" selected>' . $name . '</option>';
				}
				else{
					echo '<option value="' . $id . '">' . $name . '</option>';
				}
                
            }
            echo '</select>'; // Đóng thẻ select đầy đủ ở đây
        } else {
            echo "Không có dữ liệu";
        }

        mysqli_close($link);
    }
    
    public function danhsachcongty($sql) {
        $link = $this->connect();

        $result = mysqli_query($link, $sql);
        if (!$result) {
            die('Lỗi truy vấn SQL: ' . mysqli_error($link));
        }

        $num_rows = mysqli_num_rows($result);

        if ($num_rows > 0) {
            echo '<table width="607" border="1" cellpadding="3" cellspacing="1" style="margin-left:auto; margin-right:auto;">
                    <tbody>
                        <tr>
                            <td width="99">STT</td>
                            <td width="99">Tên Sản Phẩm</td>
                            <td width="100">Mô Tả</td>
                            <td width="100">Giá</td>
                            <td width="161">Giảm Giá</td>
                        </tr>';
            $dem = 1;
            while ($row = mysqli_fetch_array($result)) {
                $idsp = $row['idsp'];
                $tensp = $row['tensp'];
                $gia = $row['gia'];
                $mota = $row['mota'];
                $giamgia = $row['giamgia'];
                echo '<tr>
                        <td><a href="?id='.$idsp.'">'. $dem .'</a></td>
                        <td><a href="?id='.$idsp.'">'. $tensp .'</a></td>
                        <td><a href="?id='.$idsp.'">'. $mota .'</a></td>
                        <td><a href="?id='.$idsp.'">'. $gia .'</a></td>
                        <td><a href="?id='.$idsp.'">'. $giamgia .'</a></td>
                    </tr>';
                $dem++;
            }
            echo '</tbody></table>'; 
        } else {
            echo "Không có dữ liệu";
        }

        mysqli_close($link);
    }
}
?>
