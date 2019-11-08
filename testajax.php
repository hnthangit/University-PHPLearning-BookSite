<?php 
include_once("model/user.php");
include_once("model/contact.php");
include_once("model/tag.php");
include_once("model/contact_tag.php");
$lsFromDB = array();
$lstemp = array();
$listparameter = array();
$listparameter = $_GET["tagid"];
if($listparameter[0]==0){
    $lsFromDB= Contact::getListContactFromDB();
}else {
    foreach ($listparameter as $listItem) {
        # code...
        if(empty(Contact::getListContactOfTag($listItem))){
            $lsFromDB = array();
            break;
        } else {
            $lsFromDB = array_merge($lsFromDB, Contact::getListContactOfTag($listItem));
        }
    }
}


$lsFromDB = array_unique($lsFromDB, SORT_REGULAR);
$lsTagFromDB = Tag::getListTagFromDB();
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

