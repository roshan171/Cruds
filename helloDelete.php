<?php
session_start();
include('constant.php');

$object    = new Constants();
$constants = $object->constant();
$conn      = $constants['connection'];
$rooturl   = $constants['rooturl'];

//  $base_url = $_SERVER['DOCUMENT_ROOT']; 

$base_url = $_SERVER['DOCUMENT_ROOT'];

$url=$_SERVER['REQUEST_URI']; 

$str_arr = explode ("/", $url); 
//print_r($str_arr[2]); exit;
$idd=$_GET['id'];

$date1=date('Y-m-d h:i:s');
$sql = "UPDATE `inboundscanuploaders` SET `deleted_at`='$date1' WHERE `id` ='$idd' ;";
$result = mysqli_query($conn, $sql);
//$data=mysqli_fetch_array($result);
if($result){
         echo "<script type=\"text/javascript\">
              alert(\"Data Deleted Successfully\");
              window.location = \"inoutbound.php\"
              </script>";
    }

?>
