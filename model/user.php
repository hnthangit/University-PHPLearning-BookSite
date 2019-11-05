<?php 
class User{
    var $userName;
    var $passWord;
    var $fullName;

    function User($userName, $passWord, $fullName){
        $this->userName = $userName;
        $this->passWord = $passWord;
        $this->fullName = $fullName;
        
    }

    /**
     * Xác thực người sử dụng
     * @param $userName string Tên đăng nhập
     * @param $passWord string Mật khẩu
     * @return User hoặc null nếu không tồn tại
     */
    static function authentication($userName, $passWord){
        if($userName == "abc@gmail.com" && $passWord == "123"){
            return new User($userName, $passWord, "Nguoi dung 123");
        }
        else return null;
    }
}
?>