<?php 
class Tag {


    #Begin properties
    var $id;
    var $name;
    var $total;
    #end properties

    #Construct function
    function __construct($id, $name, $total)
    {
        $this->id = $id;
        $this->name = $name;
        $this->total = $total;
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

    static function getListTagFromDB()
    {
        //Bước1: tạo kếtCRUD
        $con = Tag::connect();
        //Bước2: Thao tác với CSDL: CRUD
        $sql = "SELECT * FROM `tag`";
        $result = $con->query($sql);
        $lsTag = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                # code...
                $tag = new Tag($row["Id"], $row["TagName"], $row["Total"]);
                array_push($lsTag, $tag);
            }
        }
        //Bước3: Đóng kết nối
        $con->close();
        return $lsTag;
    }

    static function addTagDb($name)
    {
        $con = Tag::connect();
        $sql = "INSERT INTO tag (TagName, Total) VALUES ('$name', 0);";
        if ($con->query($sql) == true) {
            echo "Thêm thành công";
        } else {
            echo "Thêm thất bại";
        }
        $con->close();
    }
}
?>