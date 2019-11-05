<?php 
include_once("model/user.php");
include_once("model/book.php");
$userName = $_REQUEST["username"];

$lsFromFile = Book::getListFromJson();
//$jsonBook  = json_encode($tempArr);
//$user = new User($userName, "123", "Thang123");
//$jsonUser = json_encode($user);
//echo $jsonBook;

?>
<table class="table table-bordered">
    <tr style="background: #343a40; color: white">
        <td>STT</td>       
        <td>Tieu de</td>
        <td>Gia</td>
        <td>Tac gia</td>
        <td>Nam hoc</td>
    </tr>
    <?php foreach ($lsFromFile as  $bookItem) { ?>
        <tr>
            <td><?php echo $bookItem->id ?></td>
            <td><?php echo $bookItem->title ?></td>
            <td><?php echo $bookItem->price ?></td>
            <td><?php echo $bookItem->author ?></td>
            <td><?php echo $bookItem->year ?></td>
            <td>

                <div>
                    <button data-toggle="modal" data-target="<?php echo "#editBook".$bookItem->id; ?>" class="btn btn-outline-warning"><i class="fas fa-edit"></i>&nbsp;Sửa</button>
                    <div class="modal fade" id="<?php echo "editBook".$bookItem->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form method="post">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <?php echo $bookItem->title;?>
                                        <h5 class="modal-title" id="exampleModalLabel">Sua thong tin sach</h5>
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
                                        <input type="hidden" name="bookId" value="<?php echo "$bookItem->id"; ?>" />
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Huy</button>
                                        <button type="submit" name="action" value="edit" class="btn btn-primary">Luu</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
                <form style="display: inline;" action="" method="post">
                    <input type="hidden" name="bookId" value="<?php echo "$bookItem->id"; ?>" />
                    <button type="submit" name="action" value="delete" class="btn btn-outline-danger"><i class="fas fa-trash-alt"></i>&nbsp;Xóa</button>
                </form>

            </td>

        <?php } ?>
</table>

