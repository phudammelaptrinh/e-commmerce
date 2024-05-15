<?php
class tmdt {
    protected function connect() {
        $con = mysqli_connect("localhost", "usertmdt", "passtmdt", "TMDT_db");
        if (!$con) {
            die('Không kết nối được CSDL: ' . mysqli_connect_error());
        }
        
        mysqli_set_charset($con, 'utf8');
        
        return $con;
    }

    public function xuatdscty($sql) {
        $link = $this->connect();

        $result = mysqli_query($link, $sql);
        if (!$result) {
            die('Lỗi truy vấn SQL: ' . mysqli_error($link));
        }

        $num_rows = mysqli_num_rows($result);

        if ($num_rows > 0) {
            echo '<table width="400" border="1" align="center" cellpadding="5">
                <tbody>
                    <tr>
                        <td align="center" valign="middle"><strong>STT:</strong></td>
                        <td align="center" valign="middle"><strong>Tên Công Ty:</strong></td>
                        <td align="center" valign="middle"><strong>Địa Chỉ</strong></td>
                    </tr>';

            $count = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>
                        <td align="center" valign="middle">' . $count . '</td>
                        <td align="center" valign="middle">' . $row['tencty'] . '</td>
                        <td align="center" valign="middle">' . $row['diachi'] . '</td>
                    </tr>';
                $count++;
            }

            echo '</tbody></table>';
        } else {
            echo "Không có dữ liệu";
        }

        mysqli_free_result($result);
        mysqli_close($link);
    }

    public function upLoadFile($name, $tmp_name, $folder) {
        $newname = $folder . "/" . $name;
        if (move_uploaded_file($tmp_name, $newname)) {
            return true;
        } else {
            return false;
        }
    }

    public function themxoasua($sql) {
        $link = $this->connect();
        $success = mysqli_query($link, $sql);
        mysqli_close($link);

        return $success ? true : false;
    }

    public function laycot($sql) {
        $link = $this->connect();
        $result = mysqli_query($link, $sql);

        if (!$result) {
            die('Lỗi truy vấn SQL: ' . mysqli_error($link));
        }

        $value = '';
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            $value = $row[0];
        }

        mysqli_free_result($result);
        mysqli_close($link);

        return $value;
    }
}
?>
