<?php
session_start();
include('constant.php');
$object    = new Constants();
$constants = $object->constant();
$conn      = $constants['connection'];
if (!$conn) {
  mysqli_error($conn);
}
if(isset($_POST['add_trasc'])){

$name = $_SESSION['name'];
$credit_no = $_POST['c_c_number'];
$st_name = $_POST['st_name'];
$buying_acc_name = $_POST['buying_acc_name'];
$other_comment = $_POST['other_comment'];
$amount = $_POST['amount'];
$reference_id = $_POST['reference_id'];

$sql = "INSERT INTO `transaction_detail` (`c_c_no`,`amount`,`created_by_name`,`store_name`,`other_comment`,`buying_acc_name`,`reference_id`,`status`) values($credit_no,'$amount','$name','$st_name','$other_comment','$buying_acc_name','$reference_id',0)";
$result = mysqli_query($conn,$sql);
if(!$result){
  echo mysqli_error($conn);
  exit;
}
echo "<script>window.location.href='transactiondetail.php';</script>";
}

// Change status code 
if(isset($_POST['update_status'])){
    $change_id = $_POST['id'];

    $sql = "select `status` from transaction_detail where id = $change_id";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($result);
    // print_r($row);
    // exit;

    if($row['status'] == 1){
      $sql = "UPDATE transaction_detail SET `status` = 0 where id = $change_id";
      mysqli_query($conn,$sql);
      echo "<script>window.location.href='transactiondetail.php';</script>";
    }else{
      $sql = "UPDATE transaction_detail SET `status` = 1 where id = $change_id";
      mysqli_query($conn,$sql);
      echo "<script>window.location.href='transactiondetail.php';</script>";
    }    
  }
//end

if(isset($_POST['update_info'])){
  // print_r($_POST);
  $id = $_POST['t_id'];
  $credit_no = $_POST['c_c_no'];
  $amt = $_POST['amt'];
  $store_number = $_POST['strore_name'];
  $comment = $_POST['other_comment1'];
  $updated_date =date("Y/m/d H:i:s");
  $created_name = $_POST['created_by_name'];

  $sql = "UPDATE `transaction_detail` SET `c_c_no`='$credit_no',`amount`='$amt',`store_name`='$store_number',`other_comment`='$comment',`updated_at`='$updated_date',`created_by_name`='$created_name' where id = $id";

  $result = mysqli_query($conn,$sql);
  if(!$result){
    echo mysqli_error($conn);
    exit;
  }
  echo "<script>window.location.href='transactiondetail.php';</script>";


  exit;
}


if (isset($_POST['add'])) {
  $multi = $_POST['multiple'];
  $multi_array =  implode(",", $multi);
  $role = $_POST['role'];
  $sql = "INSERT INTO `roles`(`name`,`permi_id`)values('$role','$multi_array')";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    echo "<script>window.location.href='role.php';</script>";
  }
}
if (isset($_POST['delete'])) {
  $id = $_POST['id'];
  $deleteSql = "DELETE FROM `roles` WHERE `id` = $id";
  $query = mysqli_query($conn, $deleteSql) or die(mysqli_error($conn));
  if ($query) {
    echo "<script>window.location.href='role.php';</script>";
  }
}
// if (isset($_POST['exporttocsv'])) {
//   // print_r($_POST);
//   $credit_card_no = $_POST['cc_tabs'];
//   $from_date = $_POST['from_date'];
//   $to_date = $_POST['to_date'];

//   $sql = "SELECT * FROM `transaction_detail` WHERE DATE(created_at) BETWEEN '$from_date' AND '$to_date';
//   ";
//   $res = mysqli_query($conn, $sql);
//   // print_r($sql);

//   $file_name = 'test1.csv';
//   $f = fopen($file_name, 'w');
//   while ($result = mysqli_fetch_assoc($res)) {
//     // print_r($result);
//     $c_c_no = $result['c_c_no'];
//     $amount = $result['amount'];
//     $created_by_name = $result['created_by_name'];
//     $store_number_name = $result['store_name'];
//     $other_comment = $result['other_comment'];
//     $created_at = $result['created_at'];
//     fputcsv($f, array("c_c_no" => "$c_c_no", "amount" => "$amount", "created_by_name" => "$created_by_name", "store_name" => "$store_number_name", "other_comment" => "$other_comment", "created_at" => "$created_at"));
//   }
//   fclose($f);
//   // header("http://order.ecomretails.in/AI/order/oauth/v2/test1.csv");
//   //print_r($Detail);
//   echo "<script>window.open('http://order.ecomretails.in/AI/order/oauth/v2/test1.csv','_blank')</script>";
// }

if (isset($_POST['exporttocsv'])) {
  header('Content-Type: text/csv; charset=utf-8');  
  header('Content-Disposition: attachment; filename=data.csv'); 
  
  $credit_card_no = $_POST['cc_tabs'];
  $from_date = $_POST['from_date'];
  $to_date = $_POST['to_date'];

  $output = fopen("php://output", "w");  
  fputcsv($output, array('id','c_c_no','amount','created_by_name','store_name' ,'other_comment' ,'created_at'));  
    $query = "SELECT `id`,`c_c_no`,`amount`,`created_by_name`,`store_name`,`other_comment` ,`created_at` from transaction_detail WHERE `c_c_no`='$credit_card_no' and DATE(created_at) BETWEEN '$from_date' AND '$to_date' ORDER BY id DESC";  
    $result = mysqli_query($conn, $query);
  while($row = mysqli_fetch_assoc($result))  
    {
    fputcsv($output,$row);  
    }
    fclose($output);
    exit();
  }
  
if (isset($_POST['submit'])) {
  print_r($_POST);
  print_r($_FILES);

  exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Credit Card List</title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="../plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.min.css">
  <link rel="stylesheet" href="../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
  <!-- new links -->
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="../plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="../plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- BS Stepper -->
  <link rel="stylesheet" href="../plugins/bs-stepper/css/bs-stepper.min.css">
  <!-- dropzonejs -->
  <link rel="stylesheet" href="../plugins/dropzone/min/dropzone.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>
<style>
  tbody td {
    padding: 8px 8px !important;
  }

  .bttn {
    margin-left: 10px;
  }

  .hidden_div {
    display: none;
  }

  thead tr th {

    background-color: #6b8b9f;
    color: white;
    font-size:13px;
  }

  tfoot tr th {
    font-size:13px;
    background-color: #6b8b9f;

    color: white;

  }
  .clear-btn{
    font-size:13px;
  }

  .card {
    box-shadow: 0px 10px 10px #6b8b9f !important;

    border-radius: 6px;

  }

  /* table tr th{
width: 20% !important;
}
table.dataTable thead th{
padding:3px !important;
}
table.dataTable tfoot th{
padding:3px !important;
width: 20% !important;
} */

  .table tbody tr:hover {
    box-shadow: -1px 5px 9px #6b8b9f;
  }

  .table td {

    padding: 0.3rem !important;
  }

  .cronDel {
    float: right;
    margin-right: 7px;
    margin-bottom: 2px;
  }

  .searchInput {
    height: 33px;
    width: 60%;
    border-radius: 5px;
    border: none;
    padding-left: 16px;
  }

  .searchInput:focus {
    outline: none;
    -moz-box-shadow: 0px 0px 4px #6b8b9f;
    -webkit-box-shadow: 0px 0px 4px #6b8b9f;
    box-shadow: 0px 3px 4px #6b8b9f;
  }

  .searchInput:hover {
    outline: none;
    -moz-box-shadow: 0px 0px 4px #6b8b9f;
    -webkit-box-shadow: 0px 0px 4px #6b8b9f;
    box-shadow: 0px 3px 4px #6b8b9f;
  }

  .table thead tr th a {
    color: white;
  }

  .table thead tr th a:focus {
    color: white;
  }

  .table thead tr th a:hover {
    color: white;
  }

  .card-body {
    padding: 0.5rem !important;
  }
  .card-header{
        padding: 0.5rem !important; 
    }
    .modal-header{
        padding: 0.5rem !important;
        background-color: #6b8b9f;
        color: white;
    }
    .search-btn{
      background-color: #6b8b9f;
        color: white;
        font-size:13px;
    }

  .table th{
        padding: 0.5rem !important;
    }
  .card-header{
        background-color: #6b8b9f;
        color: white;
    }

  .table td {

padding: 0.3rem !important;
font-size: 13px;
}
  .pagination>li>a:hover {
    background: #6b8b9f;
    color: white;
    padding: 6px;
    box-shadow: 2px 5px 9px #6b8b9f;
  }

  .pagination>li>a {
    background-color: #6b8b9f;
    color: white;
    padding: 5px;
    margin-right: 5px;
    border-radius: 12px;
  }

  .pagination {
    margin-top: 5px;
    float: right;
  }

  .view-btn{

background-color: #6b8b9f;
color: white;
font-size: 13px;
}
.edit-btn{

background-color: #6b8b9f;
color: white;
font-size: 13px;
}

.btn-status{

background-color: #6b8b9f;
color: white;
font-size: 13px;
}


</style>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Preloader -->
    <!--<div class="preloader flex-column justify-content-center align-items-center">-->
    <!--  <img class="animation__shake" src="../dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">-->
    <!--</div>-->
    <!-- Navbar -->
    <?php include('../layout/header.php'); ?>
    <!-- /.navbar -->
    <!-- Main Sidebar Container -->
    <?php include('../layout/sidebar.php'); ?>
    <!-- Main Sidebar Container -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <br>
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Credit Card List</h3>
                  <?php
                    $dashcount=mysqli_fetch_array(mysqli_query($conn,"select count(id) as cn from `transaction_detail` where status='0'"));
                    $valid = $dashcount['cn'];
                    $dashcounts=mysqli_fetch_array(mysqli_query($conn,"select count(id) as cn from `transaction_detail` where status='1'"));
                    $invalid = $dashcounts['cn'];
                    ?>   
                  <form action="" method="POST">
                    <button type="submit" name="valid" class="btn btns btn-sm" style="float:right;margin-left:7px;background-color:white;color:#6b8b9f;" data-toggle="modal" data-target="#primary">Valid(<?php echo $valid; ?>)</button>
                    <button type="submit" name="invalid" class="btn btns btn-sm" style="float:right;margin-left:7px;background-color:white;color:#6b8b9f;" data-toggle="modal" data-target="#primary">Invalid(<?php echo $invalid; ?>)</button>

                  </form>
                  <button class="btn btns btn-sm" style="float:right;margin-left: 7px;background-color:white;color:#6b8b9f;" data-toggle="modal" data-target="#add_trans">Add Transaction Detail</button>
                  <button class="btn btns btn-sm" style="float:right;margin-left:7px;background-color:white;color:#6b8b9f;"data-toggle="modal" data-target="#uploadfile">Upload File</button>
                </div>
                <div class="card-body">

                  <label>Date Range Filter</label>
                  <form method="POST" class="form-group" style="display: flex;flex-direction: row;flex-wrap: nowrap;gap: 5px;border-bottom: 1px solid #e7e7e7;padding-bottom: 1em;">
                    <?php $sql = mysqli_query($conn, "select * from `credit_card_details`") ?>
                    <select class="form-control form-control-sm col-md-3" id="cc_tabs" name="cc_tabs" required>
                      <option value="">Select Credit Card</option>
                      <?php
                      while ($final = mysqli_fetch_assoc($sql)) {
                      ?>
                        <option value="<?php echo $final['c_c_no'] ?>"><?php echo $final['c_c_no'] ?></option>
                      <?php } ?>
                    </select>
                    <div class="col-md-3" style="display: flex;flex-wrap: nowrap;gap: 10px;">
                      <label for="from_date">From</label>
                      <input type="date" name="from_date" class="form-control form-control-sm" id="from_date" required>
                    </div>
                    <div class="col-md-3" style="display: flex;flex-wrap: nowrap;gap: 10px;">
                      <label for="to_date">To</label>
                      <input type="date" name="to_date" class="col form-control form-control-sm" id="to_date" required>
                    </div>
                    <button type="submit" class="btn btn-sm btns" name="exporttocsv" id="exporttocsv" style="background-color:#6b8b9f;color:white;">Export To CSV <i class="fa fa-download" aria-hidden="true"></i></button>
                  </form>
                  <div>
                    <div class="card-header">

                      <h3 class="card-title">Transaction Detail</h3>

                    </div>

                    <!-- /.card-header -->
                    <?php
                    if (isset($_GET['search'])) {

                      $fetchValues = $_GET['valueToSearch'];
                      // echo $fetchValues; 
                      // exit;
                      if (isset($_GET['pageno'])) {
                        $pageno = $_GET['pageno'];
                        // print_r($pageno);
                      } else {

                        $pageno = 1;
                      }
                      if (isset($_REQUEST['page_count'])) {
                        $no_of_records_per_page = $_REQUEST['page_count'];
                        //  }elseif(isset($no_of_records_per_page)){

                        //  }
                      } else {
                        $no_of_records_per_page = 10;
                      }
                      $offset = ($pageno - 1) * $no_of_records_per_page;


                      $columns = array('id', 'c_c_no', 'amount', 'created_by_name', 'store_name', 'other_comment', 'status', 'created_at');
                      $column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
                      $sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';

                      /****FILTER QUERY PAGE COUNT*****/
                      $total_pages_sql = "SELECT COUNT(id) FROM `transaction_detail` WHERE `deleted_at` is null AND CONCAT(`c_c_no`, `amount`, `created_by_name`, `store_name`, `other_comment`, `status`,`created_at`) LIKE '%$fetchValues%' ORDER BY " . $column . ' ' . $sort_order;

                      $result_1 = mysqli_query($conn, $total_pages_sql);
                      $total_rows = mysqli_fetch_array($result_1)[0];
                      $total_pages = $total_rows;
                      // echo $total_pages."<br>";
                      $last_page = ceil($total_rows / $no_of_records_per_page);
                      // echo $last_page;

                      /**********FILTER MAIN QUERY*********/


                      $sql = "SELECT * FROM `transaction_detail` WHERE `deleted_at` IS NULL AND CONCAT(`c_c_no`, `amount`, `created_by_name`, `store_name`, `other_comment`, `status`,`created_at`) LIKE '%$fetchValues%' ORDER BY " . $column . ' ' . $sort_order . ' ' . " limit $offset,$no_of_records_per_page";

                      $up_or_down = str_replace(array('ASC', 'DESC'), array('up', 'down'), $sort_order);
                      $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
                      $add_class = '';
                    } else {
                      if (isset($_GET['pageno'])) {
                        $pageno = $_GET['pageno'];
                      } else {

                        $pageno = 1;
                      }
                      if (isset($_REQUEST['page_count'])) {
                        $no_of_records_per_page = $_REQUEST['page_count'];
                        $checkCount = $_GET['page_count'];
                      } else {
                        $no_of_records_per_page = 10;
                      }

                      $offset = ($pageno - 1) * $no_of_records_per_page;
                      // echo $offset;
                      $entriesCount = "SELECT COUNT(*) FROM `transaction_detail`WHERE `deleted_at` IS NULL";
                      $result = mysqli_query($conn, $entriesCount);
                      $row = mysqli_fetch_row($result);
                      $total_records = $row[0];
                      $total_pages = $total_records;

                      // Number of pages required.
                      $last_page  = ceil($total_records / $no_of_records_per_page);
                      $columns = array('id', 'c_c_no', 'amount', 'created_by_name', 'store_name', 'other_comment', 'status', 'created_at');
                      $column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
                      $sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'asc' ? 'ASC' : 'DESC';
                      $up_or_down = str_replace(array('DESC', 'ASC'), array('down', 'up'), $sort_order);
                      $asc_or_desc = $sort_order == 'DESC' ? 'asc' : 'desc';
                      $add_class = '';

                      $sql  = "SELECT * FROM `transaction_detail` WHERE `deleted_at` IS NULL ORDER BY " . $column . ' ' . $sort_order . ' ' . " limit $offset,$no_of_records_per_page";
                    }
                    if (isset($_POST['valid'])) {
                      $sql  = "SELECT * FROM `transaction_detail` WHERE `deleted_at` IS NULL AND `status` = 0 ORDER BY " . $column . ' ' . $sort_order . ' ' . " limit $offset,$no_of_records_per_page";
                    }
                    if (isset($_POST['invalid'])) {
                      $sql  = "SELECT * FROM `transaction_detail` WHERE `deleted_at` IS NULL AND `status` = 1 ORDER BY " . $column . ' ' . $sort_order . ' ' . " limit $offset,$no_of_records_per_page";
                    }
                    ?>

                    <div>
                      <form action="" method="GET" id="frm">
                        <div class="cronDel">
                          <input type="text" name="valueToSearch" class="searchInput" placeholder="Enter Your Data.." size="20 " value="<?php if (isset($_GET['search'])) {
                                                                                                                                          echo  $_GET['valueToSearch'];
                                                                                                                                        } ?>">
                          <button type="submit" class="btn btn-sm font-weight-bold search-btn" style="color:white;" name="search">Search <i class="fa fa-regular fa-magnifying-glass"></i></button>
                          <button type="button" class="btn clear_btn btn-sm btns font-weight-bold" style="background-color:#6b8b9f;color:white; margin-right:3px ;">Clear <i class="fa fa-solid fa-arrows-rotate"></i></button>
                        </div>
                        <table id="" class="table table-bordered table-striped">

                          <thead>

                            <tr>

                              <th class="no">No </th>

                              <th style="display:none ;">Id</th>

                              <th><a href="<?php
                                            if (isset($_GET['search']) && isset($_GET['page_count']) && isset($_GET['pageno'])) {
                                              echo "transactiondetail.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&pageno=" . $_GET['pageno'] . "&column=c_c_no&order=" . $asc_or_desc;
                                            } else if (isset($_GET['search']) && isset($_GET['page_count'])) {
                                              echo "transactiondetail.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&column=c_c_no&order=" . $asc_or_desc;
                                            } else if (isset($_GET['search']) && isset($_GET['pageno'])) {
                                              echo "transactiondetail.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&pageno=" . $_GET['pageno'] . "&column=c_c_no&order=" . $asc_or_desc;
                                            } else if (isset($_GET['search'])) {
                                              echo "track_cron.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&column=c_c_no&order=" . $asc_or_desc;
                                            } else if (isset($_GET['page_count']) && isset($_GET['column']) && isset($_GET['order']) && isset($_GET['pageno'])) {
                                              echo "transactiondetail.php?page_count=" . $_GET['page_count'] . "&pageno=" . $_GET['pageno'] . "&column=c_c_no&order=" . $asc_or_desc;
                                            } else if (isset($_GET['page_count']) && isset($_GET['pageno'])) {
                                              echo "transactiondetail.php?page_count=" . $_GET['page_count'] . "&pageno=" . $_GET['pageno'] . "&column=c_c_no&order=" . $asc_or_desc;
                                            } else if (isset($_GET['page_count'])) {
                                              echo "transactiondetail.php?page_count=" . $_GET['page_count'] . "&column=c_c_no&order=" . $asc_or_desc;
                                            } elseif (isset($_GET['column']) && isset($_GET['order']) && isset($_GET['pageno'])) {
                                              echo "transactiondetail.php?column=c_c_no&order=" . $asc_or_desc . "&pageno=" . $_GET['pageno'];
                                            } else if (isset($_GET['pageno'])) {
                                              echo "transactiondetail.php?pageno=" . $_GET['pageno'] . "&column=c_c_no&order=" . $asc_or_desc;
                                            } else { ?>transactiondetail.php?column=c_c_no&order=<?php echo $asc_or_desc;
                                                                                                } ?>"> Credit Card Number<i class="fas fa-sort<?php echo $column == 'c_c_no' ? '-' . $up_or_down : ''; ?> sort"></i></a></th>

                              <th><a href="<?php
                                            if (isset($_GET['search']) && isset($_GET['page_count']) && isset($_GET['pageno'])) {
                                              echo "transactiondetail.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&pageno=" . $_GET['pageno'] . "&column=amount&order=" . $asc_or_desc;
                                            } else if (isset($_GET['search']) && isset($_GET['page_count'])) {
                                              echo "transactiondetail.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&column=amount&order=" . $asc_or_desc;
                                            } else if (isset($_GET['search']) && isset($_GET['pageno'])) {
                                              echo "transactiondetail.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&pageno=" . $_GET['pageno'] . "&column=amount&order=" . $asc_or_desc;
                                            } else if (isset($_GET['search'])) {
                                              echo "track_cron.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&column=amount&order=" . $asc_or_desc;
                                            } else if (isset($_GET['page_count']) && isset($_GET['column']) && isset($_GET['order']) && isset($_GET['pageno'])) {
                                              echo "transactiondetail.php?page_count=" . $_GET['page_count'] . "&pageno=" . $_GET['pageno'] . "&column=amount&order=" . $asc_or_desc;
                                            } else if (isset($_GET['page_count']) && isset($_GET['pageno'])) {
                                              echo "transactiondetail.php?page_count=" . $_GET['page_count'] . "&pageno=" . $_GET['pageno'] . "&column=amount&order=" . $asc_or_desc;
                                            } else if (isset($_GET['page_count'])) {
                                              echo "transactiondetail.php?page_count=" . $_GET['page_count'] . "&column=amount&order=" . $asc_or_desc;
                                            } elseif (isset($_GET['column']) && isset($_GET['order']) && isset($_GET['pageno'])) {
                                              echo "transactiondetail.php?column=amount&order=" . $asc_or_desc . "&pageno=" . $_GET['pageno'];
                                            } else if (isset($_GET['pageno'])) {
                                              echo "transactiondetail.php?pageno=" . $_GET['pageno'] . "&column=amount&order=" . $asc_or_desc;
                                            } else { ?>transactiondetail.php?column=amount&order=<?php echo $asc_or_desc;
                                                                                                } ?>"> Amount<i class="fas fa-sort<?php echo $column == 'amount' ? '-' . $up_or_down : ''; ?> sort"></i></a></th>

                              <th><a href="<?php
                                            if (isset($_GET['search']) && isset($_GET['page_count']) && isset($_GET['pageno'])) {
                                              echo "transactiondetail.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&pageno=" . $_GET['pageno'] . "&column=store_name&order=" . $asc_or_desc;
                                            } else if (isset($_GET['search']) && isset($_GET['page_count'])) {
                                              echo "transactiondetail.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&column=store_name&order=" . $asc_or_desc;
                                            } else if (isset($_GET['search']) && isset($_GET['pageno'])) {
                                              echo "transactiondetail.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&pageno=" . $_GET['pageno'] . "&column=store_name&order=" . $asc_or_desc;
                                            } else if (isset($_GET['search'])) {
                                              echo "track_cron.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&column=store_name&order=" . $asc_or_desc;
                                            } else if (isset($_GET['page_count']) && isset($_GET['column']) && isset($_GET['order']) && isset($_GET['pageno'])) {
                                              echo "transactiondetail.php?page_count=" . $_GET['page_count'] . "&pageno=" . $_GET['pageno'] . "&column=store_name&order=" . $asc_or_desc;
                                            } else if (isset($_GET['page_count']) && isset($_GET['pageno'])) {
                                              echo "transactiondetail.php?page_count=" . $_GET['page_count'] . "&pageno=" . $_GET['pageno'] . "&column=store_name&order=" . $asc_or_desc;
                                            } else if (isset($_GET['page_count'])) {
                                              echo "transactiondetail.php?page_count=" . $_GET['page_count'] . "&column=store_name&order=" . $asc_or_desc;
                                            } elseif (isset($_GET['column']) && isset($_GET['order']) && isset($_GET['pageno'])) {
                                              echo "transactiondetail.php?column=store_name&order=" . $asc_or_desc . "&pageno=" . $_GET['pageno'];
                                            } else if (isset($_GET['pageno'])) {
                                              echo "transactiondetail.php?pageno=" . $_GET['pageno'] . "&column=store_name&order=" . $asc_or_desc;
                                            } else { ?>transactiondetail.php?column=store_name&order=<?php echo $asc_or_desc;
                                                                                                    } ?>"> Store Name<i class="fas fa-sort<?php echo $column == 'store_name' ? '-' . $up_or_down : ''; ?> sort"></i></a></th>

                              <th><a href="<?php
                                            if (isset($_GET['search']) && isset($_GET['page_count']) && isset($_GET['pageno'])) {
                                              echo "transactiondetail.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&pageno=" . $_GET['pageno'] . "&column=created_by_name&order=" . $asc_or_desc;
                                            } else if (isset($_GET['search']) && isset($_GET['page_count'])) {
                                              echo "transactiondetail.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&column=created_by_name&order=" . $asc_or_desc;
                                            } else if (isset($_GET['search']) && isset($_GET['pageno'])) {
                                              echo "transactiondetail.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&pageno=" . $_GET['pageno'] . "&column=created_by_name&order=" . $asc_or_desc;
                                            } else if (isset($_GET['search'])) {
                                              echo "track_cron.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&column=created_by_name&order=" . $asc_or_desc;
                                            } else if (isset($_GET['page_count']) && isset($_GET['column']) && isset($_GET['order']) && isset($_GET['pageno'])) {
                                              echo "transactiondetail.php?page_count=" . $_GET['page_count'] . "&pageno=" . $_GET['pageno'] . "&column=created_by_name&order=" . $asc_or_desc;
                                            } else if (isset($_GET['page_count']) && isset($_GET['pageno'])) {
                                              echo "transactiondetail.php?page_count=" . $_GET['page_count'] . "&pageno=" . $_GET['pageno'] . "&column=created_by_name&order=" . $asc_or_desc;
                                            } else if (isset($_GET['page_count'])) {
                                              echo "transactiondetail.php?page_count=" . $_GET['page_count'] . "&column=created_by_name&order=" . $asc_or_desc;
                                            } elseif (isset($_GET['column']) && isset($_GET['order']) && isset($_GET['pageno'])) {
                                              echo "transactiondetail.php?column=created_by_name&order=" . $asc_or_desc . "&pageno=" . $_GET['pageno'];
                                            } else if (isset($_GET['pageno'])) {
                                              echo "transactiondetail.php?pageno=" . $_GET['pageno'] . "&column=created_by_name&order=" . $asc_or_desc;
                                            } else { ?>transactiondetail.php?column=created_by_name&order=<?php echo $asc_or_desc;
                                                                                                        } ?>">Created By Name<i class="fas fa-sort<?php echo $column == 'created_by_name' ? '-' . $up_or_down : ''; ?> sort"></i></a></th>

                              <th><a href="<?php
                                            if (isset($_GET['search']) && isset($_GET['page_count']) && isset($_GET['pageno'])) {
                                              echo "transactiondetail.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&pageno=" . $_GET['pageno'] . "&column=other_comment&order=" . $asc_or_desc;
                                            } else if (isset($_GET['search']) && isset($_GET['page_count'])) {
                                              echo "transactiondetail.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&column=other_comment&order=" . $asc_or_desc;
                                            } else if (isset($_GET['search']) && isset($_GET['pageno'])) {
                                              echo "transactiondetail.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&pageno=" . $_GET['pageno'] . "&column=other_comment&order=" . $asc_or_desc;
                                            } else if (isset($_GET['search'])) {
                                              echo "track_cron.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&column=other_comment&order=" . $asc_or_desc;
                                            } else if (isset($_GET['page_count']) && isset($_GET['column']) && isset($_GET['order']) && isset($_GET['pageno'])) {
                                              echo "transactiondetail.php?page_count=" . $_GET['page_count'] . "&pageno=" . $_GET['pageno'] . "&column=other_comment&order=" . $asc_or_desc;
                                            } else if (isset($_GET['page_count']) && isset($_GET['pageno'])) {
                                              echo "transactiondetail.php?page_count=" . $_GET['page_count'] . "&pageno=" . $_GET['pageno'] . "&column=other_comment&order=" . $asc_or_desc;
                                            } else if (isset($_GET['page_count'])) {
                                              echo "transactiondetail.php?page_count=" . $_GET['page_count'] . "&column=other_comment&order=" . $asc_or_desc;
                                            } elseif (isset($_GET['column']) && isset($_GET['order']) && isset($_GET['pageno'])) {
                                              echo "transactiondetail.php?column=other_comment&order=" . $asc_or_desc . "&pageno=" . $_GET['pageno'];
                                            } else if (isset($_GET['pageno'])) {
                                              echo "transactiondetail.php?pageno=" . $_GET['pageno'] . "&column=other_comment&order=" . $asc_or_desc;
                                            } else { ?>transactiondetail.php?column=other_comment&order=<?php echo $asc_or_desc;
                                                                                                      } ?>"> Other Comment <i class="fas fa-sort<?php echo $column == 'other_comment' ? '-' . $up_or_down : ''; ?> sort"></i></a></th>

                              <th><a href="<?php
                                            if (isset($_GET['search']) && isset($_GET['page_count']) && isset($_GET['pageno'])) {
                                              echo "transactiondetail.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&pageno=" . $_GET['pageno'] . "&column=created_at&order=" . $asc_or_desc;
                                            } else if (isset($_GET['search']) && isset($_GET['page_count'])) {
                                              echo "transactiondetail.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&column=created_at&order=" . $asc_or_desc;
                                            } else if (isset($_GET['search']) && isset($_GET['pageno'])) {
                                              echo "transactiondetail.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&pageno=" . $_GET['pageno'] . "&column=created_at&order=" . $asc_or_desc;
                                            } else if (isset($_GET['search'])) {
                                              echo "track_cron.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&column=created_at&order=" . $asc_or_desc;
                                            } else if (isset($_GET['page_count']) && isset($_GET['column']) && isset($_GET['order']) && isset($_GET['pageno'])) {
                                              echo "transactiondetail.php?page_count=" . $_GET['page_count'] . "&pageno=" . $_GET['pageno'] . "&column=created_at&order=" . $asc_or_desc;
                                            } else if (isset($_GET['page_count']) && isset($_GET['pageno'])) {
                                              echo "transactiondetail.php?page_count=" . $_GET['page_count'] . "&pageno=" . $_GET['pageno'] . "&column=created_at&order=" . $asc_or_desc;
                                            } else if (isset($_GET['page_count'])) {
                                              echo "transactiondetail.php?page_count=" . $_GET['page_count'] . "&column=created_at&order=" . $asc_or_desc;
                                            } elseif (isset($_GET['column']) && isset($_GET['order']) && isset($_GET['pageno'])) {
                                              echo "transactiondetail.php?column=created_at&order=" . $asc_or_desc . "&pageno=" . $_GET['pageno'];
                                            } else if (isset($_GET['pageno'])) {
                                              echo "transactiondetail.php?pageno=" . $_GET['pageno'] . "&column=created_at&order=" . $asc_or_desc;
                                            } else { ?>transactiondetail.php?column=created_at&order=<?php echo $asc_or_desc;
                                                                                                    } ?>"> Created Date <i class="fas fa-sort<?php echo $column == 'created_at' ? '-' . $up_or_down : ''; ?> sort"></i></a></th>

                              <th><a href="<?php
                                            if (isset($_GET['search']) && isset($_GET['page_count']) && isset($_GET['pageno'])) {
                                              echo "transactiondetail.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&pageno=" . $_GET['pageno'] . "&column=status&order=" . $asc_or_desc;
                                            } else if (isset($_GET['search']) && isset($_GET['page_count'])) {
                                              echo "transactiondetail.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&column=status&order=" . $asc_or_desc;
                                            } else if (isset($_GET['search']) && isset($_GET['pageno'])) {
                                              echo "transactiondetail.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&pageno=" . $_GET['pageno'] . "&column=status&order=" . $asc_or_desc;
                                            } else if (isset($_GET['search'])) {
                                              echo "track_cron.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&column=status&order=" . $asc_or_desc;
                                            } else if (isset($_GET['page_count']) && isset($_GET['column']) && isset($_GET['order']) && isset($_GET['pageno'])) {
                                              echo "transactiondetail.php?page_count=" . $_GET['page_count'] . "&pageno=" . $_GET['pageno'] . "&column=status&order=" . $asc_or_desc;
                                            } else if (isset($_GET['page_count']) && isset($_GET['pageno'])) {
                                              echo "transactiondetail.php?page_count=" . $_GET['page_count'] . "&pageno=" . $_GET['pageno'] . "&column=status&order=" . $asc_or_desc;
                                            } else if (isset($_GET['page_count'])) {
                                              echo "transactiondetail.php?page_count=" . $_GET['page_count'] . "&column=status&order=" . $asc_or_desc;
                                            } elseif (isset($_GET['column']) && isset($_GET['order']) && isset($_GET['pageno'])) {
                                              echo "transactiondetail.php?column=status&order=" . $asc_or_desc . "&pageno=" . $_GET['pageno'];
                                            } else if (isset($_GET['pageno'])) {
                                              echo "transactiondetail.php?pageno=" . $_GET['pageno'] . "&column=status&order=" . $asc_or_desc;
                                            } else { ?>transactiondetail.php?column=status&order=<?php echo $asc_or_desc;
                                                                                                } ?>"> Status <i class="fas fa-sort<?php echo $column == 'status' ? '-' . $up_or_down : ''; ?> sort"></i></a></th>

                              <th>Action</th>

                            </tr>

                          </thead>

                          <tbody>
                            <?php $i = 1;
                            // $qry = "select * from `transaction_detail`";
                            // echo $sql;
                            $result = mysqli_query($conn, $sql);

                            while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                              <tr>
                                <td><?php echo $i; ?></td>
                                <td style="display:none;"><?php echo $row['id']; ?></td>
                                <td> <?php echo $row['c_c_no']; ?></td>
                                <td> <?php echo $row['amount']; ?></td>
                                <td> <?php echo $row['store_name']; ?></td>
                                <td> <?php echo $row['created_by_name']; ?></td>
                                <td> <?php echo $row['other_comment']; ?></td>
                                <td> <?php echo $row['created_at']; ?></td>
                                <td> <?php if ($row['status'] == '0') {
                                        echo "<span style='color:green'>Valid</span>";
                                      } else {
                                        echo "<span style='color:red'>Invalid</span>";
                                      } ?></td>
                                <td width="200">

                                  <button type="button" class="btn btn-sm edit-btn edit" data-toggle="modal" data-target="#edit"><i class="fa fa-edit" class="text-white"></i></button>

                                  <button type="button" data-toggle="tooltip" data-id="<?php echo $row['id'] ?>"  class="btn btn-sm view-btn view-creditcard text-white"><i class="fa fa-eye"></i></button>

                                  <button type="button" data-toggle="tooltip" data-id="<?php echo $row['id'] ?>" class="delete btn btn-sm btns view-creditcard" style="background-color:#6b8b9f;color:white;"><i class="fa fa-trash"></i></button>

                                  <!-- <button type="button" data-toggle="modal" data-target="#change_status" data-id="<?php echo $row['id'] ?>" data-status="0" data-original-title="Update" class="changestatus btn btn-sm btn-info"><i class="fa fa-edit"></i> Status</button> -->
                                  <button type="button" class="btn btn-status btn-sm edit_status" data-toggle="modal" data-target="#change_status"><i class="fa fa-edit" class="text-white">Status</i></button>
                                </td>
                              </tr>
                            <?php $i++;
                            } ?>
                          </tbody>
                          <tfoot>
                            <tr>
                              <th>No </th>
                              <th style="display:none;">id</th>
                              <th>Credit Card Number</th>
                              <th>Amount</th>
                              <th>Store Name</th>
                              <th>Created By Name</th>
                              <th>Other Comment</th>
                              <th>Created Date</th>
                              <th>Status</th>
                              <th>Action</th>
                            </tr>
                          </tfoot>

                        </table>
                      </form>


                      <ul class="pagination" id="data_pagination">
                        <!-- FIRST PAGE PAGINATION START HERE -->

                        <li class="page-item"><a href="<?php
                                                        if (isset($_GET['search']) && isset($_GET['page_count']) && isset($_GET['column']) && isset($_GET['order']) && isset($_GET['pageno'])) {

                                                          echo "transaction_detail.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&pageno=1&column=" . $_GET['column'] . "&order=" . $_GET['order'];
                                                        } else if (isset($_GET['search']) && isset($_GET['page_count'])) {

                                                          echo "transaction_detail.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&pageno=1";
                                                        } else if (isset($_GET['search']) && isset($_GET['column']) && isset($_GET['order'])) {

                                                          echo "transaction_detail.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&column=" . $_GET['column'] . "&order=" . $_GET['order'] . "&pageno=1";
                                                        } else if (isset($_GET['search'])) {
                                                          echo "transaction_detail.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&pageno=1";
                                                        } elseif (isset($_GET['page_count']) && isset($_GET['column']) && isset($_GET['order'])  && isset($_GET['pageno'])) {
                                                          echo "transaction_detail.php?page_count=" . $_GET['page_count'] . "&column=" . $_GET['column'] . "&order=" . $_GET['order'] . "&pageno=1";
                                                        } elseif (isset($_GET['page_count']) && isset($_GET['pageno'])) {
                                                          echo "transaction_detail.php?page_count=" . $_GET['page_count'] . "&pageno=1";
                                                        } elseif (isset($_GET['column']) && isset($_GET['order']) && isset($_GET['pageno'])) {

                                                          echo "transaction_detail.php?column=" . $_GET['column'] . "&order=" . $_GET['order'] . "&pageno=1";
                                                        } else { ?>
                                            ?pageno=1<?php } ?>">First</a></li>
                        <!-- PREVIOUS PAGE FUNCTIONALITY START HERE -->
                        <li class="<?php if ($pageno <= 1) {
                                      echo 'disabled';
                                    } ?>">
                          <a href="<?php if ($pageno <= 1) {
                                      echo '#';
                                    } elseif (isset($_GET['search']) && isset($_GET['page_count']) && isset($_GET['column']) && isset($_GET['order'])) {

                                      echo "transaction_detail.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&pageno=" . ($pageno - 1) . "&column=" . $_GET['column'] . "&order=" . $_GET['order'];
                                    } elseif (isset($_GET['search']) && isset($_GET['page_count'])) {

                                      echo "transaction_detail.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&pageno=" . ($pageno - 1);
                                    } else if (isset($_GET['search']) && isset($_GET['column']) && isset($_GET['order'])) {

                                      echo "transaction_detail.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&column=" . $_GET['column'] . "&order=" . $_GET['order'] . "&pageno=" . ($pageno - 1);
                                    } elseif (isset($_GET['search'])) {
                                      echo "transaction_detail.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&pageno=" . ($pageno - 1);
                                    } elseif (isset($_GET['page_count']) && isset($_GET['column']) && isset($_GET['order'])  && isset($_GET['pageno'])) {
                                      echo "transaction_detail.php?page_count=" . $_GET['page_count'] . "&column=" . $_GET['column'] . "&order=" . $_GET['order'] . "&pageno=" . ($pageno - 1);
                                    } elseif (isset($_GET['page_count']) && isset($_GET['pageno'])) {
                                      echo "transaction_detail.php?page_count=" . $_GET['page_count'] . "&pageno=" . ($pageno - 1);
                                    } elseif (isset($_GET['column']) && isset($_GET['order']) && isset($_GET['pageno'])) {

                                      echo "transaction_detail.php?column=" . $_GET['column'] . "&order=" . $_GET['order'] . "&pageno=" . $_GET['pageno'] - 1;
                                    } else {
                                      echo "?pageno=" . ($pageno - 1);
                                    }

                                    ?>">Prev</a>
                        </li>
                        <!-- NEXT PAGE FUNCTIONALITY START HERE -->
                        <li class="<?php if ($pageno >= $last_page) {
                                      echo 'disabled';
                                    } ?>">
                          <a href="<?php if ($pageno >= $last_page) {
                                      echo '#';
                                    } elseif (isset($_GET['search']) && isset($_GET['page_count']) && isset($_GET['column']) && isset($_GET['order'])) {

                                      echo "transaction_detail.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&pageno=" . ($pageno + 1) . "&column=" . $_GET['column'] . "&order=" . $_GET['order'];
                                    } elseif (isset($_GET['search']) && isset($_GET['page_count'])) {

                                      echo "transaction_detail.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&pageno=" . ($pageno + 1);
                                    } else if (isset($_GET['search']) && isset($_GET['column']) && isset($_GET['order'])) {

                                      echo "transaction_detail.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&column=" . $_GET['column'] . "&order=" . $_GET['order'] . "&pageno=" . ($pageno + 1);
                                    } elseif (isset($_GET['search'])) {
                                      echo "transaction_detail.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&pageno=" . ($pageno + 1);
                                    } elseif (isset($_GET['page_count']) && isset($_GET['column']) && isset($_GET['order'])) {
                                      echo "transaction_detail.php?page_count=" . $_GET['page_count'] . "&column=" . $_GET['column'] . "&order=" . $_GET['order'] . "&pageno=" . ($pageno + 1);
                                    } elseif (isset($_GET['page_count'])) {
                                      echo "transaction_detail.php?page_count=" . $_GET['page_count'] . "&pageno=" . ($pageno + 1);
                                    } elseif (isset($_GET['column']) && isset($_GET['order'])) {

                                      echo "transaction_detail.php?column=" . $_GET['column'] . "&order=" . $_GET['order'] . "&pageno=" . ($pageno + 1);
                                    } else {
                                      //print_r($filter_url= $_GET['filter']);

                                      echo "?pageno=" . ($pageno + 1);
                                    }


                                    ?>">Next</a>
                        </li>
                        <!-- DISPLAYED PAGENUMBER IN NUMBER FORMAT -->
                        <li>
                          <?php
                          $link = "";
                          //    $pageno = 1; // your current page
                          //    $last_page=20; // Total number of pages

                          $limit = 4; // LIMIT NO TO 3

                          if ($last_page >= 1 && $pageno <= $last_page) {
                            $counter = 1;
                            $link = "";
                            // if ($pageno > ($limit/2))
                            // { $link .= "<a href=\"?pageno=1\">1 </a>  ";}
                            for ($x = $pageno; $x <= $last_page; $x++) {

                              if ($counter < $limit && isset($_GET['search']) && isset($_GET['page_count']) && isset($_GET['column']) && isset($_GET['order'])) {

                                $link .= "<a href=\"transaction_detail.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&pageno=" . $x . "&column=" . $_GET['column'] . "&order=" . $_GET['order'] . "\">" . $x . " </a>";
                              } else if ($counter < $limit && isset($_GET['search']) && isset($_GET['page_count'])) {

                                $link .= "<a href=\"transaction_detail.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&pageno=" . $x . "\">" . $x . " </a>";
                              } else if ($counter < $limit && isset($_GET['search'])) {
                                $link .= "<a href=\"transaction_detail.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&pageno=" . $x . "\">" . $x . " </a>";
                              } elseif ($counter < $limit && isset($_GET['page_count'])  && isset($_GET['column']) && isset($_GET['order'])) {

                                $link .= "<a href=\"transaction_detail.php?page_count=" . $_GET['page_count'] . "&column=" . $_GET['column'] . "&order=" . $_GET['order'] . "&pageno=" . $x . "\">" . $x . " </a>";
                              } elseif ($counter < $limit && isset($_GET['page_count'])) {

                                $link .= "<a href=\"transaction_detail.php?page_count=" . $_GET['page_count'] . "&pageno=" . $x . "\">" . $x . " </a>";
                              } elseif ($counter < $limit && isset($_GET['column']) && isset($_GET['order'])) {

                                $link .= "<a href=\"transaction_detail.php?column=" . $_GET['column'] . "&order=" . $_GET['order'] . "&pageno=" . $x . "\">" . $x . " </a>";
                              } elseif ($counter < $limit) {
                                $link .= "<a href=\"transaction_detail.php?pageno=" . $x . "\">" . $x . " </a>";
                              }
                              $counter++;
                            }
                            // if ($pageno < $last_page - ($limit/2))
                            // { $link .= "<a href=\"?pageno=" .$pageno."\">".$last_page." </a>"; }
                          }
                          echo $link; ?>
                        </li>
                        <!-- LAST PAGE FUNCTIONALITY START HERE -->

                        <li><a href="<?php
                                      if (isset($_GET['search']) && isset($_GET['page_count']) && isset($_GET['column']) && isset($_GET['order'])) {

                                        echo "transaction_detail.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&pageno=" . $last_page . "&column=" . $_GET['column'] . "&order=" . $_GET['order'];
                                      } else if (isset($_GET['search']) && isset($_GET['page_count'])) {

                                        echo "transaction_detail.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&pageno=" . $last_page;
                                      } else if (isset($_GET['search']) && isset($_GET['column']) && isset($_GET['order'])) {

                                        echo "transaction_detail.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&column=" . $_GET['column'] . "&order=" . $_GET['order'] . "&pageno=" . $last_page;
                                      } elseif (isset($_GET['search'])) {
                                        echo "transaction_detail.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&pageno=" . $last_page;
                                      } elseif (isset($_GET['page_count']) && isset($_GET['column']) && isset($_GET['order'])) {
                                        echo "transaction_detail.php?page_count=" . $_GET['page_count'] . "&column=" . $_GET['column'] . "&order=" . $_GET['order'] . "&pageno=" . $last_page;
                                      } elseif (isset($_GET['page_count'])) {
                                        echo "transaction_detail.php?page_count=" . $_GET['page_count'] . "&pageno=" . $last_page;
                                      } elseif (isset($_GET['column']) && isset($_GET['order'])) {

                                        echo "transaction_detail.php?column=" . $_GET['column'] . "&order=" . $_GET['order'] . "&pageno=" . $last_page;
                                      } else {
                                      ?>
                            transaction_detail.php?pageno=<?php echo $last_page;
                                                        } ?>">Last</a></li>
                      </ul>
                      <!-- PAGE COUNT SELECTBOX START HERE -->
                      <div style="margin-left: 5px; float:left;margin-top: 8px;">

                        <?php
                        $options = array(10, 20, 50, 100,);

                        echo '<form method="GET">
                                <select name="page_count"  class="pageCountForm"  onchange="this.form.submit();pageCountFunction();">';

                        foreach ($options as $option) {
                          if ($option == $no_of_records_per_page) {
                            echo "<option selected='selected'> $option </option>";
                          } else {
                            echo "<option> $option </option>";
                          }
                        }
                        echo '</select>';


                        ?>
                      </div>
                      <!-- PAGE COUNT SELECTBOX  HERE -->
                      <div style="float:left; margin-left:10px; margin-top: 8px;" class="tableFooter">

                        <!-- PAGENO AND TOTALENTRIES FUNCTIONALITY START HERE -->
                        Current Page <?php echo $pageno; ?> Of Total Pages <?php echo $last_page; ?> And Total Entries <?php echo $total_pages; ?> &nbsp; &nbsp;

                      </div>
                      <!-- page end-->

                    </div>
                  </div>
                  <!-- /.card-body -->
                </div>
              </div>
            </div>
            
            <!-- ADD Modal -->
            <div class="modal fade text-left" id="primary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <label class="modal-title text-text-bold-600" id="myModalLabel33">
                      <h4 class="text-white">Add Role</h4>
                    </label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form action="" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                      <div class="form-group row">
                        <div class="col-sm-3">
                          <label class="product_label">Role: </label>
                          <input type="text" id="" name="role" value="" class="form-control" placeholder="" required>
                        </div>
                        <div class="col-sm-6">
                          <?php
                          // $newconn = mysqli_connect("localhost", "root", "", "dropdown");
                          $selsql = mysqli_query($conn, "SELECT * FROM `permissions` ") or die(mysqli_error($conn));
                          ?>
                          <div class="form-group">
                            <label>Permission</label>
                            <select class="select2" name="multiple[]" multiple="multiple" data-placeholder="Select a Permissions" style="width: 100%;" required>
                              <?php while ($sel = mysqli_fetch_assoc($selsql)) { ?>
                                <option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <input type="submit" class="btn btn-outline-success btn-md" name="add" value="Submit">
                      <button type="reset" class="btn btn-outline-secondary btn-md" data-dismiss="modal" value="close">Close</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- ADD MODAL END HERE -->
            <!-- upload Modal -->
            <div class="modal fade text-left" id="uploadfile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <label class="modal-title text-text-bold-600" id="myModalLabel33">
                      <h4 class="text-white">Import Credit Card Details</h4>
                    </label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="d-flex justify-content-center">

                    <form action="" method="POST" enctype="multipart/form-data">
                      <div class="modal-body">
                        <div class="form-group row">
                          <!-- <div class="col-sm-3">
                  
                        </div> -->
                          <div class="col-sm-12">
                            <div class="form-group row">
                              <div class="col-sm-12">
                                <?php $sql = mysqli_query($conn, "select * from `credit_card_details`") ?>
                                <select class="form-control form-control-sm col-md-7" id="cc_tabs" name="cc_tabs" required>
                                  <option value="">Select Credit Card</option>
                                  <?php while ($sel = mysqli_fetch_assoc($sql)) { ?>
                                    <option value="<?php echo $sel['c_c_no'] ?>"><?php echo $sel['c_c_no'] ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                              <div class="col-sm-11">
                                </select> <span style="color: red">(Select card number to upload file)</span>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-8">
                          <div class="form-group">
                            <label for="exampleFormControlFile1">Upload File</label>
                            <input type="file" class="form-control-file" accept=".csv,.xls,.xlsx" name='csv_file' id="exampleFormControlFile1" required>
                          </div>
                        </div>
                        <p id="fileerror" style="color:red !important;"></p>
                        <div class="card-footer">
                          <button type="submit" name="submit" class="btn btn-info" id="submit"> Submit</button>

                          <button type="button" title="Download Sample File" class="btn btn-info" id="Download">
                            <a href="" style="color: #ffffff;" id="download_btn">
                              <i class="fa fa-download"></i> Download Sample File </a>
                          </button>
                          <!-- <a href="creditcardlist.php"
                                class="btn btn-sm btn-warning">Back</a> -->
                          <button type="reset" class="btn btn btn-warning" data-dismiss="modal" value="close">Close</button>

                        </div>

                      </div>
                    </form>
                  </div>

                </div>
              </div>
            </div>
            <!-- upload MODAL END HERE -->
            
            <!-- DELETE MODAL START HERE -->
            <div class="modal animated fadeIn text-left" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <label class="modal-title text-text-bold-600" id="myModalLabel33">
                      <h4 class="text-white">Delete Role</h4>
                    </label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form action="" method="POST">
                    <div class="modal-body">
                      <h3>Are You Want To Delete This Role? <i class="ft-alert-triangle text-warning"></i></h3>
                    </div>
                    <div class="modal-footer">
                      <input type="hidden" id="id_d" name="id" class="form-control">
                      <input type="submit" class="btn btn-outline-danger btn-md" name="delete" value="Submit">
                      <button type="reset" class="btn btn-outline-secondary btn-md" data-dismiss="modal" value="close">Close</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- DELETE MODAL END HERE -->
          </div>
        </div>
        <!-- edit model -->
        <div class="modal fade text-left" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <label class="modal-title text-text-bold-600" id="myModalLabel33">
                      <h4 class="text-white">Edit</h4>
                    </label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="card-body">
                    <form action="" method="POST">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-sm-4">
                            <label for="owner"> Credit Card Number :</label>
                            <input type="text" id="c_c_no" name="c_c_no" class="form-control">
                            <input type="hidden" id="t_id" name="t_id" class="form-control">
                          </div>
                          <div class="col-sm-4">
                            <label for="cvv">Amount :</label>
                            <input type="text" id="amt" name="amt" class="form-control">
                          </div>
                          <div class="col-sm-4">
                            <label for="cardNumber">Store Name :</label>
                            <input type="text" id="strore_name" name="strore_name" class="form-control">
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <div class="col-sm-4">
                            <label for="cardNumber">Other Comment :</label>
                            <input type="text" id="other_comment1" name="other_comment1" class="form-control">
                          </div>
                          <!-- <div class="col-sm-4">
                            <label for="cardNumber">Created Date :</label>
                            <input type="date" id="created_date" name="created_date" class="form-control" >
                          </div> -->
                          <div class="col-sm-4">
                            <label for="cardNumber">Created By Name :</label>
                            <input type="text" id="created_by_name" name="created_by_name" class="form-control">
                          </div>
                        </div>
                      </div>
                      <div class="card-footer">
                        <div class="col-sm-4" id="pay-now">
                          <button type="submit" name="update_info" class="btn btn-success">Update</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- edit modal end -->

            <!-- edit status model -->
            <div class="modal fade text-left" id="change_status" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
                  <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <label class="modal-title text-text-bold-600" id="myModalLabel33">
                          <h5 class="text-white">Change Card Status</h5>
                        </label>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="card-body">
                    <form action="" method="POST">
                    <div class="modal-body" id="smallBody">
                    <div>
                      <p class="modal_delete">Are You Sure, you wanted to change this card status?</p>
                      <input type="hidden" id="id" name="id" class="form-control">
                    </div>
                  </div>
                  <div class="modal-footer">
                    <a href="#" class="btn btn-sm btn-info" id="delete_no" data-dismiss="modal">Cancel</a>
                    <button type="submit" name="update_status" class="btn btn-sm btn-success">Yes,Change</button>
                  </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- edit status modal end -->

            <!-- add transaction Modal -->
            <div class="modal fade text-left" id="add_trans" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <label class="modal-title text-text-bold-600" id="myModalLabel33">
                      <h4 class="text-white">Add New Credit Card</h4>
                    </label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="">

                    <form  action="" method="post">
                      <div class="card-body">
                        <div class="form-group row">
                          <label for="inputEmail3" class="col-sm-4 col-form-label">Credit Card Number <span class="starcolor">*</span></label>
                          <div class="col-sm-6">

                            <?php $sql = mysqli_query($conn, "select * from `credit_card_details`") ?>
                            <select class="form-control" id="c_c_number" name="c_c_number" required>
                              <option value="">Select Credit Card</option>
                              <?php while ($sel = mysqli_fetch_assoc($sql)) { ?>
                                <option value="<?php echo $sel['c_c_no'] ?>"><?php echo $sel['c_c_no'] ?></option>
                              <?php } ?>
                            </select>
                          </div>

                        </div>
                        <!--  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-6">
                      <input type="text" name="cc_name" class="form-control" id="inputEmail3" placeholder="Name"/>
                    </div>
                  </div> -->
                        <div class="form-group row">
                          <label for="inputEmail3" class="col-sm-4 col-form-label" id="music">Store Name <span class="starcolor">*</span></label>
                          <div class="col-sm-6">
                            <select id="sectionChooser" class="form-control" name="st_name" required="required">
                              <option value="" selected="selected" hidden="hidden">Select Store Name</option>
                              <option value="Amazon.com"><label>Amazon.com</label></option>
                              <option value="Other">Other</option>
                            </select>
                          </div>

                        </div>
                        <div class="hidden_div" id="Amazon.com" class="form-group row">
                          <label for="inputEmail3" class="col-sm-4 col-form-label">Buying Account Name<span class="starcolor">*</span></label>

                          <div class="col-sm-6">
                          <select class="form-control" style="margin-bottom: 14px;" id="buying_acc_name" name="buying_acc_name">
                                <option value="" selected="selected" hidden="hidden">Select Buing Account Name</option>
                                <option value="N27 LLC">N27 LLC</option>
                                <option value="Jerry N27">Jerry N27</option>
                                <option value="Tom N27">Tom N27</option> 
                                <option value="Alpha">Alpha</option>
                                <option value="GMS">GMS</option> 
                                <option value="Koushal">Koushal</option>     
                          </select>
                          </div>
                        </div>
                        <div class="hidden_div" id="Other" class="form-group row">
                          <label for="inputEmail3" class="col-sm-4 col-form-label">Other Comment<span class="starcolor">*</span></label>

                          <div class="col-sm-6">
                            <textarea class="form-control" style="margin-bottom: 14px;" name="other_comment" id="other_comment" placeholder="Comment"></textarea>
                          </div>
                        </div>
                        
                        <div class="form-group row">
                          <label for="inputEmail3" class="col-sm-4 col-form-label">Amount <span class="starcolor">*</span></label>
                          <div class="col-sm-6">
                            <input type="text" name="amount" class="form-control" id="inputEmail3" placeholder="amount" required="">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputEmail3" class="col-sm-4 col-form-label">Reference Id <span class="starcolor">*</span></label>
                          <div class="col-sm-6">
                            <input type="text" name="reference_id" class="form-control" id="inputEmail3" placeholder="Reference Id" required="">
                          </div>
                        </div>
                      </div>
                      <div class="card-footer">
                        <!-- <button type="submit" name="add_trasc" class="btn btn-info">Save</button> -->
                        <button type="submit" name="add_trasc" class="btn btn-default">Update</button>

                        <button type="reset" class="btn btn btn-warning" data-dismiss="modal" value="close">Close</button>

                      </div>
                    </form>
                  </div>

                </div>
              </div>
            </div>
            <!-- add transaction MODAL END HERE -->
      </section>
      <!-- /.content -->
    </div>

    <!-- /.content-wrapper -->
    <?php include('../layout/footer.php'); ?>
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->
  <!-- jQuery -->
  <script src="../plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="../plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script type="text/javascript">
    // function showDiv(select){
    //    if(select.value==1){
    //     document.getElementById('hidden_div').style.display = "none";
    //    } else{
    //     document.getElementById('hidden_div').style.display = "flex";
    //    }
    // } 
  </script>
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->

  <script>
    $('#sectionChooser').change(function() {
      var myID = $(this).val();
      $('.hidden_div').each(function() {
        myID === $(this).attr('id') ? $(this).show().css("display", "flex") : $(this).hide();
        // $("#Other").css("display","flex");
        // $("#Amazoncom").css("display","flex")
      });
    });
  </script>
  <script>
    $.widget.bridge('uibutton', $.ui.button)
    $(document).ready(function() {
      $('#example1').DataTable();
    });

    $(".clear_btn").on("click", function() {
      window.location = "transactiondetail.php";
    });

    // $('.delete').on('click', function() {
    //         $tr = $(this).closest('tr');
    //         var data = $tr.children("td").map(function() {
    //             return $(this).text();
    //         }).get();
    //         // console.log(data);
    //         $('#id_d').val(data[1]);
    // });
    $('.edit').on('click', function() {
            $tr = $(this).closest('tr');
            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();
            console.log(data);
            $('#t_id').val(data[1]);
            $('#c_c_no').val(data[2]);
            $('#amt').val(data[3]);
            $('#strore_name').val(data[4]);
            $('#other_comment1').val(data[6]);
            $('#created_date').val(data[7]);
            $('#created_by_name').val(data[5]);
            // $('#amt').val(data[3]);
    });
    $('.edit_status').on('click', function() {
            $tr = $(this).closest('tr');
            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();
            // console.log(data[1]);
            $('#id').val(data[1]);
    });
  </script>
  <!-- Bootstrap 4 -->
  <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="../plugins/chart.js/Chart.min.js"></script>
  <!-- Sparkline -->
  <script src="../plugins/sparklines/sparkline.js"></script>
  <!-- JQVMap -->
  <script src="../plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="../plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="../plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="../plugins/moment/moment.min.js"></script>
  <script src="../plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="../plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../dist/js/adminlte.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="../dist/js/demo.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="../dist/js/pages/dashboard.js"></script>
  <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
  <script src="../plugins/select2/js/select2.full.min.js"></script>
  <!-- new links -->
  <!-- Select2 -->
  <script src="../plugins/select2/js/select2.full.min.js"></script>
  <!-- Bootstrap4 Duallistbox -->
  <script src="../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
  <!-- InputMask -->
  <script>
    $(function() {
      //Initialize Select2 Elements
      $('.select2').select2()
      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      })
    })
  </script>
</body>

</html>