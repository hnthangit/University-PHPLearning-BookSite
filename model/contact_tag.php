<?php 
class Contact_Tag {

    #Begin properties
    var $idContact;
    var $idTag;

    #end properties

    #Construct function
    function __construct($idContact, $idTag)
    {
        $this->idContact = $idContact;
        $this->idTag = $idTag;
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

    static function getListContact_TagOfEachContact($idContact)
    {
        //Bước1: tạo kếtCRUD
        $con = Contact_Tag::connect();
        //Bước2: Thao tác với CSDL: CRUD
        $sql = "SELECT * FROM `contact_tag` where IdContact = $idContact";
        $result = $con->query($sql);
        $lscontact_tag = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                # code...
                $contact_tag = new Contact_Tag($row["IdContact"], $row["IdTag"]);
                array_push($lscontact_tag, $contact_tag);
            }
        }
        //Bước3: Đóng kết nối
        $con->close();
        return $lscontact_tag;
    }

    static function addContact_TagDb($idContact, $idTag)
    {
        $con = Contact_Tag::connect();
        $sql = "INSERT INTO contact_tag (IdContact, IdTag) VALUES ($idContact, $idTag);";
        if ($con->query($sql) == true) {
            //echo "Thêm ct thành công";
        } else {
            //echo "Thêm ct thất bại";
        }
        $con->close();
    }

    static function deleteContact_Tag($idContact, $idTag)
    {
        $con = Contact_Tag::connect();
        $sql = "DELETE FROM `contact_tag` WHERE `IdContact`=$idContact and `IdTag`=$idTag";
        if ($con->query($sql) == true) {
            //echo "Xóa thành công";
        } else {
            //echo "Xóa thất bại";
        }
        $con->close();
    }

}
?>