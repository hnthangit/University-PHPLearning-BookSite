<?php
class Book
{
    #Begin properties
    var $id;
    var $title;
    var $price;
    var $author;
    var $year;
    #end properties

    #Construct function
    function __construct($id, $title, $price, $author, $year)
    {
        $this->id = $id;
        $this->title = $title;
        $this->price = $price;
        $this->author = $author;
        $this->year = $year;
    }

    #Member function
    function display()
    {
        echo "Price: " . $this->price . "<br />";
        echo "Title: " . $this->title . "<br />";
        echo "Author: " . $this->author . "<br />";
        echo "Year: " . $this->year . "<br />";
    }

    #Mock data
    /**
     * Lay toan bo cac cuon sach co trong CSDL
     */
    static function getList()
    {
        $listBook = array();
        array_push($listBook, new Book(1, "OOP in PHP", 5, "ngDung", 2019));
        array_push($listBook, new Book(2, "OOP in c++", 9, "nthang", 1500));
        array_push($listBook, new Book(3, "OOP in python", 4, "Trung", 1998));
        array_push($listBook, new Book(4, "OOP in C#", 4, "Huy", 2005));
        array_push($listBook, new Book(5, "OOP in java", 45, "Hoang", 2199));
        return $listBook;
    }
    /**
     * 
     */
    static function getListFromFile()
    {
        $arrData = file("data/book.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $lsbook = array();
        //var_dump($arrData);
        foreach ($arrData as $key => $value) {
            # code...
            $arrItems = explode("#", $value);
            $book = new Book($arrItems[0], $arrItems[1],  $arrItems[2], $arrItems[3], $arrItems[4]);
            array_push($lsbook, $book);
        }
        return $lsbook;
    }


    static function getListFromDB()
    {
        //Bước1: tạo kếtCRUD
        $con = Book::connect();
        //Bước2: Thao tác với CSDL: CRUD
        $sql = "SELECT * FROM `book`";
        $result = $con->query($sql);
        $lsbook = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                # code...
                $book = new Book($row["ID"], $row["Title"], $row["Price"], $row["Author"], $row["Year"]);
                array_push($lsbook, $book);
            }
        }
        //Bước3: Đóng kết nối
        $con->close();
        return $lsbook;
    }

    static function connect()
    {
        $con = new mysqli("localhost", "root", "", "bookmanager");
        $con->set_charset("utf8");
        if ($con->connect_error)
            die("Kết nốt thất bại. Chi tiết: " . $con->connect_error);
        //echo "<h1>Kết nối thành công</h1>";
        return $con;
    }

    static function getList2($search = null)
    {

        $data = file("data/book.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        $arrBook = [];

        foreach ($data as $key => $value) {

            $row = explode("#", $value);

            if (

                strlen(strstr($row[0], $search)) || strlen(strstr($row[3], $search)) ||

                strlen(strstr($row[1], $search)) || strlen(strstr($row[4], $search)) ||

                strlen(strstr($row[2], $search)) || $search == null

            )

                $arrBook[] = new Book($row[0], $row[1], $row[2], $row[3], $row[4]);
        }

        return $arrBook;
    }

    static function AddToFile($content, $bookId)
    {
        $listBook = Book::getListFromFile();
        $bookExist = 0;
        // var_dump($listBook)
        foreach ($listBook as $value) {
            # code..
            if ($bookId == $value->id) {
                $bookExist = $bookExist + 1;
                break;
            }
        }
        if ($bookExist == 0) {
            $myfile = fopen("data/book.txt", "a") or die("Unable to open file!");

            fwrite($myfile, "\n" . $content);

            fclose($myfile);
        } else
            echo "Da ton tai sach voi ID da nhap";


        $arrData = file("data/book.txt");
        $tempArr = array();
        foreach ($arrData as $key => $value) {
            var_dump($value);
            # code...
            if ($value == "\n") {
                continue;
            } else {
                array_push($tempArr, $value);
            }
        }
        file_put_contents('data/book.txt', $tempArr);
    }

    static function deleteBook($bookId)
    {
        $str = null;
        $listBook = Book::getListFromFile();
        // var_dump($listBook)
        foreach ($listBook as $value) {
            # code..
            if ($bookId == $value->id) {
                $str = $value->id . "#" . $value->title . "#" . $value->price  . "#" . $value->author . "#" . $value->year;
                var_dump($str);
                break;
            }
        }
        $contents = file_get_contents("data/book.txt");
        $contents = str_replace($str, '', $contents);
        $contents = preg_replace("/^\s+/m", '', $contents);
        //$contents = str_replace("\n\n", "\n",$contents);
        var_dump($contents);
        file_put_contents("data/book.txt", $contents);
    }

    static function deleteBookFromDB($bookId)
    {
        $con = Book::connect();
        $sql = "DELETE FROM book WHERE id='" . $bookId . "'";
        if ($con->query($sql) == true) {
            echo "Xóa thành công";
        } else {
            echo "Xóa thất bại";
        }
        $con->close();
    }

    static function editBook($bookId, $newTitle, $newPrice, $newAuthor, $newYear)
    {
        $changedInfo = ["$newTitle", $newPrice, $newAuthor, $newYear];
        $originInfo = null;
        $str = null;
        $listBook = Book::getListFromFile();
        foreach ($listBook as $value) {
            # code...
            if ($bookId == $value->id) {
                $tempArr = [$value->title, $value->price, $value->author, $value->year];
                $originInfo = $value->id . "#" . $value->title . "#" . $value->price  . "#" . $value->author . "#" . $value->year;
                for ($i = 0; $i < 4; $i++) {
                    # code...
                    if ($changedInfo[$i] == "")
                        $changedInfo[$i] = $tempArr[$i];
                }
                break;
            }
        }

        $str = $bookId . "#" . $changedInfo[0] . "#" . $changedInfo[1] . "#" . $changedInfo[2] . "#" . $changedInfo[3];
        $contents = file_get_contents("data/book.txt");
        $contents = str_replace($originInfo, $str, $contents);
        file_put_contents("data/book.txt", $contents);
    }

    static function editBookFromDb($bookId, $newTitle, $newPrice, $newAuthor, $newYear)
    {
        $con = Book::connect();
        $sql = "UPDATE book SET Title='$newTitle', Author='$newAuthor', Price='$newPrice', Year='$newYear' WHERE ID=$bookId";
        if ($con->query($sql) == true) {
            echo "Cập nhật thành công";
        } else {
            echo "Cập nhật thất bại";
        }
        $con->close();
    }

    static function addBookDb($Title, $Price, $Author, $Year)
    {
        $con = Book::connect();
        $sql = "INSERT INTO book (Title, Author, Price, Year) VALUES ('$Title', '$Author', $Price, $Year);";
        if ($con->query($sql) == true) {
            echo "Thêm thành công";
        } else {
            echo "Thêm thất bại";
        }
        $con->close();
    }

    static function getBookOfPage($page)
    {
        //So item moi trang
        $limit = 5;
        $tempArr = array();
        $listBook = Book::getListFromFile();

        $startItem = ($page - 1) * 5;
        $endItem = $startItem + 4;

        for ($i = $startItem; $i < $endItem + 1; $i++) {
            # code...
            if (isset($listBook[$i])) {
                array_push($tempArr, $listBook[$i]);
            }
        }

        return $tempArr;
    }

    static function getBookOfPageFromDB($page)
    {
        $limit = 5;
        $offset = ($page - 1) * $limit;
        $con = Book::connect();

        //Lay du lieu cho trang
        $sql = "SELECT * FROM book LIMIT $offset, $limit";
        $result = $con->query($sql);
        $lsbook = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                # code...
                $book = new Book($row["ID"], $row["Title"], $row["Price"], $row["Author"], $row["Year"]);
                array_push($lsbook, $book);
            }
        }

        $con->close();
        return $lsbook;
    }

    static function getTotalPageFromDB()
    {
        $limit = 5;
        $con = Book::connect();

        //Lay so record cua bang
        $count = "SELECT COUNT(*) FROM `book`";
        $result = $con->query($count)->fetch_array();
        $record = $result[0];

        //Tinh so trang
        $totalPage = ceil($record / $limit);
        $con->close();

        return $totalPage;
    }

    static function searchBookFromDB($keyword){
        $con = Book::connect();
        $sql = "SELECT * FROM `book` WHERE Title like '%$keyword%' or Author like '%$keyword%'";
        $result = $con->query($sql);
        $lsbook = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                # code...
                $book = new Book($row["ID"], $row["Title"], $row["Price"], $row["Author"], $row["Year"]);
                array_push($lsbook, $book);
            }
        }

        $con->close();
        return $lsbook;
    }
}
