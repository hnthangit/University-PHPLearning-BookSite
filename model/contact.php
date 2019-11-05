<?php 
class Contact {

    #Begin properties
    var $id;
    var $name;
    var $email;
    var $phone;
    var $tag;
    #end properties

    #Construct function
    function __construct($id, $name, $email, $phone, $tag)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email= $email;
        $this->phone = $phone;
        $this->tag = $tag;
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

    static function getListContactFromDB()
    {
        //Bước1: tạo kếtCRUD
        $con = Contact::connect();
        //Bước2: Thao tác với CSDL: CRUD
        $sql = "SELECT * FROM `contact`";
        $result = $con->query($sql);
        $lscontact = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                # code...
                $contact = new Contact($row["Id"], $row["Name"], $row["Email"], $row["Phone"], $row["Tag"]);
                array_push($lscontact, $contact);
            }
        }
        //Bước3: Đóng kết nối
        $con->close();
        return $lscontact;
    }

    static function addContactDb($name, $email, $phone, $tag)
    {
        $con = Contact::connect();
        $sql = "INSERT INTO contact (Name, Email, Phone, Tag) VALUES ('$name', '$email', '$phone', $tag);";
        if ($con->query($sql) == true) {
            echo "Thêm thành công";
        } else {
            echo "Thêm thất bại";
        }
        $con->close();
    }

    static function editContactFromDb($contactId, $newName, $newEmail, $newPhone, $newTag)
    {
        $con = Contact::connect();
        $sql = "UPDATE contact SET Name='$newName', Email='$newEmail', Phone='$newPhone', Tag='$newTag' WHERE ID=$contactId";
        if ($con->query($sql) == true) {
            echo "Cập nhật thành công";
        } else {
            echo "Cập nhật thất bại";
        }
        $con->close();
    }


}
?>