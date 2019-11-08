<?php 
class Contact {

    #Begin properties
    var $id;
    var $name;
    var $email;
    var $phone;
    var $idUser;
    #end properties

    #Construct function
    function __construct($id, $name, $email, $phone, $idUser)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email= $email;
        $this->phone = $phone;
        $this->idUser = $idUser;
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
                $contact = new Contact($row["Id"], $row["Name"], $row["Email"], $row["Phone"], $row["IdUser"]);
                array_push($lscontact, $contact);
            }
        }
        //Bước3: Đóng kết nối
        $con->close();
        return $lscontact;
    }

    static function getListContactOfTag($idTag)
    {
        //Bước1: tạo kếtCRUD
        $con = Contact::connect();
        //Bước2: Thao tác với CSDL: CRUD
        $sql = "SELECT * FROM `contact` INNER JOIN `contact_tag` ON contact.Id = contact_tag.IdContact WHERE `IdTag`=$idTag";
        $result = $con->query($sql);
        $lscontact = array();
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                # code...
                $contact = new Contact($row["Id"], $row["Name"], $row["Email"], $row["Phone"], $row["IdUser"]);
                array_push($lscontact, $contact);
            }
        }
        //Bước3: Đóng kết nối
        $con->close();
        return $lscontact;
    }

    static function addContactDb($name, $email, $phone)
    {
        $con = Contact::connect();
        $sql = "INSERT INTO contact (Name, Email, Phone) VALUES ('$name', '$email', '$phone');";
        if ($con->query($sql) == true) {
            echo "Thêm thành công";
        } else {
            echo "Thêm thất bại";
        }
        $con->close();
    }

    static function editContactFromDb($contactId, $newName, $newEmail, $newPhone)
    {
        $con = Contact::connect();
        $sql = "UPDATE contact SET Name='$newName', Email='$newEmail', Phone='$newPhone' WHERE Id=$contactId";
        if ($con->query($sql) == true) {
            echo "Cập nhật thành công";
        } else {
            echo "Cập nhật thất bại";
        }
        $con->close();
    }

    static function deleteContactDb($idContact)
    {
        $con = Contact::connect();
        $sql = "DELETE FROM `contact` WHERE `Id`=$idContact";
        if ($con->query($sql) == true) {
            echo "Xóa thành công";
        } else {
            //echo "Thêm thất bại";
        }
        $con->close();
    }


}
?>