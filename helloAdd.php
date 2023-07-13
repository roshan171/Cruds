<?php
session_start();
include('constant.php');
$name=$_SESSION['name'];
$object    = new Constants();
$constants = $object->constant();
$conn      = $constants['connection'];
$rooturl   = $constants['rooturl'];

//echo $base_url = $_SERVER['DOCUMENT_ROOT']; exit;

$base_url = $_SERVER['DOCUMENT_ROOT'];
//$conn=mysqli_connect("localhost","root","","ecomretails_order");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inoutbound</title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
 <link rel="stylesheet" href="<?php $base_url; ?>/AI/order/oauth/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php $base_url; ?>/AI/order/oauth/dist/css/adminlte.min.css">


<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
 <section class="content">
      
        
          <div class="card ">
             <div class="card-header">
                  <div class="row">
                    <div class="col-sm-4">
                        <h3 class="card-title">Inoutbound</h3>
                    </div >
                    <div class="col-sm-8">
                        <a href="http://order.ecomretails.in/AI/order/oauth/v2/inoutbound.php" class="btn btn-warning" style="float: right;top-margin:-3rem;">Back</a> 
                    </div>
                   </div>
              </div>       
            <div class="card-body">
               
              <form action="" method="POST">
                <div class="row">
                    <div class="col-sm-2">
                        <label>Asin</label>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" class="form-group" name="asin" required>      
                    </div>
                    <div class="col-sm-2">
                        &nbsp;&nbsp;&nbsp;<label>Sku</label>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" class="form-group" name="sku" required>
                    </div>
                    <div class="col-sm-2">
                        &nbsp;&nbsp;&nbsp;<label>Product Name</label>     
                    </div>
                    <div class="col-sm-2">
                        <input type="text" class="form-group" name="pname" style="width:100%;" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <label>Img-url</label>
                    </div>
                    <div class="col-sm-2">
                        <input type="url" class="form-group" name="imgurl" required>
                    </div>
                    <div class="col-sm-2">
                        &nbsp;&nbsp;&nbsp;<label>Quantity</label>
                    </div>
                    <div class="col-sm-2">
                        <input type="number" class="form-group" name="quantity" required>
                    </div>
                    <div class="col-sm-2">
                        &nbsp;&nbsp;&nbsp;<label>Price IND</label>
                    </div>
                    <div class="col-sm-2">
                        <input type="number" class="form-group" name="price_ind" style="width:100%;" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <label>Price USD</label>
                    </div>
                    <div class="col-sm-2">
                        <input type="number" class="form-group" name="price_usd" required>
                    </div>
                <div class="col-sm-2">
                &nbsp;&nbsp;&nbsp;<label>Category</label>
                </div>
                <div class="col-sm-2">
                    <select class="form-select" aria-label="Default select example" name="category" required>
                        <option selected>Select Category</option>
                        <option value="Toy">Toy</option>
                        <option value="Electronics">Electronics</option>
                        <option value="Baby Products">Baby Products</option>
                        <option value="Beauty Products">Beauty Products</option>
                        <option value="Tools">Tools</option>
                        <option value="Car Accessories">Car Accessories</option>
                        <option value="Books">Books</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    &nbsp;&nbsp;&nbsp;<label>Age Type</label>
                </div>
                <div class="col-sm-2">
                    <select class="form-select" aria-label="Default select example" name="age_type" required>
                        <option selected>Select Type</option>
                        <option value="New">New</option>
                        <option value="Old">Old</option>
                        <option value="Damaged">Damaged</option>
                    </select>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-2">
                    <label>Rack</label>
                </div>
                <div class="col-sm-2">
                <!-- <input type="text" class="form-group" name="category" required> -->
                    <select class="form-select" aria-label="Default select example" name="rack" required>
                      <option selected>Rack</option>
                      <option value="A">A</option>
                      <option value="B">B</option>
                      <option value="C">C</option>
                      <option value="D">D</option>
                      <option value="E">E</option>
                      <option value="F">F</option>
                      <option value="G">G</option>
                      <option value="H">H</option>
                      <option value="I">I</option>
                      <option value="J">J</option>
                      <option value="K">K</option>
                      <option value="L">L</option>
                      <option value="M">M</option>
                      <option value="N">N</option>
                      <option value="O">O</option>
                    </select>
                </div>
                <div class="col-sm-2">
                <!-- <input type="text" class="form-group" name="age" required> -->
                    &nbsp;&nbsp;&nbsp;<label>Shelf</label>
                </div>
                <div class="col-sm-2">
                <!-- <input type="url" class="form-group" name="imgurl" required> -->
                    <select class="form-select" aria-label="Default select example" name="shelf" required>
                      <option selected>Shelf</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <option value="6">6</option>
                      <option value="7">7</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    &nbsp;&nbsp;&nbsp;<label>Expiry Date</label>
                </div>
                <div class="col-sm-2">
                    <input type="date" class="form-group" name="exp_date" required>
                </div>
                </div>
                <div class="row">
                <div class="col-sm-2">
                 <label>Market Place</label>
                </div>
                <div class="col-sm-2">
                 <input type="text" class="form-group" name="market_place" required>
                </div>
                 <div class="col-sm-2">
                &nbsp;&nbsp;&nbsp;<label>Store</label>
                </div>
                <div class="col-sm-2">
                <input type="text" class="form-group" name="store" required>
                </div>
                
                <div class="col-sm-2">
                &nbsp;&nbsp;&nbsp;<input type="submit" class="btn btn-warning" name="addproduct" >
                </div>
              </div>
              <div class="row">
               

              </div>
              </form></div>
</div>
</section>

  <?php    

if(isset($_POST['addproduct'])){
    $asin  = $_POST['asin'];
    $sku  = $_POST['sku'];
    $pname  = $_POST['pname'];
    $imgurl  = $_POST['imgurl'];
    $quantity  = $_POST['quantity'];
    $price_ind  = $_POST['price_ind'];
    $price_usd  = $_POST['price_usd'];
    $category  = $_POST['category'];
    $age_type  = $_POST['age_type'];
    $rack  = $_POST['rack'];
    $shelf  = $_POST['shelf'];
    $exp_date  = $_POST['exp_date'];
    $market_place  = $_POST['market_place'];
    $store  = $_POST['store'];
   
   $sql = "INSERT INTO `inboundscanuploaders`(`asin`, `sku`, `title`, `image`, `quantity`, `buy`, `sell`, `product_type`, `product_condition`,`select_rack`,`select_shelf`,`expiry_date`,`market_place`,`store`,`inbound_name`) VALUES ('$asin','$sku','$pname','$imgurl','$quantity','$price_usd','$price_ind','$category','$age_type','$rack','$shelf','$exp_date','$market_place','$store','$name')";
    $result = mysqli_query($conn,$sql);
    if($result){
         echo "<script type=\"text/javascript\">
              alert(\"Insert Data Successfully\");
              window.location = \"inoutbound.php\"
              </script>";
    }
  }

  ?>

 


          
      <!--  </div>-->
      <!--</div>-->
    
   
  

 