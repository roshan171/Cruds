<?php
include_once 'config.php';

//Export File

if(isset($_POST["Export"])){
     
      header('Content-Type: text/csv; charset=utf-8');  
      header('Content-Disposition: attachment; filename=modalcrud.csv');  
      $output = fopen("php://output", "w");  
      fputcsv($output, array('id', 'reference_id', 'order_id', 'first_name', 'last_name','status'));  
      $query = "SELECT * from modalcrud";  
      $result = mysqli_query($conn, $query);  
      while($row = mysqli_fetch_assoc($result))  
      {  
           fputcsv($output, $row);  
      }  
      fclose($output);  
 }  

// Insert Query

if(isset($_POST['submit'])){
	$reference_id=$_POST['reference_id'];
	$order_id=$_POST['order_id'];
	$first_name=$_POST['first_name'];
$last_name=$_POST['last_name'];
$status=$_POST['status'];


$sql="INSERT INTO modalcrud(reference_id,order_id,first_name,last_name,status)VALUES ('$reference_id','$order_id','$first_name','$last_name','$status') ";

if($conn->query($sql)){
			
			header("location:modalcrud.php");
		}
		else{
			echo "Data not Inserted".mysql_error($conn);
		}

		header("location:modalcrud.php");
		exit;
	}

//Delete Query

if(isset($_GET['id'])){
	$id=$_GET['id'];

	$sql = "DELETE FROM modalcrud WHERE id='$id'";
	$result=$conn->query($sql);
	  if ($result) {
    echo "<script type=\"text/javascript\">
              alert(\"Data deleted Successfully\");
              window.location = \"modalcrud.php\"
              </script>"; 
 
  }
  else{
    die(mysqli_error($conn));
  }
}

//Update Query

if(isset($_POST['updatedata'])){
   //  print_r($_POST);
   // echo "point!"; exit;

 $id=$_POST['id'];
 $reference_id = $_POST['reference_id'];
   $order_id = $_POST['order_id'];
   $first_name = $_POST['first_name'];
   $last_name = $_POST['last_name'];
 $status=$_POST['status'];



 $sql = mysqli_query($conn,"UPDATE `modalcrud` SET id='$id', reference_id='$reference_id',order_id='$order_id',first_name='$first_name',last_name='$last_name',status='$status' WHERE id='$id'")or die(mysqli_error($conn));
    

     if($sql){
        echo "<script type=\"text/javascript\">
              alert(\"Data Updated Successfully\");
              window.location = \"modalcrud.php\"
              </script>"; 
      }
      else{
       echo "Data not Updated".mysql_error($conn);
    }
       // header('location:crm.php');
   //exit;
      }






?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Crud Operation</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
		
</head>
<body>

<div class="mt-3">
	<h1 class="text-center">Crud Using Modal</h1>
	<button type="submit" class=" btn btn-primary m-3" data-toggle="modal" data-target="#addModal">Add Form</button>
	<form class="form-horizontal" action="modalcrud.php" method="post" name="upload_excel"   
                      enctype="multipart/form-data">
                  <div class="form-group">
                            <div class="col-md-4 col-md-offset-4">
                                <input type="submit" name="Export" class="btn btn-success mt-3" value="Export File"/>
                            </div>
                   </div>                    
            </form>
</div>

<div class="">
	<input type="" name="Search" id="search">
	<button type="submit" class="btn btn-info mb-2">Search</button>
</div>

<!-- Modal Add form -->

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="modalcrud.php" method="POST">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputrefeid4">Reference Id</label>
      <input type="text" class="form-control" id="inputrefeid" name="reference_id" placeholder="Reference Id" required>
    </div>
     <div class="form-group col-md-6">
      <label for="inputorderid4">Order Id</label>
      <input type="text" class="form-control" id="inputorderid" name="order_id" placeholder="Order Id" required>
    </div>
    <div class="form-group col-md-6">
      <label for="inputfname4">First Name</label>
      <input type="text" class="form-control" id="inputfname" name="first_name" placeholder="First Name" required>
    </div>
     <div class="form-group col-md-6">
      <label for="inputlname4">Last Name</label>
      <input type="text" class="form-control" id="inputlname" name="last_name" placeholder="Last Name" required>
    </div>
  </div>
  
  <div class="form-row">
    <div class="form-group col-md-6">
    <label for="exampleFormStore">Status</label>
    <select class="form-control" id="exampleFormStatus" name="status">
      <option></option>
      <option>Done</option>
      <option>Pending</option>
    </select>
  </div>
  </div>
   <div class="modal-footer">
        <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">Close</button>
         <button type="submit" class="btn btn-primary" name="submit">Save Data</button>
      </div>
    </div>
    </form>
    </div>
  </div>
</div>

     <!-- end -->


<!--Fetch The data In Table-->


<table class="table" id="myTable">
  <thead>
    <tr>
      <th scope="col">Id</th>
      <th scope="col">Reference Id</th>
      <th scope="col">Order Id</th>
      <th scope="col">First Name</th>
      <th scope="col">Last Name</th>
      <th scope="col">Status</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
 
        <?php
        require 'config.php';
        $rows = mysqli_query($conn, "SELECT * FROM modalcrud");
        $i = 1;
?>
<?php foreach($rows as $row) :  ?>
<tr id = <?php echo $row["id"]; ?>>
<td><?php echo $i++; ?></td>
<td><?php echo $row["reference_id"]; ?></td>
<td><?php echo $row["order_id"]; ?></td>
<td><?php echo $row["first_name"]; ?></td>
<td><?php echo $row["last_name"]; ?></td>
<td><?php echo $row["status"]; ?></td>

<td class="actions">
<a href="" data-toggle="modal" data-target="#editModal"  class=" btn btn-warning editbtn"><i class="fas fa-edit"></i></a>

      <a href="modalcrud.php?id=<?php echo $row['id'];?>" class="btn btn-danger trash m-1"><i class="fas fa-trash" ></i></a>

       <a href="" data-toggle="modal" data-target="#viewModal" class=" btn btn-success viewbtn"><i class="fas fa-eye"></i> </a>
</td>
</tr>

    <?php endforeach;  ?>
</tbody>

<!--End-->


<!--Edit Modal-->

<div id="editModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Here</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body edit_crm">
                     <form action="" method="POST">
                      <input type="hidden" id="id" name="id2" class="form-control" required>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Reference Id</label>
      <input type="text" class="form-control" id="reference_id2" name="reference_id2" placeholder="Reference Id" value="">
    </div>
     <div class="form-group col-md-6">
      <label for="inputEmail4">Order Id</label>
      <input type="text" class="form-control" id="order_id2" name="order_id2" 
      value="" placeholder="Order Id">
    </div>
    <div class="form-group col-md-6">
      <label for="inputEmail4">First Name</label>
      <input type="text" class="form-control" id="first_name2" name="first_name2" 
      value=""  placeholder="First Name">
    </div>
     <div class="form-group col-md-6">
      <label for="inputEmail4">Last Name</label>
      <input type="text" class="form-control" id="last_name2" name="last_name2" 
      value="" placeholder="Last Name" >
    </div>
  </div>
  
  <div class="form-row">
    <div class="form-group col-md-6">
    <label for="status">status</label>
    <select class="form-control"  name="status2" id="status2" value="" >
      <option >Done </option>
      <option >Pending</option>
     
    </select>
  </div>
  </div>
<div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <input type="submit" class="btn btn-info"  name="updatedata" value="Update">
                </div>
                </form>
    </div>
  </div>      
  </div>
</div>
<!--End-->



<!--View Modal-->


<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Read Only</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="POST">
        	<input type="hidden" name="id1" id="id1" value="">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputrefeid4">Reference Id</label>
      <input type="text" class="form-control" id="reference_id1" name="reference_id" placeholder="Reference Id" required>
    </div>
     <div class="form-group col-md-6">
      <label for="inputorderid4">Order Id</label>
      <input type="text" class="form-control" id="order_id1" name="order_id" placeholder="Order Id" required>
    </div>
    <div class="form-group col-md-6">
      <label for="inputfname4">First Name</label>
      <input type="text" class="form-control" id="first_name1" name="first_name" placeholder="First Name" required>
    </div>
     <div class="form-group col-md-6">
      <label for="inputlname4">Last Name</label>
      <input type="text" class="form-control" id="last_name1" name="last_name" placeholder="Last Name" required>
    </div>
  </div>
  
  <div class="form-row">
    <div class="form-group col-md-6">
    <label for="exampleFormStore">Status</label>
    <select class="form-control" id="status1" name="status">
      <option></option>
      <option>Done</option>
      <option>Pending</option>
    </select>
  </div>
  </div>
   <div class="modal-footer">
        <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">Close</button>
         <!-- <button type="submit" class="btn btn-primary" name="update">Update Data</button> -->
      </div>
    </div>
    </form>
    </div>
  </div>
</div>
<!--End-->






<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


<script type="text/javascript">
	 
 
$(document).ready(function () {
$('.editbtn').on('click',function(){
$tr = $(this).closest('tr');

        var data = $tr.children("td").map(function() {

            return $(this).text();

        }).get();

        console.log(data);
        $('#id').val(data[0]);
         $('#reference_id').val(data[1]);
           $('#order_id').val(data[2]);
             $('#first_name').val(data[3]);
               $('#last_name').val(data[4]);
                 $('#status').val(data[5]);
                 
});

});



</script>
</body>
</html>