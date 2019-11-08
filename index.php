<?php
session_start();
include_once("model/user.php");
if (!isset($_SESSION["user"])) {
    header("location:login.php");
}
?>
<?php
include_once("header.php")
?>
<?php
include_once("nav.php")
?>

<?php
include_once("model/user.php");
include_once("model/contact.php");
include_once("model/tag.php");
include_once("model/contact_tag.php");

$lsFromDB = Contact::getListContactFromDB();
$lsTagFromDB = Tag::getListTagFromDB();
?>
<?php
if (isset($_REQUEST["addContact"])) {

    $name = $_REQUEST["name"];

    $email = $_REQUEST["email"];

    $phone = $_REQUEST["phone"];

    Contact::addContactDb($name, $email, $phone);
}

if (isset($_REQUEST["addTag"])) {

    $name = $_REQUEST["tagname"];

    Tag::addTagDb($name);
}
?>

<table id="contentAjax" class="table table-bordered">
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
                <span>
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
                                        <input type="hidden" name="id" class="form-control" placeholder="" value="<?php echo $contactItem->id; ?>">
                                        <label for="exampleInputEmail1">Name</label>
                                        <input type="text" name="name" class="form-control" placeholder="Nhập tên liên hệ" value="<?php echo $contactItem->name; ?>">
                                        <label for="exampleInputEmail1">Email</label>
                                        <input type="text" name="email" class="form-control" placeholder="Nhập email" value="<?php echo $contactItem->email; ?>">
                                        <label for="exampleInputEmail1">Phone</label>
                                        <input type="text" name="phone" class="form-control" placeholder="Nhập số điện thoại" value="<?php echo $contactItem->phone; ?>">
                                        <label for="exampleInputEmail1">Tag</label><br />
                                        <div style="display: flex; flex-direction: row; flex-wrap: wrap; justify-content: space-between; align-items: center; ">
                                            <?php
                                                $lsContactTagOfEachContact = Contact_Tag::getListContact_TagOfEachContact($contactItem->id);
                                                foreach ($lsTagFromDB as $tagItem) {

                                                    if (in_array($tagItem->id, array_column($lsContactTagOfEachContact, 'idTag'))) {
                                                        ?>
                                                    <span>
                                                        <input checked type="checkbox" name="tagid[]" value="<?php echo $tagItem->id ?>">
                                                        <label class="mr-3"><?php echo $tagItem->name ?></label>
                                                    </span>
                                                <?php } else {
                                                            ?>
                                                    <span>
                                                        <input type="checkbox" name="tagid[]" value="<?php echo $tagItem->id ?>">
                                                        <label class="mr-3"><?php echo $tagItem->name ?></label>
                                                    </span>
                                            <?php
                                                    }
                                                } ?>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" name="contactId" value="<?php echo "$contactItem->id"; ?>" />
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Huy</button>
                                        <button name="action" value="edit" class="btn btn-primary">Luu</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </span>
                <form style="display: inline;" action="index.php" method="post">
                    <input type="hidden" name="contactId" value="<?php echo "$contactItem->id"; ?>" />
                    <button type="submit" name="action" value="delete" class="btn btn-outline-danger"><i class="fas fa-trash-alt"></i>&nbsp;Xóa</button>
                </form>
            </td>
        </tr>
    <?php } ?>
</table>

<?php
if (isset($_REQUEST["action"])) {
    if ($_REQUEST["action"] == 'delete') {
        Contact::deleteContactDb($_REQUEST["contactId"]);
        $lsdelete= array();
        $lsdelete = Contact_Tag::getListContact_TagOfEachContact($_REQUEST["contactId"]);
        foreach ($lsdelete as $item) {
            # code...
            Tag::changeTotal($item->idTag, -1);
            Contact_Tag::deleteContact_Tag($_REQUEST["contactId"],$item->idTag);
        }
    }
    if ($_REQUEST["action"] == 'edit') {
        Contact::editContactFromDb($_REQUEST["id"], $_REQUEST["name"], $_REQUEST["email"], $_REQUEST["phone"]);
        $lsContactTagOfEachContact = Contact_Tag::getListContact_TagOfEachContact($_REQUEST["id"]);
        // echo $_REQUEST["id"];
        // echo $_REQUEST["name"];
        // echo $_REQUEST["email"];
        // echo $_REQUEST["phone"]."  ";
        foreach ($_REQUEST['tagid'] as $item) {
            // query to delete where item = $item
            if (in_array($item, array_column($lsContactTagOfEachContact, 'idTag'))) {
                // Contact_Tag::deleteContact_Tag($_REQUEST["id"], item);
                // Tag::changeTotal(item, -1);
            } else {
                Contact_Tag::addContact_TagDb($_REQUEST["id"], $item);
                Tag::changeTotal($item, 1);
            }
        }
    }
}
?>


<script>
    function showContact(tagId) {
        var array = [];
        var checkboxes = document.querySelectorAll('input#listtag2[type=checkbox]:checked');
        for (var i = 0; i < checkboxes.length; i++) {
            array.push(checkboxes[i].value)
        }
        // var val = document.getElementByName("listtag[]");
        console.log(array);
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("contentAjax").innerHTML = this.responseText;
            }
        }
        var s="";
        for (var i=0;i< array.length;i++)
        {
            s+="&tagid[]="+array[i];
        }

        if(array.length!=0){
            xhttp.open("GET", "testajax.php?" + s, true);
        } else {
            xhttp.open("GET", "testajax.php?tagid[]=" + 0, true);
        }       
        xhttp.send();
    }
</script>

<?php
include_once("footer.php")
?>