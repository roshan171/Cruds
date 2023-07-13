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
$url=$_SERVER['REQUEST_URI']; 
$idd=$_GET['id'];
     

if(isset($_POST['editproduct'])){
    $asin  = $_POST['asin'];
    $sku  = $_POST['sku'];
    $pname  = $_POST['pname'];
    $imgurl  = $_POST['imgurl'];
    $quantity  = $_POST['quantity'];
    $price_ind  = $_POST['price_ind'];
    if($price_ind==''){
        $price_ind=0;
    }
    $price_usd  = $_POST['price_usd'];
    if($price_usd==''){
        $price_usd=0;
    }
    $category  = $_POST['category'];
    $age_type  = $_POST['age_type'];
    $rack  = $_POST['rack'];
    $shelf  = $_POST['shelf'];
    $exp_date  = $_POST['exp_date'];
    $market_place  = $_POST['market_place'];
    $store  = $_POST['store'];
   
   // $sql = "INSERT INTO `inboundscanuploaders`(`asin`, `sku`, `title`, `image`, `quantity`, `buy`, `sell`, `product_type`, `product_condition`,`select_rack`,`select_shelf`,`expiry_date`,`market_place`,`store`,`inbound_name`) VALUES ('$asin','$sku','$pname','$imgurl','$quantity','$price_usd','$price_ind','$category','$age_type','$rack','$shelf','$exp_date','$market_place','$store','ki')";
    $sql ="UPDATE `inboundscanuploaders` SET `id`='$idd', `asin`='$asin',`sku`='$sku',`title`='$pname',`image`='$imgurl',`quantity`='$quantity',`buy`='$price_usd',`sell`='$price_ind',`product_type`='$category',`product_condition`='$age_type', `select_rack`='$rack',`select_shelf`='$shelf',`expiry_date`='$exp_date',`market_place`='$market_place',`store`='$store',`inbound_name`='$name' WHERE  `id`='$idd'";
     //print_r($sql); exit;
    $result = mysqli_query($conn,$sql);
    if($result){
            echo "<script type=\"text/javascript\">
              alert(\"Data Updated Successfully\");
              window.location = \"https://order.ecomretails.in/AI/order/oauth/v2/inoutbound.php\"
              </script>"; 
    }
    else{
        // echo "hello";
    }
  }




$str_arr = explode ("/", $url); 
//print_r($str_arr[2]); exit;


$sql = "SELECT * FROM `inboundscanuploaders` WHERE `id` ='$idd' AND `deleted_at` IS NULL;";
$result = mysqli_query($conn, $sql);
$data=mysqli_fetch_array($result);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>InoutboundEdit</title>
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
      <div class="row">
        <div class="col-12">
          <div class="card ">
             <div class="card-header">
               <h3 class="card-title">Inoutbound </h3> <a href="http://order.ecomretails.in/AI/order/oauth/v2/inoutbound.php" class="btn btn-warning" style="float: right;">Back</a>
              </div>
            <div class="card-body">
              <form action="" method="POST">
                  <input type="hidden" id="id" name="id" value="<?php echo $data['id'];?>">
                <div class="row">
                <div class="col-sm-1">
                <label style="font-size:13px;">Asin</label>
                </div>
                 <div class="col-sm-2">
                <input type="text" style="font-size:12px;" class="form-group" name="asin" value="<?php echo $data['asin'];?>" required>
                </div>
                
                <div class="col-sm-1">
                <label style="font-size:13px;">Sku</label>
                </div>
                <div class="col-sm-2">
                <input type="text" style="font-size:12px;" class="form-group" name="sku" value="<?php echo $data['sku'];?>" required>
                </div>
                
                <div class="col-sm-1">
                <label style="font-size:13px;">Title</label>
                </div>
                <div class="col-sm-2">
                <input type="text" style="font-size:12px;"  class="form-group" name="pname" value="<?php echo $data['title'];?>" required>
                </div>
                
                <div class="col-sm-1">
                <label style="font-size:13px;">Image</label>
                </div>
                <div class="col-sm-2">
                <input type="text" style="font-size:12px;" class="form-group" name="imgurl" value="<?php echo $data['image'];?>" required>
                </div>
                
                
                
                </div>
                
                
                
                

              
                <div class="row">
                <div class="col-sm-1">
                <label style="font-size:13px;">Price USD</label>
                </div>
                 <div class="col-sm-2">
                <input type="text" style="font-size:12px;" class="form-group" name="price_usd" value="<?php echo $data['buy'];?>" required>
                </div>
                <div class="col-sm-1">
                <label style="font-size:13px;">Category</label>
                </div>
                 <div class="col-sm-2">
                <!-- <input type="text" class="form-group" name="category" required> -->
                <select class="form-select" aria-label="Default select example" style="font-size:12px;" name="category" value="<?php echo $data['product_type'];?>" required>
                  <option <?php echo $data['product_type'];?>><?php echo $data['product_type'];?></option>
                  <option value="Toy">Toy</option>
                  <option value="Electronics">Electronics</option>
                  <option value="Baby Products">Baby Products</option>
                </select>
                </div>
                
                <div class="col-sm-1">
                <label style="font-size:13px;">Age Type</label>
                </div>
                  <div class="col-sm-2">
                <!-- <input type="text" class="form-group" name="age" required> -->
                <select class="form-select" style="font-size:12px;" aria-label="Default select example" name="age_type" value="<?php echo $data['product_condition'];?>" required>
                  <option <?php echo $data['product_condition'];?>><?php echo $data['product_condition'];?></option>
                  <option value="New">New</option>
                  <option value="Old">Old</option>
                  <option value="Damaged">Damaged</option>
                </select>
                </div>
                
                <div class="col-sm-1">
                <label style="font-size:13px;">Rack</label>
                </div>
                    <div class="col-sm-2">
                <!-- <input type="url" class="form-group" name="imgurl" required> -->
                <select class="form-select" style="font-size:12px;" aria-label="Default select example" name="rack" value="<?php echo $data['select_rack'];?>" required>
                  <option <?php echo $data['select_rack'];?>><?php echo $data['select_rack'];?></option>
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
                <div class="col-sm-1">
                <label style="font-size:13px;">Shelf</label>
                </div>
                
                <div class="col-sm-2">
                <select class="form-select" style="font-size:12px;" aria-label="Default select example" name="shelf" value="<?php echo $data['select_shelf'];?>" required>
                  <option <?php echo $data['select_shelf'];?>><?php echo $data['select_shelf'];?></option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                </select>
                </div>
                <div class="col-sm-1">
                <label style="font-size:13px;">Expiry Date</label>
                </div>
                  <div class="col-sm-2">
                <input type="text" style="font-size:12px;" class="form-group" name="exp_date" value="<?php echo $data['expiry_date'];?>" required>
                </div>
                <div class="col-sm-1">
                 <label style="font-size:13px;">Market Place</label>
                </div>
                <div class="col-sm-2">
                <input type="text" class="form-group" style="font-size:12px;" name="market_place" value="<?php echo $data['market_place'];?>" required>
                </div>
                <div class="col-sm-1">
                 <label style="font-size:13px;">Store</label>
                </div>
                <div class="col-sm-2">
                <input type="text" class="form-group" name="store" style="font-size:12px;" value="<?php echo $data['store'];?>" required>
                </div>
                
              </div>
              <div class="row">
               
               <div class="col-sm-1">
                <label style="font-size:13px;">Quantity</label>
                </div>
                <div class="col-sm-2">
                <input type="text" class="form-group" style="font-size:12px;" name="quantity" value="<?php echo $data['quantity'];?>" required>
                </div>
              
            
                <div class="col-sm-2">
               
                </div>
               </div>
                <div class="row">
                
                <!-- <div class="col-sm-2">
                 <label>Expiry Date</label>
                </div> -->
              </div>
              <div class="row">
                
                
                 <div class="col-sm-2">
                <input type="submit" class="btn btn-warning" name="editproduct" >
                </div>
               

              </div>
              </form>
<br/><br/>
<div >


</div>  
</div>
          </div>
        </div>
      </div>
    </section>

   <!-- <?php //include('../layout/footer.php'); ?> -->
  <!--<?php include('../layout/footer.php'); ?>-->

 