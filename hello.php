<?php
session_start();
$name=$_SESSION['name'];
include('constant.php');

$object    = new Constants();
$constants = $object->constant();
$conn      = $constants['connection'];
$rooturl   = $constants['rooturl'];
$base_url = $_SERVER['DOCUMENT_ROOT'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>InoutBound</title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
 <link rel="stylesheet" href="<?php $base_url; ?>/AI/order/oauth/plugins/fontawesome-free/css/all.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="<?php $base_url; ?>/AI/order/oauth/dist/css/adminlte.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  

<style>
 .thead tr th {
    background-color: #6b8b9f;
    font-size: 13px;
    color: white;
  }

 .tfoot tr th {

   background-color: #6b8b9f;
    font-size: 13px;
    color: white;

  }

 .card-header {

    background-color: #6b8b9f;

   color: white;
  }

  .modal-header {
   background-color: #6b8b9f;
    color: white;
    padding: 0.3rem !important;
  }

 .table td {

    padding: 0.3rem !important;
    font-size: 13px;
  }

  .card {
    box-shadow: 0px 3px 6px #6b8b9f !important;
    border-radius: 6px;
  }

  .card-header {
    padding: 0.5rem !important;
  }

 /* DATA TABLE TR HOVER EFFECT */
  table#example1.dataTable tbody tr:hover {
    box-shadow: 0px 4px 7px #6b8b9f !important;
    border-radius: 6px;
  }

  /* DATA TABLE PAGINATION CSS START HERE */
  .dataTables_wrapper .dataTables_paginate .paginate_button {
    background: none;
    color: black !important;
  }

*  .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    background: #6b8b9f;
    color: white !important;
    border-radius: 4px;
    border: 1px solid #6b8b9f;
  }

  .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
    background: #6b8b9f;
    color: white !important;
    border: 1px solid #6b8b9f;
  }

  .dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background: #6b8b9f;
    color: white !important;
    border: 1px solid #6b8b9f;
  }
  /* DATA TABLE PAGINATION CSS ENDS HERE */
  
  .submit-btn{
    margin-top: 3.5%;
  }
  .apply-btn{
   background: #6b8b9f;
    color: white !important;
  }
</style>

<style type="text/css">

.table td, .table th {

    padding: .25rem;}

a.btn.btn-warning {
    margin-top: 2rem;
}
form {
    margin-top: 1rem;
}
input#orderid {
    margin-left: 3.5rem;
}
input#DateSearch {
    margin-left: 0.9rem;
    width: 185px;
}
input.btn.btn-warning {
    padding: 3px 6px;
    margin-top: -0.3rem;
    margin-left: 0.5rem;
}
button.btn.btn-warning {
    padding: 3px 6px;
    margin-top: -0.3rem;
    margin-left: 0.5rem;
}
</style>

<body class="hold-transition sidebar-mini layout-fixed">
 <?php include('../layout/header.php'); ?>
 <?php include('../layout/sidebar.php'); ?>
 
<div class="content-wrapper">

  <div class="content-header">

    <div class="container-fluid">

      <!-- @if (Session::has('message'))
         <div class="alert alert-success">{{ Session::get('message') }}</div>
      @endif
      @if (Session::has('error'))
         <div class="alert alert-danger">{{ Session::get('error') }}</div>
      @endif -->
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0 text-dark">Inoutbound</h1>
        </div>
        <div class="col-sm-6">
        </div>
      </div>
    </div>
  </div>
 <?php 
                    $sql1 = "SELECT sum(quantity) as it, sum(sell) as se, sum(out_qty) as ot FROM `inboundscanuploaders` WHERE `deleted_at` IS NULL";
                    $result1 = mysqli_fetch_array(mysqli_query($conn, $sql1));
                    $it=$result1['it'];
                    $se=round($result1['se']);
                    $ot=$result1['ot'];
  ?> 
  
 <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card ">
             <div class="card-header">
               <h3 class="card-title">Inoutbound </h3>  <a href="http://order.ecomretails.in/AI/order/oauth/v2/inoutboundAdd.php" class="btn-sm btn-primary m-1" style="float: right;">ADD</a>
              <a href="#" class="btn-sm btn-danger" style="float: right; margin:5px;">Total In Quantity<b><?php echo $it;?></b></a>
              <a href="#" class="btn-sm btn-danger" style="float: right; margin:5px;">Total Sell<b><?php echo $se;?></b></a>
              <a href="#" class="btn-sm btn-danger" style="float: right; margin:5px;">Total Out Quantity<b><?php echo $ot;?></b></a>
              <b><?php //echo $result1['it'];?></b>
              </div>
            <div class="card-body">
   <!--  <table id="trackingdata" class="table table-bordered table-hover w-100" style="border:1px solid #17a2b8 !important;" >
                <thead style="border:1px solid #17a2b8 !important;" >
                <tr>Courier Name</tr>
                </thead> -->
               
                <table id="myTable" class=" table table-bordered table-striped dt-responsive" >
                
                          <thead style="background:#6b8b9f;color:#fff;">

                            <tr>
                              <th class="no">No </th>
                              <th style="display:none ;">Id</th>
                              <th>Asin</th>
                              <th>Title</th>
                              <th>Total</th>
                              <th>Inbound Qty</th>
                              <th>Outbound Qty</th>
                              <th>Barcode</th>
                              <th>Action</th>
                            </tr>

                          </thead>

                          <tbody style="font-size:12px;" cellpadding="1px">
                <!-- <tbody> -->
                   <?php
                    //include_once($_SERVER['DOCUMENT_ROOT']."/public/constants.php"); 
                    //$con=mysqli_connect("localhost","e4all_ecomretail","ecomretail@123","e4all_ecomretail");
                   //$conn=mysqli_connect("localhost","root","","ecomretails_order");
                    // $object=new Constants();
                    // $constants=$object->constant();
                    // $conn=$constants['connection'];
                    // session_start();
                    // include('constant.php');
                    
                    // $object    = new Constants();
                    // $constants = $object->constant();
                    // $conn      = $constants['connection'];
                    $sql = "SELECT * FROM `inboundscanuploaders` WHERE `deleted_at` IS NULL order by id DESC ;";
                    $result = mysqli_query($conn, $sql);
                    $i=0;
                    // $data=mysqli_fetch_array($result);
                    //  $i++;?>
                                 
                    <?php while($data=mysqli_fetch_array($result)){ $i++;
                      ?><tr> 
                                <td><?php echo $i; ?></td>
                                <td style="display:none;"><?php echo $data['id']; ?></td>
                                <td><?php echo $data['asin']; ?></td>
                                <td><?php echo $data['title']; ?></td>
                                <td><?php echo $data['quantity']-$data['out_qty']; ?></td>
                                <td><?php echo $data['quantity']; ?></td>
                                <td><?php echo $data['out_qty']; ?></td>
                                <td><?php echo "Barcode unique" ?></td>  
                                <td>
                        <a target="_blank" href="inoutboundEdit.php?id=<?php echo $data['id']; ?>" class="btn-sm btn-warning" style="font-size:6px;" title="Edit"><i class="fas fa-edit"></i></a>
                         <a href="inoutboundDelete.php?id=<?php echo $data['id']; ?>" class="btn-sm btn-danger" style="font-size:6px;"  title="Delete"><i class="fas fa-trash"></i></a>
                 <a target="_blank" href="inoutboundOut.php?id=<?php echo $data['id']; ?>"  class="btn-sm btn-primary"  style="font-size:6px;" title="Outbound"><i class="fas fa-edit"></i></a>
                         </td>
                      </tr>           
                                     
                    <?php  }

                    ?> 
                    <!-- <td><input type="button" onclick="printDiv('printableArea')" value="print a div!" /></td> -->
                             
              </tbody>
              </table>
              
               </div>
          </div>
        </div>
      </div>
    </section>
              
<br/><br/>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function () {
 let table = new DataTable('#myTable');
  $('.dataTables_length').addClass('bs-select');
});

</script>

</body>

</html>
<br/><br/><br/><br/><br/>
   

  <!--<?php include_once($base_url . '/AI/order/oauth/layout/footer.php'); ?>-->

  