<?php
include_once("header.php")
?>
<?php
include_once("nav.php")
?>

<?php
include_once("model/contact.php");
include_once("model/tag.php");
include_once("model/contact_tag.php");
$lsFromDB = Contact::getListContactFromDB();
$lsTagFromDB = Tag::getListTagFromDB();

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
if (isset($_REQUEST["addContact"])) {

    $name = $_REQUEST["name"];

    $email = $_REQUEST["email"];

    $phone = $_REQUEST["phone"];

    $tag = $_REQUEST["tag"];

    Contact::addContactDb($name, $email, $phone, $tag);
}

if (isset($_REQUEST["addTag"])) {

    $name = $_REQUEST["tagname"];

    Tag::addTagDb($name);
}
?>

<?php
if (isset($_REQUEST["action"])) {
    if ($_REQUEST["action"] == 'delete') {
        Book::deleteBookFromDB($_POST["bookId"]);
    }
    if ($_REQUEST["action"] == 'edit') {
        echo $_REQUEST["id"];
        echo $_REQUEST["name"];
        echo $_REQUEST["email"];
        echo $_REQUEST["phone"];
        echo $_REQUEST["tag"];
        Contact::editContactFromDb($_REQUEST["id"], $_REQUEST["name"], $_REQUEST["email"], $_REQUEST["phone"], $_REQUEST["tag"]);
    }
}
?>

<table class="table table-bordered">
    <tr style="background: #343a40; color: white">
        <td>Name</td>
        <td>Email</td>
        <td>Phone</td>
        <td>Thao tác</td>
    </tr>
    <?php foreach ($lsFromDB as  $contactItem) { ?>
        <tr>
            <td><?php echo $contactItem->name ?></td>
            <td><?php echo $contactItem->email ?></td>
            <td><?php echo $contactItem->phone ?></td>
            <td>
                <div>
                    <button data-toggle="modal" data-target="<?php echo "#editContact" . $contactItem->id; ?>" class="btn btn-outline-warning"><i class="fas fa-edit"></i>&nbsp;Sửa</button>
                    <div class="modal fade" id="<?php echo "editContact" . $contactItem->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form method="post">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <?php echo $contactItem->name; ?>
                                        <h5 class="modal-title" id="exampleModalLabel">Sửa thông tin liên hệ</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="id" class="form-control" placeholder="Nhap ten sach" value="<?php echo $contactItem->name; ?>">
                                        <label for="exampleInputEmail1">Name</label>
                                        <input type="text" name="name" class="form-control" placeholder="Nhap ten sach" value="<?php echo $contactItem->name; ?>">
                                        <label for="exampleInputEmail1">Email</label>
                                        <input type="text" name="email" class="form-control" placeholder="Enter ten tac gia" value="<?php echo $contactItem->email; ?>">
                                        <label for="exampleInputEmail1">Phone</label>
                                        <input type="text" name="phone" class="form-control" placeholder="Nhap nam xuat ban" value="<?php echo $contactItem->phone; ?>">
                                        <label for="exampleInputEmail1">Tag</label><br />
                                        <?php 
                                        $lsContactTagOfEachContact = Contact_Tag::getListContact_TagOfEachContact($contactItem->id);
                                        foreach ($lsTagFromDB as $tagItem) {
                                            echo $tagItem->id;
                                                if (in_array($tagItem->id, array_column($lsContactTagOfEachContact, 'idTag'))) {
                                                    ?>
                                                <span>
                                                    <input checked type="checkbox" name="<?php echo $tagItem->id ?>" value="<?php echo $tagItem->id ?>">
                                                    <label class="mr-3"><?php echo $tagItem->name ?></label>
                                                </span>
                                            <?php } else {
                                                        ?>
                                                <span>
                                                    <input type="checkbox" name="<?php echo $tagItem->id ?>" value="<?php echo $tagItem->id ?>">
                                                    <label class="mr-3"><?php echo $tagItem->name ?></label>
                                                </span>
                                        <?php
                                                }
                                            } ?>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" name="contactId" value="<?php echo "$contactItem->id"; ?>" />
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Huy</button>
                                        <button name="action" value="edit" class="btn btn-primary">Luu</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
                <form style="display: inline;" action="baiso4.php" method="post">
                    <input type="hidden" name="contactId" value="<?php echo "$contactItem->id"; ?>" />
                    <button type="submit" name="action" value="delete" class="btn btn-outline-danger"><i class="fas fa-trash-alt"></i>&nbsp;Xóa</button>
                </form>
            </td>
        </tr>
    <?php } ?>
</table>

<?php
include_once("footer.php")
?>