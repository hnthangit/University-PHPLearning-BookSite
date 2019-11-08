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
                $tag = new Tag($row["Id"], $row["Name"], $row["Total"]);
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
        $sql = "INSERT INTO tag (Name, Total) VALUES ('$name', 0);";
        if ($con->query($sql) == true) {
            echo "Thêm tag thành công";
        } else {
            //echo "Thêm thất bại";
        }
        $con->close();
    }

    static function changeTotal($idTag, $change)
    {
        $con = Tag::connect();
        ($change==1) ? $sql = "UPDATE tag SET Total=Total+1 WHERE Id=$idTag" : $sql = "UPDATE tag SET Total=Total-1 WHERE Id=$idTag";
        if ($con->query($sql) == true) {
            //echo "Thêm tag thành công";
        } else {
           // echo "Thêm tag thất bại";
        }
        $con->close();
    }

}
?>