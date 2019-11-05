<?php
include_once("header.php")
?>
<?php
include_once("nav.php")
?>

<?php
#Code bai so 4
include_once("model/book.php");

if (isset($_GET["page"]) && !isset($_REQUEST["search"])) {
    $page  = $_GET["page"];
    $lsFromDB = Book::getBookOfPageFromDB($page);
} else {
    $page = 1;
    $lsFromDB = Book::getBookOfPageFromDB(1);
};

// echo '<pre>' . print_r($lsFromFile1) . '</pre>';
?>
<div class="float-right pb-3">
    <button data-toggle="modal" data-target="#addBook" class="btn btn-primary"><i class="fas fa-plus"></i>&nbsp;Them</button>
    <!-- Modal -->
    <div class="modal fade" id="addBook" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Them sach moi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label for="exampleInputEmail1">Ten Sach</label>
                        <input type="text" name="title" class="form-control" placeholder="Nhap ten sach">
                        <label for="exampleInputEmail1">Tac gia</label>
                        <input type="text" name="author" class="form-control" placeholder="Enter ten tac gia">
                        <label for="exampleInputEmail1">Nam xuat ban</label>
                        <input type="text" name="year" class="form-control" placeholder="Nhap nam xuat ban">
                        <label for="exampleInputEmail1">Gia</label>
                        <input type="text" name="price" class="form-control" placeholder="Nhap gia">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Huy</button>
                        <button type="submit" name="addBook" class="btn btn-primary">Luu</button>
                    </div>
            </form>
        </div>
    </div>
</div>
</div>
<?php
if (isset($_REQUEST["addBook"])) {

    $Title = $_REQUEST["title"];

    $Price = $_REQUEST["price"];

    $Author = $_REQUEST["author"];

    $Year = $_REQUEST["year"];

    Book::addBookDb($Title, $Price, $Author, $Year);

    //echo "<meta http-equiv='refresh' content='0'>";

}
?>


<form action="" method="GET">

    <div class="form-group">

        <input class="form-control" name="search" style="max-width: 200px; display:inline-block;" placeholder="Search">

    </div>

</form>

<?php
if (isset($_POST["action"])) {
    if ($_POST["action"] == 'delete') {
        Book::deleteBookFromDB($_POST["bookId"]);
    }
    if ($_POST["action"] == 'edit') {
        Book::editBookFromDb($_POST["bookId"], $_POST["title"], $_POST["price"], $_POST["author"], $_POST["year"]);
    }
}
?>

<table id="contentAjax" class="table table-bordered">
    <tr style="background: #343a40; color: white">
        <td>STT</td>
        <td>Tieu de</td>
        <td>Gia</td>
        <td>Tac gia</td>
        <td>Nam hoc</td>
        <td>Thao tác</td>
    </tr>
    <?php foreach ($lsFromDB as  $bookItem) { ?>
        <tr>
            <td><?php echo $bookItem->id ?></td>
            <td><?php echo $bookItem->title ?></td>
            <td><?php echo $bookItem->price ?></td>
            <td><?php echo $bookItem->author ?></td>
            <td><?php echo $bookItem->year ?></td>
            <td>
                <div>
                    <button data-toggle="modal" data-target="<?php echo "#editBook" . $bookItem->id; ?>" class="btn btn-outline-warning"><i class="fas fa-edit"></i>&nbsp;Sửa</button>
                    <div class="modal fade" id="<?php echo "editBook" . $bookItem->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form method="post">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <?php echo $bookItem->title; ?>
                                        <h5 class="modal-title" id="exampleModalLabel">Sua thong tin sach</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <label for="exampleInputEmail1">Ten Sach</label>
                                        <input type="text" name="title" class="form-control" placeholder="Nhap ten sach" value="<?php echo $bookItem->title; ?>">
                                        <label for="exampleInputEmail1">Tac gia</label>
                                        <input type="text" name="author" class="form-control" placeholder="Enter ten tac gia" value="<?php echo $bookItem->author; ?>">
                                        <label for="exampleInputEmail1">Nam xuat ban</label>
                                        <input type="text" name="year" class="form-control" placeholder="Nhap nam xuat ban" value="<?php echo $bookItem->year; ?>">
                                        <label for="exampleInputEmail1">Gia</label>
                                        <input type="text" name="price" class="form-control" placeholder="Nhap gia" value="<?php echo $bookItem->price; ?>">
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" name="bookId" value="<?php echo "$bookItem->id"; ?>" />
                                        <input type="hidden" name="currentPage" value="<?php echo "1" ?>" />
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Huy</button>
                                        <button onclick="textAjax(1)" name="action" value="edit" class="btn btn-primary">Luu</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
                <form style="display: inline;" action="baiso4.php" method="post">
                    <input type="hidden" name="bookId" value="<?php echo "$bookItem->id"; ?>" />
                    <button type="submit" name="action" value="delete" class="btn btn-outline-danger"><i class="fas fa-trash-alt"></i>&nbsp;Xóa</button>
                </form>
            </td>
        <?php } ?>
</table>

<!-- #region -->
<!-- Xu li phan trang o day-->
<!-- #endregion -->
<?php
if (isset($_GET["page"]) && $_GET['page'] != "") {
    $page  = $_GET["page"];
    $lsFromFile = Book::getBookOfPageFromDB($page);
} else {
    $page = 1;
    $lsFromFile = Book::getBookOfPageFromDB(1);
};
?>


<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        <li class="page-item">
            <a class="page-link" href="<?php echo "?page=" . ($_GET["page"] - 1); ?>">Previous</a>
        </li>
        <?php
        $limit = 5;
        $listBook = Book::getListFromFile();

        if (isset($_GET["page"])) {
            $currentPage = (int) $_GET["page"];
        } else {
            $currentPage = 1;
        }

        //Tong so trang hien thi
        $total_pages = Book::getTotalPageFromDB();
        for ($i = 1; $i <= $total_pages; $i++) {
            # code...
            if ($i == $currentPage) {
                ?>
                <button onclick="testAjax(<?php echo $i; ?>)" class='page-item active page-link'><?php echo $i; ?></button>
            <?php
                } else {
                    ?>
                <button onclick="testAjax(<?php echo $i; ?>)" class='page-item page-link'><?php echo $i; ?></button>
        <?php
            }
        }
        ?>

        <li class="page-item">
            <a class="page-link" href="<?php echo "?page=" . ($_GET["page"] + 1); ?>">Next</a>
        </li>
    </ul>
</nav>
<script>
    function testAjax(page) {       
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("contentAjax").innerHTML = this.responseText;
            }
        }
        xhttp.open("GET", "paginationajax.php?page="+page, true);
        xhttp.send();
    }
    
    function testAjax2(currentPage) {       
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("contentAjax").innerHTML = this.responseText;
            }
        }
        xhttp.open("GET", "paginationajax.php?page="+page, true);
        xhttp.send();
    }

</script>

<?php
include_once("footer.php")
?>
