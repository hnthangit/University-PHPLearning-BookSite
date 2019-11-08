<?php 
class User{
    var $userName;
    var $passWord;
    var $fullName;
    var $id;

    function User($userName, $passWord, $fullName, $id){
        $this->userName = $userName;
        $this->passWord = $passWord;
        $this->fullName = $fullName;
        $this->id = $id;
        
    }

    /**
     * Xác thực người sử dụng
     * @param $userName string Tên đăng nhập
     * @param $passWord string Mật khẩu
     * @return User hoặc null nếu không tồn tại
     */
    static function authentication($userName, $passWord){
        $lsuser = User::getAccount($userName, $passWord);
        if(strcmp($userName, reset($lsuser)->userName)==0 && strcmp($passWord, reset($lsuser)->passWord)==0){
            return new User($userName, $passWord, $userName, reset($lsuser)->id);
        }
        else return null;
    }

    static function getAccount($username, $password)
    {
        //Bước1: tạo kếtCRUD
        $con = User::connect();
        //Bước2: Thao tác với CSDL: CRUD
        $sql = "SELECT * FROM `user` WHERE `Username`= '$username' AND `Password`= '$password'";
        $result = $con->query($sql);
        $lsuser = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                # code...
                $user = new User($row["Username"], $row["Password"], $row["Username"], $row["Id"]);
                array_push($lsuser, $user);
            }
        }
        //Bước3: Đóng kết nối
        $con->close();
        return $lsuser;
    }

    static function connect()
    {
        $con = new mysqli("localhost", "root", "", "contactmanager");
        $con->set_charset("utf8");
        if ($con->connect_error)
            die("Kết nốt thất bại. Chi tiết: " . $con->connect_error);
        //echo "<h1>Kết nối thành công</h1>";
        return $con;
    }
}
?>