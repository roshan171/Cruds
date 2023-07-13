<?php
session_start();
include('constant.php');
$object    = new Constant1();
$constants = $object->constant1();
$conn      = $constants['connection'];
if (!$conn) {
  mysqli_error($conn);
}


// Export File

if(isset($_POST["Export"])){
  header('Content-Type: text/csv; charset=utf-8');  
  header('Content-Disposition: attachment; filename=data.csv');  
  $output = fopen("php://output", "w");  

  fputcsv($output, array('ID','Order ID','Buyer Name','Store','Comments' ,'Status'));  
  $query = "SELECT * from contact ";  
  $result = mysqli_query($conn, $query);  
  while($row = mysqli_fetch_assoc($result))  
  {
    fputcsv($output,$row);  
  }
  fclose($output);
  exit();
  }


// Import File



if(isset($_POST["Import"])){ 
     $headerLine = true;
$filename=$_FILES["file"]["tmp_name"];    
if($_FILES["file"]["size"] > 0)
{
$file = fopen($filename, "r");
//fgetcsv($file);
//print_r($con); exit;
if(!$conn){ echo "no connection";}
//$con = mysqli_connect("localhost","root","","ecomretails_order");
  while (($getData = fgetcsv($file, 100000, ",")) !== FALSE)
   {
       if($headerLine) { $headerLine = false; }
        else {
     $sql = mysqli_query($conn,"INSERT INTO contact (`order_id`,`buyer_name`,`store`,`comments`,`status`)
           VALUES ('".$getData[0]."','".$getData[1]."','".$getData[2]."','".$getData[3]."','".$getData[4]."')"); 
     mysqli_error($conn);
     $result = mysqli_query($conn,$sql);}

     if(!isset($result))
     {
         echo "<script type=\"text/javascript\">
      alert(\"CSV File has been successfully Imported.\");
      window.location = \"contact1.php\"
      </script>";
     }
     else 
     {
       echo "<script type=\"text/javascript\">
      alert(\"Invalid File:Please Upload CSV File.\");
      window.location = \"contact1.php\"
      </script>";
     }
    }
   fclose($file);  
}
}








// Insert Query

if(isset($_POST['submit'])){
  $order_id=$_POST['order_id'];
  $customer_name=$_POST['buyer_name'];
  $store=$_POST['store'];
  $comments=$_POST['comments'];
  $status=str_replace(" ","",$_POST['status']);

      $sql= mysqli_query($conn,"INSERT INTO contact(`order_id`,`buyer_name`,`store`,`comments`,`status`)VALUES('$order_id','$customer_name','$store','$comments','$status')") or die(mysqli_error($conn));

     if($sql){
        echo "<script type=\"text/javascript\">
              alert(\"Data Inserted Successfully\");
              window.location = \"contact1.php\"
              </script>"; 
      }
      else{
       echo "Data not Inserted".mysql_error($conn);
    }
  //  header('location:crm.php');
    //exit;
      }


//Update 

if(isset($_POST['update_info'])){
   //  print_r($_POST);
   // echo "point!"; exit;

 $id=$_POST['t_id'];
   $order_id = $_POST['order_id'];
   $customer_name = $_POST['buyer_name'];
   $store = $_POST['store'];
 $comments = $_POST['comments'];
 $status=str_replace(" ","",$_POST['status']);


 $sql = "UPDATE `contact` SET id='$id',order_id='$order_id',buyer_name='$customer_name',store='$store',comments='$comments',status='$status' WHERE id='$id'";
    $result = $conn->query($sql);

     if($result){
        echo "<script type=\"text/javascript\">
              alert(\"Data Updated Successfully\");
              window.location = \"contact1.php\"
              </script>"; 
      }
      else{
       echo "Data not Updated".mysql_error($conn);
    }
       // header('location:crm.php');
   //exit;
      }



// delete Query

if (isset($_GET['user_delete']))
{
    $id = $_GET['id'];
    //echo $id;exit;
    date_default_timezone_set("Asia/Calcutta"); //India time (GMT+5:30)
    $date = date('Y-m-d H:i:s');

    $sql = mysqli_query($conn, "UPDATE `contact` SET `deleted_at` = '$date' WHERE id='$id'");
    if ($sql)
    {
         echo "<script type=\"text/javascript\">
              alert(\"Data deleted Successfully\");
              window.location = \"contact1.php\"
              </script>";
    }
}




// if (isset($_POST['submit'])) {
//   print_r($_POST);
//   print_r($_FILES);

//   exit;
// }

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Contact</title>
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
                  <h3 class="card-title">Contact</h3>

<?php
                                $dashcount=mysqli_fetch_array(mysqli_query($conn,"select count(id) as cn from `contact` where status='Done'"));
                                $done = $dashcount['cn'];
                                $dashcounts=mysqli_fetch_array(mysqli_query($conn,"select count(id) as cn from `contact` where status='Pending'"));
                                $pending = $dashcounts['cn'];
                                ?>  
                  <form action="" method="POST">
                  
                    <button type="submit" name="Done" class="btn btn-primary btn-sm" style="float:right;     margin-left: 7px;" data-toggle="modal" data-target="#primary">Done(<?php echo $done; ?>)</button>
                    <button type="submit" name="Pending" class="btn btn-danger btn-sm" style="float:right;     margin-left: 7px;" data-toggle="modal" data-target="#primary">Pending(<?php echo $pending; ?>)</button>
        
                  </form>
       
                <button class="btn  btn-sm" style="float:right;margin-left: 7px;background-color: white; color:#6b8b9f;" data-toggle="modal" data-target="#add_trans">Add Form</button> 
                </div>
                              <form class="form-horizontal" action="" method="post" name="upload_excel" enctype="multipart/form-data">
                                 <button class="btn btn-sm btn-success border-0" style="color:white;font-size:13px; margin:8px;"><a href="http://localhost/AI/order/oauth/v2/contact.csv" style="color:white;">Sample</a></button>
          <input type="file" name="file" id="file" class="input-large ml-4" style="font-size:10px;" required>
      <button type="submit" id="submit" name="Import" class="btn btn-sm btn-secondary button-loading" data-loading-text="Loading...">Import<i class="fas fa-upload ml-2" style="font-size:10px;background-color: #6b8b9f;"></i></button>
       
            <input type="submit" name="Export" class="btn btn-sm btn-secondary border-0 m-2" style="float:right;background-color: #6b8b9f;" value="export to excel" />
          
      </form>
                <div class="card-body">

                  <!-- <label>Date Range Filter</label> -->
                  
                  <div>
                    <div class="card-header">

                      <h3 class="card-title">Contact List</h3>

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


                      $columns = array('id', 'order_id', 'buyer_name', 'store', 'comments','status');
                      $column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
                      $sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';

                      /****FILTER QUERY PAGE COUNT*****/
                      $total_pages_sql = "SELECT COUNT(id) FROM `contact` WHERE `deleted_at` is null AND CONCAT(`order_id`, `buyer_name`, `store`, `comments`, `status`) LIKE '%$fetchValues%' ORDER BY " . $column . ' ' . $sort_order;

                      $result_1 = mysqli_query($conn, $total_pages_sql);
                      $total_rows = mysqli_fetch_array($result_1)[0];
                      $total_pages = $total_rows;
                      // echo $total_pages."<br>";
                      $last_page = ceil($total_rows / $no_of_records_per_page);
                      // echo $last_page;

                      /**********FILTER MAIN QUERY*********/


                      $sql = "SELECT * FROM `contact` WHERE `deleted_at` IS NULL AND CONCAT(`order_id`, `buyer_name`, `store`, `comments`, `status`) LIKE '%$fetchValues%' ORDER BY " . $column . ' ' . $sort_order . ' ' . " limit $offset,$no_of_records_per_page";

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
                      $entriesCount = "SELECT COUNT(*) FROM `contact`WHERE `deleted_at` IS NULL";
                      $result = mysqli_query($conn, $entriesCount);
                      $row = mysqli_fetch_row($result);
                      $total_records = $row[0];
                      $total_pages = $total_records;

                      // Number of pages required.
                      $last_page  = ceil($total_records / $no_of_records_per_page);
                      $columns = array('id', 'order_id', 'buyer_name', 'store', 'comments', 'status');
                      $column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
                      $sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'asc' ? 'ASC' : 'DESC';
                      $up_or_down = str_replace(array('DESC', 'ASC'), array('down', 'up'), $sort_order);
                      $asc_or_desc = $sort_order == 'DESC' ? 'asc' : 'desc';
                      $add_class = '';

                      $sql  = "SELECT * FROM `contact` WHERE `deleted_at` IS NULL ORDER BY " . $column . ' ' . $sort_order . ' ' . " limit $offset,$no_of_records_per_page";
                    }
                    if (isset($_POST['Done'])) {
                      $sql  = "SELECT * FROM `contact` WHERE `deleted_at` IS NULL AND `status` = 'Done' ORDER BY " . $column . ' ' . $sort_order . ' ' . " limit $offset,$no_of_records_per_page";
                    }
                    if (isset($_POST['Pending'])) {
                      $sql  = "SELECT * FROM `contact` WHERE `deleted_at` IS NULL AND `status` = 'Pending' ORDER BY " . $column . ' ' . $sort_order . ' ' . " limit $offset,$no_of_records_per_page";
                    }
                    ?>

                    <div>
                      <form action="" method="GET" id="frm">
                        <div class="cronDel">
                          <input type="text" name="valueToSearch" class="searchInput" placeholder="Enter Your Data.." size="20 " value="<?php if (isset($_GET['search'])) {
                              echo  $_GET['valueToSearch'];
                            } ?>">
                          <button type="submit" class="btn btn-sm font-weight-bold search-btn" style="color:white;" name="search">Search <i class="fa fa-regular fa-magnifying-glass"></i></button>
                          <button type="button" class="btn clear_btn btn-sm btn-primary font-weight-bold" style="color:white; margin-right:3px ;">Clear <i class="fa fa-solid fa-arrows-rotate"></i></button>
                        </div>
                        <table id="" class="table table-bordered table-striped">

                          <thead>

                            <tr>

                              <th class="no">No </th>

                              <th style="display:none ;">Id</th>

                              <th><a href="<?php
                                            if (isset($_GET['search']) && isset($_GET['page_count']) && isset($_GET['pageno'])) {
                                              echo "contact1.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&pageno=" . $_GET['pageno'] . "&column=order_id&order=" . $asc_or_desc;
                                            } else if (isset($_GET['search']) && isset($_GET['page_count'])) {
                                              echo "contact1.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&column=order_id&order=" . $asc_or_desc;
                                            } else if (isset($_GET['search']) && isset($_GET['pageno'])) {
                                              echo "contact1.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&pageno=" . $_GET['pageno'] . "&column=order_id&order=" . $asc_or_desc;
                                            } else if (isset($_GET['search'])) {
                                              echo "contact1.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&column=order_id&order=" . $asc_or_desc;
                                            } else if (isset($_GET['page_count']) && isset($_GET['column']) && isset($_GET['order']) && isset($_GET['pageno'])) {
                                              echo "contact1.php?page_count=" . $_GET['page_count'] . "&pageno=" . $_GET['pageno'] . "&column=order_id&order=" . $asc_or_desc;
                                            } else if (isset($_GET['page_count']) && isset($_GET['pageno'])) {
                                              echo "contact1.php?page_count=" . $_GET['page_count'] . "&pageno=" . $_GET['pageno'] . "&column=order_id&order=" . $asc_or_desc;
                                            } else if (isset($_GET['page_count'])) {
                                              echo "contact1.php?page_count=" . $_GET['page_count'] . "&column=order_id&order=" . $asc_or_desc;
                                            } elseif (isset($_GET['column']) && isset($_GET['order']) && isset($_GET['pageno'])) {
                                              echo "contact1.php?column=order_id&order=" . $asc_or_desc . "&pageno=" . $_GET['pageno'];
                                            } else if (isset($_GET['pageno'])) {
                                              echo "contact1.php?pageno=" . $_GET['pageno'] . "&column=order_id&order=" . $asc_or_desc;
                                            } else { ?>contact1.php?column=order_id&order=<?php echo $asc_or_desc;
                                                                                                } ?>"> Order Id<i class="fas fa-sort<?php echo $column == 'order_id' ? '-' . $up_or_down : ''; ?> sort"></i></a></th>

                              <th><a href="<?php
                                            if (isset($_GET['search']) && isset($_GET['page_count']) && isset($_GET['pageno'])) {
                                              echo "contact1.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&pageno=" . $_GET['pageno'] . "&column=buyer_name&order=" . $asc_or_desc;
                                            } else if (isset($_GET['search']) && isset($_GET['page_count'])) {
                                              echo "contact1.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&column=buyer_name&order=" . $asc_or_desc;
                                            } else if (isset($_GET['search']) && isset($_GET['pageno'])) {
                                              echo "contact1.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&pageno=" . $_GET['pageno'] . "&column=buyer_name&order=" . $asc_or_desc;
                                            } else if (isset($_GET['search'])) {
                                              echo "contact1.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&column=buyer_name&order=" . $asc_or_desc;
                                            } else if (isset($_GET['page_count']) && isset($_GET['column']) && isset($_GET['order']) && isset($_GET['pageno'])) {
                                              echo "contact1.php?page_count=" . $_GET['page_count'] . "&pageno=" . $_GET['pageno'] . "&column=buyer_name&order=" . $asc_or_desc;
                                            } else if (isset($_GET['page_count']) && isset($_GET['pageno'])) {
                                              echo "contact1.php?page_count=" . $_GET['page_count'] . "&pageno=" . $_GET['pageno'] . "&column=buyer_name&order=" . $asc_or_desc;
                                            } else if (isset($_GET['page_count'])) {
                                              echo "contact1.php?page_count=" . $_GET['page_count'] . "&column=buyer_name&order=" . $asc_or_desc;
                                            } elseif (isset($_GET['column']) && isset($_GET['order']) && isset($_GET['pageno'])) {
                                              echo "contact1.php?column=buyer_name&order=" . $asc_or_desc . "&pageno=" . $_GET['pageno'];
                                            } else if (isset($_GET['pageno'])) {
                                              echo "contact1.php?pageno=" . $_GET['pageno'] . "&column=buyer_name&order=" . $asc_or_desc;
                                            } else { ?>contact1.php?column=buyer_name&order=<?php echo $asc_or_desc;
                                                                                                } ?>"> buyer_name<i class="fas fa-sort<?php echo $column == 'buyer_name' ? '-' . $up_or_down : ''; ?> sort"></i></a></th>

                              <th><a href="<?php
                                            if (isset($_GET['search']) && isset($_GET['page_count']) && isset($_GET['pageno'])) {
                                              echo "contact1.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&pageno=" . $_GET['pageno'] . "&column=store&order=" . $asc_or_desc;
                                            } else if (isset($_GET['search']) && isset($_GET['page_count'])) {
                                              echo "contact1.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&column=store&order=" . $asc_or_desc;
                                            } else if (isset($_GET['search']) && isset($_GET['pageno'])) {
                                              echo "contact1.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&pageno=" . $_GET['pageno'] . "&column=store&order=" . $asc_or_desc;
                                            } else if (isset($_GET['search'])) {
                                              echo "contact1.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&column=store&order=" . $asc_or_desc;
                                            } else if (isset($_GET['page_count']) && isset($_GET['column']) && isset($_GET['order']) && isset($_GET['pageno'])) {
                                              echo "contact1.php?page_count=" . $_GET['page_count'] . "&pageno=" . $_GET['pageno'] . "&column=store&order=" . $asc_or_desc;
                                            } else if (isset($_GET['page_count']) && isset($_GET['pageno'])) {
                                              echo "contact1.php?page_count=" . $_GET['page_count'] . "&pageno=" . $_GET['pageno'] . "&column=store&order=" . $asc_or_desc;
                                            } else if (isset($_GET['page_count'])) {
                                              echo "contact1.php?page_count=" . $_GET['page_count'] . "&column=store&order=" . $asc_or_desc;
                                            } elseif (isset($_GET['column']) && isset($_GET['order']) && isset($_GET['pageno'])) {
                                              echo "contact1.php?column=store&order=" . $asc_or_desc . "&pageno=" . $_GET['pageno'];
                                            } else if (isset($_GET['pageno'])) {
                                              echo "contact1.php?pageno=" . $_GET['pageno'] . "&column=store&order=" . $asc_or_desc;
                                            } else { ?>contact1.php?column=store&order=<?php echo $asc_or_desc;
                                                                                                    } ?>"> Store Name<i class="fas fa-sort<?php echo $column == 'store' ? '-' . $up_or_down : ''; ?> sort"></i></a></th>

                              <th><a href="<?php
                                            if (isset($_GET['search']) && isset($_GET['page_count']) && isset($_GET['pageno'])) {
                                              echo "contact1.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&pageno=" . $_GET['pageno'] . "&column=comments&order=" . $asc_or_desc;
                                            } else if (isset($_GET['search']) && isset($_GET['page_count'])) {
                                              echo "contact1.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&column=comments&order=" . $asc_or_desc;
                                            } else if (isset($_GET['search']) && isset($_GET['pageno'])) {
                                              echo "contact1.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&pageno=" . $_GET['pageno'] . "&column=comments&order=" . $asc_or_desc;
                                            } else if (isset($_GET['search'])) {
                                              echo "contact1.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&column=comments&order=" . $asc_or_desc;
                                            } else if (isset($_GET['page_count']) && isset($_GET['column']) && isset($_GET['order']) && isset($_GET['pageno'])) {
                                              echo "contact1.php?page_count=" . $_GET['page_count'] . "&pageno=" . $_GET['pageno'] . "&column=comments&order=" . $asc_or_desc;
                                            } else if (isset($_GET['page_count']) && isset($_GET['pageno'])) {
                                              echo "contact1.php?page_count=" . $_GET['page_count'] . "&pageno=" . $_GET['pageno'] . "&column=comments&order=" . $asc_or_desc;
                                            } else if (isset($_GET['page_count'])) {
                                              echo "contact1.php?page_count=" . $_GET['page_count'] . "&column=comments&order=" . $asc_or_desc;
                                            } elseif (isset($_GET['column']) && isset($_GET['order']) && isset($_GET['pageno'])) {
                                              echo "contact1.php?column=comments&order=" . $asc_or_desc . "&pageno=" . $_GET['pageno'];
                                            } else if (isset($_GET['pageno'])) {
                                              echo "contact1.php?pageno=" . $_GET['pageno'] . "&column=comments&order=" . $asc_or_desc;
                                            } else { ?>contact1.php?column=comments&order=<?php echo $asc_or_desc;
                                                                                                        } ?>">comments<i class="fas fa-sort<?php echo $column == 'comments' ? '-' . $up_or_down : ''; ?> sort"></i></a></th>

                              <th><a href="<?php
                                            if (isset($_GET['search']) && isset($_GET['page_count']) && isset($_GET['pageno'])) {
                                              echo "contact1.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&pageno=" . $_GET['pageno'] . "&column=status&order=" . $asc_or_desc;
                                            } else if (isset($_GET['search']) && isset($_GET['page_count'])) {
                                              echo "contact1.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&column=status&order=" . $asc_or_desc;
                                            } else if (isset($_GET['search']) && isset($_GET['pageno'])) {
                                              echo "contact1.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&pageno=" . $_GET['pageno'] . "&column=status&order=" . $asc_or_desc;
                                            } else if (isset($_GET['search'])) {
                                              echo "contact1.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&column=status&order=" . $asc_or_desc;
                                            } else if (isset($_GET['page_count']) && isset($_GET['column']) && isset($_GET['order']) && isset($_GET['pageno'])) {
                                              echo "contact1.php?page_count=" . $_GET['page_count'] . "&pageno=" . $_GET['pageno'] . "&column=status&order=" . $asc_or_desc;
                                            } else if (isset($_GET['page_count']) && isset($_GET['pageno'])) {
                                              echo "contact1.php?page_count=" . $_GET['page_count'] . "&pageno=" . $_GET['pageno'] . "&column=status&order=" . $asc_or_desc;
                                            } else if (isset($_GET['page_count'])) {
                                              echo "contact1.php?page_count=" . $_GET['page_count'] . "&column=status&order=" . $asc_or_desc;
                                            } elseif (isset($_GET['column']) && isset($_GET['order']) && isset($_GET['pageno'])) {
                                              echo "contact1.php?column=status&order=" . $asc_or_desc . "&pageno=" . $_GET['pageno'];
                                            } else if (isset($_GET['pageno'])) {
                                              echo "contact1.php?pageno=" . $_GET['pageno'] . "&column=status&order=" . $asc_or_desc;
                                            } else { ?>contact1.php?column=status&order=<?php echo $asc_or_desc;
                                                                                                      } ?>"> status <i class="fas fa-sort<?php echo $column == 'status' ? '-' . $up_or_down : ''; ?> sort"></i></a></th>
<!-- 
                              <th><a href="<?php
                                            if (isset($_GET['search']) && isset($_GET['page_count']) && isset($_GET['pageno'])) {
                                              echo "contact1.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&pageno=" . $_GET['pageno'] . "&column=created_at&order=" . $asc_or_desc;
                                            } else if (isset($_GET['search']) && isset($_GET['page_count'])) {
                                              echo "contact1.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&column=created_at&order=" . $asc_or_desc;
                                            } else if (isset($_GET['search']) && isset($_GET['pageno'])) {
                                              echo "contact1.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&pageno=" . $_GET['pageno'] . "&column=created_at&order=" . $asc_or_desc;
                                            } else if (isset($_GET['search'])) {
                                              echo "track_cron.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&column=created_at&order=" . $asc_or_desc;
                                            } else if (isset($_GET['page_count']) && isset($_GET['column']) && isset($_GET['order']) && isset($_GET['pageno'])) {
                                              echo "contact1.php?page_count=" . $_GET['page_count'] . "&pageno=" . $_GET['pageno'] . "&column=created_at&order=" . $asc_or_desc;
                                            } else if (isset($_GET['page_count']) && isset($_GET['pageno'])) {
                                              echo "contact1.php?page_count=" . $_GET['page_count'] . "&pageno=" . $_GET['pageno'] . "&column=created_at&order=" . $asc_or_desc;
                                            } else if (isset($_GET['page_count'])) {
                                              echo "contact1.php?page_count=" . $_GET['page_count'] . "&column=created_at&order=" . $asc_or_desc;
                                            } elseif (isset($_GET['column']) && isset($_GET['order']) && isset($_GET['pageno'])) {
                                              echo "contact1.php?column=created_at&order=" . $asc_or_desc . "&pageno=" . $_GET['pageno'];
                                            } else if (isset($_GET['pageno'])) {
                                              echo "contact1.php?pageno=" . $_GET['pageno'] . "&column=created_at&order=" . $asc_or_desc;
                                            } else { ?>contact1.php?column=created_at&order=<?php echo $asc_or_desc;
                                                                                                    } ?>"> Created Date <i class="fas fa-sort<?php echo $column == 'created_at' ? '-' . $up_or_down : ''; ?> sort"></i></a></th> -->

                   <!--            <th><a href="<?php
                                            if (isset($_GET['search']) && isset($_GET['page_count']) && isset($_GET['pageno'])) {
                                              echo "contact1.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&pageno=" . $_GET['pageno'] . "&column=status&order=" . $asc_or_desc;
                                            } else if (isset($_GET['search']) && isset($_GET['page_count'])) {
                                              echo "contact1.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&column=status&order=" . $asc_or_desc;
                                            } else if (isset($_GET['search']) && isset($_GET['pageno'])) {
                                              echo "contact1.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&pageno=" . $_GET['pageno'] . "&column=status&order=" . $asc_or_desc;
                                            } else if (isset($_GET['search'])) {
                                              echo "track_cron.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&column=status&order=" . $asc_or_desc;
                                            } else if (isset($_GET['page_count']) && isset($_GET['column']) && isset($_GET['order']) && isset($_GET['pageno'])) {
                                              echo "contact1.php?page_count=" . $_GET['page_count'] . "&pageno=" . $_GET['pageno'] . "&column=status&order=" . $asc_or_desc;
                                            } else if (isset($_GET['page_count']) && isset($_GET['pageno'])) {
                                              echo "contact1.php?page_count=" . $_GET['page_count'] . "&pageno=" . $_GET['pageno'] . "&column=status&order=" . $asc_or_desc;
                                            } else if (isset($_GET['page_count'])) {
                                              echo "contact1.php?page_count=" . $_GET['page_count'] . "&column=status&order=" . $asc_or_desc;
                                            } elseif (isset($_GET['column']) && isset($_GET['order']) && isset($_GET['pageno'])) {
                                              echo "contact1.php?column=status&order=" . $asc_or_desc . "&pageno=" . $_GET['pageno'];
                                            } else if (isset($_GET['pageno'])) {
                                              echo "contact1.php?pageno=" . $_GET['pageno'] . "&column=status&order=" . $asc_or_desc;
                                            } else { ?>contact1.php?column=status&order=<?php echo $asc_or_desc;
                                                                                                } ?>"> Status <i class="fas fa-sort<?php echo $column == 'status' ? '-' . $up_or_down : ''; ?> sort"></i></a></th> -->

                              <th>Action</th>

                            </tr>

                          </thead>

                          <tbody>
                            <?php $i = 1;
                            // $qry = "SELECT * FROM `contact` where deleted_at is NULL";
                        // echo $qry; exit;
                            
                            $result = mysqli_query($conn, $sql);

                            while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                              <tr>
                                <td><?php echo $i; ?></td>
                                <td style="display:none;"><?php echo $row['id']; ?></td>
                                <td> <?php echo $row['order_id']; ?></td>
                                <td> <?php echo $row['buyer_name']; ?></td>
                                <td> <?php echo $row['store']; ?></td>
                                <td> <?php echo $row['comments']; ?></td>
                                <td> <?php if ($row['status'] == 'Done') {
                                        echo "<span style='color:green'>Done</span>";
                                      } else {
                                        echo "<span style='color:red'>Pending</span>";
                                      } ?></td>
                                <td width="200">

                                  <button type="button" class="btn btn-sm edit-btn edit" data-toggle="modal" data-target="#edit"><i class="fa fa-edit" class="text-white"></i></button>

                                 <!--  <button type="button" data-toggle="tooltip" data-id="<?php echo $row['id'] ?>"  class="btn btn-sm view-btn view-creditcard text-white"><i class="fa fa-eye"></i></button> -->

                                  <button type="button"  data-toggle="modal" data-target="#delete"    class="delete btn btn-sm btn-danger delete"><i class="fa fa-trash"></i></button>

                                  <!-- <button type="button" data-toggle="modal" data-target="#change_status" data-id="<?php echo $row['id'] ?>" data-status="0" data-original-title="Update" class="changestatus btn btn-sm btn-info"><i class="fa fa-edit"></i> Status</button> -->
                                <!--   <button type="button" class="btn btn-status btn-sm edit_status" data-toggle="modal" data-target="#change_status"><i class="fa fa-edit" class="text-white">Status</i></button> -->
                                </td>
                              </tr>
                            <?php $i++;
                            } ?>
                          </tbody>
                       

                        </table>
                      </form>


                      <ul class="pagination" id="data_pagination">
                        <!-- FIRST PAGE PAGINATION START HERE -->

                        <li class="page-item"><a href="<?php
                                                        if (isset($_GET['search']) && isset($_GET['page_count']) && isset($_GET['column']) && isset($_GET['order']) && isset($_GET['pageno'])) {

                                                          echo "contact1.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&pageno=1&column=" . $_GET['column'] . "&order=" . $_GET['order'];
                                                        } else if (isset($_GET['search']) && isset($_GET['page_count'])) {

                                                          echo "contact1.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&pageno=1";
                                                        } else if (isset($_GET['search']) && isset($_GET['column']) && isset($_GET['order'])) {

                                                          echo "contact1.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&column=" . $_GET['column'] . "&order=" . $_GET['order'] . "&pageno=1";
                                                        } else if (isset($_GET['search'])) {
                                                          echo "contact1.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&pageno=1";
                                                        } elseif (isset($_GET['page_count']) && isset($_GET['column']) && isset($_GET['order'])  && isset($_GET['pageno'])) {
                                                          echo "contact1.php?page_count=" . $_GET['page_count'] . "&column=" . $_GET['column'] . "&order=" . $_GET['order'] . "&pageno=1";
                                                        } elseif (isset($_GET['page_count']) && isset($_GET['pageno'])) {
                                                          echo "contact1.php?page_count=" . $_GET['page_count'] . "&pageno=1";
                                                        } elseif (isset($_GET['column']) && isset($_GET['order']) && isset($_GET['pageno'])) {

                                                          echo "contact1.php?column=" . $_GET['column'] . "&order=" . $_GET['order'] . "&pageno=1";
                                                        } else { ?>
                                            ?pageno=1<?php } ?>">First</a></li>
                        <!-- PREVIOUS PAGE FUNCTIONALITY START HERE -->
                        <li class="<?php if ($pageno <= 1) {
                                      echo 'disabled';
                                    } ?>">
                          <a href="<?php if ($pageno <= 1) {
                                      echo '#';
                                    } elseif (isset($_GET['search']) && isset($_GET['page_count']) && isset($_GET['column']) && isset($_GET['order'])) {

                                      echo "contact1.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&pageno=" . ($pageno - 1) . "&column=" . $_GET['column'] . "&order=" . $_GET['order'];
                                    } elseif (isset($_GET['search']) && isset($_GET['page_count'])) {

                                      echo "contact1.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&pageno=" . ($pageno - 1);
                                    } else if (isset($_GET['search']) && isset($_GET['column']) && isset($_GET['order'])) {

                                      echo "contact1.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&column=" . $_GET['column'] . "&order=" . $_GET['order'] . "&pageno=" . ($pageno - 1);
                                    } elseif (isset($_GET['search'])) {
                                      echo "contact1.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&pageno=" . ($pageno - 1);
                                    } elseif (isset($_GET['page_count']) && isset($_GET['column']) && isset($_GET['order'])  && isset($_GET['pageno'])) {
                                      echo "contact1.php?page_count=" . $_GET['page_count'] . "&column=" . $_GET['column'] . "&order=" . $_GET['order'] . "&pageno=" . ($pageno - 1);
                                    } elseif (isset($_GET['page_count']) && isset($_GET['pageno'])) {
                                      echo "contact1.php?page_count=" . $_GET['page_count'] . "&pageno=" . ($pageno - 1);
                                    } elseif (isset($_GET['column']) && isset($_GET['order']) && isset($_GET['pageno'])) {

                                      echo "contact1.php?column=" . $_GET['column'] . "&order=" . $_GET['order'] . "&pageno=" . $_GET['pageno'] - 1;
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

                                      echo "contact1.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&pageno=" . ($pageno + 1) . "&column=" . $_GET['column'] . "&order=" . $_GET['order'];
                                    } elseif (isset($_GET['search']) && isset($_GET['page_count'])) {

                                      echo "contact1.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&pageno=" . ($pageno + 1);
                                    } else if (isset($_GET['search']) && isset($_GET['column']) && isset($_GET['order'])) {

                                      echo "contact1.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&column=" . $_GET['column'] . "&order=" . $_GET['order'] . "&pageno=" . ($pageno + 1);
                                    } elseif (isset($_GET['search'])) {
                                      echo "contact1.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&pageno=" . ($pageno + 1);
                                    } elseif (isset($_GET['page_count']) && isset($_GET['column']) && isset($_GET['order'])) {
                                      echo "contact1.php?page_count=" . $_GET['page_count'] . "&column=" . $_GET['column'] . "&order=" . $_GET['order'] . "&pageno=" . ($pageno + 1);
                                    } elseif (isset($_GET['page_count'])) {
                                      echo "contact1.php?page_count=" . $_GET['page_count'] . "&pageno=" . ($pageno + 1);
                                    } elseif (isset($_GET['column']) && isset($_GET['order'])) {

                                      echo "contact1.php?column=" . $_GET['column'] . "&order=" . $_GET['order'] . "&pageno=" . ($pageno + 1);
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

                                $link .= "<a href=\"contact1.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&pageno=" . $x . "&column=" . $_GET['column'] . "&order=" . $_GET['order'] . "\">" . $x . " </a>";
                              } else if ($counter < $limit && isset($_GET['search']) && isset($_GET['page_count'])) {

                                $link .= "<a href=\"contact1.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&pageno=" . $x . "\">" . $x . " </a>";
                              } else if ($counter < $limit && isset($_GET['search'])) {
                                $link .= "<a href=\"contact1.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&pageno=" . $x . "\">" . $x . " </a>";
                              } elseif ($counter < $limit && isset($_GET['page_count'])  && isset($_GET['column']) && isset($_GET['order'])) {

                                $link .= "<a href=\"contact1.php?page_count=" . $_GET['page_count'] . "&column=" . $_GET['column'] . "&order=" . $_GET['order'] . "&pageno=" . $x . "\">" . $x . " </a>";
                              } elseif ($counter < $limit && isset($_GET['page_count'])) {

                                $link .= "<a href=\"contact1.php?page_count=" . $_GET['page_count'] . "&pageno=" . $x . "\">" . $x . " </a>";
                              } elseif ($counter < $limit && isset($_GET['column']) && isset($_GET['order'])) {

                                $link .= "<a href=\"contact1.php?column=" . $_GET['column'] . "&order=" . $_GET['order'] . "&pageno=" . $x . "\">" . $x . " </a>";
                              } elseif ($counter < $limit) {
                                $link .= "<a href=\"contact1.php?pageno=" . $x . "\">" . $x . " </a>";
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

                                        echo "contact1.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&pageno=" . $last_page . "&column=" . $_GET['column'] . "&order=" . $_GET['order'];
                                      } else if (isset($_GET['search']) && isset($_GET['page_count'])) {

                                        echo "contact1.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&page_count=" . $_GET['page_count'] . "&pageno=" . $last_page;
                                      } else if (isset($_GET['search']) && isset($_GET['column']) && isset($_GET['order'])) {

                                        echo "contact1.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&column=" . $_GET['column'] . "&order=" . $_GET['order'] . "&pageno=" . $last_page;
                                      } elseif (isset($_GET['search'])) {
                                        echo "contact1.php?valueToSearch=" . $_GET['valueToSearch'] . "&search=&pageno=" . $last_page;
                                      } elseif (isset($_GET['page_count']) && isset($_GET['column']) && isset($_GET['order'])) {
                                        echo "contact1.php?page_count=" . $_GET['page_count'] . "&column=" . $_GET['column'] . "&order=" . $_GET['order'] . "&pageno=" . $last_page;
                                      } elseif (isset($_GET['page_count'])) {
                                        echo "contact1.php?page_count=" . $_GET['page_count'] . "&pageno=" . $last_page;
                                      } elseif (isset($_GET['column']) && isset($_GET['order'])) {

                                        echo "contact1.php?column=" . $_GET['column'] . "&order=" . $_GET['order'] . "&pageno=" . $last_page;
                                      } else {
                                      ?>
                            contact1.php?pageno=<?php echo $last_page;
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
                      <input type="text" id="id2" name="id" class="form-control">
                      <button type="submit" class="btn btn-outline-danger btn-md" name="user_delete" id="delete" value="Submit">Submit</button>
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
                            <label for="owner"> Order Id :</label>
                            <input type="text" id="order_id" name="order_id" class="form-control">
                            <input type="hidden" id="t_id" name="t_id" class="form-control">
                          </div>
                          <div class="col-sm-4">
                            <label for="cvv">buyer_name :</label>
                            <input type="text" id="amt" name="buyer_name" class="form-control">
                          </div>
                          <div class="col-sm-4">
                            <label for="cardNumber">Store :</label>
                            <!-- <input type="text" id="strore_name" name="store" class="form-control"> -->
                            <select class="form-control" id="strore_name" name="store">
                       
                                </select>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <div class="col-sm-4">
                            <label for="cardNumber">Comments :</label>
                            <input type="text" id="comments" name="comments" class="form-control">
                          </div>
                          <!-- <div class="col-sm-4">
                            <label for="cardNumber">Created Date :</label>
                            <input type="date" id="created_date" name="created_date" class="form-control" >
                          </div> -->
                          <div class="col-sm-4">
                            <label for="cardNumber">status :</label>
                            <input type="text" id="status1" name="status" class="form-control">
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

                   <form action="contact1.php" method="POST">
  <div class="form-row">
  
     <div class="form-group col-md-6">
      <label for="inputorderid4">Order Id</label>
      <input type="text" class="form-control" id="inputorderid" name="order_id" placeholder="Order Id" required>
    </div>
    <div class="form-group col-md-6">
      <label for="inputfname4">Customer Name</label>
      <input type="text" class="form-control" id="inputfname" name="buyer_name" placeholder="Customer Name" required>
    </div>
  </div>
  
  <div class="form-row">
    <div class="form-group col-md-6">
    <label for="exampleFormStore">Store</label>
    <select class="form-control" id="exampleFormStore" name="store">
      <option>Select Store</option>
      <option>Ecom Retails UAE</option>
      <option>Global Hub IN</option>
      <option>Onlineadda</option>
      <option>Whitebark</option>
    </select>
  </div>
    
    <div class="form-group col-md-4">
     <label for="inputcomment">Comments</label>
      <input type="text" class="form-control" name="comments" id="inputcomment" required>
    </div>
    <div class="form-group col-md-2">
      <label for="inputStatus">Status</label>
      <input type="text" class="form-control" name="status" id="inputStatus">
    </div>
  </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">Close</button>
         <button type="submit" class="btn " name="submit" style="background-color: #6b8b9f; color:white; ">Save Data</button>
      </div>
    </div>
  </div>
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
      window.location = "contact1.php";
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
            $('#order_id').val(data[2]);
            $('#amt').val(data[3]);
            //$('#strore_name').val(data[4]);
            $('#strore_name').append('<option value="'+data[4]+'">'+data[4]+'</option>');
            $('#strore_name').append('<option value="'+'Select Store'+'">'+'Select Store'+'</option>');
            $('#strore_name').append('<option value="'+'Ecom Retails UAE'+'">'+'Ecom Retails UAE'+'</option>');
            $('#strore_name').append('<option value="'+'Global Hub IN'+'">'+'Global Hub IN'+'</option>');
            $('#strore_name').append('<option value="'+'Whitebark'+'">'+'Whitebark'+'</option>');
            $('#status1').val(data[6]);
            $('#created_date').val(data[7]);
            $('#comments').val(data[5]);
            // $('#amt').val(data[3]);
    });
    $('.delete').on('click', function() {
            $tr = $(this).closest('tr');
            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();
            console.log(data);
            $('#id2').val(data[1]);
            
            
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
