<?php 
include_once("model/tag.php");
$lsTagFromDB = Tag::getListTagFromDB();
?>
<body>
  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="index.html">Start Bootstrap</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
          <button class="btn btn-primary" type="button">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">
      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-bell fa-fw"></i>
          <span class="badge badge-danger">9+</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-envelope fa-fw"></i>
          <span class="badge badge-danger">7</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="messagesDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user-circle fa-fw"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="#">Settings</a>
          <a class="dropdown-item" href="#">Activity Log</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="logout.php">Logout</a>
        </div>
      </li>
    </ul>

  </nav>
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
      <li data-toggle="modal" data-target="#addContact" class="btn btn-primary">
        <i class="fas fa-plus"></i>
        <span>Thêm liên mới</span>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="#">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Thường xuyên liên hệ</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
          <i class="fas fa-fw fa-table"></i>
          <span>Liên hệ trung lập</span></a>
      </li>
      <hr style="color: white">
      <li data-toggle="modal" data-target="#addTag" class="btn btn-primary">
        <i class="fas fa-plus"></i>
        <span>Thêm tag mới</span>
      </li> 
<form id="listtag">
      <?php foreach ($lsTagFromDB as  $tagItem) { ?>

      <li class="nav-item">
        <div class="nav-link">
          <input class="listtag3" id="listtag2" onclick="showContact(<?php echo $tagItem->id?>)" type="checkbox" name="listtag[]" value="<?php echo $tagItem->id?>">
          <span><?php echo $tagItem->name ?></span>
          <span class="float-right"><?php echo $tagItem->total ?></span>
          </div>
      </li>
      <?php } ?>
      </form>

      <!-- Modal -->
      <div class="modal fade" id="addTag" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <form method="post">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Thêm liên hệ mới</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <label for="exampleInputEmail1">Tên</label>
                <input type="text" name="tagname" class="form-control" placeholder="Nhập tag mới">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                <button type="submit" name="addTag" class="btn btn-primary">Lưu</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <!-- Modal -->
      <div class="modal fade" id="addContact" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <form>
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Thêm liên hệ mới</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <label for="exampleInputEmail1">Tên</label>
                <input type="text" name="name" class="form-control" placeholder="Nhập tên liên hệ">
                <label for="exampleInputEmail1">Email</label>
                <input type="text" name="email" class="form-control" placeholder="Nhập email">
                <label for="exampleInputEmail1">Số điện thoại</label>
                <input type="text" name="phone" class="form-control" placeholder="Nhập số điện thoại">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                <button type="submit" name="addContact" class="btn btn-primary">Lưu</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </ul>

    <div id="content-wrapper">

      <div class="container-fluid">

        <!--day la noi dung cua tran web-->