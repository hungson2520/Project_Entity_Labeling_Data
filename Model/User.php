<?php
require_once 'ConnectDatabase.php';
class User {
    private $id;
    private $username;
    private $password;
    private $role;
   
    // Hàm xác thực người dùng
    public static function authenticate($username, $password) {
        // Kết nối cơ sở dữ liệu
        $connection = new DatabaseConnection();
        $pw = $connection->getPassword();
        $conn= mysqli_connect("localhost","root", $pw ,"N01_GanNhan");
        // Làm sạch dữ liệu đầu vào
        $username = $conn->real_escape_string($username);
        $password = $conn->real_escape_string($password);
       
        // Truy vấn người dùng theo tên đăng nhập và mật khẩu
        $query = "SELECT * FROM NguoiDung WHERE SDT='$username' AND MatKhau='$password'";
        $result = $conn->query($query);

        if ($result->num_rows == 1) {
            // Lấy thông tin người dùng từ cơ sở dữ liệu 
            $row = $result->fetch_assoc();

            // Tạo đối tượng người dùng
            $user = new User();
            $user->id = $row['ID_NguoiDung'];
            $user->username = $row['SDT'];
            $user->password = $row['MatKhau'];
            $user->role = $row['VaiTro'];
          
            $conn->close();

            // Trả về đối tượng người dùng đã xác thực
            return $user;
        } else {
            
            $conn->close();
            return  false;
           
        }
    }
    public static function insertUserData($name, $phone, $address, $password)
{
    // Bước 1: Kết nối đến cơ sở dữ liệu
    $connection = new DatabaseConnection();
    $pw = $connection->getPassword();
    $conn= mysqli_connect("localhost","root", $pw ,"N01_GanNhan");
    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Kết nối đến cơ sở dữ liệu thất bại: " . $conn->connect_error);
    }
    $sql2 = "SELECT COUNT(*) AS count FROM NguoiDung WHERE SDT = '$phone'";

    $result = $conn->query($sql2);
    $row = $result->fetch_assoc();
    $count = $row['count'];
    
    if ($count > 0) {
        // Dòng dữ liệu bị trùng khóa chính
        echo "Lỗi: Dữ liệu bị trùng khóa chính";
        return -1;
    }
    // Bước 2: Chuẩn bị truy vấn INSERT
    $sql1 = "SELECT COUNT(*) AS count FROM NguoiDung WHERE SDT= '$phone'";

$result = $conn->query($sql1);
$row = $result->fetch_assoc();
$count = $row['count'];

if ($count > 0) {
    // Dòng dữ liệu bị trùng khóa chính
    echo "Lỗi: Dữ liệu bị trùng khóa chính";
    return -1;
}
    $sql = "INSERT INTO NguoiDung (Ten, SDT, DiaChi, MatKhau,VaiTro) VALUES ('$name', '$phone', '$address', '$password',1)";



    // Bước 3: Thực hiện truy vấn INSERT
    if ($conn->query($sql) === TRUE) {
       

       return 1;
       
       
        echo "<h1>Thêm Dữ Liệu Thành Công</h1>";
        return 1;
       
       
    } else {
       
            echo "Lỗi trong quá trình thêm dữ liệu: " . $conn->error;
            return -1;
        
    }

    // Bước 4: Đóng kết nối
    // $conn->close();
}

public static function ShowBangPhanCong()
{

     // Tạo kết nối đến MySQL
    $connection = new DatabaseConnection();
    $pw = $connection->getPassword();
    $conn= mysqli_connect("localhost","root", $pw ,"N01_GanNhan");
     $sql = "SELECT nd.ID_NguoiDung , nd.Ten, nd.SDT ,vt.TenVaiTro FROM NguoiDung nd, VaiTro vt WHERE nd.VaiTro= vt.ID_VaiTro And vt.ID_VaiTro !=3 ";
     $result = $conn->query($sql);

     // Kiểm tra và xử lý kết quả
     $phanCong = array(); // Mảng để lưu trữ dữ liệu
 
     if ($result->num_rows > 0) {
         // Dùng vòng lặp để duyệt qua từng hàng dữ liệu
         while ($row = $result->fetch_assoc()) {
             // Thêm hàng dữ liệu vào mảng
             $phanCong[] = $row;
         }
     } else {
         return null;
     }
 
     // Đóng kết nối MySQL
     $conn->close();
 
     // Trả về mảng dữ liệu
     return $phanCong;


}
public static function ThemVaoBangPhanCong($IdDuAn,$IdNguoiDung)
{

     // Tạo kết nối đến MySQL
    $connection = new DatabaseConnection();
    $pw = $connection->getPassword();
    $conn= mysqli_connect("localhost","root", $pw ,"N01_GanNhan");

    $sql1 = "SELECT COUNT(*) AS count FROM PhanCong WHERE ID_NguoiDung= '$IdNguoiDung' And ID_DuAn='$IdDuAn'";

    $result = $conn->query($sql1);
    $row = $result->fetch_assoc();
    $count = $row['count'];
    
    if ($count > 0) {
        // Dòng dữ liệu bị trùng khóa chính
        echo "Lỗi: Dữ liệu bị trùng khóa chính";
        return -1;
    }
     $sql = "INSERT INTO PhanCong (ID_NguoiDung, ID_DuAn) VALUES ('$IdNguoiDung', '$IdDuAn')";
     if (mysqli_query($conn, $sql)) {
        echo "<h1>Thêm dữ liệu thành công</h1>";
        return 1;
    } else {
        echo "Lỗi: " . $sql . "<br>" . mysqli_error($conn);
        return -1;
    }

 
   
    
 
     


}


    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getRole() {
        return $this->role;
    }
}