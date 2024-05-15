<?php
class Login
{
    public function connectLogin()
    {
        $conn = mysqli_connect("localhost", "usertmdt", "passtmdt", "tmdt_db");
        if (!$conn) {
            echo 'Không thể kết nối đến CSDL';
            exit();
        }

        mysqli_set_charset($conn, "utf8");
        return $conn;
    }

    public function myLogin($user, $pass, $table, $header)
    {
        $pass = md5($pass); 
        $conn = $this->connectLogin();
        $sql = "SELECT iduser, username, password, phanquyen FROM $table WHERE username ='$user' AND password='$pass' LIMIT 1";
        $result = mysqli_query($conn, $sql);
//
//        if (!$result) {
//            echo 'Lỗi thực thi truy vấn: ' . mysqli_error($conn);
//            return 0;
//        }

        $num_rows = mysqli_num_rows($result);

        if ($num_rows == 1) {
            $row = mysqli_fetch_assoc($result);
            session_start();
            $_SESSION['id'] = $row['iduser'];
            $_SESSION['user'] = $row['username'];
            $_SESSION['pass'] = $row['password'];
            $_SESSION['phanquyen'] = $row['phanquyen'];
            header('Location: ' . $header);
            exit;
        } else {
            return  $sql;
        }
    }

    public function confirmLogin($id, $user, $pass, $phanquyen)
    {
        $conn = $this->connectLogin();
        $sql = "SELECT iduser FROM taikhoan WHERE iduser ='$id' AND username ='$user' AND password='$pass' AND phanquyen ='$phanquyen' LIMIT 1";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            echo 'Lỗi thực thi truy vấn: ' . mysqli_error($conn);
            header('Location: ../login/login.php');
            exit;
        }

        $num_rows = mysqli_num_rows($result);

        if ($num_rows != 1) {
            header('Location: ../login/login.php');
            exit;
        }
    }
}
?>
	