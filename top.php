<?php
include_once('conn.php');

$page = basename($_SERVER['PHP_SELF']);
session_start();
$_SESSION["page"] = $page;
error_reporting(0);
/*if(isset($_SESSION['names'])){

}
else {
    header("Location:login.php");}*/

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Books System</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
   <!-- IonIcons -->
   <link rel="stylesheet" href="dist/css/ionicons.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- BS Stepper -->
  <link rel="stylesheet" href="plugins/bs-stepper/css/bs-stepper.min.css">
  <!-- dropzonejs -->
  <link rel="stylesheet" href="plugins/dropzone/min/dropzone.min.css">
  <!-- SweetAlert2 -->
    <link rel="stylesheet" href="plugins/sweetalert2/sweetalert2.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
<!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
 
    </ul>
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->


    </ul>


  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <img src="dist/img/munyiralogo.png" alt="St.Marks Logo" width="100%">
      
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">

        <div class="info">
          <a class="d-block"><?php echo $_SESSION['names']?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li>
                <a href="index.php" class="nav-link <?php if(strpos($page,"index") !== false){echo "active";}?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
              &nbspDashboard
                
              </p>
            </a>
        </li>

            <li class="nav-item">
                <a href="addbookrecords.php" class="nav-link  <?php if($page=="addbookrecords.php"){echo "active";}?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Books</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="deletebookrecords.php" class="nav-link  <?php if($page=="deletebookrecords.php"){echo "active";}?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Delete Books</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="issuebooks.php" class="nav-link <?php if($page=="issuebooks.php"){echo "active";}?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Issue Books</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Recieve Issued Books
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                <a href="recievebooks.php" class="nav-link <?php if($page=="viewissuedbooks.php"){echo "active";}?>">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>by Books</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="recievestudents.php" class="nav-link <?php if($page=="viewstudents.php"){echo "active";}?>">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>by Students</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="recieveclass.php" class="nav-link <?php if($page=="viewclass.php"){echo "active";}?>">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>by Class</p>
                </a>
              </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    View Issued Books
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                <a href="viewissuedbooks.php" class="nav-link <?php if($page=="viewissuedbooks.php"){echo "active";}?>">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>by Books</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="viewstudents.php" class="nav-link <?php if($page=="viewstudents.php"){echo "active";}?>">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>by Students</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="viewclass.php" class="nav-link <?php if($page=="viewclass.php"){echo "active";}?>">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>by Class</p>
                </a>
              </li>
                </ul>
              </li>
              
              <li class="nav-item">
                <a href="allbooks.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View All books</p>
                </a>
              </li>


              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Labels
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                <a href="scanlabel.php" class="nav-link <?php if($page=="viewstudents.php"){echo "active";}?>">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>Scan Label</p>
                </a>
                </li>
              <li class="nav-item">
                <a href="printlabels.php" class="nav-link <?php if($page=="viewstudents.php"){echo "active";}?>">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>Print Labels</p>
                </a>
                
              </li>
              <li class="nav-item">
                <a href="printlabel.php" class="nav-link <?php if($page=="viewstudents.php"){echo "active";}?>">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>Print Label</p>
                </a>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Students
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                <a href="addstudent.php" class="nav-link <?php if($page=="viewissuedbooks.php"){echo "active";}?>">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>Add Student(s)</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="viewstudents.php" class="nav-link <?php if($page=="viewstudents.php"){echo "active";}?>">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>View Students</p>
                </a>
</li>
<li class="nav-item">
                <a href="" class="nav-link <?php if($page=="viewstudents.php"){echo "active";}?>">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>Delete Teachers</p>
                </a>
</li>
                </ul>
</li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Teachers
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                <a href="addstaff.php" class="nav-link <?php if($page=="viewissuedbooks.php"){echo "active";}?>">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>Add Teacher(s)</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="viewstaff.php" class="nav-link <?php if($page=="viewstudents.php"){echo "active";}?>">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>View Teachers</p>
                </a>
</li>
<li class="nav-item">
                <a href="" class="nav-link <?php if($page=="viewstudents.php"){echo "active";}?>">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>Delete Teachers</p>
                </a>
</li>
                </ul>
</li>

              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    System
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                <a href="adduser.php" class="nav-link <?php if($page=="viewissuedbooks.php"){echo "active";}?>">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>Add user</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="viewusers.php" class="nav-link <?php if($page=="viewstudents.php"){echo "active";}?>">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>View users</p>
                </a>
                </ul>
              </li>
              
              </li>
            </ul>
          </li>
          
            </a>
          </li>


        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">